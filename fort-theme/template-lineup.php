<?php
/*
 * Template Name: HOUSE（家づくりの方法・3つを比べる）
 * 推奨スラッグ：house（従来の lineup のままでも動きます）
 * 3つの商品を「グレードの上下」ではなく「家のつくり方の違い」として比べる
 */
get_header();
$items = fort_house_items();
$rows  = array(
	'method'  => 'つくり方',
	'freedom' => '設計の自由度',
	'choose'  => '選べる範囲',
	'price'   => '価格の目安',
);
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'HOUSE', '' ) ) ); ?>
			<p class="bh-label">HOUSE</p>
			<h1 class="bh-pagehead__title"><span class="bh-nb">家のつくり方を、</span><span class="bh-nb">3つから。</span></h1>
			<p class="bh-pagehead__lead"><span class="bh-nb">どれを選んでも、FORTらしいデザインはそのまま。</span><span class="bh-nb">性能も、暮らしと予算に合わせて設計します。</span></p>
		</div>
	</header>
	<figure class="bh-pagephoto"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/house-design.jpg' ); ?>" alt="" fetchpriority="high" decoding="async" style="object-position:50% 50%"></figure>

	<section class="bh-hx">
		<div class="bh-wrap">
			<div class="bh-hx__grid">
				<?php foreach ( $items as $key => $it ) :
					$url = fort_url( $key ); $ext = 0 !== strpos( $url, home_url() ); ?>
				<article class="bh-hx__item" id="house-<?php echo esc_attr( $key ); ?>">
					<?php /* 3つを比べる：同じ項目を同じ高さにそろえ、横に見比べられるようにする */ ?>
					<a class="bh-hx__fig" href="<?php echo esc_url( $url ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><img src="<?php echo esc_url( fort_media( $it['photo'] ) ); ?>" alt="<?php echo esc_attr( $it['name'] ); ?>の住まい" width="1200" height="1500" loading="lazy" decoding="async"></a>
					<p class="bh-hx__method"><span><?php echo esc_html( $it['en'] ); ?></span><?php echo esc_html( $it['method'] ); ?></p>
					<h2 class="bh-hx__name"><?php echo esc_html( $it['name'] ); ?></h2>
					<p class="bh-hx__catch"><?php echo esc_html( $it['catch'] ); ?></p>
					<p class="bh-hx__text"><?php echo esc_html( $it['text'] ); ?></p>
					<p class="bh-hx__price"><?php echo esc_html( fort_house_price( $it ) ); ?><small><?php echo esc_html( $it['price_note'] ); ?></small></p>
					<dl class="bh-hx__spec">
						<div><dt>設計の自由度</dt><dd><?php echo esc_html( $it['freedom'] ); ?></dd></div>
						<div><dt>選べる範囲</dt><dd><?php echo esc_html( $it['choose'] ); ?></dd></div>
						<div><dt>こんな方に</dt><dd><?php echo esc_html( implode( '／', $it['for'] ) ); ?></dd></div>
					</dl>
					<a class="bh-more" href="<?php echo esc_url( $url ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $it['name'] ); ?><?php echo $ext ? '（公式サイト）' : 'を詳しく'; ?></a>
				</article>
				<?php endforeach; ?>
			</div>
			<ul class="bh-house__common bh-house__common--light">
				<li><a href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a></li>
				<li><a href="<?php echo esc_url( fort_url( 'flow' ) ); ?>">家づくりの流れ</a></li>
				<li><a href="<?php echo esc_url( fort_url( 'works' ) ); ?>">施工事例</a></li>
			</ul>
		</div>
	</section>

	<?php get_template_part( 'parts/photo-band', null, array( 'offset' => 3, 'title' => 'つくり方は違っても、FORTらしさは同じ。' ) ); ?>

	<!-- 性能：3つ共通の考え方 -->
	<section class="pf-std bh-hperf" id="performance">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">PERFORMANCE</p>
				<h2 class="bh-head__title"><span class="bh-nb">性能は、</span><span class="bh-nb">シリーズで決めない。</span></h2>
				<p class="bh-eq__lead">すべてを最高性能にすることが、すべての家族にとっての正解ではありません。<br>FORTでは基準となる性能を持ちながら、構造・断熱・窓・換気・制振まで、一邸ごとに必要な性能を選択できます。</p>
			</header>
			<?php echo fort_performance_table( fort_url( 'performance' ) ); ?>
			<p class="bh-eq__note">シリーズ・プランにより選べる範囲が異なる場合があります。くわしくは<a href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a>のページ、またはスタッフまでお問い合わせください。</p>
		</div>
	</section>

	<!-- 設備グレード比較表 -->
	<section class="bh-eq" id="equipment">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">EQUIPMENT</p>
				<h2 class="bh-head__title"><span class="bh-nb">暮らしの快適さは、</span><span class="bh-nb">設備で変わる。</span></h2>
				<p class="bh-eq__lead">FORTが標準で採用する設備を、3つのシリーズで比べました。窓・換気などの性能にかかわる部分は、ご要望に合わせて変更できます。</p>
			</header>
			<div class="bh-cmp__scroll" tabindex="0" role="region" aria-label="設備グレード比較表（横にスクロールできます）">
				<table class="bh-eq__table">
					<thead><tr><th scope="col"><span class="sr-only">項目</span></th><?php foreach ( array( 'style', 'pro', 'design' ) as $k ) : $it = $items[ $k ]; ?><th scope="col"><?php echo esc_html( $it['name'] ); ?><small><?php echo esc_html( $it['method'] ); ?></small></th><?php endforeach; ?></tr></thead>
					<tbody>
						<?php foreach ( fort_equipment_table() as $row ) : ?>
						<tr><th scope="row"><?php echo esc_html( $row[0] ); ?><small><?php echo esc_html( $row[1] ); ?></small></th><?php foreach ( $row[2] as $cell ) : ?><td><?php echo fort_br( $cell ); ?></td><?php endforeach; ?></tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<p class="bh-eq__note">掲載の内容は時期により変更となる場合があります。詳しくはスタッフまでお問い合わせください。</p>
		</div>
	</section>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'house', 'title' => 'どれが合うかは、<br>話しながら決められます。' ) ); ?>
<?php get_footer(); ?>
