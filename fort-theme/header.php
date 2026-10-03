<?php
/**
 * ヘッダー（全ページ共通）
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">本文へ移動</a>

	<header class="header" id="header">
		<div class="header__inner container">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo" aria-label="<?php bloginfo( 'name' ); ?> トップへ"><img class="header__logo-img header__logo-img--white" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-lockup-white.png' ); ?>" alt="FORT"><img class="header__logo-img header__logo-img--dark" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-lockup-dark.png' ); ?>" alt="" aria-hidden="true"></a>

			<div class="header__right">
				<!-- グローバルナビ（PCで表示・スマホでは目次MENUに集約） -->
				<nav class="header-nav" aria-label="主要メニュー">
					<?php foreach ( fort_nav_visible() as $item ) : ?>
					<a href="<?php echo esc_url( $item['href'] ); ?>" class="header-nav__link<?php echo 'VISIT' === $item['en'] ? ' header-nav__link--visit' : ''; ?>"><span class="header-nav__en"><?php echo esc_html( $item['en'] ); ?></span><span class="header-nav__ja"><?php echo esc_html( $item['ja'] ); ?></span></a>
					<?php endforeach; ?>
				</nav>

				<!-- スマホ：控えめな来場予約リンク（写真やフォームの邪魔をしない大きさ） -->
				<a href="<?php echo esc_url( fort_url( 'visit' ) ); ?>" class="header__visit">VISIT</a>

				<!-- 右上の「MENU」ボタン（全ページの目次を開く。中身は script.js が生成） -->
				<button class="menu-toggle" id="menuToggle" type="button"
						aria-label="メニュー" aria-expanded="false" aria-controls="globalMenu">
					<span class="menu-toggle__bars" aria-hidden="true"><span></span><span></span><span></span></span>
					<span class="menu-toggle__txt">MENU</span>
				</button>
			</div>
		</div>
	</header>

	<main id="main" tabindex="-1">
