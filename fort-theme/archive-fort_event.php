<?php
/** イベント 一覧（見学会・モデルハウス予約） */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $img . 'ldk.jpg' ); ?>" alt="" aria-hidden="true"><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal>EVENT &amp; MODEL HOUSE</p>
			<h1 class="subhero__title" data-reveal>見学会・モデルハウス予約</h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>見学会・モデルハウス</span></nav>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<p class="page-lead" data-reveal>
				写真やカタログだけでは伝わらない、空気感や心地よさ。<br>
				FORTの家を、ぜひその目で、その肌で感じてください。常時3つ以上のイベントを開催しています。
			</p>
		</div>
	</section>

	<!-- 開催中の見学会・イベント（写真カード） -->
	<section class="section section--gray" id="events">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>EVENT</p>
				<h2 class="section__title" data-reveal>開催中の見学会・イベント</h2>
				<p class="section__desc" data-reveal>気になるイベントの「予約する」ボタンから、かんたんにお申し込みいただけます。</p>
			</header>
			<ul class="feature__grid">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					$thumb = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'fort-card' ) : $img . 'exterior.jpg';
					$badge = fort_meta( 'fort_badge' );
					$date  = fort_meta( 'fort_date' );
					$place = fort_meta( 'fort_place' ); ?>
				<li class="feature__card" data-reveal>
					<figure class="feature__figure"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy"></figure>
					<div class="feature__body">
						<?php if ( $badge ) : ?><span class="feature__tag"><?php echo esc_html( $badge ); ?></span><?php endif; ?>
						<h3 class="feature__title"><?php the_title(); ?></h3>
						<p class="feature__text"><?php echo esc_html( get_the_excerpt() ); ?><?php if ( $date || $place ) : ?><br><?php echo esc_html( trim( $date . '・' . $place, '・' ) ); ?><?php endif; ?></p>
						<a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--accent btn--block">この見学会を予約する</a>
					</div>
				</li>
				<?php endwhile; else : ?>
				<li class="feature__card" data-reveal>
					<figure class="feature__figure"><img src="<?php echo esc_url( $img . 'exterior.jpg' ); ?>" alt="完成見学会" loading="lazy"></figure>
					<div class="feature__body"><span class="feature__tag">完成見学会</span><h3 class="feature__title">完成・構造見学会</h3><p class="feature__text">イベントは管理画面「イベント &gt; 新規追加」から登録できます。</p><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--accent btn--block">来場を予約する</a></div>
				</li>
				<?php endif; ?>
			</ul>
		</div>
	</section>

	<!-- 開催予定（日程一覧） -->
	<section class="section" id="schedule">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>SCHEDULE</p><h2 class="section__title" data-reveal>開催予定</h2></header>
			<div class="schedule" data-reveal>
				<?php if ( have_posts() ) : rewind_posts(); while ( have_posts() ) : the_post(); ?>
				<div class="schedule__item">
					<div class="schedule__meta">
						<?php if ( fort_meta( 'fort_date' ) ) : ?><span class="schedule__date"><?php echo esc_html( fort_meta( 'fort_date' ) ); ?></span><?php endif; ?>
						<?php if ( fort_meta( 'fort_badge' ) ) : ?><span class="schedule__badge"><?php echo esc_html( fort_meta( 'fort_badge' ) ); ?></span><?php endif; ?>
						<?php if ( fort_meta( 'fort_place' ) ) : ?><span class="schedule__place"><?php echo esc_html( fort_meta( 'fort_place' ) ); ?></span><?php endif; ?>
					</div>
					<p class="schedule__title"><?php the_title(); ?></p>
				</div>
				<?php endwhile; else : ?>
				<div class="schedule__item"><p class="schedule__title">イベントは管理画面「イベント &gt; 新規追加」から登録できます。</p></div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- モデルハウス（常設・予約優先） -->
	<section class="section section--gray" id="modelhouse">
		<div class="container">
			<header class="section__head">
				<p class="section__label" data-reveal>MODEL HOUSE</p>
				<h2 class="section__title" data-reveal>常設モデルハウス</h2>
				<p class="section__desc" data-reveal>FORTのデザインと性能を、いつでもご体感いただける2つのモデルハウス。ご予約優先でご案内します。</p>
			</header>
			<ul class="feature__grid">
				<li class="feature__card" data-reveal>
					<figure class="feature__figure"><img src="<?php echo esc_url( $img . 'model-tamano.jpg' ); ?>" alt="岡山玉野モデルハウス" loading="lazy"></figure>
					<div class="feature__body"><span class="feature__tag">岡山エリア</span><h3 class="feature__title">岡山玉野モデルハウス</h3><p class="feature__text">実際の住まいで、FORTの性能とデザインを体感いただけます。暮らしのサイズ感や心地よさをその場で。</p><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--accent btn--block">来場を予約する</a></div>
				</li>
				<li class="feature__card" data-reveal>
					<figure class="feature__figure"><img src="<?php echo esc_url( $img . 'model-shimokamo.jpg' ); ?>" alt="福山下加茂モデルハウス" loading="lazy"></figure>
					<div class="feature__body"><span class="feature__tag">福山エリア</span><h3 class="feature__title">福山下加茂モデルハウス</h3><p class="feature__text">光や風の通り方、素材の質感まで。スタッフがご案内しながらじっくりご覧いただけます。</p><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--accent btn--block">来場を予約する</a></div>
				</li>
			</ul>
		</div>
	</section>

	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'kitchen-view.jpg' ); ?>" alt="" aria-hidden="true"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>RESERVE</p>
			<h2 class="section__title section__title--light" data-reveal>見学会・モデルハウスを予約する。</h2>
			<p class="reserve__lead" data-reveal>ご予約は無料です。お子さま連れも歓迎。お気軽にお越しください。</p>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--accent btn--block">ご来場予約</a></li>
				<li><a href="#events" class="btn btn--accent btn--block">見学会を選ぶ</a></li>
				<li><a href="<?php echo esc_url( home_url( '/request/' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--light btn--block">お問合せ</a></li>
			</ul>
			<p class="reserve__tel" data-reveal>
				お電話でのご予約：<a href="tel:0862369600">086-236-9600</a>（岡山）／ <a href="tel:0849827404">084-982-7404</a>（福山）
				<span class="reserve__tel-note">（受付時間 9:00〜18:00 / 水曜定休）</span>
			</p>
		</div>
	</section>
<?php get_footer(); ?>
