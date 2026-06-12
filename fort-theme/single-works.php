<?php
/** 施工事例 詳細 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
while ( have_posts() ) : the_post();
	$area = fort_meta( 'fort_area' );
	$hero = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'fort-hero' ) : $img . 'hero.jpg';
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $hero ); ?>" alt="<?php the_title_attribute(); ?>"><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal>WORKS<?php echo $area ? ' ／ ' . esc_html( $area ) : ''; ?></p>
			<h1 class="subhero__title" data-reveal><?php the_title(); ?></h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>">WORKS</a><span>／</span><span><?php the_title(); ?></span></nav>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<?php if ( has_excerpt() ) : ?><p class="page-lead" data-reveal><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>

			<?php
			$spec = array(
				'所在地'       => fort_meta( 'fort_location' ),
				'ご家族構成'   => fort_meta( 'fort_family' ),
				'延床面積'     => fort_meta( 'fort_floorarea' ),
				'間取り'       => fort_meta( 'fort_layout' ),
				'竣工'         => fort_meta( 'fort_completion' ),
				'シリーズ'     => fort_meta( 'fort_series' ),
				'構造・性能'   => fort_meta( 'fort_spec' ),
				'参考価格帯'   => fort_meta( 'fort_price' ),
			);
			$has_spec = array_filter( $spec );
			if ( $has_spec ) : ?>
			<dl class="case-spec" data-reveal>
				<?php foreach ( $spec as $label => $val ) : if ( ! $val ) continue; ?>
				<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo ( '参考価格帯' === $label ) ? '<strong>' . esc_html( $val ) . '</strong>（建物本体）' : esc_html( $val ); ?></dd></div>
				<?php endforeach; ?>
			</dl>
			<?php endif; ?>
		</div>
	</section>

	<!-- 本文（写真やストーリーは編集画面でブロックとして追加） -->
	<section class="section section--gray">
		<div class="container" style="max-width:880px;">
			<div class="case-body" data-reveal>
				<?php the_content(); ?>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'exterior.jpg' ); ?>" alt="" aria-hidden="true"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
			<h2 class="section__title section__title--light" data-reveal>こんな住まいを、体感しませんか？</h2>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
			</ul>
		</div>
	</section>

	<!-- ほかの施工事例 -->
	<section class="works section">
		<div class="container">
			<header class="section__head"><p class="section__label">OTHER WORKS</p><h2 class="section__title">ほかの施工事例</h2></header>
			<ul class="works__grid">
				<?php
				$others = new WP_Query( array( 'post_type' => 'works', 'posts_per_page' => 3, 'post__not_in' => array( get_the_ID() ), 'orderby' => 'rand' ) );
				while ( $others->have_posts() ) : $others->the_post(); $oa = fort_meta( 'fort_area' ); ?>
				<li class="works__card" data-reveal>
					<a href="<?php the_permalink(); ?>" class="works__link">
						<figure class="works__figure"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'fort-card', array( 'loading' => 'lazy' ) ); } else { echo '<img src="' . esc_url( $img . 'ldk.jpg' ) . '" alt="">'; } ?></figure>
						<div class="works__body"><?php if ( $oa ) : ?><p class="works__cat"><?php echo esc_html( $oa ); ?></p><?php endif; ?><h3 class="works__card-title"><?php the_title(); ?></h3></div>
					</a>
				</li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
			<div class="section__more"><a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="btn btn--outline">施工事例の一覧へ戻る</a></div>
		</div>
	</section>
<?php endwhile; get_footer(); ?>
