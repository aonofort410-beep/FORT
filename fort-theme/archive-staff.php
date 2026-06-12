<?php
/** スタッフ 一覧（部門ごと） */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
$depts = array(
	'sales'        => array( 'SALES', '営業 ／ コンサルティングコーディネーター' ),
	'design'       => array( 'DESIGN', '設計 ／ デザインコーディネーター' ),
	'construction' => array( 'ENGINEERING', '工務 ／ エンジニアリングコーディネーター' ),
	'admin'        => array( 'ADMIN', '総務' ),
);
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="" aria-hidden="true"><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal>STAFF</p>
			<h1 class="subhero__title" data-reveal>チームでつくる家づくり。</h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>STAFF</span></nav>
		</div>
	</section>

	<section class="section staff-intro">
		<div class="container staff-intro__inner">
			<p class="section__label" data-reveal>OUR TEAM</p>
			<h2 class="section__title" data-reveal>担当者まかせにしない、<br>チームの家づくり。</h2>
			<p class="staff-intro__text" data-reveal>営業・設計・工務の各コーディネーターと総務が、ひとつのチームとなって、あなたの理想の住まいをかたちにします。</p>
		</div>
	</section>

	<?php $gray = true; foreach ( $depts as $key => $d ) :
		$q = new WP_Query( array(
			'post_type'      => 'staff',
			'posts_per_page' => -1,
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			'meta_query'     => array( array( 'key' => 'fort_dept', 'value' => $key ) ),
		) );
		if ( ! $q->have_posts() ) { continue; }
		$gray = ! $gray;
	?>
	<section class="section dept<?php echo $gray ? ' section--gray' : ''; ?>" id="<?php echo esc_attr( $key ); ?>">
		<div class="container">
			<header class="dept__head">
				<p class="dept__label" data-reveal><?php echo esc_html( $d[0] ); ?></p>
				<h2 class="dept__title" data-reveal><?php echo esc_html( $d[1] ); ?></h2>
			</header>
			<ul class="member__grid">
				<?php while ( $q->have_posts() ) : $q->the_post();
					$role = fort_meta( 'fort_role' ); $en = fort_meta( 'fort_name_en' ); $cred = fort_meta( 'fort_cred' ); ?>
				<li class="member" data-reveal>
					<figure class="member__figure"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'fort-square', array( 'loading' => 'lazy' ) ); } else { echo '<img src="' . esc_url( $img . 'staff-' . $key . '.jpg' ) . '" alt="">'; } ?></figure>
					<div class="member__body">
						<?php if ( $role ) : ?><p class="member__role"><?php echo esc_html( $role ); ?></p><?php endif; ?>
						<h3 class="member__name"><?php the_title(); ?><?php if ( $en ) : ?><span class="member__name-en"><?php echo esc_html( $en ); ?></span><?php endif; ?></h3>
						<?php if ( $cred ) : ?><p class="member__cred"><?php echo esc_html( $cred ); ?></p><?php endif; ?>
					</div>
				</li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</div>
	</section>
	<?php endforeach; ?>

	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'exterior.jpg' ); ?>" alt="" aria-hidden="true"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
			<h2 class="section__title section__title--light" data-reveal>チームに会いに来てください。</h2>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
			</ul>
		</div>
	</section>
<?php get_footer(); ?>
