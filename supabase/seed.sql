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
  ('F-001', '青野 弘輝', 'h.aono@fort410.jp',       '経営', '専務取締役',   '岡山', '正社員', 'executive'),
  ('F-002', '中尾 翔',   's.nakao@fort410.jp',      '営業', '営業リーダー', '岡山', '正社員', 'manager'),
  ('F-003', '坂本 美咲', 'm.sakamoto@fort410.jp',   '営業', '営業',         '岡山', '正社員', 'member'),
  ('F-004', '中山 奈央', 'n.nakayama@fort410.jp',   '営業', '営業',         '岡山', '正社員', 'member'),
  ('F-005', '松川 亮',   'r.matsukawa@fort410.jp',  '設計', '設計主任',     '岡山', '正社員', 'manager'),
  ('F-006', '日笠 拓也', 't.higasa@fort410.jp',     '設計', '設計',         '岡山', '正社員', 'member'),
  ('F-007', '山下 彩',   'a.yamashita@fort410.jp',  '設計', '設計',         '岡山', '正社員', 'member'),
  ('F-008', '村上 大輔', 'd.murakami@fort410.jp',   '設計', '設計',         '福山', '正社員', 'member'),
  ('F-009', '長瀧 誠',   'm.nagataki@fort410.jp',   '工務', '工務部長',     '岡山', '正社員', 'manager'),
  ('F-010', '古林 誠一', 's.furubayashi@fort410.jp','工務', '工務主任',     '岡山', '正社員', 'member'),
  ('F-011', '加藤 健',   'k.kato@fort410.jp',       '工務', '工務',         '岡山', '正社員', 'member'),
  ('F-012', '石田 翔平', 's.ishida@fort410.jp',     '工務', '工務',         '岡山', '正社員', 'member'),
  ('F-013', '松﨑 健太', 'k.matsuzaki@fort410.jp',  '工務', '工務',         '福山', '正社員', 'member'),
  ('F-014', '中村 涼子', 'r.nakamura@fort410.jp',   '総務', '総務',         '岡山', '正社員', 'hr')
on conflict (employee_no) do nothing;
