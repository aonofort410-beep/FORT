<?php
/**
 * 写真の帯：ゆっくり横に流れる「デザイン・暮らし」の写真（各ページ共通）
 * $args: offset（何枚目から始めるか）, label / title（任意の見出し）
 * ・写真は 管理画面「FORT 設定」→ 各ページに流れる写真。未設定ならテーマ同梱の写真
 */
$ph = fort_band_photos();
if ( count( $ph ) < 3 ) return;
$off = isset( $args['offset'] ) ? (int) $args['offset'] % count( $ph ) : 0;
$ph  = array_merge( array_slice( $ph, $off ), array_slice( $ph, 0, $off ) );
$ph  = array_slice( $ph, 0, 10 );
?>
<section class="bh-pband" aria-label="FORTの住まいと暮らし">
	<?php if ( ! empty( $args['title'] ) ) : ?>
	<div class="bh-wrap bh-pband__head"><p class="bh-label"><?php echo esc_html( $args['label'] ?? 'LIFE & DESIGN' ); ?></p><p class="bh-pband__title"><?php echo esc_html( $args['title'] ); ?></p></div>
	<?php endif; ?>
	<div class="bh-pband__track" aria-hidden="true">
		<?php for ( $r = 0; $r < 2; $r++ ) : foreach ( $ph as $i => $u ) : ?>
		<figure class="bh-pband__item bh-pband__item--<?php echo esc_attr( $i % 3 ); ?>"><img src="<?php echo esc_url( $u ); ?>" alt="" loading="lazy" decoding="async"></figure>
		<?php endforeach; endfor; ?>
	</div>
</section>
