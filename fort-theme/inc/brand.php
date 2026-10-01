<?php
/**
 * FORT ブランドサイト化（v2）で追加した仕組み
 * ------------------------------------------------------------
 * 1. サイト内リンクの一元管理（fort_url）
 *    固定ページがまだ無い場合は既存ページへ自動で逃がすので、リンク切れになりません。
 * 2. JOURNAL（読みもの）投稿タイプ
 * 3. イベントの地域・状態・期間などの項目
 * 4. YouTube（MOVIE）の登録欄
 * ============================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ============================================================
   1. サイト内リンク
============================================================ */

/** 最初に見つかった固定ページのURLを返す。どれも無ければ $fallback */
function fort_page_link( $paths, $fallback ) {
	foreach ( (array) $paths as $path ) {
		$page = get_page_by_path( $path );
		if ( $page && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return $fallback;
}

/** 情報設計（WORKS / HOUSE / EVENT / JOURNAL / PLACE / ABOUT / VISIT）のURL */
function fort_url( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) return $cache[ $key ];

	switch ( $key ) {
		case 'works':        $url = get_post_type_archive_link( 'works' ); break;
		case 'house':        $url = fort_page_link( array( 'house', 'lineup' ), home_url( '/lineup/' ) ); break;
		case 'design':       $url = fort_page_link( array( 'house/design', 'fort-design' ), home_url( '/fort-design/' ) ); break;
		case 'pro':          $url = fort_page_link( array( 'fort-pro', 'house/pro' ), home_url( '/fort-pro/' ) ); break;
		case 'style':        $url = fort_page_link( array( 'house/style' ), 'https://www.fortstyle.org/' ); break;
		case 'performance':  $url = fort_page_link( array( 'house/performance', 'performance' ), home_url( '/performance/' ) ); break;
		case 'flow':         $url = fort_page_link( array( 'house/flow', 'flow' ), home_url( '/flow/' ) ); break;
		case 'event':        $url = get_post_type_archive_link( 'fort_event' ); break;
		case 'journal':      $url = get_post_type_archive_link( 'journal' ); break;
		case 'place':        $url = fort_page_link( array( 'place', 'studio' ), home_url( '/studio/' ) ); break;
		case 'okayama':      $url = fort_page_link( array( 'place/okayama' ), fort_url( 'place' ) ); break;
		case 'fukuyama':     $url = fort_page_link( array( 'place/fukuyama' ), fort_url( 'place' ) ); break;
		case 'about':        $url = fort_page_link( array( 'about', 'company' ), home_url( '/company/' ) ); break;
		case 'company':      $url = fort_page_link( array( 'company' ), home_url( '/company/' ) ); break;
		case 'staff':        $url = get_post_type_archive_link( 'staff' ); break;
		case 'visit':        $url = fort_page_link( array( 'visit' ), home_url( '/visit/' ) ); break;
		case 'request':      $url = fort_page_link( array( 'request' ), home_url( '/request/' ) ); break;
		case 'contact':      $url = fort_page_link( array( 'contact' ), home_url( '/contact/' ) ); break;
		case 'privacy':      $url = get_privacy_policy_url() ? get_privacy_policy_url() : fort_page_link( array( 'privacy', 'privacy-policy' ), '' ); break;
		default:             $url = home_url( '/' );
	}
	return $cache[ $key ] = $url;
}

/** 予約ページへのURL（地域・イベントを引き継ぐ） */
function fort_visit_url( $args = array() ) {
	$args = array_filter( array_intersect_key( $args, array_flip( array( 'area', 'event' ) ) ) );
	return $args ? add_query_arg( $args, fort_url( 'visit' ) ) : fort_url( 'visit' );
}

/** グローバルナビ（ヘッダー・目次・フッターで共通） */
function fort_nav_items() {
	return array(
		array( 'en' => 'WORKS',   'ja' => '施工事例',       'href' => fort_url( 'works' ) ),
		array( 'en' => 'HOUSE',   'ja' => '家づくり',       'href' => fort_url( 'house' ) ),
		array( 'en' => 'EVENT',   'ja' => '見学会・イベント', 'href' => fort_url( 'event' ) ),
		array( 'en' => 'JOURNAL', 'ja' => '読みもの',       'href' => fort_url( 'journal' ), 'needs' => 'journal' ),
		array( 'en' => 'PLACE',   'ja' => '岡山・福山',     'href' => fort_url( 'place' ) ),
		array( 'en' => 'ABOUT',   'ja' => 'FORTについて',   'href' => fort_url( 'about' ) ),
		array( 'en' => 'VISIT',   'ja' => '来場予約',       'href' => fort_url( 'visit' ) ),
	);
}

/** JOURNAL は記事が1件以上あるときだけナビに出す */
function fort_nav_visible() {
	return array_values( array_filter( fort_nav_items(), function ( $item ) {
		return empty( $item['needs'] ) || fort_has_posts( $item['needs'] );
	} ) );
}

function fort_has_posts( $post_type ) {
	$c = wp_count_posts( $post_type );
	return $c && ! empty( $c->publish );
}

/* ============================================================
   2. JOURNAL（読みもの）
============================================================ */
function fort_register_journal() {
	register_post_type( 'journal', array(
		'labels' => array(
			'name'          => 'JOURNAL',
			'singular_name' => 'JOURNAL',
			'add_new_item'  => '記事を追加',
			'edit_item'     => '記事を編集',
			'all_items'     => '記事一覧',
		),
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-book-alt',
		'menu_position' => 8,
		'rewrite'       => array( 'slug' => 'journal' ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'  => true,
	) );
	register_taxonomy( 'journal_cat', 'journal', array(
		'labels'       => array( 'name' => 'テーマ', 'singular_name' => 'テーマ' ),
		'public'       => true,
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'journal-theme' ),
	) );
}
add_action( 'init', 'fort_register_journal' );

/* ============================================================
   3. イベント：地域・状態・期間
   ・期間限定（limited）は終了日を過ぎると自動で「終了」扱い
   ・常設（permanent）は終了しない
============================================================ */
function fort_event_choices() {
	return array(
		'fort_region' => array( '' => '選択してください', 'okayama' => '岡山', 'fukuyama' => '福山' ),
		'fort_kind'   => array( 'limited' => '期間限定（見学会など）', 'permanent' => '常設（相談会・モデルハウスなど）' ),
		'fort_status' => array( 'open' => '受付中', 'full' => '満席', 'paused' => '受付停止', 'ended' => '終了' ),
	);
}

function fort_select_field( $post_id, $key, $label, $choices ) {
	$val = get_post_meta( $post_id, $key, true );
	echo '<p style="margin:10px 0;"><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label><select name="' . esc_attr( $key ) . '" style="width:100%;padding:6px;">';
	foreach ( $choices as $k => $v ) {
		echo '<option value="' . esc_attr( $k ) . '" ' . selected( $val, $k, false ) . '>' . esc_html( $v ) . '</option>';
	}
	echo '</select></p>';
}

function fort_date_field( $post_id, $key, $label ) {
	$val = esc_attr( get_post_meta( $post_id, $key, true ) );
	echo '<p style="margin:10px 0;"><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label><input type="date" name="' . esc_attr( $key ) . '" value="' . $val . '" style="padding:6px;"></p>';
}

function fort_textarea_field( $post_id, $key, $label, $ph = '' ) {
	$val = esc_textarea( get_post_meta( $post_id, $key, true ) );
	echo '<p style="margin:10px 0;"><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label><textarea name="' . esc_attr( $key ) . '" rows="3" placeholder="' . esc_attr( $ph ) . '" style="width:100%;padding:6px;">' . $val . '</textarea></p>';
}

function fort_event_meta_v2_cb( $post ) {
	wp_nonce_field( 'fort_meta_v2', 'fort_meta_v2_nonce' );
	$c = fort_event_choices();
	echo '<p style="color:#666;">空欄の項目はページに表示されません。</p>';
	fort_select_field( $post->ID, 'fort_region', '地域', $c['fort_region'] );
	fort_select_field( $post->ID, 'fort_kind', '種類', $c['fort_kind'] );
	fort_select_field( $post->ID, 'fort_status', '受付状態', $c['fort_status'] );
	fort_date_field( $post->ID, 'fort_start', '開始日（期間限定のみ）' );
	fort_date_field( $post->ID, 'fort_end', '終了日（期間限定のみ。過ぎると自動で「終了」）' );
	fort_text_field( $post->ID, 'fort_time', '時間', '例：10:00〜17:00（最終受付16:00）' );
	fort_text_field( $post->ID, 'fort_duration', '所要時間の目安', '例：約60〜90分' );
	fort_text_field( $post->ID, 'fort_parking', '駐車場', '例：現地に3台' );
	fort_textarea_field( $post->ID, 'fort_see', '何が見られるか' );
	fort_textarea_field( $post->ID, 'fort_consult', '何が相談できるか' );
}

function fort_meta_boxes_v2() {
	add_meta_box( 'fort_event_meta_v2', 'イベントの地域・状態・期間', 'fort_event_meta_v2_cb', 'fort_event', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'fort_meta_boxes_v2' );

function fort_save_meta_v2( $post_id ) {
	if ( ! isset( $_POST['fort_meta_v2_nonce'] ) || ! wp_verify_nonce( $_POST['fort_meta_v2_nonce'], 'fort_meta_v2' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	$choices = fort_event_choices();
	foreach ( $choices as $k => $opts ) {
		if ( isset( $_POST[ $k ] ) ) {
			$v = sanitize_key( wp_unslash( $_POST[ $k ] ) );
			update_post_meta( $post_id, $k, isset( $opts[ $v ] ) ? $v : '' );
		}
	}
	foreach ( array( 'fort_start', 'fort_end' ) as $k ) {
		if ( isset( $_POST[ $k ] ) ) {
			$v = sanitize_text_field( wp_unslash( $_POST[ $k ] ) );
			update_post_meta( $post_id, $k, preg_match( '/^\d{4}-\d{2}-\d{2}$/', $v ) ? $v : '' );
		}
	}
	foreach ( array( 'fort_time', 'fort_duration', 'fort_parking' ) as $k ) {
		if ( isset( $_POST[ $k ] ) ) update_post_meta( $post_id, $k, sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
	}
	foreach ( array( 'fort_see', 'fort_consult' ) as $k ) {
		if ( isset( $_POST[ $k ] ) ) update_post_meta( $post_id, $k, sanitize_textarea_field( wp_unslash( $_POST[ $k ] ) ) );
	}
}
add_action( 'save_post', 'fort_save_meta_v2' );

/** イベントの実際の状態（期間限定は終了日で自動終了。常設は終わらない） */
function fort_event_state( $id = null ) {
	$id   = $id ? $id : get_the_ID();
	$kind = get_post_meta( $id, 'fort_kind', true ) === 'permanent' ? 'permanent' : 'limited';
	$st   = get_post_meta( $id, 'fort_status', true );
	$st   = $st ? $st : 'open';
	if ( 'limited' === $kind ) {
		$end = get_post_meta( $id, 'fort_end', true );
		if ( $end && $end < wp_date( 'Y-m-d' ) ) $st = 'ended';
	} elseif ( 'ended' === $st ) {
		$st = 'paused'; // 常設に「終了」は使わない
	}
	$labels = array( 'open' => '受付中', 'full' => '満席', 'paused' => '受付停止', 'ended' => '終了' );
	return array(
		'kind'   => $kind,
		'status' => $st,
		'label'  => 'permanent' === $kind && 'open' === $st ? '常設' : $labels[ $st ],
		'region' => get_post_meta( $id, 'fort_region', true ),
	);
}

/** 開催日の表示（期間限定は開始〜終了、無ければ従来の「開催日（表示用）」） */
function fort_event_dates( $id = null ) {
	$id    = $id ? $id : get_the_ID();
	$start = get_post_meta( $id, 'fort_start', true );
	$end   = get_post_meta( $id, 'fort_end', true );
	$w     = array( '日', '月', '火', '水', '木', '金', '土' );
	$fmt   = function ( $d ) use ( $w ) {
		$t = strtotime( $d );
		return wp_date( 'n.j', $t ) . '（' . $w[ (int) wp_date( 'w', $t ) ] . '）';
	};
	if ( $start && $end && $start !== $end ) return $fmt( $start ) . ' – ' . $fmt( $end );
	if ( $start ) return $fmt( $start );
	return get_post_meta( $id, 'fort_date', true );
}

/** 今参加できるイベント（終了・受付停止を除く）。地域を指定可 */
function fort_current_events( $region = '', $limit = 6 ) {
	$q = get_posts( array( 'post_type' => 'fort_event', 'posts_per_page' => 50, 'orderby' => 'date', 'order' => 'DESC' ) );
	$out = array();
	foreach ( $q as $p ) {
		$s = fort_event_state( $p->ID );
		if ( in_array( $s['status'], array( 'ended', 'paused' ), true ) ) continue;
		if ( $region && $s['region'] !== $region ) continue;
		$out[] = $p;
	}
	// 期間限定を先に、開始日の近い順
	usort( $out, function ( $a, $b ) {
		$ka = fort_event_state( $a->ID )['kind'] === 'permanent' ? 1 : 0;
		$kb = fort_event_state( $b->ID )['kind'] === 'permanent' ? 1 : 0;
		if ( $ka !== $kb ) return $ka - $kb;
		return strcmp( (string) get_post_meta( $a->ID, 'fort_start', true ), (string) get_post_meta( $b->ID, 'fort_start', true ) );
	} );
	return array_slice( $out, 0, $limit );
}

/* 公式SNS・トップのコピー（初期値） */
define( 'FORT_INSTAGRAM', 'https://www.instagram.com/fort_architecture/' );
define( 'FORT_INSTAGRAM_FAMILY', 'https://www.instagram.com/fort_family.jp/' );
define( 'FORT_YOUTUBE', 'https://www.youtube.com/@FORT-dg7fz' );
define( 'FORT_HERO_COPY', '暮らしを、少しかっこよく。' );
define( 'FORT_HERO_SUB', 'いい家より、いい暮らし。' );

/** 公式SNS（フッターなどで使用） */
function fort_sns() {
	return array_filter( array(
		'Instagram'        => get_theme_mod( 'fort_instagram', FORT_INSTAGRAM ),
		'Instagram FAMILY' => get_theme_mod( 'fort_instagram_family', FORT_INSTAGRAM_FAMILY ),
		'YouTube'          => get_theme_mod( 'fort_youtube_channel', FORT_YOUTUBE ),
	) );
}

/* ============================================================
   4. MOVIE（YouTube）：カスタマイザーにURLを登録
============================================================ */
function fort_customize_v2( $wp ) {
	$wp->add_section( 'fort_movie', array( 'title' => 'FORT：MOVIE（YouTube）', 'priority' => 32, 'description' => 'YouTube動画のURLを入れると、トップページのMOVIEに表示されます。空欄ならMOVIE自体を表示しません。' ) );
	for ( $i = 1; $i <= 3; $i++ ) {
		$wp->add_setting( 'fort_movie_' . $i, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp->add_control( 'fort_movie_' . $i, array( 'label' => '動画URL ' . $i, 'section' => 'fort_movie', 'type' => 'url' ) );
		$wp->add_setting( 'fort_movie_' . $i . '_title', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp->add_control( 'fort_movie_' . $i . '_title', array( 'label' => '動画タイトル ' . $i, 'section' => 'fort_movie', 'type' => 'text' ) );
	}
	$wp->add_setting( 'fort_youtube_channel', array( 'default' => FORT_YOUTUBE, 'sanitize_callback' => 'esc_url_raw' ) );
	$wp->add_control( 'fort_youtube_channel', array( 'label' => 'YouTubeチャンネルURL', 'section' => 'fort_movie', 'type' => 'url' ) );
	$wp->add_setting( 'fort_instagram', array( 'default' => FORT_INSTAGRAM, 'sanitize_callback' => 'esc_url_raw' ) );
	$wp->add_control( 'fort_instagram', array( 'label' => 'Instagram（FORT 建築）', 'section' => 'fort_contact', 'type' => 'url' ) );
	$wp->add_setting( 'fort_instagram_family', array( 'default' => FORT_INSTAGRAM_FAMILY, 'sanitize_callback' => 'esc_url_raw' ) );
	$wp->add_control( 'fort_instagram_family', array( 'label' => 'Instagram（FORT FAMILY）', 'section' => 'fort_contact', 'type' => 'url' ) );

	// トップ左下のコピー
	$wp->add_setting( 'fort_hero_copy', array( 'default' => FORT_HERO_COPY, 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp->add_control( 'fort_hero_copy', array( 'label' => 'トップ左下の1行目', 'section' => 'fort_hero', 'type' => 'text' ) );
	$wp->add_setting( 'fort_hero_sub', array( 'default' => FORT_HERO_SUB, 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp->add_control( 'fort_hero_sub', array( 'label' => 'トップ左下の2行目', 'section' => 'fort_hero', 'type' => 'text' ) );
}
add_action( 'customize_register', 'fort_customize_v2', 20 );

/** YouTube URL → 動画ID */
function fort_youtube_id( $url ) {
	if ( preg_match( '~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~', (string) $url, $m ) ) return $m[1];
	return '';
}

/** 登録済みの動画（IDとタイトル） */
function fort_movies() {
	$out = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$id = fort_youtube_id( get_theme_mod( 'fort_movie_' . $i, '' ) );
		if ( $id ) $out[] = array( 'id' => $id, 'title' => get_theme_mod( 'fort_movie_' . $i . '_title', '' ) );
	}
	return $out;
}

/** クリックするまで iframe を読み込まない YouTube（script.js の [data-yt] が差し替え） */
function fort_youtube_lite( $id, $title ) {
	$title = $title ? $title : 'FORTの動画';
	printf(
		'<button type="button" class="yt-lite" data-yt="%1$s" aria-label="%2$s を再生"><img src="https://i.ytimg.com/vi/%1$s/hqdefault.jpg" alt="" width="480" height="360" loading="lazy" decoding="async"><span class="yt-lite__play" aria-hidden="true"></span></button>',
		esc_attr( $id ),
		esc_attr( $title )
	);
}

/* ============================================================
   5. fort410.com に公開済みの写真（メディアライブラリ）
   ※ テーマ同梱の画像が無い箇所は、すでにサイトにアップ済みの写真を使います
============================================================ */
function fort_media( $key ) {
	$base = 'https://www.fort410.com/wp/wp-content/uploads/2026/07/';
	$map  = array(
		'hero'        => '%E3%83%92%E3%83%BC%E3%83%AD%E3%83%BC-scaled.jpg',
		'style'       => 'FORT-STYLE-scaled.jpg',
		'pro'         => 'FORT-PRO-scaled.jpg',
		'design'      => 'FORT-DESIGN.jpg',
		'structure'   => '%E6%A7%8B%E9%80%A0.jpg',
		'insulation'  => '%E6%B0%97%E5%AF%86%E3%83%BB%E6%96%AD%E7%86%B1-scaled.jpeg',
	);
	return isset( $map[ $key ] ) ? $base . $map[ $key ] : '';
}
