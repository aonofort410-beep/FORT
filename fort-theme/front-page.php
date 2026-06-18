<?php
/**
 * フロントページ（トップ） / 13セクション構成
 * ・ヘッダーのコピー等は「外観 > カスタマイズ」
 * ・WORKS / EVENT / NEWS は投稿（管理画面）から自動表示
 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>

	<!-- 01 HOME / 動画ヒーロー＋FORTロゴ -->
	<section class="hero hero--logo" id="hero">
		<div class="hero__media">
			<video class="hero__img" autoplay muted loop playsinline poster="<?php echo esc_url( $img . 'hero.jpg' ); ?>">
				<source src="<?php echo esc_url( $img . 'hero.mp4' ); ?>" type="video/mp4">
			</video>
			<div class="hero__overlay"></div>
		</div>
		<div class="hero__logobox" data-reveal>
			<h1 class="hero__logo">
				<img class="hero__logo-img" src="<?php echo esc_url( $img . 'logo-white.png' ); ?>" alt="FORT" data-fallback="1" onerror="this.remove()">
				<span class="hero__logo-text" aria-hidden="true">FORT</span>
				<span class="sr-only"><?php bloginfo( 'name' ); ?>｜岡山・福山の注文住宅</span>
			</h1>
		</div>
		<div class="hero__actions hero__actions--br" data-reveal>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="btn btn--light">施工事例を見る</a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent">見学会を予約する</a>
		</div>
		<p class="hero__note" data-reveal>
			性能だけでもない。<br>
			デザインだけでもない。<br>
			その<strong>ちょうど真ん中</strong>に、FORTがある。
			<span class="hero__note-en">Design × Performance × Balance</span>
		</p>
		<a href="#philosophy" class="hero__scroll" aria-label="下へスクロール"><span class="hero__scroll-line"></span><span class="hero__scroll-text">SCROLL</span></a>
	</section>

	<!-- 02 FORT PHILOSOPHY -->
	<section class="philosophy section" id="philosophy">
		<div class="container philosophy__inner">
			<div class="philosophy__text" data-reveal>
				<p class="section__label">FORT PHILOSOPHY</p>
				<h2 class="philosophy__title">家族に、ちょうどいい家を。</h2>
				<p class="philosophy__body">
					性能だけを追い求めれば、家は高くなる。<br>
					デザインだけを追い求めれば、暮らしにくくなる。<br><br>
					FORTは、性能・デザイン・価格の<br>
					ちょうどいいバランスを考える。<br><br>
					家族が無理なく、長く豊かに暮らせること。<br>
					それが、FORTの家づくりです。
				</p>
			</div>
			<figure class="philosophy__figure" data-reveal>
				<img src="<?php echo esc_url( $img . 'niche.jpg' ); ?>" alt="FORTがつくる、ちょうどいい暮らし" loading="lazy" decoding="async">
			</figure>
		</div>
	</section>

	<!-- 03 PERFORMANCE -->
	<section class="performance section section--gray" id="performance">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>PERFORMANCE</p>
				<h2 class="section__title" data-reveal>数字で、信頼を。</h2>
				<p class="section__desc" data-reveal>見えない部分こそ、ていねいに。FORTの確かな住宅性能。</p>
			</header>
			<ul class="perf-highlight" data-reveal>
				<li><p class="ph-value">0.3</p><p class="ph-label">平均 C値（気密）</p></li>
				<li><p class="ph-value">0.34<small>以下</small></p><p class="ph-label">UA値（断熱）</p></li>
				<li><p class="ph-value">等級6</p><p class="ph-label">断熱等級</p></li>
				<li><p class="ph-value">等級3</p><p class="ph-label">耐震等級</p></li>
				<li><p class="ph-value">最長60<small>年</small></p><p class="ph-label">保証（初期保証20年）</p></li>
			</ul>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( home_url( '/performance/' ) ); ?>" class="btn btn--outline">構造・性能を詳しく見る</a></div>
		</div>
	</section>

	<!-- 04 WORKS / 施工事例（スライダー・投稿から自動） -->
	<section class="works section" id="works">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>WORKS</p>
				<h2 class="section__title" data-reveal>暮らしが見える施工事例</h2>
				<p class="section__desc" data-reveal>写真をタップすると、事例の詳細をご覧いただけます。</p>
			</header>
		</div>
		<?php $ws = get_posts( array( 'post_type' => 'works', 'posts_per_page' => 8 ) ); if ( $ws ) :
			$render = function( $hide ) use ( $ws, $img ) {
				foreach ( $ws as $p ) {
					$area = get_post_meta( $p->ID, 'fort_area', true );
					$thumb = has_post_thumbnail( $p ) ? get_the_post_thumbnail_url( $p, 'fort-card' ) : $img . 'exterior.jpg';
					printf('<a class="works-slide" href="%s"%s><img src="%s" alt="%s" loading="lazy"><span class="works-slide__cap">%s%s</span></a>',
						esc_url( get_permalink( $p ) ), $hide ? ' aria-hidden="true" tabindex="-1"' : '', esc_url( $thumb ),
						$hide ? '' : esc_attr( get_the_title( $p ) ),
						$area ? '<span class="works-slide__cat">' . esc_html( $area ) . '</span>' : '', esc_html( get_the_title( $p ) ));
				}
			}; ?>
		<div class="works-slider" data-reveal aria-label="施工事例スライド"><div class="works-slider__track"><?php $render( false ); $render( true ); ?></div></div>
		<?php else : ?>
		<div class="container"><p style="text-align:center;color:var(--t-sub);">施工事例は管理画面「施工事例 &gt; 新規追加」から登録できます。</p></div>
		<?php endif; ?>
		<div class="container"><div class="section__more" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="btn btn--outline">もっと施工事例を見る</a></div></div>
	</section>

	<!-- 05 FORT FAMILY / お客様の声 -->
	<section class="family section section--gray" id="family">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>FORT FAMILY</p>
				<h2 class="section__title" data-reveal>建てたあとの、しあわせまで。</h2>
				<p class="section__desc" data-reveal>FORTで家を建てたご家族の、暮らしの声をご紹介します。</p>
			</header>
			<ul class="family__grid">
				<li class="family__card" data-reveal><figure class="family__figure"><img src="<?php echo esc_url( $img . 'family-01.jpg' ); ?>" alt="お客様の声 01" loading="lazy"></figure><div class="family__body"><p class="family__text">「チームで親身に向き合ってくれて、はじめての家づくりも安心でした。」</p><p class="family__name">倉敷市 ／ T様邸</p></div></li>
				<li class="family__card" data-reveal><figure class="family__figure"><img src="<?php echo esc_url( $img . 'family-02.jpg' ); ?>" alt="お客様の声 02" loading="lazy"></figure><div class="family__body"><p class="family__text">「性能もデザインも妥協せず、予算内で理想の住まいになりました。」</p><p class="family__name">岡山市 ／ K様邸</p></div></li>
				<li class="family__card" data-reveal><figure class="family__figure"><img src="<?php echo esc_url( $img . 'family-03.jpg' ); ?>" alt="お客様の声 03" loading="lazy"></figure><div class="family__body"><p class="family__text">「引渡し後も同じ顔ぶれで対応してくれるのが心強いです。」</p><p class="family__name">福山市 ／ M様邸</p></div></li>
			</ul>
		</div>
	</section>

	<!-- 06 LINEUP -->
	<section class="lineup section" id="lineup">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>LINEUP</p><h2 class="section__title" data-reveal>あなたらしい家づくりを選ぶ。</h2></header>
			<ul class="lineup__grid">
				<li class="lineup__card" data-reveal><figure class="lineup__figure"><img src="<?php echo esc_url( $img . 'lineup-style.jpg' ); ?>" alt="FORT STYLE" loading="lazy"></figure><div class="lineup__body"><h3 class="lineup__name">FORT STYLE</h3><p class="lineup__type">建売住宅</p><p class="lineup__text">土地・建物・外構まで、わかりやすい価格設定の住まい。</p><a href="https://www.fortstyle.org/" class="lineup__link" target="_blank" rel="noopener">公式サイトを見る</a></div></li>
				<li class="lineup__card lineup__card--featured" data-reveal><figure class="lineup__figure"><img src="<?php echo esc_url( $img . 'pro/persp-b.jpg' ); ?>" alt="FORT PRO" loading="lazy"></figure><div class="lineup__body"><h3 class="lineup__name">FORT PRO</h3><p class="lineup__type">規格・セミオーダー住宅</p><p class="lineup__text">人気の間取りをベースに、自分たちらしくカスタマイズ。</p><a href="<?php echo esc_url( home_url( '/fort-pro/' ) ); ?>" class="lineup__link">PLAN A〜F を見る</a></div></li>
				<li class="lineup__card" data-reveal><figure class="lineup__figure"><img src="<?php echo esc_url( $img . 'lineup-design.jpg' ); ?>" alt="FORT DESIGN" loading="lazy"></figure><div class="lineup__body"><h3 class="lineup__name">FORT DESIGN</h3><p class="lineup__type">自由設計</p><p class="lineup__text">理想の暮らしをゼロから形にする、完全自由設計。</p><a href="<?php echo esc_url( home_url( '/lineup/' ) ); ?>" class="lineup__link">詳しく見る</a></div></li>
			</ul>
		</div>
	</section>

	<!-- 07 FLOW -->
	<section class="flow section section--gray" id="flow">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>FLOW</p><h2 class="section__title" data-reveal>家づくりの流れ</h2><p class="section__desc" data-reveal>はじめての方もご安心ください。ご相談からお引渡しまで。</p></header>
			<ol class="flow__list">
				<li class="flow__step" data-reveal><span class="flow__num">01</span><div class="flow__body"><h3 class="flow__title">ご相談・ご来場</h3><p class="flow__text">暮らしのご希望やご予算をお聞かせください。</p></div></li>
				<li class="flow__step" data-reveal><span class="flow__num">02</span><div class="flow__body"><h3 class="flow__title">プランご提案・お見積り</h3><p class="flow__text">ご要望をかたちにしたプランをご提示します。</p></div></li>
				<li class="flow__step" data-reveal><span class="flow__num">03</span><div class="flow__body"><h3 class="flow__title">ご契約・詳細打ち合わせ</h3><p class="flow__text">仕様や色決めなど、細部まで一緒に決めます。</p></div></li>
				<li class="flow__step" data-reveal><span class="flow__num">04</span><div class="flow__body"><h3 class="flow__title">着工・お引渡し・アフター</h3><p class="flow__text">完成後も定期点検で長く安心を。</p></div></li>
			</ol>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( home_url( '/flow/' ) ); ?>" class="btn btn--outline">家づくりの流れを詳しく見る</a></div>
		</div>
	</section>

	<!-- 08 STAFF（チームを一部表示） -->
	<section class="staff section" id="staff">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>STAFF</p><h2 class="section__title" data-reveal>チームで、家づくりを支える。</h2><p class="section__desc" data-reveal>営業・設計・工務。一人ではなく、ひとつのチームで。</p></header>
			<ul class="staff__grid">
				<li class="staff__card" data-reveal><figure class="staff__figure"><img src="<?php echo esc_url( $img . 'staff-sales.jpg' ); ?>" alt="営業"></figure><h3 class="staff__role">営業</h3><p class="staff__text">想いとご予算に寄り添い、家づくりの入口を支えます。</p></li>
				<li class="staff__card" data-reveal><figure class="staff__figure"><img src="<?php echo esc_url( $img . 'staff-design.jpg' ); ?>" alt="設計"></figure><h3 class="staff__role">設計</h3><p class="staff__text">暮らしやすさとデザインを両立したプランを描きます。</p></li>
				<li class="staff__card" data-reveal><figure class="staff__figure"><img src="<?php echo esc_url( $img . 'staff-engineering.jpg' ); ?>" alt="工務"></figure><h3 class="staff__role">工務</h3><p class="staff__text">確かな施工管理で、理想を現実の住まいへ。</p></li>
			</ul>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'staff' ) ); ?>" class="btn btn--outline">スタッフ一覧を見る</a></div>
		</div>
	</section>

	<!-- 09 STUDIO -->
	<section class="studio-teaser section section--gray" id="studio">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>STUDIO</p><h2 class="section__title" data-reveal>FORTの家づくりを体感する。</h2><p class="section__desc" data-reveal>素材に触れ、空気感を確かめる。FORTの世界観を体験できる場所です。</p></header>
			<ul class="feature__grid">
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'studio-okayama.jpg' ); ?>" alt="岡山スタジオ" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">STUDIO</span><h3 class="feature__title">岡山スタジオ</h3><p class="feature__text">岡山市北区問屋町。家づくりのご相談はこちらへ。</p></div></a></li>
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'studio-fukuyama.jpg' ); ?>" alt="福山スタジオ" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">STUDIO</span><h3 class="feature__title">福山スタジオ</h3><p class="feature__text">広島県福山市東川口町。福山エリアの拠点です。</p></div></a></li>
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'ldk.jpg' ); ?>" alt="モデルハウス" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">MODEL HOUSE</span><h3 class="feature__title">モデルハウス</h3><p class="feature__text">玉野ほか。実際の住まいでFORTを体感いただけます。</p></div></a></li>
			</ul>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="btn btn--outline">スタジオ・モデルハウスを見る</a></div>
		</div>
	</section>

	<!-- 10 EVENT（投稿から自動） -->
	<section class="event section" id="event">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>EVENT</p><h2 class="section__title" data-reveal>見学会・イベント</h2></header>
			<div class="schedule" data-reveal>
				<?php $ev = new WP_Query( array( 'post_type' => 'fort_event', 'posts_per_page' => 4 ) );
				if ( $ev->have_posts() ) : while ( $ev->have_posts() ) : $ev->the_post(); ?>
				<div class="schedule__item"><div class="schedule__meta"><?php if ( fort_meta('fort_date') ) : ?><span class="schedule__date"><?php echo esc_html( fort_meta('fort_date') ); ?></span><?php endif; if ( fort_meta('fort_badge') ) : ?><span class="schedule__badge"><?php echo esc_html( fort_meta('fort_badge') ); ?></span><?php endif; if ( fort_meta('fort_place') ) : ?><span class="schedule__place"><?php echo esc_html( fort_meta('fort_place') ); ?></span><?php endif; ?></div><p class="schedule__title"><?php the_title(); ?></p></div>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<div class="schedule__item"><p class="schedule__title">イベントは管理画面「イベント &gt; 新規追加」から登録できます。</p></div>
				<?php endif; ?>
			</div>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--outline">イベント一覧・ご予約へ</a></div>
		</div>
	</section>

	<!-- 11 NEWS（投稿から自動） -->
	<section class="news section section--gray" id="news">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>NEWS</p><h2 class="section__title" data-reveal>お知らせ</h2></header>
			<ul class="news__list" data-reveal>
				<?php $nq = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 4 ) );
				if ( $nq->have_posts() ) : while ( $nq->have_posts() ) : $nq->the_post(); $cats = get_the_category(); $cat = $cats ? $cats[0]->name : 'お知らせ'; ?>
				<li class="news__item"><a href="<?php the_permalink(); ?>" class="news__link"><time class="news__date"><?php echo esc_html( get_the_date() ); ?></time><span class="news__tag"><?php echo esc_html( $cat ); ?></span><span class="news__title"><?php the_title(); ?></span></a></li>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<li class="news__item"><span class="news__title">お知らせは管理画面「お知らせ &gt; 新規追加」から投稿できます。</span></li>
				<?php endif; ?>
			</ul>
		</div>
	</section>

	<!-- 12 COMPANY -->
	<section class="company section" id="company">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>COMPANY</p><h2 class="section__title" data-reveal>会社概要</h2></header>
			<dl class="case-spec" data-reveal>
				<div><dt>会社名</dt><dd>株式会社FORT（フォート）</dd></div>
				<div><dt>設立</dt><dd>平成28年</dd></div>
				<div><dt>事業内容</dt><dd>注文住宅・規格住宅・建売住宅の設計および施工 ほか</dd></div>
				<div><dt>対応エリア</dt><dd>岡山市・倉敷市・福山市およびその周辺</dd></div>
				<div><dt>所在地</dt><dd>岡山スタジオ／福山スタジオ</dd></div>
				<div><dt>登録</dt><dd>2級建築士事務所 岡山県知事登録 第6548号</dd></div>
			</dl>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( home_url( '/company/' ) ); ?>" class="btn btn--outline">会社概要を詳しく見る</a></div>
		</div>
	</section>

	<!-- 13 CONTACT -->
	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" aria-hidden="true" loading="lazy"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>CONTACT</p>
			<h2 class="section__title section__title--light" data-reveal>家づくりのご相談、<br>モデルハウスの見学予約はこちらから。</h2>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会・来場予約</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
			</ul>
			<p class="reserve__tel" data-reveal>お電話：<a href="tel:0862369600">086-236-9600</a>（岡山）／ <a href="tel:0849827404">084-982-7404</a>（福山）<span class="reserve__tel-note">（受付 9:00〜18:00 / 水曜定休）</span></p>
		</div>
	</section>

<?php get_footer(); ?>
