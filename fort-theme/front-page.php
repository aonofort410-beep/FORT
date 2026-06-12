<?php
/**
 * フロントページ（トップ）
 * ・ヘッダーのコピーは「外観 > カスタマイズ」で編集
 * ・WORKS / EVENT / NEWS は投稿（管理画面で追加）から自動表示
 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>

	<!-- ===== HERO ===== -->
	<section class="hero" id="hero">
		<div class="hero__media">
			<img class="hero__img" src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="FORTが手がける住まい" loading="eager" decoding="async">
			<div class="hero__overlay"></div>
		</div>
		<div class="hero__inner container">
			<p class="hero__eyebrow" data-reveal><?php echo esc_html( fort_opt( 'fort_hero_eyebrow', 'FORT｜岡山・倉敷・福山の家づくり' ) ); ?></p>
			<h1 class="hero__title" data-reveal>
				<?php echo esc_html( fort_opt( 'fort_hero_line1', '性能か、デザインか。' ) ); ?><br>
				<span class="hero__title-accent"><?php echo esc_html( fort_opt( 'fort_hero_accent', 'その選択をしなくていい' ) ); ?></span><?php echo esc_html( fort_opt( 'fort_hero_line2', '家づくり。' ) ); ?>
			</h1>
			<p class="hero__lead" data-reveal><?php echo esc_html( fort_opt( 'fort_hero_lead', '営業・設計・工務がひとつのチームとなり、性能とデザインを高いレベルで両立する住まいをご提案します。' ) ); ?></p>
			<div class="hero__actions" data-reveal>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="btn btn--light">施工事例を見る</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent">見学会を予約する</a>
			</div>
		</div>
		<a href="#concept" class="hero__scroll" aria-label="下へスクロール">
			<span class="hero__scroll-line"></span><span class="hero__scroll-text">SCROLL</span>
		</a>
	</section>

	<!-- ===== CONCEPT ===== -->
	<section class="concept section" id="concept">
		<div class="container concept__inner">
			<p class="section__label" data-reveal>CONCEPT</p>
			<h2 class="section__title" data-reveal>暮らしをデザインする。</h2>
			<p class="concept__text" data-reveal>
				FORTがつくるのは、単なる建物ではありません。<br>
				家族の時間、趣味の時間、友人との時間。<br>
				その先にある暮らしをデザインします。
			</p>
		</div>
		<figure class="concept__figure" data-reveal>
			<img src="<?php echo esc_url( $img . 'niche.jpg' ); ?>" alt="FORTの住まいで過ごす家族の暮らし" loading="lazy" decoding="async">
		</figure>
	</section>

	<!-- ===== WHY FORT ===== -->
	<section class="why section section--gray" id="why">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>WHY FORT</p>
				<h2 class="section__title" data-reveal>FORTが選ばれる理由</h2>
			</header>
			<ul class="why__grid">
				<li class="why__card" data-reveal><span class="why__num">01</span><h3 class="why__card-title">性能とデザインの両立</h3><p class="why__card-text">耐震・断熱などの住宅性能と、洗練されたデザイン。どちらかを諦めるのではなく、両方を高いレベルで実現します。</p></li>
				<li class="why__card" data-reveal><span class="why__num">02</span><h3 class="why__card-title">営業・設計・工務のチーム体制</h3><p class="why__card-text">担当者まかせにせず、各分野のプロがチームで連携。安心して家づくりを進められる体制を整えています。</p></li>
				<li class="why__card" data-reveal><span class="why__num">03</span><h3 class="why__card-title">手の届く価格で実現</h3><p class="why__card-text">ムダを省いた家づくりで、デザインと性能を手の届く価格に。予算に合わせたご提案が可能です。</p></li>
				<li class="why__card" data-reveal><span class="why__num">04</span><h3 class="why__card-title">建てた後も続く安心</h3><p class="why__card-text">お引渡しはゴールではなくスタート。定期点検やアフターサポートで、長く安心して暮らせます。</p></li>
			</ul>
		</div>
	</section>

	<!-- ===== WORKS（施工事例：投稿から自動表示） ===== -->
	<section class="works section" id="works">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>WORKS</p>
				<h2 class="section__title" data-reveal>暮らしが見える施工事例</h2>
			</header>
			<ul class="works__grid">
				<?php
				$works = new WP_Query( array( 'post_type' => 'works', 'posts_per_page' => 6 ) );
				if ( $works->have_posts() ) :
					while ( $works->have_posts() ) : $works->the_post();
						$area  = fort_meta( 'fort_area' );
						$price = fort_meta( 'fort_price' );
				?>
				<li class="works__card" data-reveal>
					<a href="<?php the_permalink(); ?>" class="works__link">
						<figure class="works__figure">
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'fort-card', array( 'loading' => 'lazy' ) ); } else { echo '<img src="' . esc_url( $img . 'exterior.jpg' ) . '" alt="">'; } ?>
						</figure>
						<div class="works__body">
							<?php if ( $area ) : ?><p class="works__cat"><?php echo esc_html( $area ); ?></p><?php endif; ?>
							<h3 class="works__card-title"><?php the_title(); ?></h3>
							<?php if ( $price ) : ?><p class="works__price">建物本体<strong><?php echo esc_html( $price ); ?></strong><span class="works__price-note">※参考価格帯</span></p><?php endif; ?>
						</div>
					</a>
				</li>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<li class="works__card"><div class="works__body"><p class="works__cat">準備中</p><h3 class="works__card-title">施工事例は管理画面「施工事例 &gt; 新規追加」から登録できます。</h3></div></li>
				<?php endif; ?>
			</ul>
			<div class="section__more" data-reveal>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="btn btn--outline">もっと施工事例を見る</a>
			</div>
		</div>
	</section>

	<!-- ===== FEATURE（特集） ===== -->
	<section class="feature section section--gray" id="feature">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>FEATURE</p>
				<h2 class="section__title" data-reveal>特集</h2>
				<p class="section__desc" data-reveal>テーマで深掘りする、FORTの家づくり。</p>
			</header>
			<ul class="feature__grid">
				<?php
				$features = array(
					array( '平屋という選択', 'ワンフロアで完結する、ゆるやかにつながる暮らし。', 'exterior.jpg' ),
					array( '中庭のある暮らし', '街の視線を気にせず、光と風を取り込む住まい。', 'hero.jpg' ),
					array( '土地さがしから一緒に', '建物の視点から、暮らしに合う土地をご提案。', 'kitchen-view.jpg' ),
				);
				$i = 1;
				foreach ( $features as $f ) : ?>
				<li class="feature__card" data-reveal>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="feature__link">
						<figure class="feature__figure"><img src="<?php echo esc_url( $img . $f[2] ); ?>" alt="<?php echo esc_attr( $f[0] ); ?>" loading="lazy"></figure>
						<div class="feature__body">
							<span class="feature__tag">FEATURE 0<?php echo $i; ?></span>
							<h3 class="feature__title"><?php echo esc_html( $f[0] ); ?></h3>
							<p class="feature__text"><?php echo esc_html( $f[1] ); ?></p>
						</div>
					</a>
				</li>
				<?php $i++; endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- ===== LINEUP ===== -->
	<section class="lineup section" id="lineup">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>LINEUP</p><h2 class="section__title" data-reveal>あなたらしい家づくりを選ぶ。</h2></header>
			<ul class="lineup__grid">
				<li class="lineup__card" data-reveal>
					<figure class="lineup__figure"><img src="<?php echo esc_url( $img . 'lineup-style.jpg' ); ?>" alt="FORT STYLE" loading="lazy"></figure>
					<div class="lineup__body"><h3 class="lineup__name">FORT STYLE</h3><p class="lineup__type">建売住宅</p><p class="lineup__text">土地・建物・外構まで含めて、わかりやすい価格設定の住まい。</p><a href="https://www.fortstyle.org/" class="lineup__link" target="_blank" rel="noopener">公式サイトを見る</a></div>
				</li>
				<li class="lineup__card lineup__card--featured" data-reveal>
					<span class="lineup__badge">STANDARD</span>
					<figure class="lineup__figure"><img src="<?php echo esc_url( $img . 'pro/persp-b.jpg' ); ?>" alt="FORT PRO" loading="lazy"></figure>
					<div class="lineup__body"><h3 class="lineup__name">FORT PRO</h3><p class="lineup__type">規格・セミオーダー住宅</p><p class="lineup__text">人気の間取りをベースに、自分たちらしくカスタマイズ。</p><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="lineup__link">相談する</a></div>
				</li>
				<li class="lineup__card" data-reveal>
					<figure class="lineup__figure"><img src="<?php echo esc_url( $img . 'lineup-design.jpg' ); ?>" alt="FORT DESIGN" loading="lazy"></figure>
					<div class="lineup__body"><h3 class="lineup__name">FORT DESIGN</h3><p class="lineup__type">自由設計</p><p class="lineup__text">理想の暮らしをゼロから形にする、完全自由設計の住まい。</p><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="lineup__link">相談する</a></div>
				</li>
			</ul>
		</div>
	</section>

	<!-- ===== PERFORMANCE ===== -->
	<section class="performance section section--gray" id="performance">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>PERFORMANCE</p>
				<h2 class="section__title" data-reveal>構造・性能</h2>
				<p class="section__desc" data-reveal>見えない部分こそ、ていねいに。SMART／STANDARD／PLUS／BLACKの4つの性能グレードをご用意しています。</p>
			</header>
			<ul class="why__grid">
				<li class="why__card" data-reveal><span class="why__num">01</span><h3 class="why__card-title">高い断熱性能</h3><p class="why__card-text">UA値 0.56〜0.34以下。夏は涼しく冬はあたたかい、一年中心地よい室内環境へ。</p></li>
				<li class="why__card" data-reveal><span class="why__num">02</span><h3 class="why__card-title">すきまの少ない高気密</h3><p class="why__card-text">C値 1.0〜0.3以下。全棟、第三者機関による気密測定を実施します。</p></li>
				<li class="why__card" data-reveal><span class="why__num">03</span><h3 class="why__card-title">耐震へのこだわり</h3><p class="why__card-text">耐震等級3が基本。PLUS以上は許容応力度計算・設計性能評価を取得します。</p></li>
				<li class="why__card" data-reveal><span class="why__num">04</span><h3 class="why__card-title">計画換気・空調</h3><p class="why__card-text">第三種換気〜第一種熱交換換気「Air save」まで。空気の質まで考えた住まいへ。</p></li>
			</ul>
		</div>
	</section>

	<!-- ===== FLOW ===== -->
	<section class="flow section" id="flow">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>FLOW</p><h2 class="section__title" data-reveal>家づくりの流れ</h2><p class="section__desc" data-reveal>はじめての方もご安心ください。ご相談からお引渡し、その後まで伴走します。</p></header>
			<ol class="flow__list">
				<?php
				$steps = array(
					array( 'ご相談・ご来場', '見学会やスタジオで、暮らしのご希望やご予算をお聞かせください。' ),
					array( 'プランご提案・お見積り', 'ご要望をかたちにしたプランと、わかりやすいお見積りをご提示します。' ),
					array( 'ご契約', '内容にご納得いただいたうえで、ご契約。ここから本格的に進みます。' ),
					array( '詳細打ち合わせ', '間取り・仕様・色決めなど、細部まで一緒に決めていきます。' ),
					array( '着工・施工', '地鎮祭・上棟を経て施工へ。現場の状況も随時ご報告します。' ),
					array( '完成・お引渡し', '完成検査のうえお引渡し。新しい暮らしのはじまりです。' ),
					array( 'アフターサポート', '定期点検やメンテナンスで、住みはじめてからも長く安心を。' ),
				);
				$n = 1;
				foreach ( $steps as $s ) : ?>
				<li class="flow__step" data-reveal><span class="flow__num"><?php echo sprintf( '%02d', $n ); ?></span><div class="flow__body"><h3 class="flow__title"><?php echo esc_html( $s[0] ); ?></h3><p class="flow__text"><?php echo esc_html( $s[1] ); ?></p></div></li>
				<?php $n++; endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- ===== EVENT（投稿から自動表示） ===== -->
	<section class="event section section--gray" id="event">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>EVENT</p><h2 class="section__title" data-reveal>見学会・イベント</h2></header>
			<div class="schedule" data-reveal>
				<?php
				$ev = new WP_Query( array( 'post_type' => 'fort_event', 'posts_per_page' => 4 ) );
				if ( $ev->have_posts() ) :
					while ( $ev->have_posts() ) : $ev->the_post(); ?>
				<div class="schedule__item">
					<div class="schedule__meta">
						<?php if ( fort_meta( 'fort_date' ) ) : ?><span class="schedule__date"><?php echo esc_html( fort_meta( 'fort_date' ) ); ?></span><?php endif; ?>
						<?php if ( fort_meta( 'fort_badge' ) ) : ?><span class="schedule__badge"><?php echo esc_html( fort_meta( 'fort_badge' ) ); ?></span><?php endif; ?>
						<?php if ( fort_meta( 'fort_place' ) ) : ?><span class="schedule__place"><?php echo esc_html( fort_meta( 'fort_place' ) ); ?></span><?php endif; ?>
					</div>
					<p class="schedule__title"><?php the_title(); ?></p>
				</div>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<div class="schedule__item"><p class="schedule__title">イベントは管理画面「イベント &gt; 新規追加」から登録できます。</p></div>
				<?php endif; ?>
			</div>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--outline">イベント一覧へ</a></div>
		</div>
	</section>

	<!-- ===== VOICE / FORT FAMILY ===== -->
	<section class="family section" id="family">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>FORT FAMILY</p><h2 class="section__title" data-reveal>建てた後も続くご縁。</h2><p class="section__desc" data-reveal>お引渡しは、おつきあいのはじまり。FORTで建てたご家族の声。</p></header>
			<ul class="family__grid">
				<?php for ( $k = 1; $k <= 3; $k++ ) : ?>
				<li class="family__card" data-reveal>
					<figure class="family__figure"><img src="<?php echo esc_url( $img . 'family-0' . $k . '.jpg' ); ?>" alt="お客様 0<?php echo $k; ?>" loading="lazy"></figure>
					<div class="family__body"><p class="family__text">「チームで親身に向き合ってくれて、安心して家づくりができました。」</p><p class="family__name">FORTで建てたご家族</p></div>
				</li>
				<?php endfor; ?>
			</ul>
		</div>
	</section>

	<!-- ===== STAFF（部門イメージ／一覧へ） ===== -->
	<section class="staff section section--gray" id="staff">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>STAFF</p><h2 class="section__title" data-reveal>チームでつくる家づくり。</h2><p class="section__desc" data-reveal>営業・設計・工務。それぞれのコーディネーターがひとつのチームとなり、最初から最後まで支えます。</p></header>
			<ul class="staff__grid">
				<li class="staff__card" data-reveal><figure class="staff__figure"><img src="<?php echo esc_url( $img . 'staff-sales.jpg' ); ?>" alt="営業"></figure><h3 class="staff__role">営業</h3><p class="staff__text">コンサルティングコーディネーター。家づくりの入口をサポートします。</p></li>
				<li class="staff__card" data-reveal><figure class="staff__figure"><img src="<?php echo esc_url( $img . 'staff-design.jpg' ); ?>" alt="設計"></figure><h3 class="staff__role">設計</h3><p class="staff__text">デザインコーディネーター。あなただけのプランを描きます。</p></li>
				<li class="staff__card" data-reveal><figure class="staff__figure"><img src="<?php echo esc_url( $img . 'staff-engineering.jpg' ); ?>" alt="工務"></figure><h3 class="staff__role">工務</h3><p class="staff__text">エンジニアリングコーディネーター。理想を確かな住まいへ。</p></li>
			</ul>
			<div class="section__more" data-reveal><a href="<?php echo esc_url( get_post_type_archive_link( 'staff' ) ); ?>" class="btn btn--outline">スタッフ紹介を見る</a></div>
		</div>
	</section>

	<!-- ===== NEWS（投稿から自動表示） ===== -->
	<section class="news section" id="news">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>NEWS</p><h2 class="section__title" data-reveal>お知らせ</h2></header>
			<ul class="news__list" data-reveal>
				<?php
				$news = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 5 ) );
				if ( $news->have_posts() ) :
					while ( $news->have_posts() ) : $news->the_post();
						$cats = get_the_category();
						$cat  = $cats ? $cats[0]->name : 'お知らせ';
				?>
				<li class="news__item">
					<a href="<?php the_permalink(); ?>" class="news__link">
						<time class="news__date"><?php echo esc_html( get_the_date() ); ?></time>
						<span class="news__tag"><?php echo esc_html( $cat ); ?></span>
						<span class="news__title"><?php the_title(); ?></span>
					</a>
				</li>
				<?php endwhile; wp_reset_postdata(); else : ?>
				<li class="news__item"><span class="news__title">お知らせは管理画面「お知らせ &gt; 新規追加」から投稿できます。</span></li>
				<?php endif; ?>
			</ul>
		</div>
	</section>

	<!-- ===== RESERVE / CONTACT ===== -->
	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" aria-hidden="true" loading="lazy"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
			<h2 class="section__title section__title--light" data-reveal>まずはお気軽にご相談ください。</h2>
			<p class="reserve__lead" data-reveal>家づくりのこと、土地のこと、予算のこと。どんな小さなことでもお気軽に。</p>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
				<li><a href="#" class="btn btn--light btn--block">資料請求</a></li>
				<li><a href="#" class="btn btn--light btn--block">お問い合わせ</a></li>
			</ul>
			<p class="reserve__tel" data-reveal>お電話：<a href="tel:<?php echo esc_attr( str_replace( '-', '', fort_opt( 'fort_tel_okayama', '086-236-9600' ) ) ); ?>"><?php echo esc_html( fort_opt( 'fort_tel_okayama', '086-236-9600' ) ); ?></a>（岡山）／ <a href="tel:<?php echo esc_attr( str_replace( '-', '', fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) ) ); ?>"><?php echo esc_html( fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) ); ?></a>（福山）<span class="reserve__tel-note">（受付 9:00〜18:00 / 水曜定休）</span></p>
		</div>
	</section>

<?php get_footer(); ?>
