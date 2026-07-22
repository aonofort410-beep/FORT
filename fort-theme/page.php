<?php
/** 固定ページ（会社概要・プライバシーポリシー など） */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
while ( have_posts() ) : the_post();
	$hero = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'fort-hero' ) : $img . 'exterior.jpg';
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $hero ); ?>" alt=""><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal>PAGE</p>
			<h1 class="subhero__title" data-reveal><?php the_title(); ?></h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span><?php the_title(); ?></span></nav>
		</div>
	</section>

	<section class="section">
		<div class="container" style="max-width:880px;">
			<div class="case-body" data-reveal><?php the_content(); ?></div>
		</div>
	</section>
<?php endwhile; get_footer(); ?>
