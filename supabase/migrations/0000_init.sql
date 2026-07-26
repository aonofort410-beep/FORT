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
