-- ============================================================
-- FORT 社内ポータル ｜ 初回セットアップ用 一括SQL
--
-- 使い方：
--   Supabase ダッシュボード → 左メニュー「SQL Editor」→「New query」に
--   このファイルの中身を全部貼り付けて「Run」。
--   （migrations 0000 + 0001 + seed を1つにまとめたものです）
--
-- ⚠️ 実行後、ログインする自分のアドレスを必ず設定してください（末尾の案内参照）。
-- ============================================================

-- ============ [1/3] 0000_init.sql ============
-- ============================================================
-- FORT 社内ポータル ｜ Phase 0 基盤マイグレーション
--   - fiscal_periods（会計期）
--   - employees（社員マスタ）＋ 権限・RLS
-- docs/04_data_model.md / docs/05_architecture.md
-- ============================================================

-- uuid 生成に使う拡張
create extension if not exists "pgcrypto";

-- ------------------------------------------------------------
-- 共通：updated_at を自動更新するトリガ関数
-- ------------------------------------------------------------
create or replace function public.set_updated_at()
returns trigger
language plpgsql
as $$
begin
  new.updated_at = now();
  return new;
end;
$$;

-- ------------------------------------------------------------
-- fiscal_periods（会計期）
--   FORT の会計年度は非標準（11期はM&Aのため短期4ヶ月）。
-- ------------------------------------------------------------
create table if not exists public.fiscal_periods (
  id          uuid primary key default gen_random_uuid(),
  label       text not null unique,          -- 例：10期 / 11期 / 12期
  start_date  date not null,
  end_date    date,                          -- 進行中の期は null 可
  created_at  timestamptz not null default now(),
  updated_at  timestamptz not null default now()
);

create trigger fiscal_periods_set_updated_at
  before update on public.fiscal_periods
  for each row execute function public.set_updated_at();

-- ------------------------------------------------------------
-- employees（社員マスタ）
-- ------------------------------------------------------------
create table if not exists public.employees (
  id            uuid primary key default gen_random_uuid(),
  auth_user_id  uuid unique references auth.users(id) on delete set null,
  employee_no   text unique,                 -- 例：F-001
  name          text not null,               -- 氏名（例：青野 弘輝）
  name_kana     text,                        -- フリガナ
  email         text unique,                 -- @fort410.jp
  dept          text,                        -- 経営／営業／設計／工務／総務
  role_title    text,                        -- 役職
  base          text,                        -- 拠点（岡山／福山）
  employment    text,                        -- 雇用形態
  joined_on     date,                        -- 入社日
  tel           text,
  permission    text not null default 'member'
                  check (permission in ('executive','manager','hr','member')),
  is_active     boolean not null default true,
  created_at    timestamptz not null default now(),
  updated_at    timestamptz not null default now()
);

create index if not exists employees_dept_idx on public.employees (dept);
create index if not exists employees_email_idx on public.employees (lower(email));

create trigger employees_set_updated_at
  before update on public.employees
  for each row execute function public.set_updated_at();

-- ------------------------------------------------------------
-- 権限ヘルパー（SECURITY DEFINER）
--   RLS ポリシー内で社員行を参照すると再帰するため、
--   RLS を迂回する定義者権限の関数で権限を取得する。
-- ------------------------------------------------------------
create or replace function public.current_permission()
returns text
language sql
stable
security definer
set search_path = public
as $$
  select permission
  from public.employees
  where auth_user_id = auth.uid()
  limit 1;
$$;

-- 初回ログイン時に、メール一致の社員行へ auth_user_id を紐付ける。
-- （招待リスト方式：employees に登録済みの社員だけがログインを完了できる）
create or replace function public.link_current_employee()
returns void
language plpgsql
security definer
set search_path = public
as $$
declare
  uid    uuid := auth.uid();
  uemail text := auth.jwt() ->> 'email';
begin
  if uid is null or uemail is null then
    return;
  end if;

  update public.employees
     set auth_user_id = uid,
         updated_at   = now()
   where lower(email) = lower(uemail)
     and auth_user_id is null;
end;
$$;

grant execute on function public.current_permission() to authenticated;
grant execute on function public.link_current_employee() to authenticated;

-- ============================================================
-- RLS（Row Level Security）
--   DBレベルで守る。アプリ側チェックだけに頼らない。
-- ============================================================
alter table public.employees      enable row level security;
alter table public.fiscal_periods enable row level security;

-- ---- employees ----
-- 参照：ログイン済みの社員なら全員の一覧を読める（社員名簿）
drop policy if exists employees_select on public.employees;
create policy employees_select
  on public.employees
  for select
  to authenticated
  using (true);

-- 追加：総務・経営のみ
drop policy if exists employees_insert on public.employees;
create policy employees_insert
  on public.employees
  for insert
  to authenticated
  with check (public.current_permission() in ('hr','executive'));

-- 更新：総務・経営のみ（自分の情報変更や紐付けは link 関数／設定画面経由）
drop policy if exists employees_update on public.employees;
create policy employees_update
  on public.employees
  for update
  to authenticated
  using (public.current_permission() in ('hr','executive'))
  with check (public.current_permission() in ('hr','executive'));

-- 削除：経営のみ（原則は is_active=false の論理削除を推奨）
drop policy if exists employees_delete on public.employees;
create policy employees_delete
  on public.employees
  for delete
  to authenticated
  using (public.current_permission() = 'executive');

-- ---- fiscal_periods ----
-- 参照：ログイン済みなら読める
drop policy if exists fiscal_periods_select on public.fiscal_periods;
create policy fiscal_periods_select
  on public.fiscal_periods
  for select
  to authenticated
  using (true);

-- 追加・更新・削除：総務・経営のみ
drop policy if exists fiscal_periods_write on public.fiscal_periods;
create policy fiscal_periods_write
  on public.fiscal_periods
  for all
  to authenticated
  using (public.current_permission() in ('hr','executive'))
  with check (public.current_permission() in ('hr','executive'));

-- ============ [2/3] 0001_phase1_reports_attendance.sql ============
-- ============================================================
-- FORT 社内ポータル ｜ Phase 1：日報・勤怠
--   - daily_reports / report_project_links
--   - attendance / leave_requests / leave_balances
--   ＋ 可視範囲ヘルパー関数 ＋ RLS
-- docs/04_data_model.md / docs/06_roadmap.md
-- ============================================================

-- ------------------------------------------------------------
-- 可視範囲ヘルパー（SECURITY DEFINER：RLS 内での再帰を避ける）
-- ------------------------------------------------------------

-- 現在ユーザーに対応する社員 id
create or replace function public.current_employee_id()
returns uuid
language sql
stable
security definer
set search_path = public
as $$
  select id from public.employees where auth_user_id = auth.uid() limit 1;
$$;

-- 対象社員のデータを現在ユーザーが閲覧してよいか
--   本人 → 可 ／ 総務・経営 → 全員 ／ 管理職 → 同じ部署
create or replace function public.can_view_employee(target uuid)
returns boolean
language plpgsql
stable
security definer
set search_path = public
as $$
declare
  me     public.employees;
  t_dept text;
begin
  select * into me from public.employees where auth_user_id = auth.uid() limit 1;
  if me.id is null then
    return false;
  end if;
  if me.id = target then
    return true;
  end if;
  if me.permission in ('hr', 'executive') then
    return true;
  end if;
  if me.permission = 'manager' then
    select dept into t_dept from public.employees where id = target;
    return t_dept is not distinct from me.dept;
  end if;
  return false;
end;
$$;

grant execute on function public.current_employee_id() to authenticated;
grant execute on function public.can_view_employee(uuid) to authenticated;

-- ------------------------------------------------------------
-- daily_reports（日報）
-- ------------------------------------------------------------
create table if not exists public.daily_reports (
  id           uuid primary key default gen_random_uuid(),
  employee_id  uuid not null references public.employees(id) on delete cascade,
  report_date  date not null,
  plan_am      text,
  plan_pm      text,
  plan_ev      text,
  result_am    text,
  result_pm    text,
  result_ev    text,
  base         text,                      -- その日の主な拠点
  submitted    boolean not null default false,
  submitted_at timestamptz,
  created_at   timestamptz not null default now(),
  updated_at   timestamptz not null default now(),
  unique (employee_id, report_date)
);

create index if not exists daily_reports_date_idx on public.daily_reports (report_date);
create index if not exists daily_reports_emp_date_idx on public.daily_reports (employee_id, report_date);

create trigger daily_reports_set_updated_at
  before update on public.daily_reports
  for each row execute function public.set_updated_at();

-- ------------------------------------------------------------
-- report_project_links（日報↔案件の紐付け）
--   projects テーブルは Phase 2 で作成するため、
--   ここでは project_id を FK 無しの uuid として持つ（Phase 2 で FK 追加）。
-- ------------------------------------------------------------
create table if not exists public.report_project_links (
  id              uuid primary key default gen_random_uuid(),
  daily_report_id uuid not null references public.daily_reports(id) on delete cascade,
  project_id      uuid,                   -- → projects（Phase 2 で FK 化）
  slot            text check (slot in ('am', 'pm', 'ev')),
  note            text,
  created_at      timestamptz not null default now(),
  updated_at      timestamptz not null default now()
);

create index if not exists report_project_links_report_idx
  on public.report_project_links (daily_report_id);

create trigger report_project_links_set_updated_at
  before update on public.report_project_links
  for each row execute function public.set_updated_at();

-- ------------------------------------------------------------
-- attendance（勤怠：出退勤）
-- ------------------------------------------------------------
create table if not exists public.attendance (
  id               uuid primary key default gen_random_uuid(),
  employee_id      uuid not null references public.employees(id) on delete cascade,
  work_date        date not null,
  clock_in         time,
  clock_out        time,
  break_minutes    int not null default 0,
  overtime_minutes int,
  status           text not null default '出勤',   -- 出勤／休暇／外出／直行直帰 等
  note             text,
  created_at       timestamptz not null default now(),
  updated_at       timestamptz not null default now(),
  unique (employee_id, work_date)
);

create index if not exists attendance_date_idx on public.attendance (work_date);

create trigger attendance_set_updated_at
  before update on public.attendance
  for each row execute function public.set_updated_at();

-- ------------------------------------------------------------
-- leave_requests（休暇・各種休み申請）
-- ------------------------------------------------------------
create table if not exists public.leave_requests (
  id           uuid primary key default gen_random_uuid(),
  employee_id  uuid not null references public.employees(id) on delete cascade,
  leave_type   text not null,             -- 有給／代休／公休／半休 等
  start_date   date not null,
  end_date     date not null,
  reason       text,
  status       text not null default '申請中'
                 check (status in ('申請中', '承認', '差戻し', '却下')),
  approver_id  uuid references public.employees(id) on delete set null,
  decided_at   timestamptz,
  created_at   timestamptz not null default now(),
  updated_at   timestamptz not null default now()
);

create index if not exists leave_requests_emp_idx on public.leave_requests (employee_id);
create index if not exists leave_requests_range_idx on public.leave_requests (start_date, end_date);

create trigger leave_requests_set_updated_at
  before update on public.leave_requests
  for each row execute function public.set_updated_at();

-- ------------------------------------------------------------
-- leave_balances（有給残）
-- ------------------------------------------------------------
create table if not exists public.leave_balances (
  id           uuid primary key default gen_random_uuid(),
  employee_id  uuid not null references public.employees(id) on delete cascade,
  fiscal_label text not null,             -- 例：10期
  granted_days numeric not null default 0,
  used_days    numeric not null default 0,
  created_at   timestamptz not null default now(),
  updated_at   timestamptz not null default now(),
  unique (employee_id, fiscal_label)
);

create trigger leave_balances_set_updated_at
  before update on public.leave_balances
  for each row execute function public.set_updated_at();

-- ============================================================
-- RLS
-- ============================================================
alter table public.daily_reports        enable row level security;
alter table public.report_project_links enable row level security;
alter table public.attendance            enable row level security;
alter table public.leave_requests        enable row level security;
alter table public.leave_balances        enable row level security;

-- ---- daily_reports ----
-- 参照：本人・部署管理職・総務・経営
drop policy if exists daily_reports_select on public.daily_reports;
create policy daily_reports_select on public.daily_reports
  for select to authenticated
  using (public.can_view_employee(employee_id));

-- 書き込みは本人のみ
drop policy if exists daily_reports_insert on public.daily_reports;
create policy daily_reports_insert on public.daily_reports
  for insert to authenticated
  with check (employee_id = public.current_employee_id());

drop policy if exists daily_reports_update on public.daily_reports;
create policy daily_reports_update on public.daily_reports
  for update to authenticated
  using (employee_id = public.current_employee_id())
  with check (employee_id = public.current_employee_id());

drop policy if exists daily_reports_delete on public.daily_reports;
create policy daily_reports_delete on public.daily_reports
  for delete to authenticated
  using (employee_id = public.current_employee_id());

-- ---- report_project_links（親日報の可視性に従う）----
drop policy if exists report_links_select on public.report_project_links;
create policy report_links_select on public.report_project_links
  for select to authenticated
  using (exists (
    select 1 from public.daily_reports r
    where r.id = daily_report_id and public.can_view_employee(r.employee_id)
  ));

drop policy if exists report_links_write on public.report_project_links;
create policy report_links_write on public.report_project_links
  for all to authenticated
  using (exists (
    select 1 from public.daily_reports r
    where r.id = daily_report_id and r.employee_id = public.current_employee_id()
  ))
  with check (exists (
    select 1 from public.daily_reports r
    where r.id = daily_report_id and r.employee_id = public.current_employee_id()
  ));

-- ---- attendance ----
drop policy if exists attendance_select on public.attendance;
create policy attendance_select on public.attendance
  for select to authenticated
  using (public.can_view_employee(employee_id));

drop policy if exists attendance_insert on public.attendance;
create policy attendance_insert on public.attendance
  for insert to authenticated
  with check (employee_id = public.current_employee_id());

drop policy if exists attendance_update on public.attendance;
create policy attendance_update on public.attendance
  for update to authenticated
  using (employee_id = public.current_employee_id())
  with check (employee_id = public.current_employee_id());

drop policy if exists attendance_delete on public.attendance;
create policy attendance_delete on public.attendance
  for delete to authenticated
  using (employee_id = public.current_employee_id());

-- ---- leave_requests ----
-- 参照：本人・部署管理職・総務・経営、加えて承認者
drop policy if exists leave_requests_select on public.leave_requests;
create policy leave_requests_select on public.leave_requests
  for select to authenticated
  using (
    public.can_view_employee(employee_id)
    or approver_id = public.current_employee_id()
  );

-- 申請：本人のみ
drop policy if exists leave_requests_insert on public.leave_requests;
create policy leave_requests_insert on public.leave_requests
  for insert to authenticated
  with check (employee_id = public.current_employee_id());

-- 更新：本人（自分の申請の編集）または 承認権限者（管理職・総務・経営）
drop policy if exists leave_requests_update on public.leave_requests;
create policy leave_requests_update on public.leave_requests
  for update to authenticated
  using (
    employee_id = public.current_employee_id()
    or public.current_permission() in ('manager', 'hr', 'executive')
  )
  with check (
    employee_id = public.current_employee_id()
    or public.current_permission() in ('manager', 'hr', 'executive')
  );

-- 取消：本人（申請中のみ）
drop policy if exists leave_requests_delete on public.leave_requests;
create policy leave_requests_delete on public.leave_requests
  for delete to authenticated
  using (employee_id = public.current_employee_id() and status = '申請中');

-- ---- leave_balances ----
drop policy if exists leave_balances_select on public.leave_balances;
create policy leave_balances_select on public.leave_balances
  for select to authenticated
  using (public.can_view_employee(employee_id));

drop policy if exists leave_balances_write on public.leave_balances;
create policy leave_balances_write on public.leave_balances
  for all to authenticated
  using (public.current_permission() in ('hr', 'executive'))
  with check (public.current_permission() in ('hr', 'executive'));

-- ------------------------------------------------------------
-- 「本日休みの人」（docs/06_roadmap.md Phase 1-9）
--   承認済み休暇＋日報の休み記載から集計。
--   氏名・部署・区分ラベルのみ返し、休暇理由などの詳細は返さない
--   （個別の leave_requests は RLS で保護したまま、全社に休みだけ共有）。
-- ------------------------------------------------------------
create or replace function public.off_today()
returns table (employee_id uuid, name text, dept text, label text)
language sql
stable
security definer
set search_path = public
as $$
  with d as (
    select (now() at time zone 'Asia/Tokyo')::date as today
  )
  -- 承認済みの休暇
  select e.id, e.name, e.dept, lr.leave_type as label
  from public.leave_requests lr
  join public.employees e on e.id = lr.employee_id
  cross join d
  where lr.status = '承認'
    and d.today between lr.start_date and lr.end_date
    and e.is_active
  union
  -- 日報に休みの記載
  select e.id, e.name, e.dept, '休み' as label
  from public.daily_reports r
  join public.employees e on e.id = r.employee_id
  cross join d
  where r.report_date = d.today
    and e.is_active
    and (
      coalesce(r.plan_am, '') || coalesce(r.plan_pm, '') || coalesce(r.plan_ev, '') ||
      coalesce(r.result_am, '') || coalesce(r.result_pm, '') || coalesce(r.result_ev, '')
    ) ~ '(公休|有給|代休|休み|休暇|欠勤)';
$$;

grant execute on function public.off_today() to authenticated;

-- ============ [3/3] seed.sql ============
-- ============================================================
-- FORT 社内ポータル ｜ 初期データ（seed）
--   Phase 0：会計期 ＋ 社員マスタ 14名
-- docs/04_data_model.md「実データのサンプル」より
-- ============================================================
--
-- ⚠️ メールアドレスは仮の値（ローマ字から生成した placeholder）です。
--    ログインは employees.email との一致で許可されるため、
--    運用前に必ず実際の @fort410.jp のアドレスへ修正してください。
--    部署・役職・権限も暫定です。Phase 0 実装後、設定画面から調整します。
-- ============================================================

-- ---- 会計期（fiscal_periods）----
insert into public.fiscal_periods (label, start_date, end_date) values
  ('10期', '2025-10-01', '2026-09-30'),   -- 開始日は推定（12ヶ月想定）
  ('11期', '2026-10-01', '2027-01-31'),   -- 短期4ヶ月（M&Aのため）
  ('12期', '2027-02-01', null)            -- 進行中（終了日は未確定）
on conflict (label) do nothing;

-- ---- 社員マスタ（employees）----
insert into public.employees
  (employee_no, name, email, dept, role_title, base, employment, permission)
values
  ('F-001', '青野 弘輝', 'aono@fort410.jp',       '経営', '専務取締役',   '岡山', '役員', 'executive'),
  ('F-002', '中尾 実樹',   'nakao@fort410.jp',      '営業', '営業', '福山', '正社員', 'manager'),
  ('F-003', '坂本 薫', 'sakamoto@fort410.jp',   '設計', '設計',         '岡山', '正社員', 'member'),
  ('F-004', '中山 七海', 'nakayama@fort410.jp',   '総務', '総務',         '岡山', 'パート', 'member'),
  ('F-005', '松川 琳斗',  'matsukawa@fort410.jp',  '設計', '設計',     '岡山', '正社員', 'manager'),
  ('F-006', '日笠 泰成', 'higasa@fort410.jp',     '工務', '工務',         '岡山', '正社員', 'member'),
  ('F-007', '山下 唯',   'yamashita@fort410.jp',  '設計', '設計',         '福山', '正社員', 'member'),
  ('F-008', '村上 芽生', 'murakami@fort410.jp',   '設計', '設計',         '岡山', '正社員', 'member'),
  ('F-009', '長瀧 渉',   'nagataki@fort410.jp',   '工務', '管理建築士',     '岡山', '正社員', 'manager'),
  ('F-010', '古林 真希', 'kobayashi@fort410.jp','設計', '設計',     '福山', '正社員', 'member'),
  ('F-011', '加藤 真穂',   'kato@fort410.jp',       '工務', '工務',         '岡山', '正社員', 'member'),
  ('F-012', '石田 一成', 'ishida@fort410.jp',     '工務', '工務',         '福山', '正社員', 'member'),
  ('F-013', '松﨑 真紀', 'matsuzaki@fort410.jp',  '工務', '工務部長',         '福山', '正社員', 'member'),
  ('F-014', '中村 涼子', 'r.nakamura@fort410.jp',   '総務', '総務',         '岡山', '正社員', 'hr')
  ('F-015', '川崎 力', 'kawasaki@fort410.jp',   '経営', '常務取締役',         '福山', '役員', 'hr')
on conflict (employee_no) do nothing;

-- ---- 有給残（leave_balances）10期・仮の付与日数 ----
-- ※ 実際の付与日数は勤続年数で異なります。運用前に総務が調整してください。
insert into public.leave_balances (employee_id, fiscal_label, granted_days, used_days)
select e.id, '10期', 10, 0
from public.employees e
on conflict (employee_id, fiscal_label) do nothing;

-- ============================================================
-- ★最後に必ず：ログインする自分の実アドレスを設定★
--   下の 'あなた@fort410.jp' を、実際にログインに使う
--   @fort410.jp のメールアドレスに書き換えて実行してください。
--   （このアドレスが社員マスタと一致しないとログインできません）
-- ------------------------------------------------------------
-- update public.employees
--   set email = 'あなた@fort410.jp'
--   where employee_no = 'F-001';   -- 青野 弘輝（経営・executive）
-- ============================================================
