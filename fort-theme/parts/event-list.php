<?php
/**
 * EVENT 一覧（HOME・施工事例・イベント一覧・/now/・地域ページで共通）
 * $args:
 *   limit   件数（既定 6）
 *   heading 見出しを出すか
 *   region  'okayama' / 'fukuyama' で固定
 *   kind    'limited'（期間限定）/ 'permanent'（常設）で絞る
 *   tabs    ALL / OKAYAMA / FUKUYAMA の切り替えを出すか（既定 true）
 *   label / title  見出しの英字ラベルと日本語
 *   visit   来場予約ボタンを出すか（既定 true）
 * ・切り替えは script.js（[data-region-tabs]）。JavaScriptが無くても全件が読める
 */
$limit   = isset( $args['limit'] ) ? (int) $args['limit'] : 6;
$region  = isset( $args['region'] ) ? $args['region'] : '';
$kind    = isset( $args['kind'] ) ? $args['kind'] : '';
$heading = ! empty( $args['heading'] );
$tabs    = ! isset( $args['tabs'] ) || $args['tabs'];
$visit   = ! isset( $args['visit'] ) || $args['visit'];
$label   = isset( $args['label'] ) ? $args['label'] : 'EVENT';
$title   = isset( $args['title'] ) ? $args['title'] : '<span class="bh-nb">いま参加できる</span><span class="bh-nb">見学会・相談会</span>';
$events  = fort_current_events( $region, $limit, $kind );
$names   = array( 'okayama' => '岡山', 'fukuyama' => '福山' );
?>
<section class="bh-event"<?php echo $kind ? ' id="event-' . esc_attr( $kind ) . '"' : ' id="event"'; ?>>
	<div class="bh-wrap">
		<?php if ( $heading ) : ?>
		<header class="bh-head">
			<p class="bh-label"><?php echo esc_html( $label ); ?></p>
			<h2 class="bh-head__title"><?php echo wp_kses( $title, array( 'span' => array( 'class' => array() ) ) ); ?></h2>
			<?php if ( ! is_post_type_archive( 'fort_event' ) ) : ?><a class="bh-more" href="<?php echo esc_url( fort_url( 'event' ) ); ?>">すべてのイベント</a><?php endif; ?>
		</header>
		<?php endif; ?>

		<?php if ( $events && ! $region && $tabs ) : ?>
		<div class="bh-tabs" role="group" aria-label="地域で絞り込む" data-region-tabs>
			<button type="button" aria-pressed="true" data-region="">ALL</button>
			<button type="button" aria-pressed="false" data-region="okayama">OKAYAMA</button>
			<button type="button" aria-pressed="false" data-region="fukuyama">FUKUYAMA</button>
		</div>
		<?php endif; ?>

		<?php if ( $events ) : ?>
		<div class="bh-evslide" data-ev-slider>
		<ul class="bh-event__list">
			<?php foreach ( $events as $p ) :
				$s     = fort_event_state( $p->ID );
				$dates = fort_event_dates( $p->ID );
				$place = get_post_meta( $p->ID, 'fort_place', true );
				$badge = get_post_meta( $p->ID, 'fort_badge', true ); ?>
			<li class="bh-ev bh-ev--<?php echo esc_attr( $s['status'] ); ?>" data-region="<?php echo esc_attr( $s['region'] ); ?>">
				<a class="bh-ev__link bh-ev__link--fig" href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-track="event_view" data-track-label="<?php echo esc_attr( $p->post_name ); ?>">
					<figure class="bh-ev__fig">
						<?php if ( has_post_thumbnail( $p ) ) : echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); else : ?><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-4.jpg' ); ?>" alt="" loading="lazy" decoding="async"><?php endif; ?>
						<span class="bh-ev__state bh-ev__state--<?php echo esc_attr( 'permanent' === $s['kind'] && 'open' === $s['status'] ? 'permanent' : $s['status'] ); ?>"><?php echo esc_html( $s['label'] ); ?></span>
						<?php if ( in_array( $s['status'], array( 'ended', 'full' ), true ) ) : ?><span class="bh-ev__closed"><?php echo 'full' === $s['status'] ? 'FULL' : 'CLOSED'; ?></span><?php endif; ?>
					</figure>
					<h3 class="bh-ev__title"><?php if ( $badge ) : ?><span class="bh-ev__kind">【<?php echo esc_html( $badge ); ?>】</span><?php endif; ?><?php echo esc_html( get_the_title( $p ) ); ?></h3>
					<dl class="bh-ev__info">
						<?php if ( $dates ) : ?><div><dt>日程</dt><dd><?php echo esc_html( $dates ); ?></dd></div><?php endif; ?>
						<?php if ( $place || isset( $names[ $s['region'] ] ) ) : ?><div><dt>場所</dt><dd><?php echo esc_html( $place ?: $names[ $s['region'] ] ); ?></dd></div><?php endif; ?>
					</dl>
					<span class="bh-ev__go" aria-hidden="true">→</span>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="bh-evslide__nav"><button type="button" class="bh-evslide__btn" data-dir="-1" aria-label="前へ">←</button><button type="button" class="bh-evslide__btn" data-dir="1" aria-label="次へ">→</button></div>
		</div>
		<p class="bh-event__none" hidden data-region-empty>この地域で受付中のイベントは、いまはありません。スタジオでの見学・相談はご希望の日時で予約できます。</p>
		<?php else : ?>
		<p class="bh-event__none"><?php echo 'permanent' === $kind ? '常設の相談会・モデルハウスは、準備ができしだいここに掲載します。' : 'いま受付中の見学会はありません。スタジオでの見学・相談は、ご希望の日時で予約できます。'; ?></p>
		<?php endif; ?>

		<?php if ( $visit ) : ?>
		<p class="bh-event__visit">
			<?php if ( $region ) : ?>
			<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => $region ) ) ); ?>" data-track="cta_click" data-track-label="event_visit_<?php echo esc_attr( $region ); ?>"><?php echo esc_html( $names[ $region ] ); ?>スタジオの来場予約</a>
			<?php else : ?>
			<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'okayama' ) ) ); ?>" data-track="cta_click" data-track-label="event_visit_okayama">岡山で来場予約</a>
			<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'fukuyama' ) ) ); ?>" data-track="cta_click" data-track-label="event_visit_fukuyama">福山で来場予約</a>
			<?php endif; ?>
		</p>
		<?php endif; ?>
	</div>
</section>
