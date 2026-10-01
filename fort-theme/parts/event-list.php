<?php
/**
 * EVENT 一覧（HOME・/now/・地域ページで共通）
 * $args: limit（件数）, heading（見出しを出すか）, region（'okayama' / 'fukuyama' で固定）
 * ・ALL / OKAYAMA / FUKUYAMA の切り替えは script.js（[data-region-tabs]）
 * ・JavaScriptが無くても全件が読める
 */
$limit   = isset( $args['limit'] ) ? (int) $args['limit'] : 6;
$region  = isset( $args['region'] ) ? $args['region'] : '';
$heading = ! empty( $args['heading'] );
$events  = fort_current_events( $region, $limit );
$names   = array( 'okayama' => '岡山', 'fukuyama' => '福山' );
?>
<section class="bh-event" id="event">
	<div class="bh-wrap">
		<?php if ( $heading ) : ?>
		<header class="bh-head">
			<p class="bh-label">EVENT</p>
			<h2 class="bh-head__title"><span class="bh-nb">いま参加できる</span><span class="bh-nb">見学会・相談会</span></h2>
			<a class="bh-more" href="<?php echo esc_url( fort_url( 'event' ) ); ?>">すべてのイベント</a>
		</header>
		<?php endif; ?>

		<?php if ( $events && ! $region ) : ?>
		<div class="bh-tabs" role="group" aria-label="地域で絞り込む" data-region-tabs>
			<button type="button" aria-pressed="true" data-region="">ALL</button>
			<button type="button" aria-pressed="false" data-region="okayama">OKAYAMA</button>
			<button type="button" aria-pressed="false" data-region="fukuyama">FUKUYAMA</button>
		</div>
		<?php endif; ?>

		<?php if ( $events ) : ?>
		<ul class="bh-event__list">
			<?php foreach ( $events as $p ) :
				$s     = fort_event_state( $p->ID );
				$dates = fort_event_dates( $p->ID );
				$place = get_post_meta( $p->ID, 'fort_place', true );
				$badge = get_post_meta( $p->ID, 'fort_badge', true ); ?>
			<li class="bh-ev" data-region="<?php echo esc_attr( $s['region'] ); ?>">
				<a class="bh-ev__link<?php echo has_post_thumbnail( $p ) ? ' bh-ev__link--fig' : ''; ?>" href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-track="event_view" data-track-label="<?php echo esc_attr( $p->post_name ); ?>">
					<?php if ( has_post_thumbnail( $p ) ) : ?><figure class="bh-ev__fig"><?php echo get_the_post_thumbnail( $p, 'fort-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?></figure><?php endif; ?>
					<p class="bh-ev__meta">
						<span class="bh-ev__state bh-ev__state--<?php echo esc_attr( 'permanent' === $s['kind'] && 'open' === $s['status'] ? 'permanent' : $s['status'] ); ?>"><?php echo esc_html( $s['label'] ); ?></span>
						<?php if ( 'limited' === $s['kind'] && $badge ) : ?><span><?php echo esc_html( $badge ); ?></span><?php endif; ?>
						<?php if ( isset( $names[ $s['region'] ] ) ) : ?><span><?php echo esc_html( $names[ $s['region'] ] ); ?></span><?php endif; ?>
					</p>
					<h3 class="bh-ev__title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
					<?php if ( $dates || $place ) : ?><p class="bh-ev__when"><?php echo esc_html( trim( $dates . '　' . $place ) ); ?></p><?php endif; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<p class="bh-event__none" hidden data-region-empty>この地域で受付中のイベントは、いまはありません。スタジオでの見学・相談はご希望の日時で予約できます。</p>
		<?php else : ?>
		<p class="bh-event__none">いま受付中の見学会はありません。スタジオでの見学・相談は、ご希望の日時で予約できます。</p>
		<?php endif; ?>

		<p class="bh-event__visit">
			<?php if ( $region ) : ?>
			<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => $region ) ) ); ?>" data-track="cta_click" data-track-label="event_visit_<?php echo esc_attr( $region ); ?>"><?php echo esc_html( $names[ $region ] ); ?>スタジオの来場予約</a>
			<?php else : ?>
			<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'okayama' ) ) ); ?>" data-track="cta_click" data-track-label="event_visit_okayama">岡山で来場予約</a>
			<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => 'fukuyama' ) ) ); ?>" data-track="cta_click" data-track-label="event_visit_fukuyama">福山で来場予約</a>
			<?php endif; ?>
		</p>
	</div>
</section>
