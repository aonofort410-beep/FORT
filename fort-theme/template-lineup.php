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
			<p class="bh-pagehead__lead"><span class="bh-nb">どれを選んでも、FORTらしいデザインと性能はそのまま。</span><span class="bh-nb">違うのは、家のつくり方です。</span></p>
		</div>
	</header>

	<section class="bh-hx">
		<div class="bh-wrap">
			<div class="bh-hx__grid">
				<?php foreach ( $items as $key => $it ) :
					$url = fort_url( $key ); $ext = 0 !== strpos( $url, home_url() ); ?>
				<article class="bh-hx__item" id="house-<?php echo esc_attr( $key ); ?>">
					<a class="bh-hx__fig" href="<?php echo esc_url( $url ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><img src="<?php echo esc_url( fort_media( $it['photo'] ) ); ?>" alt="<?php echo esc_attr( $it['name'] ); ?>の住まい" width="1200" height="1500" loading="lazy" decoding="async"></a>
					<p class="bh-hx__method"><span><?php echo esc_html( $it['en'] ); ?></span><?php echo esc_html( $it['method'] ); ?></p>
					<h2 class="bh-hx__name"><?php echo esc_html( $it['name'] ); ?></h2>
					<p class="bh-hx__catch"><?php echo esc_html( $it['catch'] ); ?></p>
					<p class="bh-hx__text"><?php echo esc_html( $it['text'] ); ?></p>
					<p class="bh-hx__for-label">こんな方に</p>
					<ul class="bh-hx__for"><?php foreach ( $it['for'] as $f ) : ?><li><?php echo esc_html( $f ); ?></li><?php endforeach; ?></ul>
					<a class="bh-more" href="<?php echo esc_url( $url ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $it['name'] ); ?><?php echo $ext ? '（公式サイト）' : 'を詳しく'; ?></a>
				</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="bh-cmp">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">COMPARE</p><h2 class="bh-head__title">3つを比べる</h2></header>
			<div class="bh-cmp__scroll" tabindex="0" role="region" aria-label="3つの商品の比較表（横にスクロールできます）">
				<table class="bh-cmp__table">
					<thead><tr><th scope="col"><span class="sr-only">項目</span></th><?php foreach ( $items as $it ) : ?><th scope="col"><?php echo esc_html( $it['name'] ); ?></th><?php endforeach; ?></tr></thead>
					<tbody>
						<?php foreach ( $rows as $k => $label ) : ?>
						<tr><th scope="row"><?php echo esc_html( $label ); ?></th><?php foreach ( $items as $it ) : ?><td><?php echo esc_html( $it[ $k ] ); ?><?php if ( 'price' === $k ) : ?><small><?php echo esc_html( $it['price_note'] ); ?></small><?php endif; ?></td><?php endforeach; ?></tr>
						<?php endforeach; ?>
						<tr><th scope="row">こんな方に</th><?php foreach ( $items as $it ) : ?><td><?php echo esc_html( $it['for'][0] ); ?></td><?php endforeach; ?></tr>
					</tbody>
				</table>
			</div>
			<p class="bh-cmp__note">性能・保証・家づくりの流れは、3つ共通です。</p>
			<ul class="bh-house__common bh-house__common--light">
				<li><a href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a></li>
				<li><a href="<?php echo esc_url( fort_url( 'flow' ) ); ?>">家づくりの流れ</a></li>
				<li><a href="<?php echo esc_url( fort_url( 'works' ) ); ?>">施工事例</a></li>
			</ul>
		</div>
	</section>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'house', 'title' => 'どれが合うかは、<br>話しながら決められます。' ) ); ?>
<?php get_footer(); ?>
