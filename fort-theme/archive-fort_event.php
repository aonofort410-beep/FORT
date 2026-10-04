<?php
/**
 * EVENT 一覧（/info/）
 * ・期間限定（見学会など）と常設（相談会・モデルハウス）を分けて表示
 * ・期間限定は終了日を過ぎると自動で一覧から外れる。常設は終了しない
 */
get_header();
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'EVENT', '' ) ) ); ?>
			<p class="bh-label">EVENT</p>
			<h1 class="bh-pagehead__title">見学会・相談会</h1>
			<p class="bh-pagehead__lead"><span class="bh-nb">写真では伝わらない、素材の手ざわりや光の入り方。</span><span class="bh-nb">岡山・福山で開催している見学会と相談会です。</span></p>
		</div>
	</header>

	<?php
	// ページ上部の写真：開催中の見学会の写真 → 無ければ施工写真
	$ev_photo = '';
	foreach ( fort_current_events( '', 6 ) as $ev ) { if ( has_post_thumbnail( $ev ) ) { $ev_photo = get_the_post_thumbnail_url( $ev, 'fort-hero' ); break; } }
	if ( ! $ev_photo ) $ev_photo = get_template_directory_uri() . '/assets/images/hero-4.jpg';
	?>
	<figure class="bh-pagephoto"><img src="<?php echo esc_url( $ev_photo ); ?>" alt="" fetchpriority="high" decoding="async"></figure>

	<?php get_template_part( 'parts/event-list', null, array( 'limit' => 30, 'heading' => true, 'kind' => 'limited', 'label' => 'LIMITED', 'title' => '期間限定の見学会', 'visit' => false ) ); ?>
	<?php get_template_part( 'parts/model-houses' ); ?>
	<?php get_template_part( 'parts/event-list', null, array( 'limit' => 30, 'heading' => true, 'kind' => 'permanent', 'label' => 'ALWAYS', 'title' => 'いつでも参加できる相談会', 'visit' => false ) ); ?>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'event', 'title' => '日程が合わなくても、<br>見に来られます。' ) ); ?>
<?php get_footer(); ?>
