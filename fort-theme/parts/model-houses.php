<?php
/**
 * MODEL HOUSE：見学できるモデルハウス（管理画面「モデルハウス」で公開中のもの）
 * $args: region（地域で固定）, heading（見出しを出すか）
 * ・1件も無ければ何も表示しない
 */
$region = isset( $args['region'] ) ? $args['region'] : '';
$houses = fort_model_houses( $region );
if ( ! $houses ) return;
$names = array( 'okayama' => '岡山', 'fukuyama' => '福山' );
if ( ! empty( $args['slide'] ) ) :
	// トップ用：画面いっぱいの写真がゆっくり切り替わる（各モデルハウスのメイン写真＋ギャラリー）
	$slides = array();
	foreach ( $houses as $p ) {
		$main = fort_mh_photo( $p );
		if ( $main ) $slides[] = array( $main, $p );
		foreach ( array_slice( fort_ids( get_post_meta( $p->ID, 'fort_gallery', true ) ), 0, 6 ) as $gid ) {
			$u = wp_get_attachment_image_url( $gid, 'fort-hero' );
			if ( $u ) $slides[] = array( $u, $p );
		}
	}
	if ( ! $slides ) return;
	$first = $houses[0];
?>
<section class="bh-mhs" id="model-house" data-mh-slides>
	<div class="bh-mhs__media" aria-hidden="true">
		<?php foreach ( $slides as $i => $sl ) : ?>
		<img class="bh-mhs__img<?php echo 0 === $i ? ' is-on' : ''; ?>" src="<?php echo esc_url( $sl[0] ); ?>" alt="" loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>" decoding="async">
		<?php endforeach; ?>
	</div>
	<div class="bh-mhs__body">
		<p class="bh-mhs__label">MODEL HOUSE</p>
		<h2 class="bh-mhs__title"><span class="bh-nb">いつでも見に行ける、</span><span class="bh-nb">モデルハウス</span></h2>
		<ul class="bh-mhs__list">
			<?php foreach ( $houses as $p ) : $r = get_post_meta( $p->ID, 'fort_region', true ); $place = get_post_meta( $p->ID, 'fort_place', true ); ?>
			<li><a href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-track="event_view" data-track-label="model_<?php echo esc_attr( $p->post_name ); ?>"><span class="bh-mhs__area"><?php echo esc_html( $names[ $r ] ?? '' ); ?></span><b><?php echo esc_html( get_the_title( $p ) ); ?></b><?php if ( $place ) : ?><small><?php echo esc_html( $place ); ?></small><?php endif; ?><i aria-hidden="true">→</i></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php return; endif; ?>
<section class="bh-mh" id="model-house">
	<div class="bh-wrap">
		<?php if ( ! isset( $args['heading'] ) || $args['heading'] ) : ?>
		<header class="bh-head">
			<p class="bh-label">MODEL HOUSE</p>
			<h2 class="bh-head__title"><span class="bh-nb">いつでも見に行ける、</span><span class="bh-nb">モデルハウス</span></h2>
		</header>
		<?php endif; ?>
		<ul class="bh-mh__list">
			<?php foreach ( $houses as $p ) :
				$r = get_post_meta( $p->ID, 'fort_region', true );
				$place = get_post_meta( $p->ID, 'fort_place', true );
				$method = get_post_meta( $p->ID, 'fort_mh_method', true ); ?>
			<li class="bh-mh__item"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-track="event_view" data-track-label="model_<?php echo esc_attr( $p->post_name ); ?>">
				<?php $mh_img = fort_mh_photo( $p ); if ( $mh_img ) : ?><figure class="bh-wcard__fig bh-mh__fig"><img src="<?php echo esc_url( $mh_img ); ?>" alt="<?php echo esc_attr( get_the_title( $p ) ); ?>" loading="lazy" decoding="async"></figure><?php endif; ?>
				<p class="bh-ev__meta"><span class="bh-ev__state bh-ev__state--permanent">公開中</span><?php if ( isset( $names[ $r ] ) ) : ?><span><?php echo esc_html( $names[ $r ] ); ?></span><?php endif; ?><?php if ( $method ) : ?><span><?php echo esc_html( $method ); ?></span><?php endif; ?></p>
				<h3 class="bh-wcard__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
				<?php if ( $place ) : ?><p class="bh-wcard__meta"><?php echo esc_html( $place ); ?></p><?php endif; ?>
			</a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
