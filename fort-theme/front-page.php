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
			<?php else :
				// hero-1.jpg 〜 hero-9.jpg があればゆっくり切り替わるスライドショー（無ければ hero.jpg 1枚）
				// 「FORT 設定」で選んだ写真を優先。無ければテーマ内の hero-○.jpg
				$slides = array(); $sp_set = array();
				foreach ( fort_ids( fort_setting( 'hero_pc' ) ) as $aid ) { $u = wp_get_attachment_image_url( $aid, 'full' ); if ( $u ) $slides[] = $u; }
				foreach ( fort_ids( fort_setting( 'hero_sp' ) ) as $aid ) { $u = wp_get_attachment_image_url( $aid, 'large' ); if ( $u ) $sp_set[] = $u; }
				if ( ! $slides ) for ( $i = 1; $i <= 9; $i++ ) if ( file_exists( get_template_directory() . '/assets/images/hero-' . $i . '.jpg' ) ) $slides[] = $img . 'hero-' . $i . '.jpg';
				if ( ! $slides ) $slides[] = $img . 'hero.jpg';
				?>
			<div class="bh-hero__slides" data-hero-slides>
				<?php foreach ( $slides as $i => $src ) :
					// スマホ（幅767px以下）は縦の写真 hero-sp-○.jpg があればそちらを表示。iPad・PCは横の写真
					$sp_url = $sp_set ? ( $sp_set[ $i ] ?? '' ) : ( file_exists( get_template_directory() . '/assets/images/hero-sp-' . ( $i + 1 ) . '.jpg' ) ? $img . 'hero-sp-' . ( $i + 1 ) . '.jpg' : '' ); ?>
				<picture class="bh-hero__img<?php echo 0 === $i ? ' is-on' : ''; ?>">
					<?php if ( $sp_url ) : ?><source media="(max-width: 767px)" srcset="<?php echo esc_url( $sp_url ); ?>"><?php endif; ?>
					<img src="<?php echo esc_url( $src ); ?>" alt="" width="2400" height="1600" <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?> decoding="async">
				</picture>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<!-- 公式ロゴが、じわっと浮かび上がる -->
		<div class="bh-hero__logo">
			<h1>
				<img src="<?php echo esc_url( $img . 'fort-mark.png' ); ?>" alt="FORT" width="460" height="107" fetchpriority="high" decoding="async">
				<span class="sr-only"><?php bloginfo( 'name' ); ?>｜岡山・福山の注文住宅</span>
			</h1>
		</div>
		<!-- 左下に控えめに -->
		<p class="bh-hero__note">
			<span class="bh-hero__note-main"><?php echo esc_html( fort_opt( 'fort_hero_copy', FORT_HERO_COPY ) ); ?></span>
			<span class="bh-hero__note-sub"><?php echo esc_html( fort_opt( 'fort_hero_sub', FORT_HERO_SUB ) ); ?></span>
		</p>
		<?php
		// 右下に最新のお知らせを1行（イベント・読みものの新しい順）
		$news = get_posts( array( 'post_type' => array_values( array_filter( array( 'fort_event', post_type_exists( 'journal' ) ? 'journal' : '' ) ) ), 'numberposts' => 1 ) );
		if ( $news ) : $n = $news[0]; ?>
		<a class="bh-hero__news" href="<?php echo esc_url( get_permalink( $n ) ); ?>"><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $n ) ); ?>"><?php echo esc_html( get_the_date( 'y.m.d', $n ) ); ?></time><span><?php echo esc_html( get_the_title( $n ) ); ?></span></a>
		<?php endif; ?>
		<p class="bh-hero__scroll" aria-hidden="true">SCROLL</p>
	</section>

	<!-- 02 ABOUT：FORTとは何か -->
	<section class="bh-about" id="about">
		<div class="bh-wrap bh-about__grid">
			<p class="bh-label">ABOUT</p>
			<div class="bh-about__body">
				<h2 class="bh-about__title"><span class="bh-nb">家族の数だけ、</span><span class="bh-nb">想いがある。</span><span class="bh-nb">その想いを、かたちに。</span></h2>
				<p>FORTは、岡山と福山で住まいを設計し、建てている会社です。</p>
				<p>家づくりへの想いは、十人十色。性能・デザイン・構造へのこだわりはそのままに、一つひとつの家族の想いに寄り添い、本当に求めているものを一緒に見つけ、かたちにしていきます。</p>
				<p>当たり前のようで、つい忘れがちなこと。それを、FORTはいちばん大切にしています。</p>
				<a class="bh-more" href="<?php echo esc_url( fort_url( 'about' ) ); ?>">FORTについて</a>
			</div>
		</div>
	</section>

	<!-- 03 EVENT（ABOUTのすぐ後）：岡山 / 福山。期間限定と常設を分けて表示 -->
	<?php get_template_part( 'parts/event-list', null, array( 'limit' => 6, 'heading' => true ) ); ?>
	<?php get_template_part( 'parts/model-houses' ); ?>

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

	<?php
	/* 04 LIFE WITH FORT：暮らしの写真（人が写った写真）。assets/images/life-1.jpg〜 を置くと自動で表示。無ければ非表示 */
	$life = fort_life_photos();
	if ( $life ) : ?>
	<section class="bh-life" id="life">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">LIFE WITH FORT</p>
				<h2 class="bh-head__title"><span class="bh-nb">家の中に、</span><span class="bh-nb">それぞれの暮らし。</span></h2>
			</header>
			<div class="bh-life__grid bh-life__grid--<?php echo min( 5, count( $life ) ); ?>">
				<?php foreach ( array_slice( $life, 0, 5 ) as $i => $src ) : ?>
				<figure class="bh-life__fig"><img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy" decoding="async"></figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- 05 HOUSE：グレードではなく、家づくりの方法の違い -->
	<section class="bh-house" id="house">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">HOUSE</p>
				<h2 class="bh-head__title"><span class="bh-nb">家のつくり方を、</span><span class="bh-nb">3つから。</span></h2>
			</header>
			<div class="bh-house__grid">
				<?php
				$houses = array();
				foreach ( fort_house_items() as $k => $it ) $houses[] = array( $k, $it['name'], $it['method'], $it['catch'] );
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

	<!-- 09 PLACE：活動している地域 -->
	<section class="bh-place" id="place">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">PLACE</p>
				<h2 class="bh-head__title"><span class="bh-nb">岡山と福山に、</span><span class="bh-nb">スタジオがあります。</span></h2>
			</header>
			<div class="bh-place__grid">
				<a class="bh-place__item" href="<?php echo esc_url( fort_url( 'okayama' ) ); ?>">
					<?php echo fort_place_name( 'okayama', 'OKAYAMA' ); // phpcs:ignore ?>
					<span class="bh-place__ja">岡山スタジオ</span>
					<span class="bh-place__tel"><?php echo esc_html( $tel_o ); ?></span>
				</a>
				<a class="bh-place__item" href="<?php echo esc_url( fort_url( 'fukuyama' ) ); ?>">
					<?php echo fort_place_name( 'fukuyama', 'FUKUYAMA' ); // phpcs:ignore ?>
					<span class="bh-place__ja">福山スタジオ</span>
					<span class="bh-place__tel"><?php echo esc_html( $tel_f ); ?></span>
				</a>
			</div>
		</div>
	</section>

	<!-- 10 VISIT：どちらへ行くかを選んで、見学・相談へ -->
	<?php get_template_part( 'parts/visit-cta' ); ?>

<?php get_footer(); ?>
