<?php
/**
 * FORT テーマ / 基本設定
 * ------------------------------------------------------------
 * ・カスタム投稿タイプ（施工事例 / スタッフ / イベント）を登録
 * ・お知らせは WordPress 標準の「投稿」を使います
 * ・各投稿の編集項目（価格・面積・役職など）を追加
 * ・ヘッダーのキャッチコピーや電話番号は「外観 > カスタマイズ」で編集可
 * ============================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ============================================================
   1. テーマの基本サポート
============================================================ */
function fort_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' ); // アイキャッチ画像（＝メイン写真）
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus( array(
		'primary' => 'メインメニュー（目次）',
	) );

	// アイキャッチの推奨サイズ
	add_image_size( 'fort-card', 900, 600, true );
	add_image_size( 'fort-hero', 2000, 1200, true );
	add_image_size( 'fort-square', 800, 800, true );
}
add_action( 'after_setup_theme', 'fort_setup' );

/* ============================================================
   2. CSS / JS の読み込み
============================================================ */
function fort_assets() {
	$ver = '1.0.0';
	// Google Fonts
	wp_enqueue_style( 'fort-gfont', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@500;600&display=swap', array(), null );
	// 本体スタイル
	wp_enqueue_style( 'fort-style', get_template_directory_uri() . '/assets/style.css', array(), $ver );
	// WordPress必須のstyle.css（テーマ情報）も一応読み込み
	wp_enqueue_style( 'fort-theme', get_stylesheet_uri(), array( 'fort-style' ), $ver );
	// 動き
	wp_enqueue_script( 'fort-script', get_template_directory_uri() . '/assets/script.js', array(), $ver, true );

	// 目次メニューの中身を WordPress のURLで差し込む（script.js が使用）
	$menu = array(
		array( 'en' => 'HOME',        'ja' => 'トップ',                 'href' => home_url( '/' ) ),
		array( 'en' => 'CONCEPT',     'ja' => '私たちの想い',           'href' => home_url( '/#concept' ) ),
		array( 'en' => 'WORKS',       'ja' => '施工事例',               'href' => get_post_type_archive_link( 'works' ) ),
		array( 'en' => 'PERFORMANCE', 'ja' => '構造・性能',             'href' => home_url( '/#performance' ) ),
		array( 'en' => 'FLOW',        'ja' => '家づくりの流れ',         'href' => home_url( '/#flow' ) ),
		array( 'en' => 'LINEUP',      'ja' => '商品ラインナップ',       'href' => home_url( '/#lineup' ) ),
		array( 'en' => 'EVENT',       'ja' => '見学会・イベント',       'href' => get_post_type_archive_link( 'fort_event' ) ),
		array( 'en' => 'STAFF',       'ja' => 'スタッフ紹介',           'href' => get_post_type_archive_link( 'staff' ) ),
		array( 'en' => 'NEWS',        'ja' => 'お知らせ',               'href' => home_url( '/news/' ) ),
		array( 'en' => 'COMPANY',     'ja' => '会社概要',               'href' => home_url( '/#reserve' ) ),
		array( 'en' => 'CONTACT',     'ja' => 'ご予約・お問い合わせ',   'href' => home_url( '/#reserve' ) ),
	);
	wp_add_inline_script( 'fort-script', 'window.FORT_MENU = ' . wp_json_encode( $menu ) . ';', 'before' );
}
add_action( 'wp_enqueue_scripts', 'fort_assets' );

/* ============================================================
   3. カスタム投稿タイプ（管理画面から追加・編集できる箱）
============================================================ */
function fort_post_types() {

	// --- 施工事例 ---
	register_post_type( 'works', array(
		'labels' => array(
			'name'          => '施工事例',
			'singular_name' => '施工事例',
			'add_new'       => '新規追加',
			'add_new_item'  => '施工事例を追加',
			'edit_item'     => '施工事例を編集',
			'all_items'     => '施工事例一覧',
		),
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-admin-home',
		'menu_position'=> 5,
		'rewrite'      => array( 'slug' => 'works' ),
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest' => true,
	) );

	// 施工事例のカテゴリ（注文住宅・平屋 など）
	register_taxonomy( 'works_cat', 'works', array(
		'labels'       => array( 'name' => '事例カテゴリ', 'singular_name' => 'カテゴリ' ),
		'public'       => true,
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'works-cat' ),
	) );

	// --- スタッフ ---
	register_post_type( 'staff', array(
		'labels' => array(
			'name'          => 'スタッフ',
			'singular_name' => 'スタッフ',
			'add_new_item'  => 'スタッフを追加',
			'edit_item'     => 'スタッフを編集',
			'all_items'     => 'スタッフ一覧',
		),
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-groups',
		'menu_position'=> 6,
		'rewrite'      => array( 'slug' => 'staff' ),
		'supports'     => array( 'title', 'thumbnail', 'page-attributes' ), // page-attributes=並び順
		'show_in_rest' => true,
	) );

	// --- イベント / 見学会 ---
	register_post_type( 'fort_event', array(
		'labels' => array(
			'name'          => 'イベント',
			'singular_name' => 'イベント',
			'add_new_item'  => 'イベントを追加',
			'edit_item'     => 'イベントを編集',
			'all_items'     => 'イベント一覧',
		),
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-calendar-alt',
		'menu_position'=> 7,
		'rewrite'      => array( 'slug' => 'event' ),
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'fort_post_types' );

/* お知らせ（標準投稿）のスラッグを /news/ に、ラベルも「お知らせ」に */
function fort_rename_posts( $args, $post_type ) {
	if ( 'post' === $post_type ) {
		$args['labels']['name']          = 'お知らせ';
		$args['labels']['singular_name'] = 'お知らせ';
		$args['rewrite'] = array( 'slug' => 'news' );
		$args['has_archive'] = 'news';
	}
	return $args;
}
add_filter( 'register_post_type_args', 'fort_rename_posts', 10, 2 );

/* ============================================================
   4. 各投稿の編集項目（メタボックス）
   ※ プラグイン不要。管理画面の編集欄にフォームが出ます
============================================================ */
function fort_meta_boxes() {
	add_meta_box( 'fort_works_meta', '施工事例の詳細', 'fort_works_meta_cb', 'works', 'normal', 'high' );
	add_meta_box( 'fort_staff_meta', 'スタッフ情報', 'fort_staff_meta_cb', 'staff', 'normal', 'high' );
	add_meta_box( 'fort_event_meta', 'イベント情報', 'fort_event_meta_cb', 'fort_event', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'fort_meta_boxes' );

function fort_text_field( $post_id, $key, $label, $ph = '' ) {
	$val = esc_attr( get_post_meta( $post_id, $key, true ) );
	echo '<p style="margin:10px 0;"><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label>';
	echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . $val . '" placeholder="' . esc_attr( $ph ) . '" style="width:100%;padding:6px;"></p>';
}

function fort_works_meta_cb( $post ) {
	wp_nonce_field( 'fort_meta', 'fort_meta_nonce' );
	fort_text_field( $post->ID, 'fort_area',       'エリア（カードに表示）', '例：注文住宅 ／ 倉敷市' );
	fort_text_field( $post->ID, 'fort_price',      '参考価格帯', '例：2,500万円台〜' );
	fort_text_field( $post->ID, 'fort_location',   '所在地', '例：岡山県倉敷市' );
	fort_text_field( $post->ID, 'fort_family',     'ご家族構成', '例：ご夫婦＋お子さま2人' );
	fort_text_field( $post->ID, 'fort_floorarea',  '延床面積', '例：105.00㎡（約32坪）' );
	fort_text_field( $post->ID, 'fort_layout',     '間取り', '例：3LDK＋中庭' );
	fort_text_field( $post->ID, 'fort_completion', '竣工', '例：2025年' );
	fort_text_field( $post->ID, 'fort_series',     'シリーズ', '例：FORT DESIGN（自由設計）' );
	fort_text_field( $post->ID, 'fort_spec',       '構造・性能', '例：耐震等級3／UA値0.46以下' );
}

function fort_staff_meta_cb( $post ) {
	wp_nonce_field( 'fort_meta', 'fort_meta_nonce' );
	$dept = get_post_meta( $post->ID, 'fort_dept', true );
	echo '<p style="margin:10px 0;"><label style="display:block;font-weight:600;margin-bottom:4px;">部門</label><select name="fort_dept" style="width:100%;padding:6px;">';
	foreach ( array( 'sales' => '営業（コンサルティングコーディネーター）', 'design' => '設計（デザインコーディネーター）', 'construction' => '工務（エンジニアリングコーディネーター）', 'admin' => '総務' ) as $k => $v ) {
		echo '<option value="' . esc_attr( $k ) . '" ' . selected( $dept, $k, false ) . '>' . esc_html( $v ) . '</option>';
	}
	echo '</select></p>';
	fort_text_field( $post->ID, 'fort_role',    '職種（肩書き）', '例：コンサルティングコーディネーター' );
	fort_text_field( $post->ID, 'fort_name_en', '氏名（英字）', '例：Hiroki Aono' );
	fort_text_field( $post->ID, 'fort_cred',    '資格・役職など（名前の下に表示）', '例：二級建築士' );
}

function fort_event_meta_cb( $post ) {
	wp_nonce_field( 'fort_meta', 'fort_meta_nonce' );
	fort_text_field( $post->ID, 'fort_date',  '開催日（表示用）', '例：6/14〜6/15' );
	fort_text_field( $post->ID, 'fort_badge', '種別（バッジ）', '例：完成見学会' );
	fort_text_field( $post->ID, 'fort_place', '場所', '例：倉敷市' );
}

function fort_save_meta( $post_id ) {
	if ( ! isset( $_POST['fort_meta_nonce'] ) || ! wp_verify_nonce( $_POST['fort_meta_nonce'], 'fort_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	$keys = array( 'fort_area','fort_price','fort_location','fort_family','fort_floorarea','fort_layout','fort_completion','fort_series','fort_spec','fort_dept','fort_role','fort_name_en','fort_cred','fort_date','fort_badge','fort_place' );
	foreach ( $keys as $k ) {
		if ( isset( $_POST[ $k ] ) ) {
			update_post_meta( $post_id, $k, sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
		}
	}
}
add_action( 'save_post', 'fort_save_meta' );

/* 小さなヘルパー：メタ値を取得 */
function fort_meta( $key, $id = null ) {
	$id = $id ? $id : get_the_ID();
	return get_post_meta( $id, $key, true );
}

/* ============================================================
   5. カスタマイザー（ヘッダーのコピー・電話番号などを編集）
============================================================ */
function fort_customize( $wp ) {
	$wp->add_section( 'fort_hero', array( 'title' => 'FORT：トップのキャッチコピー', 'priority' => 30 ) );
	$fields = array(
		'fort_hero_eyebrow' => array( 'ラベル（上の小文字）', 'FORT｜岡山・倉敷・福山の家づくり' ),
		'fort_hero_line1'   => array( 'キャッチ1行目', '性能か、デザインか。' ),
		'fort_hero_accent'  => array( '強調（ゴールド）部分', 'その選択をしなくていい' ),
		'fort_hero_line2'   => array( 'キャッチ続き', '家づくり。' ),
		'fort_hero_lead'    => array( 'リード文', '営業・設計・工務がひとつのチームとなり、性能とデザインを高いレベルで両立する住まいをご提案します。' ),
	);
	foreach ( $fields as $id => $f ) {
		$wp->add_setting( $id, array( 'default' => $f[1], 'sanitize_callback' => 'wp_kses_post' ) );
		$wp->add_control( $id, array( 'label' => $f[0], 'section' => 'fort_hero', 'type' => 'text' ) );
	}

	$wp->add_section( 'fort_contact', array( 'title' => 'FORT：連絡先', 'priority' => 31 ) );
	$contact = array(
		'fort_tel_okayama' => array( '岡山スタジオ TEL', '086-236-9600' ),
		'fort_tel_fukuyama'=> array( '福山スタジオ TEL', '084-982-7404' ),
	);
	foreach ( $contact as $id => $f ) {
		$wp->add_setting( $id, array( 'default' => $f[1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp->add_control( $id, array( 'label' => $f[0], 'section' => 'fort_contact', 'type' => 'text' ) );
	}
}
add_action( 'customize_register', 'fort_customize' );

/* カスタマイザー値の取得ヘルパー */
function fort_opt( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/* ============================================================
   6. 抜粋の調整
============================================================ */
function fort_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'fort_excerpt_more' );
