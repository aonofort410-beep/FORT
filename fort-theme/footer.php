<?php
/**
 * フッター（全ページ共通）
 */
$tel_o = fort_opt( 'fort_tel_okayama', '086-236-9600' );
$tel_f = fort_opt( 'fort_tel_fukuyama', '084-982-7404' );
?>
	</main>

	<footer class="footer">
		<div class="container footer__inner">
			<div class="footer__brand">
				<p class="footer__logo"><img class="footer__logo-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-white.png' ); ?>" alt="FORT"></p>
				<p class="footer__copy-text">性能か、デザインか。<br>その選択をしなくていい家づくり。</p>
			</div>
			<nav class="footer__nav" aria-label="フッターメニュー">
				<ul class="footer__list">
					<li><a href="<?php echo esc_url( home_url( '/#concept' ) ); ?>">CONCEPT</a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>">WORKS</a></li>
					<li><a href="<?php echo esc_url( home_url( '/lineup/' ) ); ?>">LINEUP</a></li>
					<li><a href="<?php echo esc_url( home_url( '/performance/' ) ); ?>">PERFORMANCE</a></li>
					<li><a href="<?php echo esc_url( home_url( '/flow/' ) ); ?>">FLOW</a></li>
					<li><a href="<?php echo esc_url( home_url( '/feature/' ) ); ?>">FEATURE</a></li>
					<li><a href="<?php echo esc_url( home_url( '/fort-pro/' ) ); ?>">FORT PRO</a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>">EVENT</a></li>
					<li><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>">STUDIO</a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'staff' ) ); ?>">STAFF</a></li>
					<li><a href="<?php echo esc_url( home_url( '/company/' ) ); ?>">COMPANY</a></li>
					<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">NEWS</a></li>
				</ul>
			</nav>
			<div class="footer__info">
				<p><?php bloginfo( 'name' ); ?></p>
				<p>岡山県・倉敷市・福山市エリアで家づくりを行っています。</p>
				<p>TEL：<?php echo esc_html( $tel_o ); ?>（岡山）／ <?php echo esc_html( $tel_f ); ?>（福山）</p>
				<p>受付時間 9:00〜18:00 / 水曜定休</p>
			</div>
		</div>
		<p class="footer__copyright">© <?php echo esc_html( date( 'Y' ) ); ?> FORT Inc. All Rights Reserved.</p>
	</footer>

	<div class="floating-cta">
		<a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="floating-cta__btn floating-cta__btn--ghost">見学会予約</a>
		<a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="floating-cta__btn floating-cta__btn--accent">資料請求・相談</a>
	</div>

	<?php wp_footer(); ?>
</body>
</html>
