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
