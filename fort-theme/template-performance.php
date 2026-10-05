<?php
/*
 * Template Name: 構造・性能
 * PERFORMANCE：性能も、暮らしに合わせて設計する。
 *   OUR POLICY → 考え方と最高基準の表 → 01 構造 → 02 制振 → 03 断熱 → 04 気密 → 05 窓 → 06 換気 → RANGE → 07 保証 → 来場予約
 * ・文言と数値は FORT 提供の原稿（2026.10）どおり
 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
/** 各章の頭に入る大きな写真 */
$band = function ( $no, $en, $title, $photo, $pos = '50% 50%' ) use ( $img ) { ?>
	<div class="pf-band" aria-hidden="true">
		<img src="<?php echo esc_url( $img . $photo ); ?>" alt="" loading="lazy" decoding="async" style="object-position:<?php echo esc_attr( $pos ); ?>">
		<p class="pf-band__txt"><span><?php echo esc_html( $no ); ?></span><b><?php echo esc_html( $en ); ?></b><?php echo esc_html( $title ); ?></p>
	</div>
<?php };
/** 写真を2〜3枚並べる帯 */
$strip = function ( $photos ) use ( $img ) { ?>
	<div class="pf-strip pf-strip--<?php echo count( $photos ); ?>" aria-hidden="true"><?php foreach ( $photos as $ph ) : ?><figure><img src="<?php echo esc_url( $img . $ph ); ?>" alt="" loading="lazy" decoding="async"></figure><?php endforeach; ?></div>
<?php };
/** 章 */
$chapter = function ( $id, $no, $en, $ja, $photo, $pos, $title, $body, $hl, $side, $alt = false ) use ( $band, $img ) { ?>
	<section class="pf-ch<?php echo $alt ? ' pf-ch--alt' : ''; ?>" id="<?php echo esc_attr( $id ); ?>">
		<?php $band( $no, $en, $ja, $photo, $pos ); ?>
		<div class="bh-wrap pf-ch__grid">
			<div class="pf-ch__text">
				<p class="pf-ch__no"><?php echo esc_html( $no . ' / ' . $en ); ?></p>
				<h2 class="pf-ch__title"><?php echo $title; ?></h2>
				<div class="pf-ch__body"><?php echo $body; ?></div>
				<?php if ( $hl ) : ?><div class="pf-hl"><?php foreach ( $hl as $h ) : ?><div class="pf-hl__item"><p class="pf-hl__label"><?php echo esc_html( $h[0] ); ?></p><p class="pf-hl__val"><?php echo $h[1]; ?></p></div><?php endforeach; ?></div><?php endif; ?>
			</div>
			<figure class="pf-ch__fig"><img src="<?php echo esc_url( $img . $side ); ?>" alt="" loading="lazy" decoding="async"></figure>
		</div>
	</section>
<?php };
$contents = array( 'structure' => '構造・耐震', 'damping' => '制振', 'insulation' => '断熱', 'airtight' => '気密', 'window' => '窓', 'ventilation' => '換気', 'support' => '保証・アフターサポート' );
$table = array(
	array( '耐震', '建物・間取り・予算に合わせて設計', '耐震等級3まで対応', 'structure' ),
	array( '構造計算', '必要に応じて選択', '許容応力度計算 対応', 'structure' ),
	array( '制振', '求める安心に合わせて選択', 'evoltz 対応', 'damping' ),
	array( '断熱', 'UA値0.46以下を基準に設計', 'UA値0.34以下まで対応', 'insulation' ),
	array( '気密', '<b>C値0.5以下</b>を基準', '現在の実測平均 C値0.2以下', 'airtight' ),
	array( '窓', '方角・開口・デザインに合わせて選定', 'APW430等まで対応', 'window' ),
	array( '換気', '暮らし・空調計画に合わせて選択', '第一種熱交換換気まで対応', 'ventilation' ),
);
$p = function ( $t ) { return '<p>' . implode( '</p><p>', array_map( function ( $x ) { return str_replace( "\n", '<br>', $x ); }, $t ) ) . '</p>'; };
?>
	<header class="pf-hero">
		<img class="pf-hero__img" src="<?php echo esc_url( $img . 'perf-interior.jpg' ); ?>" alt="" fetchpriority="high" decoding="async">
		<div class="pf-hero__txt">
			<p class="pf-hero__en">PERFORMANCE</p>
			<h1 class="pf-hero__title"><span class="bh-nb">性能も、</span><span class="bh-nb">暮らしに合わせて</span><span class="bh-nb">設計する。</span></h1>
		</div>
	</header>
	<div class="bh-wrap pf-crumb"><?php fort_breadcrumb( array( array( 'HOUSE', fort_url( 'house' ) ), array( 'PERFORMANCE', '' ) ) ); ?></div>

	<!-- OUR POLICY -->
	<section class="pf-pol">
		<div class="bh-wrap pf-pol__grid">
			<div class="pf-pol__text">
				<p class="bh-label">OUR POLICY</p>
				<p class="pf-pol__lead">性能は、高ければ高いほどいい。<br>FORTは、そうは考えていません。</p>
				<p>どこに建てるのか。<br>どんな間取りにするのか。<br>どれくらいの快適性や安心を求めるのか。<br>そして、家づくりにどこまで予算をかけるのか。</p>
				<p>その答えは、家族によって違います。</p>
				<p>だからFORTでは、ひとつの性能仕様をすべての家に当てはめるのではなく、<strong>暮らしと予算に合わせて、性能そのものを設計します。</strong></p>
				<p>そのうえで、FORTがどこまで性能を高められるのか。<br>私たちは、その「最高基準」も数字で明確にしています。</p>
			</div>
			<div class="pf-pol__figs">
				<figure><img src="<?php echo esc_url( $img . 'hero-3.jpg' ); ?>" alt="" loading="lazy" decoding="async"></figure>
				<figure><img src="<?php echo esc_url( $img . 'house-design.jpg' ); ?>" alt="" loading="lazy" decoding="async"></figure>
			</div>
		</div>
	</section>

	<!-- PERFORMANCE 表 -->
	<section class="pf-std" id="grade">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">PERFORMANCE</p>
				<h2 class="bh-head__title"><span class="bh-nb">基準を持って、</span><span class="bh-nb">その先は想いで選ぶ。</span></h2>
				<p class="bh-eq__lead">すべてを最高性能にすることが、すべての家族にとっての正解ではありません。<br>FORTでは、基本となる性能を持ちながら、構造・断熱・窓・換気・制振まで、一邸ごとに必要な性能を選択できます。</p>
			</header>
			<div class="pf-std__table" role="table" aria-label="FORTの考え方と最高基準・実績">
				<div class="pf-std__row pf-std__row--head" role="row"><span role="columnheader"></span><span role="columnheader">FORTの考え方</span><span role="columnheader">最高基準・実績</span></div>
				<?php foreach ( $table as $r ) : ?>
				<a class="pf-std__row" role="row" href="#<?php echo esc_attr( $r[3] ); ?>"><b role="rowheader"><?php echo esc_html( $r[0] ); ?></b><span role="cell" data-h="FORTの考え方"><?php echo wp_kses( $r[1], array( 'b' => array() ) ); ?></span><strong role="cell" data-h="最高基準・実績"><?php echo esc_html( $r[2] ); ?></strong></a>
				<?php endforeach; ?>
			</div>
			<nav class="pf-toc2" aria-label="このページの内容"><?php $i = 0; foreach ( $contents as $id => $name ) : $i++; ?><a href="#<?php echo esc_attr( $id ); ?>"><span><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span><?php echo esc_html( $name ); ?></a><?php endforeach; ?></nav>
		</div>
	</section>

	<?php
	$chapter( 'structure', '01', 'STRUCTURE', '構造・耐震', 'hero-2.jpg', '50% 40%',
		'<span class="bh-nb">地震への備えも、</span><span class="bh-nb">一つの答えに決めない。</span>',
		$p( array( '家の大きさや形、間取り、建築地、そして求める安心。', '条件が違えば、構造に対する考え方も変わります。', 'FORTでは、耐震性能についても一つの仕様に固定するのではなく、一邸ごとの条件に合わせて構造計画をご提案します。', 'より高い耐震性能を求める場合には<strong>耐震等級3</strong>まで対応。さらに、構造をより詳細に検証する<strong>許容応力度計算</strong>も選択できます。' ) ),
		array( array( '最高基準', '耐震等級3<small>＋ 許容応力度計算</small>' ) ), 'pro/persp-a.jpg' );
	$chapter( 'damping', '02', 'DAMPING', '制振', 'hero-5.jpg', '50% 50%',
		'<span class="bh-nb">強くするだけでなく、</span><span class="bh-nb">揺れを抑える。</span>',
		$p( array( '耐震は、建物そのものの強さを考えること。', 'そしてもう一つ、地震の揺れによって建物が受ける負担を抑えるという考え方があります。', 'FORTでは、希望に応じて木造住宅用制振装置<strong>evoltz［エヴォルツ］</strong>にも対応。', '耐震性能に制振という考え方を加えることで、繰り返す地震への備えをさらに高めることができます。' ) ),
		array( array( 'OPTION', '制振ダンパー<small>evoltz 対応</small>' ) ), 'house-pro.jpg', true );
	$strip( array( 'hero-1.jpg', 'pro/persp-c.jpg', 'studio-fukuyama.jpg' ) );
	$chapter( 'insulation', '03', 'INSULATION', '断熱', 'hero-3.jpg', '50% 55%',
		'UA値 0.46 <span class="pf-arrow">→</span> 0.34',
		$p( array( '断熱性能も、一つの数値だけをすべての家に求めることはしません。', '建築地、間取り、窓の大きさ、日射、空調計画。そして、どこまで室内環境に快適性を求めるのか。', 'それらを考えながら、その家に必要な断熱性能を設計します。', '数字だけを追うのではなく、その性能によって、暮らしがどう変わるのかまで考えます。' ) ),
		array( array( 'FORT BASE', 'UA値 0.46<small>以下</small>' ), array( 'HIGH PERFORMANCE', 'UA値 0.34<small>以下まで対応</small>' ) ), 'pro/persp-b.jpg' );
	$chapter( 'airtight', '04', 'AIRTIGHTNESS', '気密', 'hero-1.jpg', '50% 50%',
		'<span class="bh-nb">C値0.5以下。</span><span class="bh-nb">そして、実測平均0.2以下。</span>',
		$p( array( '気密性能は、カタログ上の性能ではありません。', 'どれだけ丁寧に施工されたかによって変わる、住宅そのものの施工品質です。', 'FORTでは<strong>C値0.5以下</strong>を気密性能の基準としています。そして現在の施工実績では、<strong>実測平均 C値0.2以下</strong>を確保しています。', '設計上の数値だけではなく、実際の建物で測定する。数字で施工品質を確認することも、FORTの性能への考え方です。' ) ),
		array( array( 'FORT BASE', 'C値 0.5<small>以下</small>' ), array( '実測平均', 'C値 0.2<small>以下</small>' ) ), 'studio-okayama.jpg', true );
	$strip( array( 'mh-fukuyama-shimokamo.jpg', 'hero-4.jpg' ) );
	$chapter( 'window', '05', 'WINDOW', '窓', 'hero-4.jpg', '50% 50%',
		'<span class="bh-nb">景色も、デザインも、</span><span class="bh-nb">断熱も。</span>',
		$p( array( '窓は、断熱性能だけで決めるものではありません。', 'どこから光を入れるのか。どんな景色を切り取るのか。どれくらい大きな窓をつくりたいのか。', 'FORTでは、断熱性能とデザインの両方を考えながら、一邸ごとに窓を選定します。', '性能のために窓を小さくするのではなく、デザインと性能のバランスを設計します。' ) ),
		array( array( 'PERFORMANCE RANGE', 'APW330等 <span class="pf-arrow">→</span> APW430等<small>まで対応</small>' ) ), 'pro/persp-d.jpg' );
	$chapter( 'ventilation', '06', 'VENTILATION', '換気', 'hero-5.jpg', '50% 40%',
		'<span class="bh-nb">換気も、</span><span class="bh-nb">暮らしに合わせて選ぶ。</span>',
		$p( array( '換気方式についても、一つの設備をすべての住宅に固定するのではなく、', '断熱性能、気密性能、空調計画、暮らし方、ご予算を踏まえてご提案します。', 'より高い省エネルギー性や室内環境を求める場合には、<strong>第一種熱交換換気</strong>にも対応します。' ) ),
		array( array( '最高基準', '第一種<small>熱交換換気</small>' ) ), 'pro/persp-e.jpg', true );
	?>

	<!-- FORT PERFORMANCE RANGE -->
	<section class="pf-range">
		<img class="pf-range__bg" src="<?php echo esc_url( $img . 'hero-2.jpg' ); ?>" alt="" loading="lazy" decoding="async">
		<div class="bh-wrap pf-range__in">
			<p class="pf-range__label">FORT PERFORMANCE RANGE</p>
			<h2 class="pf-range__title">どこまで求めるかも、家づくり。</h2>
			<ul class="pf-range__list">
				<li>耐震等級3</li><li>許容応力度計算</li><li>制振ダンパー evoltz</li><li>UA値 0.34以下</li><li>実測平均 C値 0.2以下</li><li>APW430等</li><li>第一種熱交換換気</li>
			</ul>
			<div class="pf-range__text">
				<p>FORTには、ここまで性能を高められる選択肢があります。<br>でも、それをすべての家に必要だとは考えていません。</p>
				<p>家づくりに使える予算には限りがあります。</p>
				<p>性能にかける予算。<br>デザインにかける予算。<br>家具や外構にかける予算。<br>そして、建てた後の暮らしに残す予算。</p>
				<p>その全部を見ながら、<br>その家族にとって本当に必要な性能を一緒に考える。</p>
			</div>
		</div>
	</section>
	<section class="pf-close">
		<div class="bh-wrap">
			<p class="pf-close__title"><span class="bh-nb">性能を選ぶのではなく、</span><span class="bh-nb">性能まで設計する。</span></p>
			<p class="pf-close__sub">それが、FORTの家づくりです。</p>
		</div>
		<?php $strip( array( 'house-design.jpg', 'hero-1.jpg', 'pro/persp-f.jpg' ) ); ?>
	</section>

	<!-- 07 保証 -->
	<section class="pf-sec" id="support">
		<?php $band( '07', 'SUPPORT', '保証・アフターサポート', 'studio-okayama.jpg', '50% 60%' ); ?>
		<div class="bh-wrap pf-sec__grid">
			<header class="pf-sec__head"><span class="pf-sec__no">07</span><h2>保証・アフターサポート</h2><p class="pf-sec__catch">建てたあとも、ずっと安心を。</p></header>
			<div class="pf-sec__body">
				<div class="pf-point"><p class="pf-point__label">POINT</p><p class="pf-point__main">躯体・防水は最長60年。</p><p class="pf-point__sub">初期保証20年。当社指定の定期点検・メンテナンスを条件に、最長60年まで保証します。</p></div>
				<p>大切な住まいに、長く安心して暮らしていただくために、充実した保証制度とアフターサポート体制を整えています。構造・防水から地盤・白蟻・設備の保証、定期点検まで、ずっと寄り添います。</p>
				<figure class="pf-fig">
					<svg viewBox="0 0 560 236" role="img" aria-label="保証期間：躯体・防水 初期20年（延長で最長60年）、地盤補強20年、白蟻10年、設備10年">
						<g class="pf-fig__scale"><text x="148" y="18">0</text><text x="268" y="18">20</text><text x="391" y="18">40</text><text x="505" y="18">60年</text>
						<line x1="153" y1="26" x2="153" y2="222"/><line x1="276" y1="26" x2="276" y2="222"/><line x1="399" y1="26" x2="399" y2="222"/><line x1="522" y1="26" x2="522" y2="222"/></g>
						<g class="pf-fig__bar"><text x="0" y="60" class="pf-fig__s">躯体・防水</text><rect x="153" y="40" width="123" height="30"/><rect x="276" y="40" width="246" height="30" class="is-dash"/><text x="290" y="60" class="pf-fig__s">延長で最長60年</text></g>
						<g class="pf-fig__bar"><text x="0" y="106" class="pf-fig__s">地盤補強</text><rect x="153" y="86" width="123" height="30"/></g>
						<g class="pf-fig__bar"><text x="0" y="152" class="pf-fig__s">白蟻</text><rect x="153" y="132" width="61.5" height="30"/></g>
						<g class="pf-fig__bar"><text x="0" y="198" class="pf-fig__s">設備</text><rect x="153" y="178" width="61.5" height="30"/></g>
					</svg>
				</figure>
				<ul class="pf-warranty">
					<li><span>躯体・防水</span><b>初期保証 20年</b><small>最長60年まで保証</small></li>
					<li><span>地盤補強</span><b>保証 20年</b><small>鋼管杭工法による保証</small></li>
					<li><span>白蟻</span><b>保証 10年</b><small>基礎パッキン工法 10年保証＋シロアリ防除施工 5年保証</small></li>
					<li><span>設備（対象機器）</span><b>保証 10年</b><small>住宅設備機器を保証</small></li>
				</ul>
				<p class="pf-fine">※ 躯体・防水の保証は、当社指定の定期点検・メンテナンスを実施いただくことが条件となります。※ 地盤補強の保証は、当社が採用する鋼管杭工法の地盤補強工事に対する保証です。※ 白蟻の保証は、基礎パッキン工法（10年）およびシロアリ防除施工（5年）の保証です。※ 設備保証の対象機器・保証内容の詳細は、スタッフまでお問い合わせください。</p>
				<p class="pf-sub">アフターメンテナンス（定期点検）</p>
				<ol class="pf-timeline"><li><span class="pf-timeline__no">01</span><b>1<small>年</small></b><span>点検</span></li><li><span class="pf-timeline__no">02</span><b>2<small>年</small></b><span>点検</span></li><li><span class="pf-timeline__no">03</span><b>5<small>年</small></b><span>点検</span></li><li><span class="pf-timeline__no">04</span><b>9<small>年</small>6<small>ヵ月</small></b><span>点検</span></li></ol>
				<div class="pf-note"><p class="pf-note__title">迅速な対応で、いつでもサポート</p><p>万が一のトラブルやお困りごとにも、専任スタッフが迅速に対応します。ご相談はお電話・LINEなど、いつでもお気軽にご連絡ください。</p></div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'performance', 'photo' => $img . 'perf-interior.jpg', 'title' => '数字の先にある心地よさを、<br>体感してください。' ) ); ?>
<?php get_footer(); ?>
