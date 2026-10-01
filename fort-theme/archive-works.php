<?php
/**
 * 施工事例 一覧（作品集）
 * ・写真が主役。地域 / 平屋・二階建て / 商品 / 特徴 で絞り込み（ページ遷移なし）
 * ・JavaScriptが無くても全件が見られる
 */
get_header();
$c        = fort_works_choices();
$cards    = array();
$present  = array( 'region' => array(), 'floors' => array(), 'series' => array(), 'feature' => array() );
if ( have_posts() ) : while ( have_posts() ) : the_post();
	$f = fort_work_facets( get_the_ID() );
	foreach ( array( 'region', 'floors', 'series' ) as $k ) if ( $f[ $k ] ) $present[ $k ][ $f[ $k ]['value'] ] = $f[ $k ]['label'];
	foreach ( $f['feature'] as $t ) $present['feature'][ $t->slug ] = $t->name;
	$cards[] = array( 'id' => get_the_ID(), 'f' => $f );
endwhile; endif;
$groups = array(
	'region'  => '地域',
	'floors'  => '階数',
	'series'  => '商品',
	'feature' => '特徴',
);
$term = is_tax( 'works_cat' ) ? get_queried_object() : null;
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( $term ? array( array( 'WORKS', fort_url( 'works' ) ), array( $term->name, '' ) ) : array( array( 'WORKS', '' ) ) ); ?>
			<p class="bh-label">WORKS</p>
			<h1 class="bh-pagehead__title"><?php echo $term ? esc_html( $term->name ) . 'の施工事例' : '施工事例'; ?></h1>
			<p class="bh-pagehead__lead"><span class="bh-nb">岡山・福山でFORTが設計し、建てた住まい。</span><span class="bh-nb">写真から、気になる一棟を見つけてください。</span></p>
		</div>
	</header>

	<section class="bh-wlist">
		<div class="bh-wrap">
			<?php if ( count( $cards ) > 1 && array_filter( $present ) ) : ?>
			<div class="bh-filter" data-works-filter>
				<?php foreach ( $groups as $g => $label ) : if ( count( $present[ $g ] ) < 1 ) continue; ?>
				<div class="bh-filter__group" role="group" aria-label="<?php echo esc_attr( $label ); ?>で絞り込む" data-group="<?php echo esc_attr( $g ); ?>">
					<span class="bh-filter__label"><?php echo esc_html( $label ); ?></span>
					<button type="button" aria-pressed="true" data-value="">すべて</button>
					<?php foreach ( $present[ $g ] as $v => $name ) : ?>
					<button type="button" aria-pressed="false" data-value="<?php echo esc_attr( $v ); ?>"><?php echo esc_html( $name ); ?></button>
					<?php endforeach; ?>
				</div>
				<?php endforeach; ?>
				<p class="bh-filter__count" aria-live="polite"><span data-works-count><?php echo count( $cards ); ?></span> 件</p>
			</div>
			<?php endif; ?>

			<?php if ( $cards ) : ?>
			<ul class="bh-wgrid">
				<?php foreach ( $cards as $i => $card ) :
					$id = $card['id']; $f = $card['f'];
					$meta = array_filter( array( $f['region'] ? $f['region']['label'] : '', $f['floors'] ? $f['floors']['label'] : '', $f['series'] ? $f['series']['label'] : '' ) );
					if ( ! $meta && get_post_meta( $id, 'fort_area', true ) ) $meta = array( get_post_meta( $id, 'fort_area', true ) ); ?>
				<li class="bh-wcard" data-region="<?php echo esc_attr( $f['region'] ? $f['region']['value'] : '' ); ?>" data-floors="<?php echo esc_attr( $f['floors'] ? $f['floors']['value'] : '' ); ?>" data-series="<?php echo esc_attr( $f['series'] ? $f['series']['value'] : '' ); ?>" data-feature="<?php echo esc_attr( implode( ' ', wp_list_pluck( $f['feature'], 'slug' ) ) ); ?>">
					<a href="<?php echo esc_url( get_permalink( $id ) ); ?>">
						<figure class="bh-wcard__fig"><?php
							if ( has_post_thumbnail( $id ) ) {
								echo get_the_post_thumbnail( $id, 'fort-hero', array( 'loading' => $i < 2 ? 'eager' : 'lazy', 'decoding' => 'async', 'alt' => '', 'sizes' => '(min-width: 1024px) 50vw, 100vw' ) );
							} ?></figure>
						<h2 class="bh-wcard__title"><?php echo esc_html( get_the_title( $id ) ); ?></h2>
						<?php if ( $meta ) : ?><p class="bh-wcard__meta"><?php echo esc_html( implode( ' / ', $meta ) ); ?></p><?php endif; ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<p class="bh-event__none" hidden data-works-empty>この条件に合う施工事例は、いまはありません。</p>
			<?php else : ?>
			<p class="bh-event__none">施工事例は準備中です。実際の住まいは、見学会やスタジオでご覧いただけます。</p>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'parts/event-list', null, array( 'limit' => 4, 'heading' => true ) ); ?>
	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'works' ) ); ?>
<?php get_footer(); ?>
