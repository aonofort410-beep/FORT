<?php
/*
 * Template Name: 構造・性能
 * PERFORMANCE STANDARD（FORTの資料「PERFORMANCE STANDARD」01〜05 にもとづく）
 *   グレード比較 → 01 耐震 → 02 断熱 → 03 気密 → 04 換気 → 05 保証・アフターサポート → 来場予約
 * ・数値は inc/house.php の fort_performance_grades() と、このファイル内の文言のみ
 */
get_header();
$img      = get_template_directory_uri() . '/assets/images/';
$contents = array( 'seismic' => '耐震性能', 'insulation' => '断熱性能', 'airtight' => '気密性能', 'ventilation' => '換気性能', 'support' => '保証・アフターサポート' );
?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'HOUSE', fort_url( 'house' ) ), array( 'PERFORMANCE', '' ) ) ); ?>
			<p class="bh-label">PERFORMANCE STANDARD</p>
			<h1 class="bh-pagehead__title"><span class="bh-nb">見えない性能が、</span><span class="bh-nb">これからの暮らしを支える。</span></h1>
		</div>
	</header>

	<section class="pf-intro">
		<div class="bh-wrap pf-intro__grid">
			<figure class="pf-intro__fig"><img src="<?php echo esc_url( $img . 'perf-interior.jpg' ); ?>" alt="大きな窓から光が入るFORTの住まいのリビング" width="938" height="1224" fetchpriority="high" decoding="async"></figure>
			<div class="pf-intro__body">
				<p>耐震性・断熱性・気密性・換気性能。<br>住まいの基本性能を高い基準で確保することで、快適で安心して暮らせる住まいをつくります。<br>FORTが大切にしている、見えない部分のこだわりです。</p>
				<nav class="pf-toc" aria-label="このページの内容">
					<p class="bh-label">CONTENTS</p>
					<ol>
						<?php $i = 0; foreach ( $contents as $id => $name ) : $i++; ?>
						<li><a href="#<?php echo esc_attr( $id ); ?>"><span><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span><?php echo esc_html( $name ); ?></a></li>
						<?php endforeach; ?>
					</ol>
				</nav>
			</div>
		</div>
	</section>

	<!-- 性能グレード -->
	<section class="pf-grade" id="grade">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">GRADE</p>
				<h2 class="bh-head__title"><span class="bh-nb">性能を選ぶのではない。</span><span class="bh-nb">暮らし方を選ぶ。</span></h2>
				<p class="bh-eq__lead">2つの性能グレードをご用意し、ライフスタイルやご予算に合わせてお選びいただけます。</p>
			</header>
			<div class="bh-cmp__scroll" tabindex="0" role="region" aria-label="性能グレードの比較（横にスクロールできます）">
				<table class="pf-table">
					<thead><tr><th scope="col"><span class="sr-only">項目</span></th>
						<th scope="col">STANDARD<small>基本性能をしっかり確保した、安心のスタンダードグレード</small></th>
						<th scope="col" class="is-plus">PLUS<small>さらに快適・安心を追求した、上位グレード</small></th></tr></thead>
					<tbody>
						<?php foreach ( fort_performance_grades() as $r ) : ?>
						<tr><th scope="row"><?php echo esc_html( $r[0] ); ?></th><td><?php echo fort_br( $r[1] ); ?></td><td class="is-plus"><?php echo fort_br( $r[2] ); ?></td></tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<p class="bh-eq__note">FORT STYLE（規格住宅）の仕様は、<a href="<?php echo esc_url( fort_url( 'house' ) ); ?>#equipment">設備グレード比較表</a>をご覧ください。プランや仕様により採用内容が異なる場合があります。</p>
		</div>
	</section>

	<!-- 01 耐震 -->
	<section class="pf-sec" id="seismic">
		<div class="bh-wrap pf-sec__grid">
			<header class="pf-sec__head"><span class="pf-sec__no">01</span><h2>耐震性能</h2><p class="pf-sec__catch">大切な家族を守る、確かな強さを。</p></header>
			<div class="pf-sec__body">
				<p>FORTでは、デザインだけではなく、万が一の地震に備えた構造の強さも大切にしています。PRO・DESIGNシリーズでは全棟、耐震等級3×許容応力度計算を採用。さらにPLUS仕様では、制振ダンパーを採用しています。</p>
				<dl class="pf-items">
					<div><dt>耐震等級3<small>住宅性能の最高等級</small></dt><dd>想定される地震力の1.5倍に対して、倒壊・崩壊しない程度の強さ。</dd></div>
					<div><dt>許容応力度計算<small>全棟実施</small></dt><dd>一棟ごとに構造の安全性を計算し、見えない安心まで確認します。</dd></div>
					<div><dt>制振ダンパー<small>PLUS仕様に採用</small></dt><dd>地震の揺れを吸収し、建物への負担を軽減します。</dd></div>
				</dl>
			</div>
		</div>
	</section>

	<!-- 02 断熱 -->
	<section class="pf-sec pf-sec--alt" id="insulation">
		<div class="bh-wrap pf-sec__grid">
			<header class="pf-sec__head"><span class="pf-sec__no">02</span><h2>断熱性能</h2><p class="pf-sec__catch">夏は涼しく、冬は暖かい。快適が続く住まいを。</p></header>
			<div class="pf-sec__body">
				<p>FORTは、外の暑さや寒さの影響を受けにくい、高い断熱性能を備えています。一年を通して、快適に過ごしやすい住まいを目指します。</p>
				<dl class="pf-items">
					<div><dt>断熱等級6<small>高い断熱性能</small></dt><dd>夏の暑さ・冬の寒さを室内に伝えにくく、快適に過ごしやすい性能です。</dd></div>
					<div><dt>UA値<small>熱の逃げにくさを表す数値</small></dt><dd>数値が小さいほど断熱性能が高くなります。STANDARD 0.46以下／PLUS 0.34以下。</dd></div>
					<div><dt>窓の断熱性能<small>窓からの熱の出入りを抑える</small></dt><dd>窓の性能を高めることで、より快適な室内環境につながります。STANDARD APW330（樹脂サッシ／ペアガラス）／PLUS APW430（樹脂サッシ／トリプルガラス）。</dd></div>
				</dl>
				<div class="pf-duo">
					<div><p class="pf-duo__label">STANDARD</p><p class="pf-duo__num">UA 0.46<small>以下</small></p><p>高い断熱性能を標準に。</p></div>
					<div class="is-plus"><p class="pf-duo__label">PLUS</p><p class="pf-duo__num">UA 0.34<small>以下</small></p><p>さらに熱を逃がしにくい、ワンランク上の断熱仕様。</p></div>
				</div>
			</div>
		</div>
	</section>

	<!-- 03 気密 -->
	<section class="pf-sec" id="airtight">
		<div class="bh-wrap pf-sec__grid">
			<header class="pf-sec__head"><span class="pf-sec__no">03</span><h2>気密性能</h2><p class="pf-sec__catch">家のすき間まで、性能として考える。</p></header>
			<div class="pf-sec__body">
				<p>断熱材を厚くするだけでは、快適な家にはなりません。わずかなすき間から外気が入り、室内の空気が逃げてしまいます。FORTでは、完成した住宅の気密性能をC値で確認。設計上の性能だけでなく、実際に建てた家の施工精度まで数値で確かめます。</p>
				<div class="pf-duo">
					<div><p class="pf-duo__label">STANDARD</p><p class="pf-duo__num">C 0.5<small>以下</small></p><p>高気密・全棟実測</p></div>
					<div class="is-plus"><p class="pf-duo__label">PLUS</p><p class="pf-duo__num">C 0.2<small>以下</small></p><p>さらに高気密・全棟実測</p></div>
				</div>
				<div class="pf-note"><p class="pf-note__title">C値とは？</p><p>住宅全体に、どれくらい「すき間」があるかを表す数値。単位は cm²/m²。数値が小さいほど気密性能が高い住宅です。</p></div>
				<ol class="pf-merits">
					<li><b>冷暖房した空気を逃がしにくい</b>すき間からの漏気を抑えることで、外気の影響を受けにくくなります。</li>
					<li><b>計画した換気を機能させやすい</b>給気・排気を計画したルートで行いやすくなります。</li>
					<li><b>断熱性能を活かす</b>すき間から空気が出入りすれば、高性能な断熱材の効果を十分に活かせません。</li>
					<li><b>壁の中への湿気の侵入を抑える</b>気密化は、壁体内結露を抑える観点でも重要です。</li>
				</ol>
				<div class="pf-note"><p class="pf-note__title">測るから、分かる。</p><p>気密性能は、材料のスペックだけで決まるものではなく、窓まわり・配管・配線・壁や床の取り合いなど、現場の施工精度によっても変わります。だからFORTでは、専用機器を使用して気密性能を測定。完成した住まいの性能をC値として確認します。</p></div>
			</div>
		</div>
	</section>

	<!-- 04 換気 -->
	<section class="pf-sec pf-sec--alt" id="ventilation">
		<div class="bh-wrap pf-sec__grid">
			<header class="pf-sec__head"><span class="pf-sec__no">04</span><h2>換気性能</h2><p class="pf-sec__catch">きれいな空気を、24時間つづける。</p></header>
			<div class="pf-sec__body">
				<p>住まいの快適さは、断熱や気密だけでは完成しません。FORTでは、24時間換気（熱交換）を採用し、室内の空気をきれいな状態へ保ちます。汚れた空気を屋外へ出しながら、新鮮な空気を取り込み、できるだけ室内の温度に近づけて届けます。一年を通して、快適で心地よい室内環境を支えます。</p>
				<dl class="pf-items">
					<div><dt>対象グレード</dt><dd>STANDARD・PLUS</dd></div>
					<div><dt>換気方式</dt><dd>第一種換気（熱交換）</dd></div>
				</dl>
				<div class="pf-note"><p class="pf-note__title">24時間換気（熱交換）とは？</p><p>外の新鮮な空気を取り込みながら、室内の汚れた空気を排出します。熱をできるだけ逃がしにくくする仕組みです。</p></div>
				<ol class="pf-merits">
					<li><b>冷暖房効率を保ちやすい</b>室内の温度をできるだけ保ちながら換気できます。</li>
					<li><b>きれいな空気を保ちやすい</b>汚れた空気を外へ出し、新鮮な空気を取り込みます。</li>
					<li><b>計画換気がしやすい</b>必要な換気を安定して行いやすくなります。</li>
					<li><b>一年中快適</b>夏も冬も、心地よい室内環境を支えます。</li>
				</ol>
				<div class="pf-note"><p class="pf-note__title">FORTの考え方</p><p>どちらが優れているかではなく、快適な暮らしを支える換気性能を標準化。FORTでは、STANDARD・PLUSともに第一種換気（熱交換）を採用しています。</p></div>
			</div>
		</div>
	</section>

	<!-- 05 保証 -->
	<section class="pf-sec" id="support">
		<div class="bh-wrap pf-sec__grid">
			<header class="pf-sec__head"><span class="pf-sec__no">05</span><h2>保証・アフターサポート</h2><p class="pf-sec__catch">建てたあとも、ずっと安心を。</p></header>
			<div class="pf-sec__body">
				<p>大切な住まいに、長く安心して暮らしていただくために、充実した保証制度とアフターサポート体制を整えています。構造・防水から地盤・白蟻・設備の保証、定期点検まで、ずっと寄り添います。</p>
				<ul class="pf-warranty">
					<li><span>躯体・防水</span><b>初期保証 20年</b><small>最長60年まで保証</small></li>
					<li><span>地盤補強</span><b>保証 20年</b><small>鋼管杭工法による保証</small></li>
					<li><span>白蟻</span><b>保証 10年</b><small>基礎パッキン工法 10年保証＋シロアリ防除施工 5年保証</small></li>
					<li><span>設備（対象機器）</span><b>保証 10年</b><small>住宅設備機器を保証</small></li>
				</ul>
				<p class="pf-fine">※ 躯体・防水の保証は、当社指定の定期点検・メンテナンスを実施いただくことが条件となります。※ 地盤補強の保証は、当社が採用する鋼管杭工法の地盤補強工事に対する保証です。※ 白蟻の保証は、基礎パッキン工法（10年）およびシロアリ防除施工（5年）の保証です。※ 設備保証の対象機器・保証内容の詳細は、スタッフまでお問い合わせください。</p>
				<p class="pf-sub">アフターメンテナンス（定期点検）</p>
				<ol class="pf-timeline"><li>1年点検</li><li>2年点検</li><li>5年点検</li><li>9年6ヵ月点検</li></ol>
				<div class="pf-note"><p class="pf-note__title">迅速な対応で、いつでもサポート</p><p>万が一のトラブルやお困りごとにも、専任スタッフが迅速に対応します。ご相談はお電話・LINEなど、いつでもお気軽にご連絡ください。</p></div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'performance', 'photo' => $img . 'perf-interior.jpg', 'title' => '数字の先にある心地よさを、<br>体感してください。' ) ); ?>
<?php get_footer(); ?>
