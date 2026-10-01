<?php
/**
 * VISIT（最終CTA）：岡山 / 福山を選んで来場予約へ
 * $args: photo（背景写真URL）, title（見出し）, from（計測ラベル用）, event（引き継ぐイベントのslug）
 */
$photo = ! empty( $args['photo'] ) ? $args['photo'] : get_template_directory_uri() . '/assets/images/hero.jpg';
$title = ! empty( $args['title'] ) ? $args['title'] : '写真の続きは、<br>実物で。';
$from  = ! empty( $args['from'] ) ? $args['from'] : 'home';
$event = ! empty( $args['event'] ) ? $args['event'] : '';
?>
	<section class="bh-visit" id="visit">
		<div class="bh-visit__media"><img src="<?php echo esc_url( $photo ); ?>" alt="" width="2400" height="1600" loading="lazy" decoding="async"></div>
		<div class="bh-wrap bh-visit__inner">
			<p class="bh-label">VISIT</p>
			<h2 class="bh-visit__title"><?php echo wp_kses( $title, array( 'br' => array() ) ); ?></h2>
			<p class="bh-visit__text">素材の手ざわり、光の入り方、天井の高さ。スタジオや見学会で、実際の住まいを確かめてください。</p>
			<div class="bh-visit__choices">
				<a class="bh-visit__choice" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'okayama', 'event' => $event ) ) ); ?>" data-track="cta_click" data-track-label="<?php echo esc_attr( $from ); ?>_visit_okayama"><span>岡山で見る</span><small>OKAYAMA</small></a>
				<a class="bh-visit__choice" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'fukuyama', 'event' => $event ) ) ); ?>" data-track="cta_click" data-track-label="<?php echo esc_attr( $from ); ?>_visit_fukuyama"><span>福山で見る</span><small>FUKUYAMA</small></a>
			</div>
			<p class="bh-visit__sub"><a href="<?php echo esc_url( fort_url( 'request' ) ); ?>">資料請求</a><a href="<?php echo esc_url( fort_url( 'contact' ) ); ?>">お問い合わせ</a></p>
		</div>
	</section>
