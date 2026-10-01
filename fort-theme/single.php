<?php
/** 記事（お知らせ・JOURNAL） */
get_header();
while ( have_posts() ) : the_post();
	$is_journal = 'journal' === get_post_type();
	$label  = $is_journal ? 'JOURNAL' : 'NEWS';
	$list   = $is_journal ? fort_url( 'journal' ) : home_url( '/news/' );
	$terms  = $is_journal ? get_the_terms( get_the_ID(), 'journal_cat' ) : get_the_category();
	$term   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
?>
	<article class="bh-article">
		<header class="bh-pagehead">
			<div class="bh-wrap">
				<?php fort_breadcrumb( array( array( $label, $list ), array( get_the_title(), '' ) ) ); ?>
				<p class="bh-label"><?php echo esc_html( $label ); ?><?php echo $term ? '　—　' . esc_html( $term->name ) : ''; ?></p>
				<h1 class="bh-pagehead__title"><?php the_title(); ?></h1>
				<p class="bh-article__date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time><?php if ( get_the_modified_date( 'Ymd' ) > get_the_date( 'Ymd' ) ) : ?>　更新 <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'Y.m.d' ) ); ?></time><?php endif; ?></p>
			</div>
		</header>
		<?php if ( has_post_thumbnail() ) : ?><figure class="bh-case__main"><?php the_post_thumbnail( 'fort-hero', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'alt' => '' ) ); ?></figure><?php endif; ?>
		<div class="bh-wrap"><div class="bh-prose"><?php the_content(); ?></div></div>
		<div class="bh-wrap bh-article__foot"><a class="bh-more" href="<?php echo esc_url( $list ); ?>">一覧へ戻る</a></div>
	</article>

	<?php
	if ( $is_journal ) :
		$more = get_posts( array( 'post_type' => 'journal', 'posts_per_page' => 3, 'post__not_in' => array( get_the_ID() ) ) );
		if ( $more ) : ?>
	<section class="bh-journal bh-journal--more">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">MORE JOURNAL</p></header>
			<ul class="bh-journal__list"><?php foreach ( $more as $p ) : ?><li><a class="bh-journal__item" href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php if ( has_post_thumbnail( $p ) ) : ?><figure class="bh-journal__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'alt' => '' ) ); ?></figure><?php endif; ?><p class="bh-journal__meta"><?php echo esc_html( get_the_date( 'Y.m.d', $p ) ); ?></p><h3 class="bh-journal__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3></a></li><?php endforeach; ?></ul>
		</div>
	</section>
		<?php endif;
	endif;
	get_template_part( 'parts/visit-cta', null, array( 'from' => $is_journal ? 'journal' : 'news' ) );
endwhile;
get_footer();
