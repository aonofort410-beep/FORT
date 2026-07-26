import { getCurrentEmployee } from "@/lib/auth";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { PERMISSION_LABELS, type Permission } from "@/lib/constants";
import {
  CalendarOff,
  FileText,
  CalendarCheck,
  AlertTriangle,
} from "lucide-react";

/** 氏名から下の名前を取り出す（「青野 弘輝」→「弘輝」） */
function givenName(name: string) {
  const parts = name.trim().split(/[\s　]+/);
  return parts.length > 1 ? parts[parts.length - 1] : name;
}

/** 時間帯であいさつを変える（静かで少しだけパーソナルに） */
function greeting() {
  const h = new Date().getHours();
  if (h < 5) return "おつかれさまです";
  if (h < 11) return "おはようございます";
  if (h < 18) return "こんにちは";
  return "おつかれさまです";
}

/** 次Phaseで中身が入るサマリー枠 */
function SummarySlot({
  eyebrow,
  title,
  icon: Icon,
  phase,
}: {
  eyebrow: string;
  title: string;
  icon: React.ComponentType<{ className?: string }>;
  phase: number;
}) {
  return (
    <Card>
      <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
        <div>
          <p className="eyebrow">{eyebrow}</p>
          <CardTitle className="mt-1 text-base">{title}</CardTitle>
        </div>
        <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
          <Icon className="h-[18px] w-[18px]" />
        </div>
      </CardHeader>
      <CardContent>
        <div className="flex items-center gap-2">
          <span className="pill pill--warn">準備中</span>
          <span className="text-xs text-sub">Phase {phase} で表示</span>
        </div>
      </CardContent>
    </Card>
  );
}

export default async function DashboardPage() {
  const employee = await getCurrentEmployee();
  const name = employee?.name ?? "";
  const permission = (employee?.permission ?? "member") as Permission;

  return (
    <div className="space-y-8">
      {/* あいさつ */}
      <div>
        <p className="eyebrow">DASHBOARD</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">
          {greeting()}、{givenName(name)} さん。
        </h1>
        <p className="mt-2 text-sm text-sub">
          {[employee?.base, employee?.dept, employee?.role_title]
            .filter(Boolean)
            .join(" ・ ")}
          {employee && (
            <span className="ml-2 text-xs">
              （権限：{PERMISSION_LABELS[permission]}）
            </span>
          )}
        </p>
      </div>

      {/* サマリー枠（各Phaseで中身を差し込む） */}
      <section>
        <h2 className="mb-3 text-sm font-semibold text-ink">今日の状況</h2>
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
          <SummarySlot
            eyebrow="OFF TODAY"
            title="本日休みの人"
            icon={CalendarOff}
            phase={1}
          />
          <SummarySlot
            eyebrow="REPORTS"
            title="日報 未提出"
            icon={FileText}
            phase={1}
          />
          <SummarySlot
            eyebrow="RESERVATIONS"
            title="本日の予約"
            icon={CalendarCheck}
            phase={2}
          />
          <SummarySlot
            eyebrow="DELAYED"
            title="遅延案件"
            icon={AlertTriangle}
            phase={2}
          />
        </div>
      </section>

      {/* これから入るエリア */}
      <section className="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <Card className="lg:col-span-2">
          <CardHeader>
            <p className="eyebrow">MY TASKS</p>
            <CardTitle className="text-base">やること・承認待ち</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="flex min-h-[140px] flex-col items-center justify-center gap-2 text-center">
              <span className="pill pill--warn">準備中</span>
              <p className="text-sm text-sub">
                タスクと承認は Phase 3 でここに集約されます。
              </p>
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader>
            <p className="eyebrow">NOTICE</p>
            <CardTitle className="text-base">お知らせ</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="flex min-h-[140px] flex-col items-center justify-center gap-2 text-center">
              <span className="pill pill--muted">まだありません</span>
              <p className="text-sm text-sub">
                社内のお知らせは Phase 4 で表示されます。
              </p>
            </div>
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
