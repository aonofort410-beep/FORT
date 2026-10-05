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
				<p class="footer__logo"><img class="footer__logo-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-lockup-dark.png' ); ?>" alt="FORT"></p>
				<p class="footer__copy-text">岡山・福山で、<br>家族の想いを、かたちに。</p>
			</div>
			<nav class="footer__nav" aria-label="フッターメニュー">
				<ul class="footer__list">
					<?php foreach ( fort_nav_visible() as $item ) : ?>
					<li><a href="<?php echo esc_url( $item['href'] ); ?>"><?php echo esc_html( $item['en'] ); ?><span><?php echo esc_html( $item['ja'] ); ?></span></a></li>
					<?php endforeach; ?>
					<li><a href="<?php echo esc_url( fort_url( 'staff' ) ); ?>">STAFF<span>スタッフ</span></a></li>
					<li><a href="<?php echo esc_url( fort_url( 'company' ) ); ?>">COMPANY<span>会社概要</span></a></li>
					<li><a href="<?php echo esc_url( fort_url( 'request' ) ); ?>">REQUEST<span>資料請求</span></a></li>
					<li><a href="<?php echo esc_url( fort_url( 'contact' ) ); ?>">CONTACT<span>お問い合わせ</span></a></li>
					<?php if ( fort_url( 'privacy' ) ) : ?><li><a href="<?php echo esc_url( fort_url( 'privacy' ) ); ?>">PRIVACY<span>プライバシーポリシー</span></a></li><?php endif; ?>
				</ul>
			</nav>
			<div class="footer__info">
				<p><?php bloginfo( 'name' ); ?></p>
				<p><a href="<?php echo esc_url( fort_url( 'okayama' ) ); ?>">岡山スタジオ</a>　<a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $tel_o ) ); ?>"><?php echo esc_html( $tel_o ); ?></a></p>
				<p><a href="<?php echo esc_url( fort_url( 'fukuyama' ) ); ?>">福山スタジオ</a>　<a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $tel_f ) ); ?>"><?php echo esc_html( $tel_f ); ?></a></p>
				<p>受付時間 9:00〜18:00 / 水曜定休</p>
				<?php if ( fort_sns() ) : ?>
				<p class="footer__sns"><?php foreach ( fort_sns() as $label => $url ) : ?><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a><?php endforeach; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<p class="footer__copyright">© <?php echo esc_html( date( 'Y' ) ); ?> FORT Inc. All Rights Reserved.</p>
	</footer>


	<?php wp_footer(); ?>
</body>
</html>
