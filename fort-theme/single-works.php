<?php
/**
 * 施工事例 詳細（作品集の1ページ）
 * 作品名 → メイン写真 → この家の背景 → 写真 → 設計上の工夫 → 暮らし → 仕様 → MOVIE → 関連作品 → EVENT / VISIT
 * ・設計担当者の名前・写真・コメントは載せない（FORTとして、なぜこの設計にしたのか を書く）
 * ・入力されていない項目は表示しない
 */
get_header();
while ( have_posts() ) : the_post();
	$id  = get_the_ID();
	$f   = fort_work_facets( $id );
	$bg  = get_post_meta( $id, 'fort_w_background', true );
	$ds  = get_post_meta( $id, 'fort_w_design', true );
	$lf  = get_post_meta( $id, 'fort_w_life', true );
	$mv  = fort_youtube_id( get_post_meta( $id, 'fort_w_movie', true ) );
	$meta = array_filter( array( $f['region'] ? $f['region']['label'] : '', $f['floors'] ? $f['floors']['label'] : '', $f['series'] ? $f['series']['label'] : '' ) );
	if ( ! $meta && get_post_meta( $id, 'fort_area', true ) ) $meta = array( get_post_meta( $id, 'fort_area', true ) );
	$spec = array_filter( array(
		'所在地'     => get_post_meta( $id, 'fort_location', true ),
		'延床面積'   => get_post_meta( $id, 'fort_floorarea', true ),
		'間取り'     => get_post_meta( $id, 'fort_layout', true ),
		'竣工'       => get_post_meta( $id, 'fort_completion', true ),
		'商品'       => $f['series'] ? $f['series']['label'] : get_post_meta( $id, 'fort_series', true ),
		'構造・性能' => get_post_meta( $id, 'fort_spec', true ),
		'ご家族構成' => get_post_meta( $id, 'fort_family', true ),
		'参考価格帯' => get_post_meta( $id, 'fort_price', true ),
	) );
	$content = trim( get_the_content() );
	$photo   = has_post_thumbnail() ? get_the_post_thumbnail_url( $id, 'fort-hero' ) : '';
?>
	<article class="bh-case">
		<header class="bh-pagehead bh-pagehead--case">
			<div class="bh-wrap">
				<?php fort_breadcrumb( array( array( 'WORKS', fort_url( 'works' ) ), array( get_the_title(), '' ) ) ); ?>
				<p class="bh-label">WORKS<?php echo $meta ? '　—　' . esc_html( implode( ' / ', $meta ) ) : ''; ?></p>
				<h1 class="bh-pagehead__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?><p class="bh-pagehead__lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
		<figure class="bh-case__main"><?php the_post_thumbnail( 'fort-hero', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async', 'sizes' => '100vw', 'alt' => esc_attr( get_the_title() ) ) ); ?></figure>
		<?php endif; ?>

		<?php if ( $bg ) : ?>
		<section class="bh-case__text">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">BACKGROUND<span>この家の背景</span></h2>
				<div class="bh-case__body"><?php echo fort_paras( $bg ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( $content ) : ?>
		<section class="bh-case__photos">
			<div class="bh-wrap bh-case__content"><?php the_content(); ?></div>
		</section>
		<?php endif; ?>

		<?php if ( $ds ) : ?>
		<section class="bh-case__text bh-case__text--design">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">DESIGN<span>設計上の工夫</span></h2>
				<div class="bh-case__body"><?php echo fort_paras( $ds ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( $lf ) : ?>
		<section class="bh-case__text">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">LIFE<span>暮らし</span></h2>
				<div class="bh-case__body"><?php echo fort_paras( $lf ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( $spec ) : ?>
		<section class="bh-case__spec">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">DATA<span>この家について</span></h2>
				<dl class="bh-spec">
					<?php foreach ( $spec as $k => $v ) : ?>
					<div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?><?php echo '参考価格帯' === $k ? '<small>（建物本体）</small>' : ''; ?></dd></div>
					<?php endforeach; ?>
				</dl>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( $mv ) : ?>
		<section class="bh-case__movie">
			<div class="bh-wrap">
				<h2 class="bh-label">MOVIE</h2>
				<div class="bh-case__yt"><?php fort_youtube_lite( $mv, get_the_title() ); ?></div>
			</div>
		</section>
		<?php endif; ?>
	</article>

	<?php
	/* 関連作品：同じ商品 → 同じ地域 → 新着 の順で3件 */
	$related = array();
	foreach ( array( 'fort_w_series' => $f['series'], 'fort_w_region' => $f['region'] ) as $mk => $val ) {
		if ( ! $val || count( $related ) >= 3 ) continue;
		$related = array_merge( $related, get_posts( array( 'post_type' => 'works', 'posts_per_page' => 3 - count( $related ), 'post__not_in' => array_merge( array( $id ), wp_list_pluck( $related, 'ID' ) ), 'meta_key' => $mk, 'meta_value' => $val['value'] ) ) );
	}
	if ( count( $related ) < 3 ) {
		$related = array_merge( $related, get_posts( array( 'post_type' => 'works', 'posts_per_page' => 3 - count( $related ), 'post__not_in' => array_merge( array( $id ), wp_list_pluck( $related, 'ID' ) ) ) ) );
	}
	if ( $related ) : ?>
	<section class="bh-related">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">RELATED WORKS</p>
				<a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">すべての施工事例</a>
			</header>
			<ul class="bh-related__list">
				<?php foreach ( $related as $p ) : $rf = fort_work_facets( $p->ID ); ?>
				<li class="bh-wcard"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
					<figure class="bh-wcard__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?></figure>
					<h3 class="bh-wcard__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
					<?php $rm = array_filter( array( $rf['region'] ? $rf['region']['label'] : '', $rf['series'] ? $rf['series']['label'] : '' ) ); if ( $rm ) : ?><p class="bh-wcard__meta"><?php echo esc_html( implode( ' / ', $rm ) ); ?></p><?php endif; ?>
				</a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>

	<?php
	$region = $f['region'] ? $f['region']['value'] : '';
	get_template_part( 'parts/event-list', null, array( 'limit' => 3, 'heading' => true, 'region' => $region ) );
	get_template_part( 'parts/visit-cta', null, array( 'from' => 'works_detail', 'photo' => $photo, 'title' => 'この空気感を、<br>実物で。' ) );
endwhile;
get_footer();
