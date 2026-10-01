<?php
/**
 * フロントページ（HOME）
 * ------------------------------------------------------------
 * 写真で惹かれ、考え方で納得し、実物を見たくなる。
 *   01 HERO / 02 ABOUT / 03 SELECTED WORKS / 04 LIFE WITH FORT
 *   05 HOUSE / 06 JOURNAL / 07 MOVIE / 08 EVENT / 09 PLACE / 10 VISIT
 * ・素材（投稿・写真・動画）が無いセクションは表示しません（仮の内容は出さない）
 * ・WORKS / EVENT / JOURNAL は管理画面の投稿から、MOVIE はカスタマイザーから自動表示
 */
get_header();
$img   = get_template_directory_uri() . '/assets/images/';
$tel_o = fort_opt( 'fort_tel_okayama', '086-236-9600' );
$tel_f = fort_opt( 'fort_tel_fukuyama', '084-982-7404' );
$has_video = file_exists( get_template_directory() . '/assets/images/hero.mp4' );
?>

	<!-- 01 HERO：施工写真1枚で成立させる（動画があれば動画） -->
	<section class="bh-hero" aria-label="FORT">
		<div class="bh-hero__media">
			<?php if ( $has_video ) : ?>
			<video class="bh-hero__img" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( $img . 'hero.jpg' ); ?>">
				<source src="<?php echo esc_url( $img . 'hero.mp4' ); ?>" type="video/mp4">
			</video>
			<?php else : ?>
			<img class="bh-hero__img" src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" width="2400" height="1600" fetchpriority="high" decoding="async">
			<?php endif; ?>
		</div>
		<!-- 公式ロゴが、じわっと浮かび上がる -->
		<div class="bh-hero__logo">
			<h1>
				<img src="<?php echo esc_url( $img . 'logo-white.png' ); ?>" alt="FORT 建築設計 OKAYAMA・FUKUYAMA" width="1600" height="350" fetchpriority="high" decoding="async">
				<span class="sr-only"><?php bloginfo( 'name' ); ?>｜岡山・福山の注文住宅</span>
			</h1>
		</div>
		<!-- 左下に控えめに -->
		<p class="bh-hero__note">
			<span class="bh-hero__note-en"><?php echo esc_html( fort_opt( 'fort_hero_copy', FORT_HERO_COPY ) ); ?></span>
			<span class="bh-hero__note-ja"><?php echo esc_html( fort_opt( 'fort_hero_sub', FORT_HERO_SUB ) ); ?></span>
		</p>
		<p class="bh-hero__links">
			<a href="<?php echo esc_url( fort_url( 'works' ) ); ?>">WORKS</a>
			<a href="<?php echo esc_url( fort_url( 'event' ) ); ?>">EVENT</a>
		</p>
	</section>

	<!-- 02 ABOUT：FORTとは何か -->
	<section class="bh-about" id="about">
		<div class="bh-wrap bh-about__grid">
			<p class="bh-label">ABOUT</p>
			<div class="bh-about__body">
				<h2 class="bh-about__title"><span class="bh-nb">性能か、デザインか。</span><span class="bh-nb">その間にある、</span><span class="bh-nb">ちょうどいい家。</span></h2>
				<p>FORTは、岡山と福山で住まいを設計し、建てている会社です。</p>
				<p>性能だけを追えば、家は高くなる。デザインだけを追えば、暮らしにくくなる。営業・設計・工務がひとつのチームになり、家族が無理なく長く暮らせるバランスを、一棟ずつ探しています。</p>
				<a class="bh-more" href="<?php echo esc_url( fort_url( 'about' ) ); ?>">FORTについて</a>
			</div>
		</div>
	</section>

	<?php
	/* 03 SELECTED WORKS：写真のある施工事例だけを誌面レイアウトで */
	$works = get_posts( array( 'post_type' => 'works', 'posts_per_page' => 5, 'meta_key' => '_thumbnail_id' ) );
	if ( 4 === count( $works ) ) $works = array_slice( $works, 0, 3 ); // 誌面が崩れない数（1・2・3・5件）にそろえる
	if ( $works ) : ?>
	<section class="bh-works" id="works">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">SELECTED WORKS</p>
				<a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">すべての施工事例</a>
			</header>
			<div class="bh-works__grid bh-works__grid--<?php echo count( $works ); ?>">
				<?php foreach ( $works as $i => $p ) :
					$area = get_post_meta( $p->ID, 'fort_area', true ); ?>
				<a class="bh-work<?php echo 0 === $i ? ' bh-work--main' : ''; ?>" href="<?php echo esc_url( get_permalink( $p ) ); ?>">
					<figure class="bh-work__fig"><?php echo get_the_post_thumbnail( $p, 0 === $i ? 'fort-hero' : 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => esc_attr( get_the_title( $p ) ) ) ); ?></figure>
					<p class="bh-work__cap"><span class="bh-work__title"><?php echo esc_html( get_the_title( $p ) ); ?></span><?php if ( $area ) : ?><span class="bh-work__meta"><?php echo esc_html( $area ); ?></span><?php endif; ?></p>
				</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php /* 04 LIFE WITH FORT：暮らしの写真がそろうまで非表示（架空の画像は使わない） */ ?>

	<!-- 05 HOUSE：グレードではなく、家づくりの方法の違い -->
	<section class="bh-house" id="house">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">HOUSE</p>
				<h2 class="bh-head__title"><span class="bh-nb">家のつくり方を、</span><span class="bh-nb">3つから。</span></h2>
			</header>
			<div class="bh-house__grid">
				<?php
				$houses = array(
					array( 'design', 'FORT DESIGN', '自由設計', '土地と暮らしを読み解き、ゼロから設計する。間取りも素材も、その家族のためだけに。' ),
					array( 'pro', 'FORT PRO', '規格住宅', 'PLAN A〜F の6つのプランをもとに、内装や設備を選んで自分たちらしく仕上げる。' ),
					array( 'style', 'FORT STYLE', '完成した住まい', '土地・建物・外構までそろった、FORTの建売住宅。実物を見て選び、すぐに暮らしはじめられる。' ),
				);
				foreach ( $houses as $h ) :
					$ext = 0 !== strpos( fort_url( $h[0] ), home_url() ); ?>
				<a class="bh-house__item" href="<?php echo esc_url( fort_url( $h[0] ) ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>>
					<figure class="bh-house__fig"><img src="<?php echo esc_url( fort_media( $h[0] ) ); ?>" alt="<?php echo esc_attr( $h[1] ); ?>の住まい" loading="lazy" decoding="async" width="1200" height="1500"></figure>
					<p class="bh-house__method"><?php echo esc_html( $h[2] ); ?></p>
					<h3 class="bh-house__name"><?php echo esc_html( $h[1] ); ?></h3>
					<p class="bh-house__text"><?php echo esc_html( $h[3] ); ?></p>
				</a>
				<?php endforeach; ?>
			</div>
			<ul class="bh-house__common">
				<li><a href="<?php echo esc_url( fort_url( 'house' ) ); ?>">3つを比べる</a></li>
				<li><a href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a></li>
				<li><a href="<?php echo esc_url( fort_url( 'flow' ) ); ?>">家づくりの流れ</a></li>
			</ul>
		</div>
	</section>

	<?php
	/* 06 JOURNAL：記事があるときだけ */
	$journal = post_type_exists( 'journal' ) ? get_posts( array( 'post_type' => 'journal', 'posts_per_page' => 3 ) ) : array();
	if ( $journal ) : ?>
	<section class="bh-journal" id="journal">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">JOURNAL</p>
				<a class="bh-more" href="<?php echo esc_url( fort_url( 'journal' ) ); ?>">すべての記事</a>
			</header>
			<ul class="bh-journal__list">
				<?php foreach ( $journal as $p ) : $terms = get_the_terms( $p, 'journal_cat' ); ?>
				<li><a class="bh-journal__item" href="<?php echo esc_url( get_permalink( $p ) ); ?>">
					<?php if ( has_post_thumbnail( $p ) ) : ?><figure class="bh-journal__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?></figure><?php endif; ?>
					<p class="bh-journal__meta"><?php echo $terms && ! is_wp_error( $terms ) ? esc_html( $terms[0]->name ) . ' — ' : ''; ?><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $p ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d', $p ) ); ?></time></p>
					<h3 class="bh-journal__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
				</a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>

	<?php
	/* 07 MOVIE：YouTube はクリックするまで読み込まない */
	$movies = fort_movies();
	if ( $movies ) : ?>
	<section class="bh-movie" id="movie">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">MOVIE</p>
				<?php if ( fort_opt( 'fort_youtube_channel', FORT_YOUTUBE ) ) : ?><a class="bh-more" href="<?php echo esc_url( fort_opt( 'fort_youtube_channel', FORT_YOUTUBE ) ); ?>" target="_blank" rel="noopener">YouTube</a><?php endif; ?>
			</header>
			<div class="bh-movie__grid bh-movie__grid--<?php echo count( $movies ); ?>">
				<?php foreach ( $movies as $m ) : ?>
				<figure class="bh-movie__item"><?php fort_youtube_lite( $m['id'], $m['title'] ); ?><?php if ( $m['title'] ) : ?><figcaption><?php echo esc_html( $m['title'] ); ?></figcaption><?php endif; ?></figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- 08 EVENT：岡山 / 福山。期間限定と常設を分けて表示 -->
	<?php get_template_part( 'parts/event-list', null, array( 'limit' => 6, 'heading' => true ) ); ?>

	<!-- 09 PLACE：活動している地域 -->
	<section class="bh-place" id="place">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">PLACE</p>
				<h2 class="bh-head__title"><span class="bh-nb">岡山と福山に、</span><span class="bh-nb">スタジオがあります。</span></h2>
			</header>
			<div class="bh-place__grid">
				<a class="bh-place__item" href="<?php echo esc_url( fort_url( 'okayama' ) ); ?>">
					<span class="bh-place__name">OKAYAMA</span>
					<span class="bh-place__ja">岡山スタジオ</span>
					<span class="bh-place__tel"><?php echo esc_html( $tel_o ); ?></span>
				</a>
				<a class="bh-place__item" href="<?php echo esc_url( fort_url( 'fukuyama' ) ); ?>">
					<span class="bh-place__name">FUKUYAMA</span>
					<span class="bh-place__ja">福山スタジオ</span>
					<span class="bh-place__tel"><?php echo esc_html( $tel_f ); ?></span>
				</a>
			</div>
		</div>
	</section>

	<!-- 10 VISIT：どちらへ行くかを選んで、見学・相談へ -->
	<section class="bh-visit" id="visit">
		<div class="bh-visit__media"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" width="2400" height="1600" loading="lazy" decoding="async"></div>
		<div class="bh-wrap bh-visit__inner">
			<p class="bh-label">VISIT</p>
			<h2 class="bh-visit__title">写真の続きは、<br>実物で。</h2>
			<p class="bh-visit__text">素材の手ざわり、光の入り方、天井の高さ。スタジオや見学会で、実際の住まいを確かめてください。</p>
			<div class="bh-visit__choices">
				<a class="bh-visit__choice" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'okayama' ) ) ); ?>" data-track="cta_click" data-track-label="home_visit_okayama"><span>岡山で見る</span><small>OKAYAMA</small></a>
				<a class="bh-visit__choice" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'fukuyama' ) ) ); ?>" data-track="cta_click" data-track-label="home_visit_fukuyama"><span>福山で見る</span><small>FUKUYAMA</small></a>
			</div>
			<p class="bh-visit__sub"><a href="<?php echo esc_url( fort_url( 'request' ) ); ?>">資料請求</a><a href="<?php echo esc_url( fort_url( 'contact' ) ); ?>">お問い合わせ</a></p>
		</div>
	</section>

<?php get_footer(); ?>
