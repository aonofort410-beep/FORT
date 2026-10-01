<?php
/**
 * 来場予約フォーム（/visit/）
 * ------------------------------------------------------------
 * 入力 → 確認 → 送信 → 完了 の4段階。プラグイン不要。
 * ・遷移元から 地域（?area=）とイベント／モデルハウス（?event=スラッグ）を引き継ぐ
 * ・送信内容は担当スタジオへメール＋管理画面「来場予約」に保存（メール不達でも予約が残る）
 * ・お客様には自動返信メール
 * ・迷惑送信対策：nonce、隠し項目（ハニーポット）、送信までの最短時間
 * ・Analytics には個人情報を送らない（reservation_success のみ）
 * ============================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- 保存先（管理画面「来場予約」：管理者だけが見られる） ---------- */
add_action( 'init', function () {
	register_post_type( 'fort_reservation', array(
		'labels'          => array( 'name' => '来場予約', 'singular_name' => '来場予約', 'all_items' => '来場予約一覧', 'edit_item' => '来場予約の内容' ),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-email-alt',
		'menu_position'   => 4,
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

/* ---------- 送信先メール（外観 → カスタマイズ → FORT：連絡先） ---------- */
add_action( 'customize_register', function ( $wp ) {
	foreach ( array( 'okayama' => '岡山', 'fukuyama' => '福山' ) as $k => $n ) {
		$wp->add_setting( 'fort_mail_' . $k, array( 'default' => '', 'sanitize_callback' => 'sanitize_email' ) );
		$wp->add_control( 'fort_mail_' . $k, array( 'label' => '来場予約の通知先（' . $n . '）。空欄なら管理者メール', 'section' => 'fort_contact', 'type' => 'email' ) );
	}
}, 30 );

/* ---------- 選択肢 ---------- */
function fort_rsv_times() {
	return array( '10:00', '11:00', '13:00', '14:00', '15:00', '16:00' );
}
function fort_rsv_timings() {
	return array( '3ヶ月以内', '半年以内', '1年以内', '1〜2年以内', '2年以降・未定', '情報収集中' );
}
/** 来場先：スタジオ＋公開中のモデルハウス。key => array( label, region ) */
function fort_rsv_places() {
	$places = array(
		'studio-okayama'  => array( '岡山スタジオ', 'okayama' ),
		'studio-fukuyama' => array( '福山スタジオ', 'fukuyama' ),
	);
	foreach ( fort_model_houses() as $p ) {
		$places[ 'model-' . $p->post_name ] = array( get_the_title( $p ), get_post_meta( $p->ID, 'fort_region', true ) );
	}
	return $places;
}
/** ?event= のスラッグ → イベント or モデルハウス */
function fort_rsv_source( $slug ) {
	$slug = sanitize_title( $slug );
	if ( ! $slug ) return null;
	foreach ( array( 'fort_event', 'model_house' ) as $type ) {
		$p = get_page_by_path( $slug, OBJECT, $type );
		if ( $p && 'publish' === $p->post_status ) return $p;
	}
	return null;
}

/* ---------- 項目定義（順番＝確認画面・メールの順） ---------- */
function fort_rsv_fields() {
	return array(
		'place'   => '来場先',
		'event'   => '参加するイベント',
		'date1'   => '第1希望日時',
		'date2'   => '第2希望日時',
		'adults'  => '来場人数（大人）',
		'kids'    => '来場人数（お子さま）',
		'name'    => 'お名前',
		'kana'    => 'ふりがな',
		'email'   => 'メールアドレス',
		'tel'     => '携帯電話番号',
		'zip'     => '郵便番号',
		'address' => 'ご住所',
		'timing'  => '建築希望時期',
		'area'    => '建築希望エリア',
		'message' => 'ご質問・ご要望',
	);
}

/** 入力値を取り出して整える */
function fort_rsv_collect( $src ) {
	$g = function ( $k ) use ( $src ) { $k = 'rsv_' . $k; return isset( $src[ $k ] ) ? trim( wp_unslash( $src[ $k ] ) ) : ''; }; // WordPressの予約語（name など）と重ならないよう rsv_ を付ける
	$tel = preg_replace( '/[^\d]/', '', mb_convert_kana( $g( 'tel' ), 'n' ) );
	$zip = preg_replace( '/[^\d]/', '', mb_convert_kana( $g( 'zip' ), 'n' ) );
	return array(
		'place'   => sanitize_key( $g( 'place' ) ),
		'event'   => sanitize_title( $g( 'event' ) ),
		'date1_d' => sanitize_text_field( $g( 'date1_d' ) ),
		'date1_t' => sanitize_text_field( $g( 'date1_t' ) ),
		'date2_d' => sanitize_text_field( $g( 'date2_d' ) ),
		'date2_t' => sanitize_text_field( $g( 'date2_t' ) ),
		'adults'  => (string) absint( $g( 'adults' ) ),
		'kids'    => '' === $g( 'kids' ) ? '' : (string) absint( $g( 'kids' ) ),
		'name'    => sanitize_text_field( $g( 'name' ) ),
		'kana'    => sanitize_text_field( $g( 'kana' ) ),
		'email'   => sanitize_email( $g( 'email' ) ),
		'tel'     => $tel,
		'zip'     => strlen( $zip ) === 7 ? substr( $zip, 0, 3 ) . '-' . substr( $zip, 3 ) : $zip,
		'address' => sanitize_text_field( $g( 'address' ) ),
		'timing'  => sanitize_text_field( $g( 'timing' ) ),
		'area'    => sanitize_text_field( $g( 'area' ) ),
		'message' => sanitize_textarea_field( $g( 'message' ) ),
		'agree'   => $g( 'agree' ) ? '1' : '',
	);
}

/** 入力チェック。エラーは 項目キー => メッセージ */
function fort_rsv_validate( $v ) {
	$e      = array();
	$places = fort_rsv_places();
	$today  = wp_date( 'Y-m-d' );
	$is_date = function ( $d ) { return (bool) preg_match( '/^\d{4}-\d{2}-\d{2}$/', $d ); };
	if ( ! isset( $places[ $v['place'] ] ) ) $e['place'] = '来場先を選んでください。';
	foreach ( array( 'date1' => '第1希望', 'date2' => '第2希望' ) as $k => $n ) {
		if ( ! $is_date( $v[ $k . '_d' ] ) ) $e[ $k ] = $n . 'の日付を選んでください。';
		elseif ( $v[ $k . '_d' ] <= $today ) $e[ $k ] = $n . 'は明日以降の日付を選んでください。';
		elseif ( ! in_array( $v[ $k . '_t' ], fort_rsv_times(), true ) ) $e[ $k ] = $n . 'の時間を選んでください。';
	}
	if ( empty( $e['date2'] ) && empty( $e['date1'] ) && $v['date1_d'] . $v['date1_t'] === $v['date2_d'] . $v['date2_t'] ) $e['date2'] = '第2希望は、第1希望と違う日時を選んでください。';
	if ( (int) $v['adults'] < 1 ) $e['adults'] = '大人の人数を選んでください。';
	if ( '' === $v['kids'] ) $e['kids'] = 'お子さまの人数を選んでください（いない場合は0名）。';
	if ( '' === $v['name'] ) $e['name'] = 'お名前を入力してください。';
	if ( ! is_email( $v['email'] ) ) $e['email'] = 'メールアドレスを正しく入力してください。';
	if ( ! preg_match( '/^0\d{9,10}$/', $v['tel'] ) ) $e['tel'] = '携帯電話番号を数字で入力してください（例：090-1234-5678）。';
	if ( ! preg_match( '/^\d{3}-\d{4}$/', $v['zip'] ) ) $e['zip'] = '郵便番号を7桁で入力してください。';
	if ( '' === $v['address'] ) $e['address'] = 'ご住所を入力してください。';
	if ( $v['timing'] && ! in_array( $v['timing'], fort_rsv_timings(), true ) ) $e['timing'] = '建築希望時期を選び直してください。';
	if ( ! $v['agree'] ) $e['agree'] = 'プライバシーポリシーへの同意が必要です。';
	return $e;
}

/** 表示用の値 */
function fort_rsv_display( $v ) {
	$places = fort_rsv_places();
	$w      = array( '日', '月', '火', '水', '木', '金', '土' );
	$date   = function ( $d, $t ) use ( $w ) {
		if ( ! $d ) return '';
		$ts = strtotime( $d );
		return wp_date( 'Y年n月j日', $ts ) . '（' . $w[ (int) wp_date( 'w', $ts ) ] . '）' . ( $t ? ' ' . $t . '〜' : '' );
	};
	$src = fort_rsv_source( $v['event'] );
	return array_filter( array(
		'place'   => isset( $places[ $v['place'] ] ) ? $places[ $v['place'] ][0] : '',
		'event'   => ( $src && 'fort_event' === $src->post_type ) ? get_the_title( $src ) : '',
		'date1'   => $date( $v['date1_d'], $v['date1_t'] ),
		'date2'   => $date( $v['date2_d'], $v['date2_t'] ),
		'adults'  => $v['adults'] ? $v['adults'] . '名' : '',
		'kids'    => '' !== $v['kids'] ? $v['kids'] . '名' : '',
		'name'    => $v['name'],
		'kana'    => $v['kana'],
		'email'   => $v['email'],
		'tel'     => $v['tel'],
		'zip'     => $v['zip'],
		'address' => $v['address'],
		'timing'  => $v['timing'],
		'area'    => $v['area'],
		'message' => $v['message'],
	), 'strlen' );
}

/* ---------- 送信処理（admin-post.php） ---------- */
function fort_rsv_handle() {
	$back = wp_get_referer() ? wp_get_referer() : fort_url( 'visit' );
	$v    = fort_rsv_collect( $_POST );
	if ( ! isset( $_POST['fort_rsv_nonce'] ) || ! wp_verify_nonce( $_POST['fort_rsv_nonce'], 'fort_rsv_send' ) ) {
		wp_safe_redirect( add_query_arg( 'rsv', 'expired', fort_url( 'visit' ) ) ); exit;
	}
	// ハニーポット・送信までの時間（3秒未満は機械的な送信とみなす）
	$t = isset( $_POST['fort_rsv_t'] ) ? (int) $_POST['fort_rsv_t'] : 0;
	if ( ! empty( $_POST['fort_rsv_url'] ) || ! $t || time() - $t < 3 ) {
		wp_safe_redirect( add_query_arg( 'rsv', 'done', fort_url( 'visit' ) ) ); exit;
	}
	if ( fort_rsv_validate( $v ) ) {
		wp_safe_redirect( add_query_arg( 'rsv', 'expired', fort_url( 'visit' ) ) ); exit;
	}

	$disp   = fort_rsv_display( $v );
	$labels = fort_rsv_fields();
	$lines  = array();
	foreach ( $disp as $k => $val ) $lines[] = '■ ' . $labels[ $k ] . "\n" . $val;
	$body   = implode( "\n\n", $lines );
	$places = fort_rsv_places();
	$region = $places[ $v['place'] ][1];

	// 管理画面に保存（メールが届かなくても予約が残るように）
	wp_insert_post( array(
		'post_type'    => 'fort_reservation',
		'post_status'  => 'private',
		'post_title'   => wp_date( 'Y/m/d H:i' ) . '　' . $disp['place'] . '　' . $v['name'] . ' 様',
		'post_content' => $body,
	) );

	// 担当スタジオへ通知
	$to = fort_opt( 'fort_mail_' . $region, '' );
	$to = $to ? $to : get_option( 'admin_email' );
	$headers = array( 'Reply-To: ' . $v['name'] . ' <' . $v['email'] . '>' );
	wp_mail( $to, '【来場予約】' . $disp['place'] . '　' . $v['name'] . ' 様', "ホームページから来場予約が届きました。\n日程を確定し、お客様へご連絡してください。\n\n" . $body, $headers );

	// お客様へ自動返信
	$tels = array( 'okayama' => fort_opt( 'fort_tel_okayama', '086-236-9600' ), 'fukuyama' => fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) );
	$reply = $v['name'] . " 様\n\n" . get_bloginfo( 'name' ) . " です。来場予約のお申し込みをありがとうございます。\n以下の内容で受け付けました。\n\n"
		. "※ この時点では、ご予約はまだ確定していません。\n　担当者より日程確定のご連絡をいたします。\n\n"
		. $body
		. "\n\n――――――――――――――――\n" . get_bloginfo( 'name' ) . "\n"
		. ( isset( $tels[ $region ] ) ? ( 'okayama' === $region ? '岡山スタジオ ' : '福山スタジオ ' ) . $tels[ $region ] . "（9:00〜18:00 / 水曜定休）\n" : '' )
		. home_url( '/' ) . "\n";
	wp_mail( $v['email'], '【' . get_bloginfo( 'name' ) . '】来場予約を受け付けました', $reply );

	wp_safe_redirect( add_query_arg( array( 'rsv' => 'done', 'area' => $region ), fort_url( 'visit' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_fort_reservation', 'fort_rsv_handle' );
add_action( 'admin_post_fort_reservation', 'fort_rsv_handle' );

/* ---------- 画面 ---------- */

/** フォームの選択・入力の初期値（URLから引き継ぎ） */
function fort_rsv_defaults() {
	$v      = fort_rsv_collect( array() );
	$area   = isset( $_GET['area'] ) ? sanitize_key( $_GET['area'] ) : '';
	$src    = isset( $_GET['event'] ) ? fort_rsv_source( wp_unslash( $_GET['event'] ) ) : null;
	$v['kids'] = '0';
	if ( $src && 'model_house' === $src->post_type ) {
		$v['place'] = 'model-' . $src->post_name;
	} else {
		if ( $src ) {
			$v['event'] = $src->post_name;
			$r = get_post_meta( $src->ID, 'fort_region', true );
			$area = $r ? $r : $area;
		}
		if ( in_array( $area, array( 'okayama', 'fukuyama' ), true ) ) $v['place'] = 'studio-' . $area;
	}
	return $v;
}

function fort_rsv_select( $name, $options, $current, $placeholder = '選択してください', $attrs = '' ) {
	echo '<select class="bh-input" id="rsv-' . esc_attr( $name ) . '" name="rsv_' . esc_attr( $name ) . '"' . $attrs . '>';
	if ( null !== $placeholder ) echo '<option value="">' . esc_html( $placeholder ) . '</option>';
	foreach ( $options as $val => $label ) {
		echo '<option value="' . esc_attr( $val ) . '"' . selected( (string) $current, (string) $val, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
}

function fort_rsv_err( $errors, $key ) {
	if ( ! empty( $errors[ $key ] ) ) echo '<p class="bh-field__err" id="err-' . esc_attr( $key ) . '">' . esc_html( $errors[ $key ] ) . '</p>';
}
function fort_rsv_aria( $errors, $key ) {
	return ! empty( $errors[ $key ] ) ? ' aria-invalid="true" aria-describedby="err-' . esc_attr( $key ) . '"' : '';
}

/** 入力画面 */
function fort_rsv_form( $v, $errors = array() ) {
	$places  = fort_rsv_places();
	$popts   = array();
	foreach ( $places as $k => $p ) $popts[ $k ] = $p[0];
	$src     = fort_rsv_source( $v['event'] );
	$times   = array_combine( fort_rsv_times(), fort_rsv_times() );
	$min     = wp_date( 'Y-m-d', strtotime( '+1 day', current_time( 'timestamp' ) ) );
	$adults  = array(); for ( $i = 1; $i <= 6; $i++ ) $adults[ $i ] = $i . '名';
	$kids    = array(); for ( $i = 0; $i <= 5; $i++ ) $kids[ $i ] = $i . '名';
	$privacy = fort_url( 'privacy' );
	?>
	<?php if ( $errors ) : ?>
	<div class="bh-form__alert" role="alert" tabindex="-1" id="rsv-alert">
		<p>入力内容を確認してください（<?php echo count( $errors ); ?>か所）。</p>
	</div>
	<?php endif; ?>
	<form class="bh-form" method="post" action="<?php echo esc_url( fort_url( 'visit' ) ); ?>#rsv" novalidate data-rsv-form>
		<input type="hidden" name="rsv_step" value="confirm">
		<input type="hidden" name="rsv_event" value="<?php echo esc_attr( $v['event'] ); ?>">

		<?php if ( $src && 'fort_event' === $src->post_type ) : ?>
		<div class="bh-form__context"><span class="bh-label">EVENT</span><p><?php echo esc_html( get_the_title( $src ) ); ?></p><p class="bh-form__context-sub"><?php echo esc_html( fort_event_dates( $src->ID ) ); ?></p></div>
		<?php endif; ?>

		<fieldset class="bh-form__group">
			<legend>ご来場について</legend>
			<div class="bh-field">
				<label for="rsv-place">来場先<span class="bh-req">必須</span></label>
				<?php fort_rsv_select( 'place', $popts, $v['place'], '選択してください', fort_rsv_aria( $errors, 'place' ) . ' required' ); ?>
				<?php fort_rsv_err( $errors, 'place' ); ?>
			</div>
			<?php foreach ( array( 'date1' => '第1希望日時', 'date2' => '第2希望日時' ) as $k => $label ) : ?>
			<div class="bh-field">
				<label for="rsv-<?php echo esc_attr( $k ); ?>_d"><?php echo esc_html( $label ); ?><span class="bh-req">必須</span></label>
				<div class="bh-field__pair">
					<input class="bh-input" type="date" id="rsv-<?php echo esc_attr( $k ); ?>_d" name="rsv_<?php echo esc_attr( $k ); ?>_d" value="<?php echo esc_attr( $v[ $k . '_d' ] ); ?>" min="<?php echo esc_attr( $min ); ?>" required<?php echo fort_rsv_aria( $errors, $k ); ?>>
					<?php fort_rsv_select( $k . '_t', $times, $v[ $k . '_t' ], '時間', ' aria-label="' . esc_attr( $label ) . 'の時間" required' ); ?>
				</div>
				<?php fort_rsv_err( $errors, $k ); ?>
			</div>
			<?php endforeach; ?>
			<p class="bh-field__note">水曜は定休日です。ご希望日時は確定ではなく、担当者から日程確定のご連絡をします。</p>
			<div class="bh-field__row">
				<div class="bh-field">
					<label for="rsv-adults">大人<span class="bh-req">必須</span></label>
					<?php fort_rsv_select( 'adults', $adults, $v['adults'], '人数', fort_rsv_aria( $errors, 'adults' ) . ' required' ); ?>
					<?php fort_rsv_err( $errors, 'adults' ); ?>
				</div>
				<div class="bh-field">
					<label for="rsv-kids">お子さま<span class="bh-req">必須</span></label>
					<?php fort_rsv_select( 'kids', $kids, $v['kids'], null, fort_rsv_aria( $errors, 'kids' ) . ' required' ); ?>
					<?php fort_rsv_err( $errors, 'kids' ); ?>
				</div>
			</div>
		</fieldset>

		<fieldset class="bh-form__group">
			<legend>お客様について</legend>
			<div class="bh-field">
				<label for="rsv-name">お名前<span class="bh-req">必須</span></label>
				<input class="bh-input" id="rsv-name" name="rsv_name" type="text" autocomplete="name" value="<?php echo esc_attr( $v['name'] ); ?>" required<?php echo fort_rsv_aria( $errors, 'name' ); ?>>
				<?php fort_rsv_err( $errors, 'name' ); ?>
			</div>
			<div class="bh-field">
				<label for="rsv-kana">ふりがな<span class="bh-opt">任意</span></label>
				<input class="bh-input" id="rsv-kana" name="rsv_kana" type="text" value="<?php echo esc_attr( $v['kana'] ); ?>">
			</div>
			<div class="bh-field">
				<label for="rsv-email">メールアドレス<span class="bh-req">必須</span></label>
				<input class="bh-input" id="rsv-email" name="rsv_email" type="email" inputmode="email" autocomplete="email" value="<?php echo esc_attr( $v['email'] ); ?>" required<?php echo fort_rsv_aria( $errors, 'email' ); ?>>
				<?php fort_rsv_err( $errors, 'email' ); ?>
			</div>
			<div class="bh-field">
				<label for="rsv-tel">携帯電話番号<span class="bh-req">必須</span></label>
				<input class="bh-input" id="rsv-tel" name="rsv_tel" type="tel" inputmode="tel" autocomplete="tel" placeholder="09012345678" value="<?php echo esc_attr( $v['tel'] ); ?>" required<?php echo fort_rsv_aria( $errors, 'tel' ); ?>>
				<?php fort_rsv_err( $errors, 'tel' ); ?>
			</div>
			<div class="bh-field bh-field--short">
				<label for="rsv-zip">郵便番号<span class="bh-req">必須</span></label>
				<input class="bh-input" id="rsv-zip" name="rsv_zip" type="text" inputmode="numeric" autocomplete="postal-code" placeholder="7000000" value="<?php echo esc_attr( $v['zip'] ); ?>" required<?php echo fort_rsv_aria( $errors, 'zip' ); ?>>
				<?php fort_rsv_err( $errors, 'zip' ); ?>
			</div>
			<div class="bh-field">
				<label for="rsv-address">ご住所<span class="bh-req">必須</span></label>
				<input class="bh-input" id="rsv-address" name="rsv_address" type="text" autocomplete="street-address" value="<?php echo esc_attr( $v['address'] ); ?>" required<?php echo fort_rsv_aria( $errors, 'address' ); ?>>
				<?php fort_rsv_err( $errors, 'address' ); ?>
			</div>
		</fieldset>

		<fieldset class="bh-form__group">
			<legend>家づくりについて<span class="bh-opt">任意</span></legend>
			<div class="bh-field">
				<label for="rsv-timing">建築希望時期</label>
				<?php fort_rsv_select( 'timing', array_combine( fort_rsv_timings(), fort_rsv_timings() ), $v['timing'] ); ?>
			</div>
			<div class="bh-field">
				<label for="rsv-area">建築希望エリア</label>
				<input class="bh-input" id="rsv-area" name="rsv_area" type="text" placeholder="例：岡山市南区、福山市 など" value="<?php echo esc_attr( $v['area'] ); ?>">
			</div>
			<div class="bh-field">
				<label for="rsv-message">ご質問・ご要望</label>
				<textarea class="bh-input" id="rsv-message" name="rsv_message" rows="4"><?php echo esc_textarea( $v['message'] ); ?></textarea>
			</div>
		</fieldset>

		<div class="bh-field bh-field--agree">
			<label class="bh-check"><input type="checkbox" name="rsv_agree" value="1"<?php checked( $v['agree'], '1' ); ?> required<?php echo fort_rsv_aria( $errors, 'agree' ); ?>>
				<span><?php if ( $privacy ) : ?><a href="<?php echo esc_url( $privacy ); ?>" target="_blank" rel="noopener">プライバシーポリシー</a><?php else : ?>プライバシーポリシー<?php endif; ?>に同意する<span class="bh-req">必須</span></span></label>
			<?php fort_rsv_err( $errors, 'agree' ); ?>
		</div>

		<div class="bh-form__actions"><button type="submit" class="bh-btn bh-btn--fill">入力内容を確認する</button></div>
	</form>
	<?php
}

/** 確認画面 */
function fort_rsv_confirm( $v ) {
	$disp   = fort_rsv_display( $v );
	$labels = fort_rsv_fields();
	?>
	<div class="bh-form" data-rsv-confirm>
		<p class="bh-form__lead">以下の内容で送信します。よろしければ「この内容で予約する」を押してください。</p>
		<dl class="bh-spec bh-form__confirm">
			<?php foreach ( $disp as $k => $val ) : ?><div><dt><?php echo esc_html( $labels[ $k ] ); ?></dt><dd><?php echo nl2br( esc_html( $val ) ); ?></dd></div><?php endforeach; ?>
		</dl>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="bh-form__actions bh-form__actions--confirm">
			<input type="hidden" name="action" value="fort_reservation">
			<?php wp_nonce_field( 'fort_rsv_send', 'fort_rsv_nonce' ); ?>
			<input type="hidden" name="fort_rsv_t" value="<?php echo esc_attr( isset( $_POST['fort_rsv_t'] ) ? absint( $_POST['fort_rsv_t'] ) : time() ); ?>">
			<div class="bh-hp" aria-hidden="true"><label>URL<input type="text" name="fort_rsv_url" tabindex="-1" autocomplete="off"></label></div>
			<?php foreach ( $v as $k => $val ) : ?><input type="hidden" name="rsv_<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php endforeach; ?>
			<button type="submit" class="bh-btn bh-btn--fill">この内容で予約する</button>
		</form>
		<form method="post" action="<?php echo esc_url( fort_url( 'visit' ) ); ?>#rsv" class="bh-form__back">
			<input type="hidden" name="rsv_step" value="edit">
			<?php foreach ( $v as $k => $val ) : ?><input type="hidden" name="rsv_<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php endforeach; ?>
			<button type="submit" class="bh-linkbtn">← 入力内容を修正する</button>
		</form>
	</div>
	<?php
}

/** 完了画面 */
function fort_rsv_done() {
	$area  = isset( $_GET['area'] ) ? sanitize_key( $_GET['area'] ) : '';
	$tels  = array( 'okayama' => fort_opt( 'fort_tel_okayama', '086-236-9600' ), 'fukuyama' => fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) );
	?>
	<div class="bh-form bh-form--done" data-rsv-done>
		<p class="bh-form__done-title">来場予約のお申し込みを受け付けました。</p>
		<p>ご入力のメールアドレスに、受付内容をお送りしました。担当者より、日程確定のご連絡をいたします。</p>
		<p>メールが届かない場合や、お急ぎの場合はお電話ください。<br>
		<?php if ( isset( $tels[ $area ] ) ) : ?><?php echo 'okayama' === $area ? '岡山' : '福山'; ?>スタジオ <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $tels[ $area ] ) ); ?>"><?php echo esc_html( $tels[ $area ] ); ?></a>
		<?php else : ?>岡山スタジオ <?php echo esc_html( $tels['okayama'] ); ?> ／ 福山スタジオ <?php echo esc_html( $tels['fukuyama'] ); ?><?php endif; ?>（9:00〜18:00 / 水曜定休）</p>
		<p class="bh-about__links"><a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">施工事例を見る</a><a class="bh-more" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップへ</a></p>
	</div>
	<script>window.addEventListener('load',function(){if(window.fortTrack)window.fortTrack('reservation_success','<?php echo esc_js( $area ); ?>');});</script>
	<?php
}

/** /visit/ の本体：状態に応じて 入力 / 確認 / 完了 を出す */
function fort_rsv_render() {
	$state = isset( $_GET['rsv'] ) ? sanitize_key( $_GET['rsv'] ) : '';
	$step  = isset( $_POST['rsv_step'] ) ? sanitize_key( $_POST['rsv_step'] ) : '';
	$steps = array( 'input' => '入力', 'confirm' => '確認', 'done' => '完了' );
	$now   = 'input';
	ob_start();
	if ( 'done' === $state ) {
		$now = 'done';
		fort_rsv_done();
	} elseif ( 'confirm' === $step ) {
		$v = fort_rsv_collect( $_POST );
		$errors = fort_rsv_validate( $v );
		if ( $errors ) {
			fort_rsv_form( $v, $errors );
		} else {
			$now = 'confirm';
			$_POST['fort_rsv_t'] = time();
			fort_rsv_confirm( $v );
		}
	} elseif ( 'edit' === $step ) {
		fort_rsv_form( fort_rsv_collect( $_POST ) );
	} else {
		if ( 'expired' === $state ) echo '<div class="bh-form__alert" role="alert"><p>時間が経って送信できませんでした。お手数ですが、もう一度入力してください。</p></div>';
		fort_rsv_form( fort_rsv_defaults() );
	}
	$html = ob_get_clean();
	echo '<ol class="bh-steps" aria-label="予約の手順">';
	foreach ( $steps as $k => $label ) {
		echo '<li' . ( $k === $now ? ' aria-current="step" class="is-current"' : '' ) . '>' . esc_html( $label ) . '</li>';
	}
	echo '</ol>';
	echo $html; // 各関数内でエスケープ済み
}

/** 確認・完了画面は検索結果に出さない */
add_action( 'wp_head', function () {
	if ( is_page( 'visit' ) && ( ! empty( $_POST ) || isset( $_GET['rsv'] ) ) ) echo '<meta name="robots" content="noindex">' . "\n";
}, 1 );
