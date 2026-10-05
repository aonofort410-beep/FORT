<?php
/*
 * Template Name: PLACE（岡山・福山）
 * ・スラッグが okayama / fukuyama のページ → その地域のページ
 *   岡山について → WORKS → EVENT → MODEL HOUSE → STUDIO → JOURNAL → VISIT
 * ・それ以外（/place/）→ 2つの地域の入口
 * ・ページ本文に書いた内容は「この地域について」として表示（空なら既定の短い文）
 */
get_header();
the_post();
$studios = fort_studios();
$slug    = get_post_field( 'post_name', get_the_ID() );
$region  = isset( $studios[ $slug ] ) ? $slug : '';

if ( ! $region ) : /* ---------- /place/：2つの地域の入口 ---------- */ ?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'PLACE', '' ) ) ); ?>
			<p class="bh-label">PLACE</p>
			<h1 class="bh-pagehead__title"><span class="bh-nb">岡山と福山に、</span><span class="bh-nb">スタジオがあります。</span></h1>
		</div>
	</header>
	<section class="bh-place bh-place--index">
		<div class="bh-wrap">
			<div class="bh-place__grid">
				<?php foreach ( $studios as $key => $st ) : ?>
				<a class="bh-place__item" href="<?php echo esc_url( fort_url( $key ) ); ?>">
					<?php echo fort_place_name( $key, $st['en'] ); // phpcs:ignore ?>
					<span class="bh-place__ja"><?php echo esc_html( $st['name'] ); ?>　<?php echo esc_html( $st['area'] ); ?></span>
					<span class="bh-place__tel"><?php echo esc_html( $st['tel'] ); ?></span>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php get_template_part( 'parts/photo-band', null, array( 'offset' => 2 ) ); ?>
	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'place' ) ); ?>
<?php else : /* ---------- 地域のページ ---------- */
	$st    = $studios[ $region ];
	$works = get_posts( array( 'post_type' => 'works', 'posts_per_page' => 6, 'meta_key' => 'fort_w_region', 'meta_value' => $region ) );
	$works = array_values( array_filter( $works, 'has_post_thumbnail' ) );
	$term  = taxonomy_exists( 'journal_cat' ) ? get_term_by( 'slug', $region, 'journal_cat' ) : false;
	$posts = $term ? get_posts( array( 'post_type' => 'journal', 'posts_per_page' => 3, 'tax_query' => array( array( 'taxonomy' => 'journal_cat', 'terms' => $term->term_id ) ) ) ) : array();
	$hero  = fort_studio_img( $region ) ?: ( $works ? get_the_post_thumbnail_url( $works[0], 'fort-hero' ) : '' );
	?>
	<header class="bh-region">
		<?php if ( $hero ) : ?><figure class="bh-region__bg"><img src="<?php echo esc_url( $hero ); ?>" alt="" fetchpriority="high" decoding="async"></figure><?php endif; ?>
		<div class="bh-wrap bh-region__inner">
			<?php fort_breadcrumb( array( array( 'PLACE', fort_url( 'place' ) ), array( $st['en'], '' ) ) ); ?>
			<h1 class="bh-region__name"><?php echo esc_html( $st['en'] ); ?><span class="sr-only">｜<?php echo esc_html( get_the_title() ); ?>の家づくり FORT</span></h1>
			<p class="bh-region__sub"><?php echo esc_html( $st['area'] ); ?>の家づくり</p>
		</div>
	</header>

	<section class="bh-case__text">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">ABOUT<span><?php echo esc_html( get_the_title() ); ?>について</span></h2>
			<div class="bh-case__body">
				<?php if ( trim( get_the_content() ) ) : the_content(); else : ?>
				<p><?php echo esc_html( $st['name'] ); ?>を拠点に、<?php echo esc_html( $st['area'] ); ?>で住まいを設計し、建てています。</p>
				<p>ここでは、<?php echo esc_html( get_the_title() ); ?>で見られる住まいや、参加できる見学会・相談会をまとめています。</p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( $works ) : ?>
	<section class="bh-now__works">
		<div class="bh-wrap"><header class="bh-head"><p class="bh-label">WORKS — <?php echo esc_html( $st['en'] ); ?></p><h2 class="bh-head__title"><?php echo esc_html( get_the_title() ); ?>の住まい</h2><a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">すべての施工事例</a></header></div>
		<ul class="bh-now__rail">
			<?php foreach ( $works as $p ) : ?>
			<li class="bh-wcard"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><figure class="bh-wcard__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?></figure><h3 class="bh-wcard__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3></a></li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php endif; ?>

	<?php get_template_part( 'parts/event-list', null, array( 'limit' => 6, 'heading' => true, 'region' => $region, 'visit' => false, 'title' => esc_html( get_the_title() ) . 'の見学会・相談会' ) ); ?>
	<?php get_template_part( 'parts/model-houses', null, array( 'region' => $region ) ); ?>

	<section class="bh-studio" id="studio">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">STUDIO<span><?php echo esc_html( $st['name'] ); ?></span></h2>
			<div>
				<dl class="bh-spec">
					<div><dt>住所</dt><dd><?php echo esc_html( $st['zip'] ); ?><br><?php echo esc_html( $st['addr'] ); ?><br><a class="bh-studio__map" href="<?php echo esc_url( fort_map_url( $st['addr'] ) ); ?>" target="_blank" rel="noopener">Googleマップで開く</a></dd></div>
					<div><dt>電話番号</dt><dd><a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $st['tel'] ) ); ?>"><?php echo esc_html( $st['tel'] ); ?></a></dd></div>
					<div><dt>営業時間</dt><dd>9:00〜18:00</dd></div>
					<div><dt>定休日</dt><dd>水曜日</dd></div>
					<div><dt>ご相談</dt><dd>ご予約優先。お子さま連れも歓迎です。</dd></div>
				</dl>
			</div>
		</div>
	</section>

	<?php if ( $posts ) : ?>
	<section class="bh-journal">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">JOURNAL — <?php echo esc_html( $st['en'] ); ?></p><a class="bh-more" href="<?php echo esc_url( get_term_link( $term ) ); ?>">記事をもっと見る</a></header>
			<ul class="bh-journal__list"><?php foreach ( $posts as $p ) : ?><li><a class="bh-journal__item" href="<?php echo esc_url( get_permalink( $p ) ); ?>"><p class="bh-journal__meta"><?php echo esc_html( get_the_date( 'Y.m.d', $p ) ); ?></p><h3 class="bh-journal__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3></a></li><?php endforeach; ?></ul>
		</div>
	</section>
	<?php endif; ?>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'place_' . $region, 'area' => $region, 'photo' => $hero, 'title' => esc_html( $st['name'] ) . 'で、<br>お待ちしています。' ) ); ?>
<?php endif; ?>
<?php get_footer(); ?>
