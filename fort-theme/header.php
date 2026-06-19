<?php
/**
 * ヘッダー（全ページ共通）
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<noscript><style>.startgate{display:none!important}</style></noscript>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<header class="header" id="header">
		<div class="header__inner container">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo" aria-label="<?php bloginfo( 'name' ); ?> トップへ"><img class="header__logo-img header__logo-img--white" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-lockup-white.png' ); ?>" alt="FORT"><img class="header__logo-img header__logo-img--dark" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-lockup-dark.png' ); ?>" alt="" aria-hidden="true"></a>

			<div class="header__right">
				<?php if ( is_front_page() ) : ?>
				<!-- トップページ用のナビ項目（PCで表示・スマホでは目次MENUに集約） -->
				<nav class="header-nav" aria-label="主要メニュー">
					<a href="#philosophy" class="header-nav__link"><span class="header-nav__en">PHILOSOPHY</span><span class="header-nav__ja">FORTの思い</span></a>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="header-nav__link"><span class="header-nav__en">EVENT</span><span class="header-nav__ja">見学会・イベント</span></a>
					<a href="#performance" class="header-nav__link"><span class="header-nav__en">PERFORMANCE</span><span class="header-nav__ja">構造・性能</span></a>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="header-nav__link"><span class="header-nav__en">WORKS</span><span class="header-nav__ja">施工事例</span></a>
					<a href="#lineup" class="header-nav__link"><span class="header-nav__en">LINEUP</span><span class="header-nav__ja">ラインナップ</span></a>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'staff' ) ); ?>" class="header-nav__link"><span class="header-nav__en">STAFF</span><span class="header-nav__ja">スタッフ</span></a>
				</nav>
				<?php endif; ?>

				<!-- 右上の「MENU」ボタン（全ページの目次を開く。中身は script.js が生成） -->
				<button class="menu-toggle" id="menuToggle" type="button"
						aria-label="メニュー" aria-expanded="false" aria-controls="globalMenu">
					<span class="menu-toggle__bars" aria-hidden="true"><span></span><span></span><span></span></span>
					<span class="menu-toggle__txt">MENU</span>
				</button>
			</div>
		</div>
	</header>

	<main>
