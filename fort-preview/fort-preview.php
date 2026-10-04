<?php
/**
 * Plugin Name: FORT 新デザイン プレビュー
 * Description: 有効にすると、ログイン中の管理者だけに新デザイン（fort-theme）を表示します。訪問者には今までのサイトがそのまま表示されます。切り替えの準備（施工事例・モデルハウス・写真の入力）に使い、本番切り替え後は無効化・削除してください。
 * Version: 1.0
 * Author: FORT
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/** プレビューに使うテーマのフォルダ名 */
const FORT_PREVIEW_THEME = 'fort-theme';

/** このリクエストで新デザインを使うか（管理者がログイン中 かつ テーマがインストール済み） */
function fort_preview_on() {
	static $on = null;
	if ( null !== $on ) return $on;
	$on = false;
	if ( get_option( 'template' ) === FORT_PREVIEW_THEME ) return $on; // すでに本番切り替え済み
	if ( ! function_exists( 'wp_get_current_user' ) || ! is_user_logged_in() ) return $on;
	if ( ! current_user_can( 'edit_theme_options' ) ) return $on;
	$theme = wp_get_theme( FORT_PREVIEW_THEME );
	$on = $theme->exists();
	return $on;
}

add_filter( 'template', function ( $t ) { return fort_preview_on() ? FORT_PREVIEW_THEME : $t; } );
add_filter( 'stylesheet', function ( $t ) { return fort_preview_on() ? FORT_PREVIEW_THEME : $t; } );

/** 上部の管理バーに「新デザインでプレビュー中」と表示 */
add_action( 'admin_bar_menu', function ( $bar ) {
	if ( ! fort_preview_on() ) return;
	$bar->add_node( array(
		'id'    => 'fort-preview',
		'title' => '● 新デザインでプレビュー中（訪問者には旧デザイン）',
		'meta'  => array( 'html' => '<style>#wp-admin-bar-fort-preview>.ab-item{background:#a08a5c!important;color:#fff!important}</style>' ),
	) );
}, 999 );

/** 新デザイン用のページ（/now/・/place/・/about/ など）を「非公開」で用意する（管理者だけ見られる）。本番切り替え時に公開へ */
add_action( 'admin_init', function () {
	if ( ! fort_preview_on() || get_option( 'fort_preview_pages_done' ) ) return;
	$pages = array(
		'about'   => array( 'FORTについて', 'template-about.php', 0 ),
		'now'     => array( 'NOW', 'template-now.php', 0 ),
		'place'   => array( 'PLACE', 'template-place.php', 0 ),
		'contact' => array( 'お問い合わせ', 'template-contact.php', 0 ),
		'visit'   => array( '来場予約', 'template-visit.php', 0 ),
	);
	foreach ( $pages as $slug => $p ) {
		if ( get_page_by_path( $slug ) ) continue;
		$id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'private', 'post_title' => $p[0], 'post_name' => $slug ) );
		if ( $id && ! is_wp_error( $id ) ) update_post_meta( $id, '_wp_page_template', $p[1] );
	}
	$place = get_page_by_path( 'place' );
	if ( $place ) {
		foreach ( array( 'okayama' => '岡山', 'fukuyama' => '福山' ) as $slug => $title ) {
			if ( get_page_by_path( 'place/' . $slug ) ) continue;
			$id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'private', 'post_title' => $title, 'post_name' => $slug, 'post_parent' => $place->ID ) );
			if ( $id && ! is_wp_error( $id ) ) update_post_meta( $id, '_wp_page_template', 'template-place.php' );
		}
	}
	update_option( 'fort_preview_pages_done', 1 );
	flush_rewrite_rules();
} );
