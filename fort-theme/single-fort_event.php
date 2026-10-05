<?php
/**
 * EVENT 詳細（/info/スラッグ/）
 * 何が見られるか → 何が相談できるか → 開催概要（日時・場所・所要時間・駐車場・予約方法）→ 本文 → 予約 → 関連WORKS → FORTについて
 * ・入力されていない項目は表示しない
 * ・予約ボタンは、地域とイベントを予約フォームへ引き継ぐ
 */
get_header();
while ( have_posts() ) : the_post();
	$id     = get_the_ID();
	$s      = fort_event_state( $id );
	$names  = array( 'okayama' => '岡山', 'fukuyama' => '福山' );
	$tels   = array( 'okayama' => fort_opt( 'fort_tel_okayama', '086-236-9600' ), 'fukuyama' => fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) );
	$dates  = fort_event_dates( $id );
	$time   = get_post_meta( $id, 'fort_time', true );
	$place  = get_post_meta( $id, 'fort_place', true );
	$badge  = get_post_meta( $id, 'fort_badge', true );
	$see    = get_post_meta( $id, 'fort_see', true );
	$talk   = get_post_meta( $id, 'fort_consult', true );
	$open   = 'open' === $s['status'];
	$tel    = isset( $tels[ $s['region'] ] ) ? $tels[ $s['region'] ] : '';
	$info   = array_filter( array(
		'日時'       => trim( $dates . ( $time ? '　' . $time : '' ) ),
		'場所'       => $place,
		'所要時間'   => get_post_meta( $id, 'fort_duration', true ),
		'駐車場'     => get_post_meta( $id, 'fort_parking', true ),
	) );
	$reserve = fort_visit_url( array( 'area' => $s['region'], 'event' => get_post_field( 'post_name', $id ) ) );
?>
	<article class="bh-evd">
		<header class="bh-pagehead">
			<div class="bh-wrap">
				<?php fort_breadcrumb( array( array( 'EVENT', fort_url( 'event' ) ), array( get_the_title(), '' ) ) ); ?>
				<p class="bh-ev__meta bh-evd__meta">
					<span class="bh-ev__state bh-ev__state--<?php echo esc_attr( 'permanent' === $s['kind'] && $open ? 'permanent' : $s['status'] ); ?>"><?php echo esc_html( $s['label'] ); ?></span>
					<?php if ( $badge ) : ?><span><?php echo esc_html( $badge ); ?></span><?php endif; ?>
					<?php if ( isset( $names[ $s['region'] ] ) ) : ?><span><?php echo esc_html( $names[ $s['region'] ] ); ?></span><?php endif; ?>
				</p>
				<h1 class="bh-pagehead__title"><?php the_title(); ?></h1>
				<?php if ( $dates ) : ?><p class="bh-evd__date"><?php echo esc_html( $dates ); ?></p><?php endif; ?>
				<?php if ( has_excerpt() ) : ?><p class="bh-pagehead__lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				<?php if ( $open ) : ?><p class="bh-evd__top-cta"><a class="bh-btn bh-btn--fill" href="<?php echo esc_url( $reserve ); ?>" data-track="reservation_start" data-track-label="event_top_<?php echo esc_attr( get_post_field( 'post_name', $id ) ); ?>">このイベントを予約する</a></p><?php endif; ?>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
		<figure class="bh-case__main"><?php the_post_thumbnail( 'fort-hero', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async', 'sizes' => '100vw', 'alt' => esc_attr( get_the_title() ) ) ); ?></figure>
		<?php endif; ?>

		<?php if ( $see ) : ?>
		<section class="bh-case__text">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">SEE<span>見られること</span></h2>
				<div class="bh-case__body"><?php echo fort_paras( $see ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( $talk ) : ?>
		<section class="bh-case__text">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">TALK<span>相談できること</span></h2>
				<div class="bh-case__body"><?php echo fort_paras( $talk ); ?></div>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( trim( get_the_content() ) ) : ?>
		<section class="bh-case__photos">
			<div class="bh-wrap bh-case__content"><?php the_content(); ?></div>
		</section>
		<?php endif; ?>

		<section class="bh-case__spec" id="reserve">
			<div class="bh-wrap bh-case__cols">
				<h2 class="bh-label">INFORMATION<span>開催概要と予約</span></h2>
				<div>
					<?php if ( $info ) : ?>
					<dl class="bh-spec">
						<?php foreach ( $info as $k => $v ) : ?><div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?></dd></div><?php endforeach; ?>
						<div><dt>予約方法</dt><dd><?php echo $open ? '下のボタンから予約フォームへ' : '現在は予約を受け付けていません'; ?><?php echo $tel ? '。お電話（' . esc_html( $tel ) . '）でも承ります' : ''; ?></dd></div>
					</dl>
					<?php endif; ?>
					<div class="bh-evd__reserve">
						<?php if ( $open ) : ?>
						<a class="bh-btn bh-btn--fill" href="<?php echo esc_url( $reserve ); ?>" data-track="reservation_start" data-track-label="event_<?php echo esc_attr( get_post_field( 'post_name', $id ) ); ?>">このイベントを予約する</a>
						<?php else : ?>
						<p class="bh-event__none"><?php echo 'full' === $s['status'] ? 'このイベントは満席です。' : ( 'ended' === $s['status'] ? 'このイベントは終了しました。' : 'このイベントは、いまは予約を受け付けていません。' ); ?>スタジオでの見学・相談は、ご希望の日時で予約できます。</p>
						<a class="bh-btn" href="<?php echo esc_url( fort_visit_url( array( 'area' => $s['region'] ) ) ); ?>" data-track="cta_click" data-track-label="event_closed_visit">スタジオの来場予約へ</a>
						<?php endif; ?>
						<?php if ( $tel ) : ?><p class="bh-evd__tel"><?php echo esc_html( $names[ $s['region'] ] ); ?>スタジオ <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $tel ) ); ?>"><?php echo esc_html( $tel ); ?></a>（9:00〜18:00 / 水曜定休）</p><?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</article>

	<?php
	/* 関連WORKS：同じ地域の施工事例 */
	$works = get_posts( array_filter( array( 'post_type' => 'works', 'posts_per_page' => 3, 'meta_key' => $s['region'] ? 'fort_w_region' : '', 'meta_value' => $s['region'] ) ) );
	if ( $works ) : ?>
	<section class="bh-related">
		<div class="bh-wrap">
			<header class="bh-head">
				<p class="bh-label">WORKS<?php echo isset( $names[ $s['region'] ] ) ? '　—　' . esc_html( $names[ $s['region'] ] ) : ''; ?></p>
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

	<!-- FORTについて（広告から直接来た人にも、どんな会社か伝わるように） -->
	<section class="bh-about bh-about--compact">
		<div class="bh-wrap bh-about__grid">
			<p class="bh-label">ABOUT FORT</p>
			<div class="bh-about__body">
				<p>FORTは、岡山と福山で住まいを設計し、建てている会社です。家族それぞれの想いに寄り添い、一棟ずつかたちにしています。</p>
				<p class="bh-about__links"><a class="bh-more" href="<?php echo esc_url( fort_url( 'about' ) ); ?>">FORTについて</a><a class="bh-more" href="<?php echo esc_url( fort_url( 'house' ) ); ?>">家づくりの方法</a></p>
			</div>
		</div>
	</section>

	<?php
	/* 構造化データ：期間限定で開始日があるときだけ、ページに表示している内容で出す */
	if ( 'limited' === $s['kind'] && get_post_meta( $id, 'fort_start', true ) ) {
		$ld = array(
			'@context'            => 'https://schema.org',
			'@type'               => 'Event',
			'name'                => get_the_title(),
			'startDate'           => get_post_meta( $id, 'fort_start', true ),
			'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
			'eventStatus'         => 'https://schema.org/EventScheduled',
			'organizer'           => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ),
			'url'                 => get_permalink(),
		);
		if ( get_post_meta( $id, 'fort_end', true ) ) $ld['endDate'] = get_post_meta( $id, 'fort_end', true );
		if ( $place ) $ld['location'] = array( '@type' => 'Place', 'name' => $place, 'address' => $place );
		if ( has_post_thumbnail() ) $ld['image'] = get_the_post_thumbnail_url( $id, 'fort-hero' );
		if ( has_excerpt() ) $ld['description'] = get_the_excerpt();
		echo '<script type="application/ld+json">' . wp_json_encode( $ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
	}
endwhile;
get_footer();
