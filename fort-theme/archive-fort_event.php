<?php
/** イベント 一覧 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>
	<section class="subhero">
		<div class="subhero__media"><img src="<?php echo esc_url( $img . 'ldk.jpg' ); ?>" alt="" aria-hidden="true"><div class="subhero__overlay"></div></div>
		<div class="container subhero__inner">
			<p class="subhero__eyebrow" data-reveal>EVENT</p>
			<h1 class="subhero__title" data-reveal>見学会・イベント</h1>
			<nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>EVENT</span></nav>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<header class="section__head"><p class="section__label" data-reveal>SCHEDULE</p><h2 class="section__title" data-reveal>開催予定</h2></header>
			<div class="schedule" data-reveal>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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

	<section class="reserve section" id="reserve">
		<div class="reserve__bg"><img src="<?php echo esc_url( $img . 'kitchen-view.jpg' ); ?>" alt="" aria-hidden="true"><div class="reserve__overlay"></div></div>
		<div class="container reserve__inner">
			<p class="section__label section__label--light" data-reveal>RESERVE</p>
			<h2 class="section__title section__title--light" data-reveal>見学会を予約する。</h2>
			<ul class="reserve__actions" data-reveal>
				<li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent btn--block">予約・お問い合わせ</a></li>
			</ul>
		</div>
	</section>
<?php get_footer(); ?>
