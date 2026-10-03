<?php
/**
 * SEO / AIO / 計測
 * ------------------------------------------------------------
 * ・説明文・OGP・canonical・構造化データ（会社とスタジオ2拠点）を出力
 *   ※ Yoast / All in One SEO / SEOPress / Rank Math が有効なときは重複しないよう出力しない（構造化データの会社情報だけは出す）
 * ・/llms.txt：AI検索向けに、会社の要点とページ一覧をテキストで返す
 * ・GA4 / GTM：カスタマイザー「FORT：計測」に ID を入れたときだけ読み込む（個人情報は送らない）
 */

function fort_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || class_exists( 'RankMath' );
}

/** ページごとの説明文 */
function fort_meta_description() {
	$default = '岡山・福山の注文住宅・規格住宅のFORT。性能とデザインのちょうどいいバランスで、家族が無理なく長く暮らせる家を、営業・設計・工務のチームでつくります。見学会・モデルハウス・来場予約受付中。';
	if ( is_front_page() ) return $default;
	if ( is_singular() ) {
		$p = get_post();
		$d = has_excerpt( $p ) ? get_the_excerpt( $p ) : wp_strip_all_tags( strip_shortcodes( $p->post_content ) );
		$d = trim( preg_replace( '/\s+/u', ' ', $d ) );
		if ( $d ) return mb_strimwidth( $d, 0, 220, '…' );
		return get_the_title( $p ) . '｜' . $default;
	}
	if ( is_post_type_archive() ) return post_type_archive_title( '', false ) . '｜' . $default;
	return $default;
}

add_action( 'wp_head', function () {
	if ( fort_seo_plugin_active() ) return;
	if ( is_404() || is_search() ) { echo '<meta name="robots" content="noindex">' . "\n"; return; }
	$desc  = fort_meta_description();
	$url   = is_front_page() ? home_url( '/' ) : ( is_singular() ? get_permalink() : ( is_post_type_archive() ? get_post_type_archive_link( get_query_var( 'post_type' ) ) : '' ) );
	$title = wp_get_document_title();
	$img   = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'fort-hero' ) : get_template_directory_uri() . '/assets/images/hero.jpg';
	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	if ( $url && ! is_singular() ) echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:type" content="' . ( is_front_page() ? 'website' : 'article' ) . '">' . "\n";
	echo '<meta property="og:site_name" content="FORT">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	if ( $url ) echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
	echo '<meta property="og:locale" content="ja_JP">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}, 2 );

/** 構造化データ：会社（工務店）＋ 岡山・福山スタジオ。トップと PLACE / ABOUT で出力 */
add_action( 'wp_head', function () {
	if ( ! ( is_front_page() || is_page( array( 'place', 'about', 'okayama', 'fukuyama', 'company' ) ) ) ) return;
	$same = array_values( array_filter( array( fort_opt( 'fort_instagram', FORT_INSTAGRAM ), fort_opt( 'fort_instagram_family', FORT_INSTAGRAM_FAMILY ), fort_opt( 'fort_youtube_channel', FORT_YOUTUBE ) ) ) );
	$org  = array(
		'@type'  => 'Organization',
		'@id'    => home_url( '/#org' ),
		'name'   => '株式会社FORT',
		'alternateName' => 'FORT',
		'url'    => home_url( '/' ),
		'logo'   => get_template_directory_uri() . '/assets/images/fort-mark.png',
		'sameAs' => $same,
	);
	$graph = array( $org, array( '@type' => 'WebSite', '@id' => home_url( '/#site' ), 'url' => home_url( '/' ), 'name' => 'FORT', 'inLanguage' => 'ja', 'publisher' => array( '@id' => home_url( '/#org' ) ) ) );
	foreach ( fort_studios() as $k => $s ) {
		preg_match( '/^(\S+?[都道府県])(\S+?[市区町村])(.*)$/u', $s['addr'], $m );
		$graph[] = array(
			'@type'     => 'HomeAndConstructionBusiness',
			'@id'       => home_url( '/#' . $k ),
			'name'      => 'FORT ' . $s['name'],
			'url'       => fort_url( $k ),
			'telephone' => $s['tel'],
			'image'     => fort_studio_img( $k ) ?: get_template_directory_uri() . '/assets/images/hero.jpg',
			'areaServed'=> $s['area'],
			'parentOrganization' => array( '@id' => home_url( '/#org' ) ),
			'address'   => array(
				'@type'           => 'PostalAddress',
				'postalCode'      => str_replace( '〒', '', $s['zip'] ),
				'addressRegion'   => $m[1] ?? '',
				'addressLocality' => $m[2] ?? '',
				'streetAddress'   => trim( $m[3] ?? $s['addr'] ),
				'addressCountry'  => 'JP',
			),
		);
	}
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 3 );

/** /llms.txt：AI 検索・要約向けの案内 */
add_action( 'wp_loaded', function () {
	$path = trim( (string) parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	if ( 'llms.txt' !== $path ) return;
	header( 'Content-Type: text/plain; charset=utf-8' );
	$out  = "# FORT（株式会社FORT）\n\n";
	$out .= "> 岡山・福山で注文住宅を設計・施工する住宅会社。性能とデザインのバランスを重視し、営業・設計・工務のチームで家づくりを行う。\n\n";
	$out .= "## 家づくりの種類\n";
	foreach ( fort_house_items() as $k => $it ) $out .= '- ' . $it['name'] . '（' . $it['method'] . '）: ' . $it['catch'] . ' ' . fort_url( $k ) . "\n";
	$out .= "\n## スタジオ\n";
	foreach ( fort_studios() as $k => $s ) $out .= '- ' . $s['name'] . ': ' . $s['zip'] . ' ' . $s['addr'] . ' / TEL ' . $s['tel'] . ' / 対応エリア ' . $s['area'] . "\n";
	$out .= "\n## 主なページ\n";
	foreach ( array( 'works' => '施工事例', 'event' => '見学会・イベント', 'performance' => '構造・性能', 'house' => '3つの家づくりの比較', 'staff' => 'スタッフ', 'about' => 'FORTについて', 'visit' => '来場予約' ) as $k => $l ) $out .= '- [' . $l . '](' . fort_url( $k ) . ")\n";
	echo $out; // テキスト出力
	exit;
} );

/* ---------- 計測（GA4 / GTM） ---------- */
add_action( 'customize_register', function ( $wp ) {
	$wp->add_section( 'fort_analytics', array( 'title' => 'FORT：計測', 'priority' => 32, 'description' => 'どちらか一方だけ入力してください。空欄なら計測タグは読み込みません。' ) );
	$wp->add_setting( 'fort_ga4', array( 'default' => '', 'sanitize_callback' => function ( $v ) { return preg_match( '/^G-[A-Z0-9]+$/', $v ) ? $v : ''; } ) );
	$wp->add_control( 'fort_ga4', array( 'label' => 'GA4 測定ID（G-XXXXXXX）', 'section' => 'fort_analytics', 'type' => 'text' ) );
	$wp->add_setting( 'fort_gtm', array( 'default' => '', 'sanitize_callback' => function ( $v ) { return preg_match( '/^GTM-[A-Z0-9]+$/', $v ) ? $v : ''; } ) );
	$wp->add_control( 'fort_gtm', array( 'label' => 'Googleタグマネージャー ID（GTM-XXXXXX）', 'section' => 'fort_analytics', 'type' => 'text' ) );
} );

add_action( 'wp_head', function () {
	if ( is_user_logged_in() ) return; // 社内の閲覧は数えない
	$gtm = fort_opt( 'fort_gtm' );
	$ga  = fort_opt( 'fort_ga4' );
	if ( $gtm ) {
		echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . esc_js( $gtm ) . "');</script>\n";
	} elseif ( $ga ) {
		echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $ga ) . '"></script>' . "\n";
		echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','" . esc_js( $ga ) . "',{allow_google_signals:false,allow_ad_personalization_signals:false});</script>\n";
	}
}, 5 );
