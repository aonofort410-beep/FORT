<?php
/*
 * Template Name: お客様の声（FORT FAMILY）
 * 以前は仮の声を固定で表示していたため撤去。実際のお客様の声は、このページの本文に書いたものだけを表示する。
 */
the_post();
// 本文が空なら、ページ自体を「見つかりません」にする（仮の内容を出さない）
if ( ! trim( get_the_content() ) ) {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	require get_template_directory() . '/404.php';
	return;
}
get_header(); ?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'VOICE', '' ) ) ); ?>
			<p class="bh-label">VOICE</p>
			<h1 class="bh-pagehead__title"><?php the_title(); ?></h1>
		</div>
	</header>
	<section class="bh-article"><div class="bh-wrap"><div class="bh-prose">
		<?php the_content(); ?>
	</div></div></section>
	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'voice' ) ); ?>
<?php get_footer();
