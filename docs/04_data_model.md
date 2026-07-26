# 04 ｜ データモデル（データベース設計）

Supabase（PostgreSQL）のテーブル設計。Phaseごとに必要なテーブルを作る。
すべてのテーブルに `id`（uuid, 主キー）、`created_at`、`updated_at` を持たせる。

> **命名**：テーブル名・カラム名は英語の snake_case。表示は日本語。
> **RLS**：各テーブルに Row Level Security を設定（`05_architecture.md` 参照）。

---

## Phase 0：基盤

### `employees`（社員マスタ）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | 主キー |
| auth_user_id | uuid | Supabase Auth のユーザーIDと紐付け |
| employee_no | text | 社員番号（例 F-001） |
| name | text | 氏名（例 青野 弘輝） |
| name_kana | text | フリガナ |
| email | text | @fort410.jp のメール |
| dept | text | 部署（経営／営業／設計／工務／総務） |
| role_title | text | 役職（専務取締役／営業リーダー 等） |
| base | text | 拠点（岡山／福山） |
| employment | text | 雇用形態（正社員 等） |
| joined_on | date | 入社日 |
| tel | text | 電話 |
| permission | text | 権限ロール（後述の `roles` の値） |
| is_active | boolean | 在籍中か |

### 権限ロール（enum 相当）

`permission` は次のいずれか。

| 値 | 意味 | できること |
|----|------|-----------|
| `executive` | 経営 | 全データ閲覧、全社ダッシュボード、設定 |
| `manager` | 管理職 | 自部署＋関連の広い閲覧、承認 |
| `hr` | 総務 | 勤怠・休日・申請・社員マスタの管理 |
| `member` | 一般 | 自分のデータ中心、必要範囲の閲覧 |

---

## Phase 1：日報・勤怠

### `daily_reports`（日報）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| employee_id | uuid | → employees |
| report_date | date | 対象日 |
| plan_am / plan_pm / plan_ev | text | 予定（午前／午後／夜） |
| result_am / result_pm / result_ev | text | 実績（午前／午後／夜） |
| base | text | その日の主な拠点 |
| submitted | boolean | 提出済みか |
| submitted_at | timestamptz | 提出時刻 |

- ユニーク制約：`(employee_id, report_date)`。
- 日報の1行から複数案件に触れることがあるので、案件紐付けは別テーブルに。

### `report_project_links`（日報↔案件の紐付け）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| daily_report_id | uuid | → daily_reports |
| project_id | uuid | → projects |
| slot | text | am / pm / ev |
| note | text | 「○○様邸 打合せ」等 |

### `attendance`（勤怠：出退勤）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| employee_id | uuid | → employees |
| work_date | date | 日付 |
| clock_in | time | 出勤 |
| clock_out | time | 退勤 |
| break_minutes | int | 休憩（分） |
| overtime_minutes | int | 残業（分、計算 or 入力） |
| status | text | 出勤／休暇／外出／直行直帰 等 |
| note | text | |

- ユニーク制約：`(employee_id, work_date)`。

### `leave_requests`（休暇・各種休み申請）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| employee_id | uuid | 申請者 |
| leave_type | text | 有給／代休／公休／半休 等 |
| start_date | date | |
| end_date | date | |
| reason | text | |
| status | text | 申請中／承認／差戻し／却下 |
| approver_id | uuid | → employees（承認者） |
| decided_at | timestamptz | |

### `leave_balances`（有給残）

| カラム | 型 | 説明 |
|--------|-----|------|
| employee_id | uuid | |
| fiscal_label | text | 会計期（例 10期） |
| granted_days | numeric | 付与 |
| used_days | numeric | 消化 |

---

## Phase 2：予約・案件

### `venues`（会場マスタ）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| name | text | 会場名（赤磐モデルハウス 等） |
| venue_type | text | モデルハウス／来場カウンター／建売モデル／建売 |
| area | text | 岡山／福山 |
| address | text | 住所 |
| map_url | text | Google地図URL |
| parking | text | 駐車場情報 |
| is_active | boolean | |

### `events`（見学会などのイベント）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| title | text | 「南区浦安 完成見学会」等 |
| catch_copy | text | キャッチコピー |
| venue_id | uuid | → venues（会場が定型なら） |
| place | text | 会場住所（イベント個別） |
| map_url | text | |
| start_date / end_date | date | 開催期間 |

### `reservation_slots`（予約枠）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| event_id | uuid | → events |
| slot_date | date | 日 |
| slot_time | time | 時間（10:00 等） |
| capacity | int | 定員（既定1） |

### `reservations`（来場予約）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| slot_id | uuid | → reservation_slots |
| customer_name | text | お客様名 |
| customer_tel | text | |
| staff_id | uuid | → employees（対応担当） |
| status | text | 予約／来場済／キャンセル |
| note | text | |

### `room_bookings`（社内リソース／席の予約）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| resource_name | text | 打合せスペース名・席名 |
| base | text | 岡山／福山 |
| booked_by | uuid | → employees |
| start_at / end_at | timestamptz | 予約時間帯 |
| purpose | text | 用途 |

### `projects`（案件）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| name | text | 「藤田様邸」等 |
| customer_name | text | お客様名 |
| base | text | 岡山／福山 |
| product_line | text | 注文住宅／規格住宅／建売住宅／リフォーム |
| sales_id | uuid | → employees（営業担当） |
| design_id | uuid | → employees（設計担当） |
| construction_id | uuid | → employees（工務担当） |
| stage | text | 工程段階（下記） |
| progress | int | 進捗率 0-100 |
| is_delayed | boolean | 遅延フラグ |
| next_action | text | 次回予定 |
| next_date | date | |
| issue | text | 課題メモ |

- **工程段階（stage）**：初回接客／資金計画／土地提案／プラン提案／見積提出／
  契約／詳細打合せ／確認申請／着工準備／着工／上棟／木工事／仕上工事／完成／
  引渡し／アフター（16段階）。

---

## Phase 3：タスク・申請・ダッシュボード

### `tasks`（タスク）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| title | text | |
| assignee_id | uuid | → employees |
| project_id | uuid | → projects（任意） |
| priority | text | 緊急／高／中／低 |
| status | text | 未着手／進行中／確認待ち／完了／差戻し |
| due_date | date | 期限 |

### `approvals`（申請ワークフロー）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| request_type | text | 有給／経費／値引／発注／代休／外注 等 |
| applicant_id | uuid | → employees |
| amount | numeric | 金額（該当時） |
| reason | text | |
| status | text | 申請中／承認／最終承認／差戻し／却下 |
| approver_id | uuid | → employees |
| requested_at / decided_at | timestamptz | |

> 休暇申請は `leave_requests` に、汎用申請は `approvals` に。将来は統合しても良い。

---

## Phase 4：資格・評価・ナレッジ

### `qualifications`（資格）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| holder_id | uuid | → employees |
| name | text | 一級建築士 等 |
| cert_no | text | 資格番号 |
| expire_on | date | 更新期限 |

### `reviews`（人事評価・面談）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| employee_id | uuid | 対象社員 |
| reviewer_id | uuid | 評価者 |
| period | text | 対象期間 |
| goals | text | 目標 |
| notes | text | 面談記録 |

### `documents`（ナレッジ・資料）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| title | text | |
| category | text | マニュアル／基準書／お知らせ 等 |
| file_url | text | Supabase Storage のパス |
| body | text | 本文（掲示板的な使い方も） |
| author_id | uuid | → employees |

### `notifications`（通知）

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| recipient_id | uuid | → employees |
| kind | text | 承認待ち／未提出／期限接近 等 |
| body | text | |
| link | text | 遷移先 |
| is_read | boolean | |

---

## 会計期の扱い

FORTの会計年度は非標準。期の定義は `fiscal_periods` テーブルで持つ。

### `fiscal_periods`

| カラム | 型 | 説明 |
|--------|-----|------|
| id | uuid | |
| label | text | 10期 / 11期 / 12期 |
| start_date | date | |
| end_date | date | |

- 10期：〜2026-09-30
- 11期：2026-10-01 〜 2027-01-31（短期4ヶ月、M&Aのため）
- 12期：2027-02-01 〜

---

## 実データのサンプル（初期投入の参考）

移行時の参考として、実データの形をここに残す。
Phase 0 の社員マスタ投入時に、以下14名を初期データとして入れる。

### 社員（部署・役職は日報の稼働実態から割当。要・実確認）

| 氏名 | 部署 | 役職 | 拠点 |
|------|------|------|------|
| 青野 弘輝 | 経営 | 専務取締役 | 岡山 |
| 中尾 翔 | 営業 | 営業リーダー | 岡山 |
| 坂本 美咲 | 営業 | 営業 | 岡山 |
| 中山 奈央 | 営業 | 営業 | 岡山 |
| 松川 亮 | 設計 | 設計主任 | 岡山 |
| 日笠 拓也 | 設計 | 設計 | 岡山 |
| 山下 彩 | 設計 | 設計 | 岡山 |
| 村上 大輔 | 設計 | 設計 | 福山 |
| 長瀧 誠 | 工務 | 工務部長 | 岡山 |
| 古林 誠一 | 工務 | 工務主任 | 岡山 |
| 加藤 健 | 工務 | 工務 | 岡山 |
| 石田 翔平 | 工務 | 工務 | 岡山 |
| 松﨑 健太 | 工務 | 工務 | 福山 |
| 中村 涼子 | 総務 | 総務 | 岡山 |

> 部署・役職・権限は暫定。Phase 0 実装後、実際の情報に合わせて設定画面から調整する。

### 会場マスタ（実在）

来場カウンター：問屋町・表町・福山。
モデルハウス：赤磐・一宮ソラマド・玉野番田・下加茂（福山）。
建売モデル：長船②・玉島上成コンセプトハウス。
建売：長船町福里・西中新田。
（各Google地図URLあり。Phase 2 で `venues` に投入。）

### 日報の構造（実データ）

社員ごと・日付ごとに、午前／午後／夜の「予定」と「実績」を自由記述。
例：「【岡山】10:00〜 堀田様邸打合せ」。休みは「公休／有給／代休／休み」と記載。
→ この構造を `daily_reports` の plan_am 等にそのまま対応させる。
