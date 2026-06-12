<?php
/** 単記事（お知らせ・イベント） */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
while ( have_posts() ) : the_post();
	$is_event = ( 'fort_event' === get_post_type() );
	$eyebrow  = $is_event ? 'EVENT' : 'NEWS';
	$hero     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'fort-hero' ) : $img . 'exterior.jpg';
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $hero ); ?>" alt="<?php the_title_attribute(); ?>"><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal><?php echo esc_html( $eyebrow ); ?></p>
			<h1 class="subhero__title" data-reveal><?php the_title(); ?></h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span><?php the_title(); ?></span></nav>
		</div>
	</section>

	<article class="section">
		<div class="container" style="max-width:780px;">
			<p class="section__label" style="text-align:left;"><?php echo esc_html( get_the_date() ); ?>
				<?php if ( $is_event && fort_meta( 'fort_place' ) ) { echo ' ／ ' . esc_html( fort_meta( 'fort_place' ) ); } ?>
			</p>
			<div class="case-body" data-reveal style="margin-top:18px;">
				<?php the_content(); ?>
			</div>
			<div class="section__more" style="margin-top:40px;">
				<a href="<?php echo esc_url( $is_event ? get_post_type_archive_link( 'fort_event' ) : home_url( '/news/' ) ); ?>" class="btn btn--outline">一覧へ戻る</a>
			</div>
		</div>
	</article>

	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" aria-hidden="true"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
			<h2 class="section__title section__title--light" data-reveal>お気軽にご相談ください。</h2>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
			</ul>
		</div>
	</section>
<?php endwhile; get_footer(); ?>
