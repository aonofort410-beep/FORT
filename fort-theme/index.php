<?php
/** 汎用一覧（お知らせ一覧・検索・フォールバック） */
get_header();
$img = get_template_directory_uri() . '/assets/images/';

$title = 'お知らせ';
if ( is_search() ) { $title = '検索結果'; }
elseif ( is_archive() ) { $title = get_the_archive_title(); }
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $img . 'exterior.jpg' ); ?>" alt="" aria-hidden="true"><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal>NEWS</p>
			<h1 class="subhero__title" data-reveal><?php echo esc_html( $title ); ?></h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span><?php echo esc_html( $title ); ?></span></nav>
		</div>
	</section>

	<section class="news section">
		<div class="container" style="max-width:880px;">
			<ul class="news__list">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					$cats = get_the_category(); $cat = $cats ? $cats[0]->name : 'お知らせ'; ?>
				<li class="news__item">
					<a href="<?php the_permalink(); ?>" class="news__link">
						<time class="news__date"><?php echo esc_html( get_the_date() ); ?></time>
						<span class="news__tag"><?php echo esc_html( $cat ); ?></span>
						<span class="news__title"><?php the_title(); ?></span>
					</a>
				</li>
				<?php endwhile; else : ?>
				<li class="news__item"><span class="news__title">お知らせはまだありません。</span></li>
				<?php endif; ?>
			</ul>
			<div class="section__more"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		</div>
	</section>
<?php get_footer(); ?>
