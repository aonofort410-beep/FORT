import { createClient } from "@/lib/supabase/server";
import type { Employee } from "@/types/database";
import type { User } from "@supabase/supabase-js";

/**
 * 現在ログイン中の Supabase Auth ユーザーを返す（未ログインなら null）。
 */
export async function getAuthUser(): Promise<User | null> {
  const supabase = await createClient();
  const {
    data: { user },
  } = await supabase.auth.getUser();
  return user;
}

/**
 * 現在ログイン中ユーザーに対応する社員レコードを返す。
 * - auth_user_id で紐付いた行を優先。
 * - 未紐付けなら、招待リスト（email 一致）で探して自動的に紐付ける。
 * - 見つからなければ null（＝未登録。総務の登録待ち）。
 */
export async function getCurrentEmployee(): Promise<Employee | null> {
  const supabase = await createClient();
  const {
    data: { user },
  } = await supabase.auth.getUser();
  if (!user) return null;

  // 1) auth_user_id で照合
  const { data: byAuth } = await supabase
    .from("employees")
    .select("*")
    .eq("auth_user_id", user.id)
    .maybeSingle();
  if (byAuth) return byAuth as Employee;

  // 2) 未紐付けなら、招待リスト（email 一致）へ auth_user_id を紐付ける。
  //    RLS を安全に通すため SECURITY DEFINER 関数（RPC）で実行する。
  await supabase.rpc("link_current_employee");

  const { data: linked } = await supabase
    .from("employees")
    .select("*")
    .eq("auth_user_id", user.id)
    .maybeSingle();

  return (linked as Employee) ?? null;
}
