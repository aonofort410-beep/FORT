import { redirect } from "next/navigation";
import { AppSidebar } from "@/components/app-sidebar";
import { AppHeader } from "@/components/app-header";
import { getAuthUser, getCurrentEmployee } from "@/lib/auth";
import type { Permission } from "@/lib/constants";

/**
 * ログイン後の共通レイアウト（サイドバー＋ヘッダー＋レスポンシブ）。
 * ここで現在の社員を解決し、未登録・未ログインは弾く。
 */
export default async function PortalLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const user = await getAuthUser();
  if (!user) redirect("/login");

  const employee = await getCurrentEmployee();
  if (!employee) redirect("/login?error=unregistered");

  return (
    <div className="min-h-screen bg-bg">
      <AppSidebar />
      <div className="lg:pl-64">
        <AppHeader
          name={employee.name}
          dept={employee.dept}
          roleTitle={employee.role_title}
          permission={employee.permission as Permission}
        />
        <main className="mx-auto max-w-7xl px-4 py-6 lg:px-8 lg:py-8">
          {children}
        </main>
      </div>
    </div>
  );
}
