<?php
/**
 * フロントページ（トップ） / ブランド導線（13セクション）
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
				<p class="philosophy__body" data-lines>
					性能だけを追い求めれば、家は高くなる。<br>
					デザインだけを追い求めれば、暮らしにくくなる。<br><br>
					FORTは、性能・デザイン・価格の<br>
					ちょうどいいバランスを考える。<br><br>
					家族が無理なく、長く豊かに暮らせること。<br>
					それが、FORTの家づくりです。
				</p>
			</div>
			<figure class="philosophy__figure" data-wipe>
				<img src="<?php echo esc_url( $img . 'niche.jpg' ); ?>" alt="FORTがつくる、ちょうどいい暮らし" loading="lazy" decoding="async">
			</figure>
		</div>
	</section>

	<!-- EVENT / 見学会・イベント（写真カード） -->
	<section class="event section section--gray" id="event">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>EVENT</p>
				<p class="section__desc" data-reveal>見学会・モデルハウス見学・無料相談会を、随時開催しています。</p>
			</header>
			<ul class="feature__grid hscroll" data-drag>
				<?php $ev = new WP_Query( array( 'post_type' => 'fort_event', 'posts_per_page' => 3 ) );
				if ( $ev->have_posts() ) : while ( $ev->have_posts() ) : $ev->the_post();
					$thumb = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'fort-card' ) : $img . 'exterior.jpg';
					$badge = fort_meta( 'fort_badge' ); ?>
				<li class="feature__card" data-reveal><a href="<?php the_permalink(); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $thumb ); ?>" alt="" loading="lazy"></figure><div class="feature__body"><?php if ( $badge ) : ?><span class="feature__tag"><?php echo esc_html( $badge ); ?></span><?php endif; ?><h3 class="feature__title"><?php the_title(); ?></h3></div></a></li>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'exterior.jpg' ); ?>" alt="完成見学会" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">完成見学会</span><h3 class="feature__title">完成・構造見学会</h3><p class="feature__text">実際の住まいで、FORTの性能とデザインを体感。</p></div></a></li>
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'ldk.jpg' ); ?>" alt="モデルハウス見学" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">モデルハウス</span><h3 class="feature__title">モデルハウス見学</h3><p class="feature__text">ご予約優先で、じっくりご覧いただけます。</p></div></a></li>
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'kitchen-view.jpg' ); ?>" alt="無料相談会" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">相談会</span><h3 class="feature__title">家づくり無料相談会</h3><p class="feature__text">資金計画や土地さがしも、お気軽にご相談ください。</p></div></a></li>
				<?php endif; ?>
			</ul>
			<p class="hscroll-note" aria-hidden="true">― 横にスクロール ―</p>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--outline">VIEW MORE</a></div>
		</div>
	</section>

	<!-- 03 PERFORMANCE -->
	<section class="performance section" id="performance">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>PERFORMANCE</p>
				<h2 class="section__title" data-reveal>数字で、信頼を。</h2>
				<p class="section__desc" data-reveal>見えない部分こそ、ていねいに。FORTの確かな住宅性能。</p>
			</header>
		</div>
		<div class="perf-marquee" data-reveal aria-label="FORTの性能数値">
			<div class="perf-marquee__track">
				<?php $perf = array(
					array('0.3','平均C値（気密）'), array('0.34<small>以下</small>','UA値（断熱）'),
					array('等級6','断熱等級'), array('等級3','耐震等級'),
					array('最長60<small>年</small>','保証（初期保証20年）'), array('10<small>年</small>','設備保証（※対象機器）'),
				);
				for ( $r = 0; $r < 2; $r++ ) { foreach ( $perf as $p ) {
					printf('<div class="perf-marquee__item"%s><span class="perf-marquee__v">%s</span><span class="perf-marquee__l">%s</span></div>',
						$r ? ' aria-hidden="true"' : '', $p[0], esc_html( $p[1] ));
				} } ?>
			</div>
		</div>
		<div class="container">
			<div class="section__more" data-reveal><a href="<?php echo esc_url( home_url( '/performance/' ) ); ?>" class="btn btn--outline">構造・性能を詳しく見る</a></div>
		</div>
	</section>

	<!-- 04 WORKS -->
	<section class="works section section--gray" id="works">
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

	<!-- FORT STORY / スクロールで言葉が切り替わる没入章 -->
	<section class="story" id="story" aria-label="FORTの家づくりの物語">
		<div class="story__sticky">
			<p class="story__label">FORT STORY</p>
			<div class="story__words">
				<div class="story__word is-active"><span class="story__en">DESIGN</span><span class="story__ja">デザインを、あきらめない。</span></div>
				<div class="story__word"><span class="story__en">PERFORMANCE</span><span class="story__ja">性能に、妥協しない。</span></div>
				<div class="story__word"><span class="story__en">BALANCE</span><span class="story__ja">だから、家族に“ちょうどいい”。</span></div>
			</div>
			<div class="story__progress"><span></span></div>
			<p class="story__hint" aria-hidden="true">SCROLL</p>
		</div>
	</section>

	<!-- 05 FORT FAMILY -->
	<section class="family section" id="family">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>FORT FAMILY</p>
				<h2 class="section__title" data-reveal>建てたあとの、しあわせまで。</h2>
				<p class="section__desc" data-reveal>FORTで家を建てたご家族の、暮らしの声をご紹介します。</p>
			</header>
			<ul class="family__grid hscroll" data-drag>
				<li class="family__card" data-reveal><figure class="family__figure"><img src="<?php echo esc_url( $img . 'family-01.jpg' ); ?>" alt="お客様の声 01" loading="lazy"></figure><div class="family__body"><p class="family__text">「チームで親身に向き合ってくれて、はじめての家づくりも安心でした。」</p><p class="family__name">倉敷市 ／ T様邸</p></div></li>
				<li class="family__card" data-reveal><figure class="family__figure"><img src="<?php echo esc_url( $img . 'family-02.jpg' ); ?>" alt="お客様の声 02" loading="lazy"></figure><div class="family__body"><p class="family__text">「性能もデザインも妥協せず、予算内で理想の住まいになりました。」</p><p class="family__name">岡山市 ／ K様邸</p></div></li>
				<li class="family__card" data-reveal><figure class="family__figure"><img src="<?php echo esc_url( $img . 'family-03.jpg' ); ?>" alt="お客様の声 03" loading="lazy"></figure><div class="family__body"><p class="family__text">「引渡し後も同じ顔ぶれで対応してくれるのが心強いです。」</p><p class="family__name">福山市 ／ M様邸</p></div></li>
			</ul>
			<p class="hscroll-note" aria-hidden="true">― 横にスクロール ―</p>
		</div>
	</section>

	<!-- 06 LINEUP -->
	<section class="lineup section section--gray" id="lineup">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>LINEUP</p><h2 class="section__title" data-reveal>あなたらしい家づくりを選ぶ。</h2></header>
			<div class="lineup-ed">
				<article class="lineup-ed__row" data-reveal>
					<figure class="lineup-ed__media" data-wipe><img src="<?php echo esc_url( $img . 'lineup-style.jpg' ); ?>" alt="FORT STYLE" loading="lazy"><span class="lineup-ed__tag">建売住宅</span></figure>
					<div class="lineup-ed__body">
						<span class="lineup-ed__no">01</span>
						<h3 class="lineup-ed__name">FORT STYLE</h3>
						<p class="lineup-ed__type">READY-MADE ／ 建売住宅</p>
						<p class="lineup-ed__text">土地・建物・外構まで含めて、わかりやすい価格設定。FORTらしいデザインと暮らしやすさを、すぐに住める形で。本体価格1,900万円〜（税別）。</p>
						<a href="https://www.fortstyle.org/" class="lineup-ed__link" target="_blank" rel="noopener">公式サイトを見る →</a>
					</div>
				</article>
				<article class="lineup-ed__row" data-reveal>
					<figure class="lineup-ed__media" data-wipe><img src="<?php echo esc_url( $img . 'pro/persp-b.jpg' ); ?>" alt="FORT PRO" loading="lazy"><span class="lineup-ed__tag">規格・セミオーダー</span></figure>
					<div class="lineup-ed__body">
						<span class="lineup-ed__no">02</span>
						<h3 class="lineup-ed__name">FORT PRO</h3>
						<p class="lineup-ed__type">SEMI-ORDER ／ 規格・セミオーダー住宅</p>
						<p class="lineup-ed__text">人気の間取りをベースに、自分たちらしくカスタマイズ。性能・デザイン・価格のバランスを重視した、FORTのスタンダード。PLAN A〜F からお選びいただけます。</p>
						<a href="<?php echo esc_url( home_url( '/fort-pro/' ) ); ?>" class="lineup-ed__link">PLAN A〜F を見る →</a>
					</div>
				</article>
				<article class="lineup-ed__row" data-reveal>
					<figure class="lineup-ed__media" data-wipe><img src="<?php echo esc_url( $img . 'lineup-design.jpg' ); ?>" alt="FORT DESIGN" loading="lazy"><span class="lineup-ed__tag">自由設計</span></figure>
					<div class="lineup-ed__body">
						<span class="lineup-ed__no">03</span>
						<h3 class="lineup-ed__name">FORT DESIGN</h3>
						<p class="lineup-ed__type">FULL-ORDER ／ 完全自由設計</p>
						<p class="lineup-ed__text">理想の暮らしをゼロから形にする、完全自由設計。土地条件やライフスタイルに合わせて、設計士と世界にひとつの住まいを描きます。</p>
						<a href="<?php echo esc_url( home_url( '/fort-design/' ) ); ?>" class="lineup-ed__link">FORT DESIGN の世界を見る →</a>
					</div>
				</article>
			</div>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( home_url( '/lineup/' ) ); ?>" class="btn btn--outline">商品ラインナップを詳しく見る</a></div>
		</div>
	</section>

	<!-- 07 FLOW -->
	<section class="flow section" id="flow">
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

	<!-- 08 STAFF -->
	<section class="staff section section--gray" id="staff">
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

	<!-- 09 STUDIO（モデルハウス） -->
	<section class="studio-teaser section" id="studio">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>STUDIO</p><h2 class="section__title" data-reveal>FORTの家づくりを体感する。</h2><p class="section__desc" data-reveal>素材に触れ、空気感を確かめる。実際の住まいでFORTを体感いただけます。</p></header>
			<ul class="feature__grid">
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'model-tamano.jpg' ); ?>" alt="岡山玉野モデルハウス" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">MODEL HOUSE</span><h3 class="feature__title">岡山玉野モデルハウス</h3><p class="feature__text">実際の住まいで、FORTの性能とデザインを体感いただけます。</p></div></a></li>
				<li class="feature__card" data-reveal><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="feature__link"><figure class="feature__figure"><img src="<?php echo esc_url( $img . 'model-shimokamo.jpg' ); ?>" alt="福山下加茂モデルハウス" loading="lazy"></figure><div class="feature__body"><span class="feature__tag">MODEL HOUSE</span><h3 class="feature__title">福山下加茂モデルハウス</h3><p class="feature__text">暮らしのサイズ感や心地よさを、その場で確かめられます。</p></div></a></li>
			</ul>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="btn btn--outline">モデルハウスを見る</a></div>
		</div>
	</section>

	<!-- 11 NEWS -->
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

	<!-- 13 CONTACT -->
	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" aria-hidden="true" loading="lazy" data-parallax="0.12" data-pscale="1.18"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>CONTACT</p>
			<h2 class="section__title section__title--light" data-reveal>家づくりのご相談、<br>モデルハウスの見学予約はこちらから。</h2>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--accent btn--block">ご来場予約</a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会・モデルハウス予約</a></li>
				<li><a href="<?php echo esc_url( home_url( '/request/' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--light btn--block">お問合せ</a></li>
			</ul>
			<p class="reserve__tel" data-reveal>お電話：<a href="tel:0862369600">086-236-9600</a>（岡山）／ <a href="tel:0849827404">084-982-7404</a>（福山）<span class="reserve__tel-note">（受付 9:00〜18:00 / 水曜定休）</span></p>
		</div>
	</section>

<?php get_footer(); ?>
