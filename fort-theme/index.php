<?php
/** 一覧（お知らせ・JOURNAL・検索・その他） */
get_header();
$is_journal = is_post_type_archive( 'journal' ) || is_tax( 'journal_cat' );
if ( is_search() )      { $label = 'SEARCH';  $title = '「' . get_search_query() . '」の検索結果'; }
elseif ( $is_journal )  { $label = 'JOURNAL'; $title = is_tax() ? single_term_title( '', false ) : '読みもの'; }
elseif ( is_archive() ) { $label = 'NEWS';    $title = wp_strip_all_tags( get_the_archive_title() ); }
else                    { $label = 'NEWS';    $title = 'お知らせ'; }
$crumbs = ( $is_journal && is_tax() ) ? array( array( 'JOURNAL', fort_url( 'journal' ) ), array( $title, '' ) ) : array( array( $label, '' ) );
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( $crumbs ); ?>
			<p class="bh-label"><?php echo esc_html( $label ); ?></p>
			<h1 class="bh-pagehead__title"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $is_journal && ! is_tax() ) : ?><p class="bh-pagehead__lead"><span class="bh-nb">設計、暮らし、土地、費用、性能。</span><span class="bh-nb">FORTだから話せることを書いています。</span></p><?php endif; ?>
			<?php if ( $is_journal ) : $terms = get_terms( array( 'taxonomy' => 'journal_cat', 'hide_empty' => true ) ); if ( $terms && ! is_wp_error( $terms ) ) : ?>
			<nav class="bh-filter__group bh-journal__themes" aria-label="テーマ"><a href="<?php echo esc_url( fort_url( 'journal' ) ); ?>"<?php echo is_tax() ? '' : ' aria-current="page"'; ?>>すべて</a><?php foreach ( $terms as $t ) : ?><a href="<?php echo esc_url( get_term_link( $t ) ); ?>"<?php echo is_tax( 'journal_cat', $t->term_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $t->name ); ?></a><?php endforeach; ?></nav>
			<?php endif; endif; ?>
		</div>
	</header>

	<section class="bh-journal bh-journal--archive">
		<div class="bh-wrap">
			<?php if ( have_posts() ) : ?>
			<ul class="bh-journal__list<?php echo $is_journal ? '' : ' bh-journal__list--text'; ?>">
				<?php while ( have_posts() ) : the_post(); ?>
				<li><a class="bh-journal__item" href="<?php the_permalink(); ?>">
					<?php if ( $is_journal && has_post_thumbnail() ) : ?><figure class="bh-journal__fig"><?php the_post_thumbnail( 'fort-card', array( 'loading' => 'lazy', 'alt' => '' ) ); ?></figure><?php endif; ?>
					<p class="bh-journal__meta"><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time></p>
					<h2 class="bh-journal__title"><?php the_title(); ?></h2>
				</a></li>
				<?php endwhile; ?>
			</ul>
			<div class="bh-pager"><?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '←', 'next_text' => '→' ) ); ?></div>
			<?php else : ?>
			<p class="bh-event__none"><?php echo is_search() ? '見つかりませんでした。別の言葉で探してみてください。' : 'まだ記事はありません。'; ?></p>
			<?php endif; ?>
		</div>
	</section>
<?php get_footer();
