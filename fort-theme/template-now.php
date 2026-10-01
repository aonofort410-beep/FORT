<?php
/*
 * Template Name: NOW（Instagramからの入口）
 * /now/ — Instagram・YouTube のプロフィールに貼る固定URL。スマホ優先。
 * 並び：いまのお知らせ（本文）→ EVENT → MODEL HOUSE → WORKS → MOVIE → JOURNAL → HOUSE → VISIT
 * ・イベント・施工事例・記事は投稿から自動で最新になる。プロフィールのURLを変える必要はない
 * ・このページの本文に書いたことは「いまのお知らせ」として一番上に出る（空なら出ない）
 */
get_header();
the_post();
$works  = get_posts( array( 'post_type' => 'works', 'posts_per_page' => 6, 'meta_key' => '_thumbnail_id' ) );
$movies = fort_movies();
$posts  = post_type_exists( 'journal' ) ? get_posts( array( 'post_type' => 'journal', 'posts_per_page' => 3 ) ) : array();
?>
	<header class="bh-now__head">
		<div class="bh-wrap">
			<img class="bh-now__mark" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/fort-mark.png' ); ?>" alt="FORT" width="460" height="107">
			<h1 class="bh-now__title"><span class="bh-label">NOW</span><span class="bh-now__date"><?php echo esc_html( wp_date( 'Y.m' ) ); ?></span><span class="sr-only">いまのFORT｜岡山・福山の見学会・施工事例</span></h1>
			<p class="bh-now__lead">岡山・福山の家づくり、FORT。<br>いま見られる家と、最近の住まい。</p>
			<nav class="bh-now__jump" aria-label="このページの中">
				<a href="#event">EVENT</a><?php if ( $works ) : ?><a href="#now-works">WORKS</a><?php endif; ?><?php if ( $movies ) : ?><a href="#now-movie">MOVIE</a><?php endif; ?><a href="#now-house">HOUSE</a><a href="#visit">VISIT</a>
			</nav>
		</div>
	</header>

	<?php if ( trim( get_the_content() ) ) : ?>
	<section class="bh-now__news">
		<div class="bh-wrap bh-case__content"><?php the_content(); ?></div>
	</section>
	<?php endif; ?>

	<?php get_template_part( 'parts/event-list', null, array( 'limit' => 4, 'heading' => true, 'visit' => false ) ); ?>
	<?php get_template_part( 'parts/model-houses' ); ?>

	<?php if ( $works ) : ?>
	<section class="bh-now__works" id="now-works">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">WORKS</p>
				<h2 class="bh-head__title">最近の住まい</h2>
				<a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">すべての施工事例</a>
			</header>
		</div>
		<ul class="bh-now__rail" aria-label="施工事例（横にスクロール）">
			<?php foreach ( $works as $p ) : $f = fort_work_facets( $p->ID ); ?>
			<li class="bh-wcard"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-track="cta_click" data-track-label="now_works">
				<figure class="bh-wcard__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?></figure>
				<h3 class="bh-wcard__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
				<?php $m = array_filter( array( $f['region'] ? $f['region']['label'] : '', $f['series'] ? $f['series']['label'] : '' ) ); if ( $m ) : ?><p class="bh-wcard__meta"><?php echo esc_html( implode( ' / ', $m ) ); ?></p><?php endif; ?>
			</a></li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php endif; ?>

	<?php if ( $movies ) : ?>
	<section class="bh-movie" id="now-movie">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">MOVIE</p><a class="bh-more" href="<?php echo esc_url( fort_opt( 'fort_youtube_channel', FORT_YOUTUBE ) ); ?>" target="_blank" rel="noopener">YouTube</a></header>
			<figure class="bh-movie__item"><?php fort_youtube_lite( $movies[0]['id'], $movies[0]['title'] ); ?><?php if ( $movies[0]['title'] ) : ?><figcaption><?php echo esc_html( $movies[0]['title'] ); ?></figcaption><?php endif; ?></figure>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $posts ) : ?>
	<section class="bh-journal">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">JOURNAL</p><a class="bh-more" href="<?php echo esc_url( fort_url( 'journal' ) ); ?>">すべての記事</a></header>
			<ul class="bh-journal__list">
				<?php foreach ( $posts as $p ) : ?>
				<li><a class="bh-journal__item" href="<?php echo esc_url( get_permalink( $p ) ); ?>">
					<p class="bh-journal__meta"><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $p ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d', $p ) ); ?></time></p>
					<h3 class="bh-journal__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
				</a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>

	<section class="bh-now__house" id="now-house">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">HOUSE</p><h2 class="bh-head__title">家のつくり方を、3つから。</h2></header>
			<ul class="bh-now__methods">
				<?php foreach ( array( array( 'design', 'FORT DESIGN', '自由設計' ), array( 'pro', 'FORT PRO', '規格住宅' ), array( 'style', 'FORT STYLE', '完成した住まい' ) ) as $h ) :
					$ext = 0 !== strpos( fort_url( $h[0] ), home_url() ); ?>
				<li><a href="<?php echo esc_url( fort_url( $h[0] ) ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><span class="bh-now__mname"><?php echo esc_html( $h[1] ); ?></span><span class="bh-now__mtype"><?php echo esc_html( $h[2] ); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'now' ) ); ?>
<?php get_footer(); ?>
