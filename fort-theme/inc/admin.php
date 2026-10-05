<?php
/**
 * 管理画面で写真・文字を簡単に変えられるようにする
 * ------------------------------------------------------------
 * 1) 施工事例・モデルハウスに「写真ギャラリー」（まとめて選ぶ・ドラッグで並べ替え）
 * 2) 管理画面メニュー「FORT 設定」
 *    トップのスライドショー（PC／スマホ）・スタジオ写真・商品写真・キャッチコピー・電話番号
 *    ※ カスタマイザーと違い、テーマを有効化する前（切り替え準備中）でも保存できます
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- 共通：画像ID（カンマ区切り）→ 配列 ---------- */
function fort_ids( $csv ) {
	return array_values( array_filter( array_map( 'absint', explode( ',', (string) $csv ) ) ) );
}

/* ---------- 画像を選ぶ欄（管理画面用・WordPressのメディアを使う） ---------- */
function fort_media_picker( $name, $value, $multiple = true, $label = '' ) {
	$ids = fort_ids( $value );
	echo '<div class="fort-picker" data-multiple="' . ( $multiple ? '1' : '0' ) . '">';
	if ( $label ) echo '<p class="fort-picker__label">' . esc_html( $label ) . '</p>';
	echo '<ul class="fort-picker__list">';
	foreach ( $ids as $id ) {
		$src = wp_get_attachment_image_url( $id, 'thumbnail' );
		if ( $src ) echo '<li data-id="' . esc_attr( $id ) . '"><img src="' . esc_url( $src ) . '" alt=""><button type="button" class="fort-picker__del" aria-label="外す">×</button></li>';
	}
	echo '</ul>';
	echo '<input type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( implode( ',', $ids ) ) . '">';
	echo '<button type="button" class="button fort-picker__add">' . ( $multiple ? '写真を選ぶ・追加する' : '写真を選ぶ' ) . '</button>';
	if ( $multiple ) echo ' <span class="description">ドラッグで並べ替えできます。</span>';
	echo '</div>';
}

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	$screen = get_current_screen();
	$ok = ( $screen && in_array( $screen->post_type, array( 'works', 'model_house' ), true ) ) || 'toplevel_page_fort-settings' === $hook;
	if ( ! $ok ) return;
	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_add_inline_style( 'wp-admin', '
		.fort-picker{margin:12px 0 20px}.fort-picker__label{font-weight:600;margin:0 0 6px}
		.fort-picker__list{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 10px;padding:0;list-style:none}
		.fort-picker__list li{position:relative;width:96px;height:96px;margin:0;cursor:move;background:#f0f0f0}
		.fort-picker__list img{width:100%;height:100%;object-fit:cover;display:block}
		.fort-picker__del{position:absolute;top:2px;right:2px;width:22px;height:22px;border:0;border-radius:50%;background:rgba(0,0,0,.65);color:#fff;cursor:pointer;line-height:1}
	' );
	wp_add_inline_script( 'jquery-ui-sortable', "
	jQuery(function($){
		function sync(box){ box.find('input[type=hidden]').val(box.find('li').map(function(){return $(this).data('id');}).get().join(',')); }
		$('.fort-picker').each(function(){ var box=$(this); box.find('.fort-picker__list').sortable({update:function(){sync(box);}}); });
		$(document).on('click','.fort-picker__del',function(){ var box=$(this).closest('.fort-picker'); $(this).closest('li').remove(); sync(box); });
		$(document).on('click','.fort-picker__add',function(e){
			e.preventDefault(); var box=$(this).closest('.fort-picker'), multi=box.data('multiple')==1;
			var frame=wp.media({title:'写真を選ぶ',button:{text:'この写真を使う'},library:{type:'image'},multiple:multi?'add':false});
			frame.on('select',function(){
				var list=box.find('.fort-picker__list'); if(!multi) list.empty();
				frame.state().get('selection').each(function(a){ a=a.toJSON(); if(list.find('li[data-id='+a.id+']').length) return;
					var src=(a.sizes&&a.sizes.thumbnail)?a.sizes.thumbnail.url:a.url;
					list.append('<li data-id=\"'+a.id+'\"><img src=\"'+src+'\" alt=\"\"><button type=\"button\" class=\"fort-picker__del\" aria-label=\"外す\">×</button></li>'); });
				sync(box);
			});
			frame.open();
		});
	});" );
} );

/* ---------- 1) 施工事例・モデルハウスの写真ギャラリー ---------- */
add_action( 'add_meta_boxes', function () {
	foreach ( array( 'works' => '施工事例の写真', 'model_house' => 'モデルハウスの写真' ) as $pt => $title ) {
		add_meta_box( 'fort_gallery', $title, function ( $post ) {
			wp_nonce_field( 'fort_gallery', 'fort_gallery_nonce' );
			echo '<p style="color:#666;margin-top:0;">ページに大きく並ぶ写真です。複数まとめて選べます。いちばん上の写真（メイン）は右の「アイキャッチ画像」で設定してください。</p>';
			fort_media_picker( 'fort_gallery', get_post_meta( $post->ID, 'fort_gallery', true ) );
		}, $pt, 'normal', 'high' );
	}
} );
add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['fort_gallery_nonce'] ) || ! wp_verify_nonce( $_POST['fort_gallery_nonce'], 'fort_gallery' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	update_post_meta( $post_id, 'fort_gallery', implode( ',', fort_ids( wp_unslash( $_POST['fort_gallery'] ?? '' ) ) ) );
} );

/** ページ側：ギャラリーを表示（1枚目は大きく、あとは2列。写真のキャプションがあれば下に） */
function fort_gallery_html( $post_id ) {
	$ids = fort_ids( get_post_meta( $post_id, 'fort_gallery', true ) );
	if ( ! $ids ) return '';
	$out = '<div class="bh-gallery">';
	foreach ( $ids as $i => $id ) {
		$img = wp_get_attachment_image( $id, 'fort-hero', false, array( 'loading' => 'lazy', 'decoding' => 'async', 'sizes' => '(min-width: 900px) 60vw, 100vw' ) );
		if ( ! $img ) continue;
		$cap = wp_get_attachment_caption( $id );
		$out .= '<figure class="bh-gallery__item">' . $img . ( $cap ? '<figcaption>' . esc_html( $cap ) . '</figcaption>' : '' ) . '</figure>';
	}
	return $out . '</div>';
}

/* ---------- 2) FORT 設定 ---------- */
function fort_settings() {
	$s = get_option( 'fort_settings', array() );
	return is_array( $s ) ? $s : array();
}
/** 設定の文字・数値（未入力なら空） */
function fort_setting( $key ) {
	$s = fort_settings();
	return isset( $s[ $key ] ) ? $s[ $key ] : '';
}
/** 設定の画像URL（1枚） */
function fort_setting_img( $key, $size = 'full' ) {
	$id = absint( fort_setting( $key ) );
	return $id ? (string) wp_get_attachment_image_url( $id, $size ) : '';
}

function fort_settings_fields() {
	return array(
		'text' => array(
			'fort_hero_copy'    => array( 'トップのキャッチコピー（1行目）', defined( 'FORT_HERO_COPY' ) ? FORT_HERO_COPY : '' ),
			'fort_hero_sub'     => array( 'トップのキャッチコピー（2行目）', defined( 'FORT_HERO_SUB' ) ? FORT_HERO_SUB : '' ),
			'fort_tel_okayama'  => array( '岡山スタジオ 電話番号', '086-236-9600' ),
			'fort_tel_fukuyama' => array( '福山スタジオ 電話番号', '084-982-7404' ),
		),
		'gallery' => array(
			'hero_pc' => 'トップのスライドショー（PC・iPad用／横長の写真）',
			'hero_sp' => 'トップのスライドショー（スマホ用／縦長の写真・PCと同じ順番で）',
			'life_photos' => '各ページに流れる「デザイン・暮らし」の写真（何枚でも）',
		),
		'image' => array(
			'studio_okayama'  => '岡山スタジオの写真',
			'studio_fukuyama' => '福山スタジオの写真',
			'house_design'    => 'FORT DESIGN の写真',
			'house_pro'       => 'FORT PRO の写真',
			'house_style'     => 'FORT STYLE の写真',
			'maker_evoltz'    => 'メーカー画像：制振ダンパー evoltz［エヴォルツ］',
			'maker_airsave'   => 'メーカー画像：第一種換気 キムラ エアセーブ',
			'maker_urethane'  => 'メーカー画像：断熱材 発泡ウレタン',
			'maker_apw'       => 'メーカー画像：YKK AP APW330／APW430',
			'maker_jio'       => 'メーカー画像：JIO（ロゴ・検査の様子など）',
		),
	);
}

add_action( 'admin_menu', function () {
	add_menu_page( 'FORT 設定', 'FORT 設定', 'edit_theme_options', 'fort-settings', 'fort_settings_page', 'dashicons-admin-home', 3 );
} );

function fort_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) return;
	$f = fort_settings_fields();
	$s = fort_settings();
	if ( isset( $_POST['fort_settings_nonce'] ) && wp_verify_nonce( $_POST['fort_settings_nonce'], 'fort_settings' ) ) {
		foreach ( $f['text'] as $k => $v ) $s[ $k ] = sanitize_text_field( wp_unslash( $_POST[ $k ] ?? '' ) );
		foreach ( array_merge( array_keys( $f['gallery'] ), array_keys( $f['image'] ) ) as $k ) $s[ $k ] = implode( ',', fort_ids( wp_unslash( $_POST[ $k ] ?? '' ) ) );
		update_option( 'fort_settings', $s );
		echo '<div class="notice notice-success is-dismissible"><p>保存しました。</p></div>';
	}
	echo '<div class="wrap"><h1>FORT 設定</h1>';
	echo '<p>サイト全体で使う写真と文字です。空欄の項目は、テーマに入っている写真・文字がそのまま使われます。</p>';
	echo '<form method="post">';
	wp_nonce_field( 'fort_settings', 'fort_settings_nonce' );
	echo '<h2>スライドショー・写真</h2>';
	foreach ( $f['gallery'] as $k => $label ) fort_media_picker( $k, $s[ $k ] ?? '', true, $label );
	echo '<h2>キャッチコピー・電話番号</h2><table class="form-table">';
	foreach ( $f['text'] as $k => $v ) {
		echo '<tr><th><label for="' . esc_attr( $k ) . '">' . esc_html( $v[0] ) . '</label></th><td><input class="regular-text" id="' . esc_attr( $k ) . '" name="' . esc_attr( $k ) . '" value="' . esc_attr( $s[ $k ] ?? '' ) . '" placeholder="' . esc_attr( $v[1] ) . '"></td></tr>';
	}
	echo '</table><h2>スタジオ・商品・メーカーの写真</h2><p>メーカー画像は、各メーカーから提供・使用許可を受けた画像を入れてください。</p>';
	foreach ( $f['image'] as $k => $label ) fort_media_picker( $k, $s[ $k ] ?? '', false, $label );
	submit_button( '保存する' );
	echo '</form></div>';
}

/** メーカー画像：FORT 設定 → テーマ同梱 assets/images/maker/<key>.(jpg|png|webp) → 空 */
function fort_maker_img( $key ) {
	$u = fort_setting_img( 'maker_' . $key, 'large' );
	if ( $u ) return $u;
	foreach ( array( 'jpg', 'png', 'webp' ) as $ext ) {
		if ( file_exists( get_template_directory() . '/assets/images/maker/' . $key . '.' . $ext ) ) return get_template_directory_uri() . '/assets/images/maker/' . $key . '.' . $ext;
	}
	return '';
}

/** 各ページに流す写真：FORT 設定 → 暮らし写真（life-*.jpg）→ テーマ同梱の住まい写真 */
function fort_band_photos() {
	$out = array();
	foreach ( fort_ids( fort_setting( 'life_photos' ) ) as $id ) { $u = wp_get_attachment_image_url( $id, 'fort-card' ); if ( $u ) $out[] = $u; }
	if ( ! $out && function_exists( 'fort_life_photos' ) ) $out = fort_life_photos();
	if ( ! $out ) {
		$base = get_template_directory_uri() . '/assets/images/';
		foreach ( array( 'hero-1.jpg', 'pro/persp-a.jpg', 'hero-3.jpg', 'house-design.jpg', 'hero-2.jpg', 'studio-okayama.jpg', 'pro/persp-c.jpg', 'hero-4.jpg', 'mh-fukuyama-shimokamo.jpg', 'perf-interior.jpg', 'hero-5.jpg', 'house-pro.jpg', 'studio-fukuyama.jpg', 'pro/persp-e.jpg' ) as $f ) $out[] = $base . $f;
	}
	return $out;
}
