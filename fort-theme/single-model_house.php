<?php
/**
 * モデルハウス 詳細（/model-house/スラッグ/）
 * 写真 → この家で見られること → 本文（写真・説明）→ 見学のご案内（場所・時間・方法・所要時間・駐車場）→ 予約 → 同じ地域の施工事例
 */
get_header();
while ( have_posts() ) : the_post();
	$id     = get_the_ID();
	$names  = array( 'okayama' => '岡山', 'fukuyama' => '福山' );
	$region = get_post_meta( $id, 'fort_region', true );
	$tels   = array( 'okayama' => fort_opt( 'fort_tel_okayama', '086-236-9600' ), 'fukuyama' => fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) );
	$tel    = isset( $tels[ $region ] ) ? $tels[ $region ] : '';
	$open   = 'closed' !== get_post_meta( $id, 'fort_mh_status', true );
	$see    = get_post_meta( $id, 'fort_see', true );
	$info   = array_filter( array(
		'場所'       => get_post_meta( $id, 'fort_place', true ),
		'見学できる時間' => get_post_meta( $id, 'fort_time', true ),
		'見学方法'   => get_post_meta( $id, 'fort_mh_method', true ),
		'所要時間'   => get_post_meta( $id, 'fort_duration', true ),
		'駐車場'     => get_post_meta( $id, 'fort_parking', true ),
	) );
	$reserve = fort_visit_url( array( 'area' => $region, 'event' => get_post_field( 'post_name', $id ) ) );
	$label   = 'model_' . get_post_field( 'post_name', $id );
?>
	<article class="bh-evd">
		<header class="bh-pagehead">
			<div class="bh-wrap">
				<?php fort_breadcrumb( array( array( 'EVENT', fort_url( 'event' ) ), array( get_the_title(), '' ) ) ); ?>
				<p class="bh-ev__meta bh-evd__meta">
					<span class="bh-ev__state bh-ev__state--<?php echo $open ? 'permanent' : 'ended'; ?>"><?php echo $open ? '公開中' : '公開終了'; ?></span>
					<span>MODEL HOUSE</span>
					<?php if ( isset( $names[ $region ] ) ) : ?><span><?php echo esc_html( $names[ $region ] ); ?></span><?php endif; ?>
				</p>
				<h1 class="bh-pagehead__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?><p class="bh-pagehead__lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				<?php if ( $open ) : ?><p class="bh-evd__top-cta"><a class="bh-btn bh-btn--fill" href="<?php echo esc_url( $reserve ); ?>" data-track="reservation_start" data-track-label="<?php echo esc_attr( $label ); ?>_top">見学を予約する</a></p><?php endif; ?>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
		<figure class="bh-case__main"><?php the_post_thumbnail( 'fort-hero', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async', 'sizes' => '100vw', 'alt' => esc_attr( get_the_title() ) ) ); ?></figure>
		<?php endif; ?>

		<?php if ( $see ) : ?>
		<section class="bh-case__text">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">SEE<span>この家で見られること</span></h2>
				<div class="bh-case__body"><?php echo fort_paras( $see ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<?php $gal = fort_gallery_html( get_the_ID() ); if ( $gal ) : ?>
		<section class="bh-case__gallery"><div class="bh-wrap"><?php echo $gal; // 画像タグは WordPress が生成 ?></div></section>
		<?php endif; ?>

		<?php if ( trim( get_the_content() ) ) : ?>
		<section class="bh-case__photos"><div class="bh-wrap bh-case__content"><?php the_content(); ?></div></section>
		<?php endif; ?>

		<section class="bh-case__spec" id="reserve">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">INFORMATION<span>見学のご案内</span></h2>
				<div>
					<?php if ( $info ) : ?>
					<dl class="bh-spec"><?php foreach ( $info as $k => $v ) : ?><div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?></dd></div><?php endforeach; ?></dl>
					<?php endif; ?>
					<div class="bh-evd__reserve">
						<?php if ( $open ) : ?>
						<a class="bh-btn bh-btn--fill" href="<?php echo esc_url( $reserve ); ?>" data-track="reservation_start" data-track-label="<?php echo esc_attr( $label ); ?>">見学を予約する</a>
						<?php else : ?>
						<p class="bh-event__none">このモデルハウスの公開は終了しました。スタジオでの見学・相談は、ご希望の日時で予約できます。</p>
						<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => $region ) ) ); ?>">スタジオの来場予約へ</a>
						<?php endif; ?>
						<?php if ( $tel ) : ?><p class="bh-evd__tel"><?php echo esc_html( $names[ $region ] ); ?>スタジオ <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $tel ) ); ?>"><?php echo esc_html( $tel ); ?></a>（9:00〜18:00 / 水曜定休）</p><?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</article>

	<?php
	$works = get_posts( array_filter( array( 'post_type' => 'works', 'posts_per_page' => 3, 'meta_key' => $region ? 'fort_w_region' : '', 'meta_value' => $region ) ) );
	if ( $works ) : ?>
	<section class="bh-related">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">WORKS<?php echo isset( $names[ $region ] ) ? '　—　' . esc_html( $names[ $region ] ) : ''; ?></p>
				<a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">すべての施工事例</a>
			</header>
			<ul class="bh-related__list">
				<?php foreach ( $works as $p ) : ?>
				<li class="bh-wcard"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
					<figure class="bh-wcard__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?></figure>
					<h3 class="bh-wcard__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
				</a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>
<?php endwhile; get_footer(); ?>
