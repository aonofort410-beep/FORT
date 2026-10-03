<?php
/*
 * Template Name: お問い合わせ
 * お問い合わせフォーム（入力 → 確認 → 送信 → 完了）。処理は inc/contact.php
 * ・?area=okayama|fukuyama で窓口を選んだ状態で開く
 */
get_header();
$tel_o = fort_opt( 'fort_tel_okayama', '086-236-9600' );
$tel_f = fort_opt( 'fort_tel_fukuyama', '084-982-7404' );
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'CONTACT', '' ) ) ); ?>
			<p class="bh-label">CONTACT</p>
			<h1 class="bh-pagehead__title">お問い合わせ</h1>
			<p class="bh-pagehead__lead"><span class="bh-nb">家づくりのご相談・ご質問など、お気軽にどうぞ。</span><span class="bh-nb">担当者より折り返しご連絡いたします。</span></p>
		</div>
	</header>

	<section class="bh-cq-ways">
		<div class="bh-wrap">
			<ul class="bh-cq-ways__list">
				<li><a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $tel_o ) ); ?>"><span class="bh-label">TEL / OKAYAMA</span><b><?php echo esc_html( $tel_o ); ?></b><small>岡山スタジオ</small></a></li>
				<li><a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $tel_f ) ); ?>"><span class="bh-label">TEL / FUKUYAMA</span><b><?php echo esc_html( $tel_f ); ?></b><small>福山スタジオ</small></a></li>
				<li><a href="<?php echo esc_url( fort_url( 'visit' ) ); ?>"><span class="bh-label">VISIT</span><b>来場予約</b><small>スタジオ・見学会のご予約はこちら</small></a></li>
			</ul>
			<p class="bh-cq-ways__note">受付時間 9:00〜18:00（水曜定休）</p>
		</div>
	</section>

	<section class="bh-rsv" id="cq">
		<div class="bh-wrap bh-rsv__inner">
			<?php fort_cq_render(); ?>
		</div>
	</section>
<?php get_footer(); ?>
