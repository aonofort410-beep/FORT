<?php
/*
 * Template Name: FORT PRO 規格プラン
 * 並び（3商品共通）：CONCEPT → こんな方に → 設計の自由度・選べる範囲 → PLAN A〜F → 価格の考え方 → 流れ → WORKS → VISIT
 */
get_header();
$img  = get_template_directory_uri() . '/assets/images/';
$it   = fort_house_items()['pro'];
$plans = array(
	'a' => array( 'スタンダードな2階建て', '3LDK', 'LDK 約18帖', '約100㎡（約30坪）', '2階建て', '使い勝手のよい王道の間取り。寝室＋子ども室2部屋を2階にまとめた、ご家族で暮らしやすいスタンダードプランです。' ),
	'b' => array( '吹抜けのある2階建て', '3LDK', 'LDK 約18帖＋吹抜け', '約100㎡（約30坪）', '2階建て', 'LDK上部に吹抜けを設けた開放的なプラン。WIC・SICなど収納も充実し、光がたっぷり届く明るい住まいです。' ),
	'c' => array( 'ゆとりのLDKの2階建て', '3LDK', 'LDK 約20.5帖', '約105㎡（約32坪）', '2階建て', '20.5帖のゆとりあるLDKが主役。シューズクロークやWICを備え、すっきり片付く暮らしやすい間取りです。' ),
	'd' => array( 'ワンフロアで暮らす平屋', '3LDK（平屋）', 'LDK 約20.5帖', '97.50㎡（29.49坪）', '平屋', '階段のないワンフロア完結の平屋プラン。寝室＋子ども室2部屋、パントリーやWICも備え、家事ラクで安全な暮らしを実現します。' ),
	'e' => array( '開放感の吹抜けプラン', '3LDK', 'LDK 約20帖＋吹抜け', '約105㎡（約32坪）', '2階建て', '20帖のLDKに上部吹抜けを重ねた、縦にも横にも広がりを感じるプラン。家族の気配を感じながら、のびやかに暮らせます。' ),
	'f' => array( '中庭のある2階建て', '3LDK', 'LDK 約19.7帖', '約104㎡（約31坪）', '2階建て・中庭', '住まいの中心に中庭を取り込み、プライバシーを守りながら採光・通風を確保。街中でも開放的に暮らせるプランです。' ),
);
$works = get_posts( array( 'post_type' => 'works', 'posts_per_page' => 3, 'meta_key' => 'fort_w_series', 'meta_value' => 'pro' ) );
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'HOUSE', fort_url( 'house' ) ), array( 'FORT PRO', '' ) ) ); ?>
			<p class="bh-label">HOUSE — <?php echo esc_html( $it['en'] ); ?></p>
			<h1 class="bh-pagehead__title bh-pagehead__title--en">FORT PRO</h1>
			<p class="bh-pagehead__lead"><?php echo esc_html( $it['method'] ); ?>　<?php echo esc_html( $it['catch'] ); ?></p>
		</div>
	</header>
	<figure class="bh-case__main"><img src="<?php echo esc_url( $img . 'pro/persp-e.jpg' ); ?>" alt="FORT PRO PLAN E 外観パース" loading="eager" fetchpriority="high" decoding="async"></figure>

	<section class="bh-case__text">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">CONCEPT<span>考え方</span></h2>
			<div class="bh-case__body"><p><?php echo esc_html( $it['text'] ); ?></p></div>
		</div>
	</section>

	<section class="bh-case__spec">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">FOR YOU<span>こんな方に</span></h2>
			<div>
				<ul class="bh-hx__for bh-hx__for--lg"><?php foreach ( $it['for'] as $f ) : ?><li><?php echo esc_html( $f ); ?></li><?php endforeach; ?></ul>
				<dl class="bh-spec bh-spec--mt">
					<div><dt>設計の自由度</dt><dd><?php echo esc_html( $it['freedom'] ); ?></dd></div>
					<div><dt>選べる範囲</dt><dd><?php echo esc_html( $it['choose'] ); ?></dd></div>
				</dl>
			</div>
		</div>
	</section>

	<section class="bh-plans" id="plans">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">PLAN A — F</p><h2 class="bh-head__title">6つのたたき台プラン</h2></header>
			<nav class="bh-plans__nav" aria-label="プランへ移動"><?php foreach ( $plans as $k => $p ) : ?><a href="#plan-<?php echo esc_attr( $k ); ?>"><?php echo esc_html( strtoupper( $k ) ); ?></a><?php endforeach; ?></nav>
			<?php foreach ( $plans as $k => $p ) : $K = strtoupper( $k ); ?>
			<article class="bh-plan" id="plan-<?php echo esc_attr( $k ); ?>">
				<header class="bh-plan__head"><span class="bh-plan__letter"><?php echo esc_html( $K ); ?></span><div><h3 class="bh-plan__name"><?php echo esc_html( $p[0] ); ?></h3><p class="bh-plan__sub"><?php echo esc_html( $p[1] . '／延床 ' . $p[3] ); ?></p></div></header>
				<div class="bh-plan__media">
					<figure><img src="<?php echo esc_url( $img . 'pro/persp-' . $k . '.jpg' ); ?>" alt="PLAN <?php echo esc_attr( $K ); ?> 外観パース" loading="lazy" decoding="async"></figure>
					<figure class="bh-plan__drawing"><a href="<?php echo esc_url( $img . 'pro/plan-' . $k . '.jpg' ); ?>" target="_blank" rel="noopener"><img src="<?php echo esc_url( $img . 'pro/plan-' . $k . '.jpg' ); ?>" alt="PLAN <?php echo esc_attr( $K ); ?> 平面図" loading="lazy" decoding="async"></a><figcaption>図面をタップで拡大</figcaption></figure>
				</div>
				<div class="bh-plan__body">
					<p><?php echo esc_html( $p[5] ); ?></p>
					<dl class="bh-spec"><div><dt>間取り</dt><dd><?php echo esc_html( $p[1] ); ?></dd></div><div><dt>LDK</dt><dd><?php echo esc_html( substr( $p[2], 4 ) ); ?></dd></div><div><dt>延床面積</dt><dd><?php echo esc_html( $p[3] ); ?></dd></div><div><dt>タイプ</dt><dd><?php echo esc_html( $p[4] ); ?></dd></div></dl>
					<a class="bh-more" href="<?php echo esc_url( fort_visit_url() ); ?>" data-track="cta_click" data-track-label="pro_plan_<?php echo esc_attr( $k ); ?>">このプランで相談する</a>
				</div>
			</article>
			<?php endforeach; ?>
			<p class="bh-cmp__note bh-plans__note">掲載のプラン・図面・パースはたたき台の一例です。間取り・仕様・面積は実際の計画により変わります。</p>
		</div>
	</section>

	<section class="bh-case__spec">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">PRICE<span>価格の考え方</span></h2>
			<div class="bh-case__body">
				<p class="bh-price"><?php echo esc_html( $it['price'] ); ?></p>
				<p><small><?php echo esc_html( $it['price_note'] ); ?></small></p>
				<p>プランをもとに、内装・設備の選び方で金額が変わります。ご予算に合わせて、どこにお金をかけるかを一緒に考えます。</p>
				<p class="bh-about__links"><a class="bh-more" href="<?php echo esc_url( fort_url( 'flow' ) ); ?>">家づくりの流れ</a><a class="bh-more" href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a><a class="bh-more" href="<?php echo esc_url( fort_url( 'house' ) ); ?>">3つを比べる</a></p>
			</div>
		</div>
	</section>

	<?php if ( $works ) : ?>
	<section class="bh-related">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">WORKS — FORT PRO</p><a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">すべての施工事例</a></header>
			<ul class="bh-related__list"><?php foreach ( $works as $p ) : ?><li class="bh-wcard"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><figure class="bh-wcard__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'alt' => '' ) ); ?></figure><h3 class="bh-wcard__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3></a></li><?php endforeach; ?></ul>
		</div>
	</section>
	<?php endif; ?>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'pro', 'photo' => $img . 'pro/persp-c.jpg', 'title' => '気になるプランから、<br>相談を始めましょう。' ) ); ?>
<?php get_footer(); ?>
