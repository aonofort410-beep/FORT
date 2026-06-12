<?php
/** 施工事例 一覧 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" aria-hidden="true"><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal>WORKS</p>
			<h1 class="subhero__title" data-reveal>暮らしが見える施工事例</h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>WORKS</span></nav>
		</div>
	</section>

	<section class="works section">
		<div class="container">
			<p class="page-lead" data-reveal>FORTが手がけた住まいの一例をご紹介します。<br>写真をクリックすると、間取りやこだわりの詳細をご覧いただけます。</p>

			<?php
			$terms = get_terms( array( 'taxonomy' => 'works_cat', 'hide_empty' => true ) );
			if ( $terms && ! is_wp_error( $terms ) ) : ?>
			<nav class="works-filter" data-reveal aria-label="カテゴリ">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="<?php echo is_post_type_archive( 'works' ) && ! is_tax() ? 'is-active' : ''; ?>">すべて</a>
				<?php foreach ( $terms as $t ) : ?>
				<a href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a>
				<?php endforeach; ?>
			</nav>
			<?php endif; ?>

			<ul class="works__grid">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					$area = fort_meta( 'fort_area' ); $price = fort_meta( 'fort_price' ); ?>
				<li class="works__card" data-reveal>
					<a href="<?php the_permalink(); ?>" class="works__link">
						<figure class="works__figure"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'fort-card', array( 'loading' => 'lazy' ) ); } else { echo '<img src="' . esc_url( $img . 'exterior.jpg' ) . '" alt="">'; } ?></figure>
						<div class="works__body">
							<?php if ( $area ) : ?><p class="works__cat"><?php echo esc_html( $area ); ?></p><?php endif; ?>
							<h2 class="works__card-title"><?php the_title(); ?></h2>
							<?php if ( $price ) : ?><p class="works__price">建物本体<strong><?php echo esc_html( $price ); ?></strong><span class="works__price-note">※参考価格帯</span></p><?php endif; ?>
						</div>
					</a>
				</li>
				<?php endwhile; else : ?>
				<li class="works__card"><div class="works__body"><h2 class="works__card-title">施工事例は管理画面から登録できます。</h2></div></li>
				<?php endif; ?>
			</ul>
			<div class="section__more"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		</div>
	</section>
<?php get_footer(); ?>
