<?php
/*
 * Template Name: ABOUT（FORTについて）
 * 推奨スラッグ：about
 * PHILOSOPHY → BALANCE → TEAM → HOUSE → COMPANY → PLACE → VISIT
 * ・文章は既存ページ（FORTの思い・スタッフ・会社概要）に載っていた内容から構成
 */
get_header();
$studios = fort_studios();
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'ABOUT', '' ) ) ); ?>
			<p class="bh-label">ABOUT</p>
			<h1 class="bh-pagehead__title">家族に、<br>ちょうどいい家を。</h1>
		</div>
	</header>
	<figure class="bh-case__main"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero.jpg' ); ?>" alt="FORTが手がけた住まいのキッチンとダイニング" width="2400" height="1600" fetchpriority="high" decoding="async"></figure>

	<section class="bh-case__text">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">PHILOSOPHY<span>FORTの思い</span></h2>
			<div class="bh-case__body bh-about-lead">
				<p>性能だけを追い求めれば、家は高くなる。<br>デザインだけを追い求めれば、暮らしにくくなる。</p>
				<p>FORTは、性能・デザイン・価格のちょうどいいバランスを考えます。家族が無理なく、長く豊かに暮らせること。それが、FORTの家づくりです。</p>
			</div>
		</div>
	</section>

	<section class="bh-balance">
		<div class="bh-wrap">
			<p class="bh-label">BALANCE</p>
			<ul class="bh-balance__list">
				<li><span>DESIGN</span>デザインを、あきらめない。</li>
				<li><span>PERFORMANCE</span>性能に、妥協しない。</li>
				<li><span>PRICE</span>だから、家族に「ちょうどいい」。</li>
			</ul>
		</div>
	</section>

	<section class="bh-case__text">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">TEAM<span>チームでつくる</span></h2>
			<div class="bh-case__body">
				<p class="bh-about-h">担当者まかせにしない、チームの家づくり。</p>
				<p>営業・設計・工務の各コーディネーターと総務が、ひとつのチームとなって、理想の住まいをかたちにします。</p>
				<p class="bh-about__links"><a class="bh-more" href="<?php echo esc_url( fort_url( 'staff' ) ); ?>">スタッフ紹介</a><a class="bh-more" href="<?php echo esc_url( fort_url( 'flow' ) ); ?>">家づくりの流れ</a></p>
			</div>
		</div>
	</section>

	<section class="bh-case__text bh-case__text--design">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">HOUSE<span>3つのつくり方</span></h2>
			<div class="bh-case__body">
				<ul class="bh-now__methods">
					<?php foreach ( fort_house_items() as $k => $it ) : $ext = 0 !== strpos( fort_url( $k ), home_url() ); ?>
					<li><a href="<?php echo esc_url( fort_url( $k ) ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><span class="bh-now__mname"><?php echo esc_html( $it['name'] ); ?></span><span class="bh-now__mtype"><?php echo esc_html( $it['method'] ); ?></span></a></li>
					<?php endforeach; ?>
				</ul>
				<p class="bh-about__links"><a class="bh-more bh-more--light" href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a></p>
			</div>
		</div>
	</section>

	<section class="bh-case__spec">
		<div class="bh-wrap bh-case__cols">
			<h2 class="bh-label">COMPANY<span>会社について</span></h2>
			<div>
				<dl class="bh-spec">
					<div><dt>会社名</dt><dd>株式会社FORT（フォート）</dd></div>
					<div><dt>設立</dt><dd>平成28年</dd></div>
					<div><dt>代表者</dt><dd>代表取締役　中村 亜樹</dd></div>
					<div><dt>事業内容</dt><dd>注文住宅・規格住宅・建売住宅の設計および施工 ほか</dd></div>
					<div><dt>対応エリア</dt><dd>岡山県全域（一部エリアはご相談ください）、福山市・尾道市・三原市</dd></div>
				</dl>
				<p class="bh-about__links"><a class="bh-more" href="<?php echo esc_url( fort_url( 'company' ) ); ?>">会社概要</a></p>
			</div>
		</div>
	</section>

	<section class="bh-place">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">PLACE</p><h2 class="bh-head__title"><span class="bh-nb">岡山と福山に、</span><span class="bh-nb">スタジオがあります。</span></h2></header>
			<div class="bh-place__grid">
				<?php foreach ( $studios as $key => $st ) : ?>
				<a class="bh-place__item" href="<?php echo esc_url( fort_url( $key ) ); ?>"><span class="bh-place__name"><?php echo esc_html( $st['en'] ); ?></span><span class="bh-place__ja"><?php echo esc_html( $st['name'] ); ?></span><span class="bh-place__tel"><?php echo esc_html( $st['tel'] ); ?></span></a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'about' ) ); ?>
<?php get_footer();
