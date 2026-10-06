<?php
/*
 * Template Name: ABOUT（FORTについて）
 * 推奨スラッグ：about
 * HERO → PHILOSOPHY → OUR WAY（LISTEN / CRAFT / SHAPE）→ TEAM → HOUSE → PLACE → VISIT
 * ・会社の情報は「会社概要」ページへ
 */
get_header();
$studios = fort_studios();
$img     = get_template_directory_uri() . '/assets/images/';
$depts   = fort_staff_depts();
$staff   = array();
if ( post_type_exists( 'staff' ) ) {
	$q     = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ) ) );
	$staff = fort_staff_sort( array_map( 'fort_staff_data', $q->posts ) );
}
$team_photos = array_values( array_filter( wp_list_pluck( $staff, 'photo' ) ) );
$way = array(
	array( 'LISTEN', '聞く', 'まず、想いを聞くことから。', '暮らし方、好きなもの、不安なこと、ご予算。図面を描く前に、家族の言葉にじっくり耳を傾けます。言葉にならない想いまで、すくい上げるために。', 'studio-okayama.jpg' ),
	array( 'CRAFT', 'こだわる', '性能・デザイン・構造に、こだわる。', '見えるところも、見えないところも。性能・デザイン・構造へのこだわりはそのままに、聞いた想いを確かな住まいへと落とし込みます。', 'pro/persp-a.jpg' ),
	array( 'SHAPE', 'かたちにする', 'その家族だけの答えを、かたちに。', '同じ家族がいないように、同じ答えもありません。十人十色の想いを、その家族だけの住まいとして、かたちにします。', 'hero-1.jpg' ),
);
$dept_text = array(
	'sales'        => '最初に想いを聞く窓口。ご要望・ご予算を整理し、家づくり全体を伴走します。',
	'design'       => '聞いた想いを、間取り・空間・素材へ。図面とコーディネートでかたちにします。',
	'construction' => '図面を、現場で確かなかたちに。品質と安全を管理し、住まいを仕上げます。',
	'admin'        => '契約から引渡し、その後まで。家づくりの手続きと暮らしを支えます。',
);
?>
	<header class="ab-hero">
		<img class="ab-hero__img" src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" fetchpriority="high" decoding="async">
		<div class="ab-hero__txt">
			<p class="ab-hero__en">ABOUT FORT</p>
			<h1 class="ab-hero__title"><span class="bh-nb">十人十色の想いを、</span><span class="bh-nb">かたちに。</span></h1>
		</div>
	</header>
	<div class="bh-wrap ab-crumb"><?php fort_breadcrumb( array( array( 'ABOUT', '' ) ) ); ?></div>

	<!-- PHILOSOPHY -->
	<section class="ab-philo">
		<div class="bh-wrap ab-philo__grid">
			<div class="ab-philo__text">
				<p class="bh-label">PHILOSOPHY</p>
				<h2 class="ab-philo__title"><span class="bh-nb">家族の数だけ、</span><span class="bh-nb">想いがある。</span></h2>
				<p>家づくりへの想いは、家族の数だけあります。<br>同じ家族は、ひとつとしてありません。</p>
				<p>FORTは、性能・デザイン・構造へのこだわりはそのままに、お客様がFORTに寄せてくださる想い、そして本当に求めていることに耳を傾けます。一つひとつの家族の想いに寄り添い、その想いを、かたちにする。</p>
				<p>当たり前のようで、つい忘れがちなこと。<br>それを、FORTの理念として、いちばん大切にしています。</p>
			</div>
			<div class="ab-philo__figs" aria-hidden="true">
				<figure class="is-a"><img src="<?php echo esc_url( $img . 'perf-interior.jpg' ); ?>" alt="" loading="lazy" decoding="async"></figure>
				<figure class="is-b"><img src="<?php echo esc_url( $img . 'hero-3.jpg' ); ?>" alt="" loading="lazy" decoding="async"></figure>
				<figure class="is-c"><img src="<?php echo esc_url( $img . 'mh-fukuyama-shimokamo.jpg' ); ?>" alt="" loading="lazy" decoding="async"></figure>
			</div>
		</div>
	</section>

	<!-- 理念の一文（全面写真） -->
	<section class="ab-statement">
		<img class="ab-statement__bg" src="<?php echo esc_url( $img . 'hero-2.jpg' ); ?>" alt="" loading="lazy" decoding="async">
		<p class="ab-statement__txt"><span class="bh-nb">十人十色の家族の想いに寄り添い、</span><span class="bh-nb">かたちにする。</span></p>
	</section>

	<!-- OUR WAY -->
	<section class="ab-way">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">OUR WAY</p>
				<h2 class="bh-head__title"><span class="bh-nb">聞いて、こだわって、</span><span class="bh-nb">かたちにする。</span></h2>
			</header>
			<?php foreach ( $way as $i => $w ) : ?>
			<article class="ab-way__row<?php echo $i % 2 ? ' is-rev' : ''; ?>">
				<figure class="ab-way__fig"><img src="<?php echo esc_url( $img . $w[4] ); ?>" alt="" loading="lazy" decoding="async"></figure>
				<div class="ab-way__text">
					<p class="ab-way__no"><span><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><?php echo esc_html( $w[0] ); ?></p>
					<p class="ab-way__ja"><?php echo esc_html( $w[1] ); ?></p>
					<h3 class="ab-way__title"><?php echo esc_html( $w[2] ); ?></h3>
					<p><?php echo esc_html( $w[3] ); ?></p>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- TEAM -->
	<section class="ab-team">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">TEAM</p>
				<h2 class="bh-head__title"><span class="bh-nb">担当者まかせにしない、</span><span class="bh-nb">チームの家づくり。</span></h2>
				<p class="bh-eq__lead">営業・設計コーディネート・工務・総務が、ひとつのチームとなって、理想の住まいをかたちにします。</p>
			</header>
			<?php if ( count( $team_photos ) >= 4 ) : ?>
			<ul class="ab-team__faces" aria-hidden="true">
				<?php foreach ( array_slice( $team_photos, 0, 13 ) as $ph ) : ?><li><img src="<?php echo esc_url( $ph ); ?>" alt="" loading="lazy" decoding="async"></li><?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<ol class="ab-team__depts">
				<?php $n = 0; foreach ( $depts as $k => $d ) : $n++; $cnt = count( wp_list_filter( $staff, array( 'dept' => $k ) ) ); ?>
				<li>
					<p class="ab-team__no"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></p>
					<p class="ab-team__en"><?php echo esc_html( $d[0] ); ?></p>
					<h3><?php echo esc_html( $d[1] ); ?></h3>
					<p><?php echo esc_html( $dept_text[ $k ] ); ?></p>
					<?php if ( $cnt ) : ?><p class="ab-team__cnt"><?php echo (int) $cnt; ?><small>名</small></p><?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ol>
			<p class="ab-links"><a class="bh-btn" href="<?php echo esc_url( fort_url( 'staff' ) ); ?>">スタッフ紹介</a><a class="bh-btn" href="<?php echo esc_url( fort_url( 'flow' ) ); ?>">家づくりの流れ</a></p>
		</div>
	</section>

	<!-- HOUSE -->
	<section class="ab-house">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">HOUSE</p>
				<h2 class="bh-head__title"><span class="bh-nb">想いに合わせて、</span><span class="bh-nb">3つのつくり方。</span></h2>
				<p class="bh-eq__lead">どれを選んでも、FORTらしいデザインはそのまま。性能も、暮らしと予算に合わせて設計します。</p>
			</header>
			<div class="ab-house__grid">
				<?php foreach ( fort_house_items() as $k => $it ) : $ext = 0 !== strpos( fort_url( $k ), home_url() ); ?>
				<a class="ab-house__item" href="<?php echo esc_url( fort_url( $k ) ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>>
					<figure><img src="<?php echo esc_url( fort_media( $it['photo'] ) ); ?>" alt="<?php echo esc_attr( $it['name'] ); ?>の住まい" loading="lazy" decoding="async"></figure>
					<div class="ab-house__txt">
						<p class="ab-house__method"><?php echo esc_html( $it['method'] ); ?></p>
						<h3><?php echo esc_html( $it['name'] ); ?></h3>
						<p><?php echo esc_html( $it['catch'] ); ?></p>
					</div>
				</a>
				<?php endforeach; ?>
			</div>
			<p class="ab-links"><a class="bh-btn" href="<?php echo esc_url( fort_url( 'house' ) ); ?>">3つを比べる</a><a class="bh-btn" href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a><a class="bh-btn" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">施工事例</a></p>
		</div>
	</section>

	<?php get_template_part( 'parts/photo-band', null, array( 'offset' => 4 ) ); ?>

	<section class="bh-place">
		<div class="bh-wrap">
			<header class="bh-head"><p class="bh-label">PLACE</p><h2 class="bh-head__title"><span class="bh-nb">岡山と福山に、</span><span class="bh-nb">スタジオがあります。</span></h2></header>
			<div class="bh-place__grid">
				<?php foreach ( $studios as $key => $st ) : ?>
				<a class="bh-place__item" href="<?php echo esc_url( fort_url( $key ) ); ?>"><?php echo fort_place_name( $key, $st['en'] ); // phpcs:ignore ?><span class="bh-place__ja"><?php echo esc_html( $st['name'] ); ?></span><span class="bh-place__tel"><?php echo esc_html( $st['tel'] ); ?></span></a>
				<?php endforeach; ?>
			</div>
			<p class="ab-links"><a class="bh-more" href="<?php echo esc_url( fort_url( 'company' ) ); ?>">会社概要</a></p>
		</div>
	</section>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'about' ) ); ?>
<?php get_footer();
