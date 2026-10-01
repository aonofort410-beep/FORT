<?php
/*
 * Template Name: ご来場予約
 * 来場予約フォーム（入力 → 確認 → 送信 → 完了）。処理は inc/reservation.php
 * ・?area=okayama|fukuyama と ?event=スラッグ で、来場先とイベントを引き継ぐ
 */
get_header();
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'VISIT', '' ) ) ); ?>
			<p class="bh-label">VISIT</p>
			<h1 class="bh-pagehead__title">来場予約</h1>
			<p class="bh-pagehead__lead"><span class="bh-nb">スタジオ・モデルハウス・見学会のご予約を承ります。</span><span class="bh-nb">ご予約は無料です。お子さま連れも歓迎します。</span></p>
		</div>
	</header>

	<section class="bh-rsv" id="rsv">
		<div class="bh-wrap bh-rsv__inner">
			<?php fort_rsv_render(); ?>
		</div>
	</section>
<?php get_footer(); ?>
