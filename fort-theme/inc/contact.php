<?php
/**
 * お問い合わせフォーム（/contact/）
 * ------------------------------------------------------------
 * 入力 → 確認 → 送信 → 完了。来場予約（inc/reservation.php）と同じ仕組み・見た目。
 * ・送信内容は窓口のスタジオへメール＋管理画面「お問い合わせ」に保存
 * ・お客様には自動返信メール
 * ・迷惑送信対策：nonce、隠し項目、送信までの最短時間
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', function () {
	register_post_type( 'fort_inquiry', array(
		'labels'          => array( 'name' => 'お問い合わせ', 'singular_name' => 'お問い合わせ', 'all_items' => 'お問い合わせ一覧', 'edit_item' => 'お問い合わせの内容' ),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-format-chat',
		'menu_position'   => 5,
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

function fort_cq_kinds() {
	return array( '家づくりのご相談', '商品・価格について', '土地探しについて', '施工事例・見学会について', 'アフターメンテナンスについて', '採用について', 'その他' );
}
function fort_cq_desks() {
	return array( 'okayama' => '岡山スタジオ', 'fukuyama' => '福山スタジオ', 'any' => 'どちらでもよい' );
}
function fort_cq_fields() {
	return array( 'kind' => 'お問い合わせの種類', 'desk' => 'ご希望の窓口', 'name' => 'お名前', 'kana' => 'ふりがな', 'email' => 'メールアドレス', 'tel' => '電話番号', 'message' => 'お問い合わせ内容' );
}

function fort_cq_collect( $src ) {
	$g = function ( $k ) use ( $src ) { $k = 'cq_' . $k; return isset( $src[ $k ] ) ? trim( wp_unslash( $src[ $k ] ) ) : ''; };
	return array(
		'kind'    => sanitize_text_field( $g( 'kind' ) ),
		'desk'    => sanitize_key( $g( 'desk' ) ),
		'name'    => sanitize_text_field( $g( 'name' ) ),
		'kana'    => sanitize_text_field( $g( 'kana' ) ),
		'email'   => sanitize_email( $g( 'email' ) ),
		'tel'     => preg_replace( '/[^\d]/', '', mb_convert_kana( $g( 'tel' ), 'n' ) ),
		'message' => sanitize_textarea_field( $g( 'message' ) ),
		'agree'   => $g( 'agree' ) ? '1' : '',
	);
}

function fort_cq_validate( $v ) {
	$e = array();
	if ( ! in_array( $v['kind'], fort_cq_kinds(), true ) ) $e['kind'] = 'お問い合わせの種類を選んでください。';
	if ( ! isset( fort_cq_desks()[ $v['desk'] ] ) ) $e['desk'] = 'ご希望の窓口を選んでください。';
	if ( '' === $v['name'] ) $e['name'] = 'お名前を入力してください。';
	if ( ! is_email( $v['email'] ) ) $e['email'] = 'メールアドレスを正しく入力してください。';
	if ( '' !== $v['tel'] && ! preg_match( '/^0\d{9,10}$/', $v['tel'] ) ) $e['tel'] = '電話番号を数字で入力してください（例：090-1234-5678）。';
	if ( mb_strlen( $v['message'] ) < 5 ) $e['message'] = 'お問い合わせ内容を入力してください。';
	if ( ! $v['agree'] ) $e['agree'] = 'プライバシーポリシーへの同意が必要です。';
	return $e;
}

function fort_cq_display( $v ) {
	$desks = fort_cq_desks();
	return array_filter( array(
		'kind'    => $v['kind'],
		'desk'    => $desks[ $v['desk'] ] ?? '',
		'name'    => $v['name'],
		'kana'    => $v['kana'],
		'email'   => $v['email'],
		'tel'     => $v['tel'],
		'message' => $v['message'],
	), 'strlen' );
}

/* ---------- 送信処理 ---------- */
function fort_cq_handle() {
	$v = fort_cq_collect( $_POST );
	if ( ! isset( $_POST['fort_cq_nonce'] ) || ! wp_verify_nonce( $_POST['fort_cq_nonce'], 'fort_cq_send' ) || fort_cq_validate( $v ) ) {
		wp_safe_redirect( add_query_arg( 'cq', 'expired', fort_url( 'contact' ) ) ); exit;
	}
	$t = isset( $_POST['fort_cq_t'] ) ? (int) $_POST['fort_cq_t'] : 0;
	if ( ! empty( $_POST['fort_cq_url'] ) || ! $t || time() - $t < 3 ) {
		wp_safe_redirect( add_query_arg( 'cq', 'done', fort_url( 'contact' ) ) ); exit;
	}
	$disp   = fort_cq_display( $v );
	$labels = fort_cq_fields();
	$lines  = array();
	foreach ( $disp as $k => $val ) $lines[] = '■ ' . $labels[ $k ] . "\n" . $val;
	$body = implode( "\n\n", $lines );

	wp_insert_post( array(
		'post_type'    => 'fort_inquiry',
		'post_status'  => 'private',
		'post_title'   => wp_date( 'Y/m/d H:i' ) . '　' . $v['kind'] . '　' . $v['name'] . ' 様',
		'post_content' => $body,
	) );

	$to = in_array( $v['desk'], array( 'okayama', 'fukuyama' ), true ) ? fort_opt( 'fort_mail_' . $v['desk'], '' ) : '';
	$to = $to ? $to : get_option( 'admin_email' );
	wp_mail( $to, '【お問い合わせ】' . $v['kind'] . '　' . $v['name'] . ' 様', "ホームページからお問い合わせが届きました。\n\n" . $body, array( 'Reply-To: ' . $v['name'] . ' <' . $v['email'] . '>' ) );

	$reply = $v['name'] . " 様\n\n" . get_bloginfo( 'name' ) . " です。お問い合わせをありがとうございます。\n以下の内容で受け付けました。担当者より折り返しご連絡いたします。\n\n"
		. $body
		. "\n\n――――――――――――――――\n" . get_bloginfo( 'name' ) . "\n"
		. '岡山スタジオ ' . fort_opt( 'fort_tel_okayama', '086-236-9600' ) . ' ／ 福山スタジオ ' . fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) . "（9:00〜18:00 / 水曜定休）\n"
		. home_url( '/' ) . "\n";
	wp_mail( $v['email'], '【' . get_bloginfo( 'name' ) . '】お問い合わせを受け付けました', $reply );

	wp_safe_redirect( add_query_arg( 'cq', 'done', fort_url( 'contact' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_fort_contact', 'fort_cq_handle' );
add_action( 'admin_post_fort_contact', 'fort_cq_handle' );

/* ---------- 画面 ---------- */
function fort_cq_select( $name, $options, $current, $attrs = '' ) {
	echo '<select class="bh-input" id="cq-' . esc_attr( $name ) . '" name="cq_' . esc_attr( $name ) . '"' . $attrs . '><option value="">選択してください</option>';
	foreach ( $options as $val => $label ) echo '<option value="' . esc_attr( $val ) . '"' . selected( (string) $current, (string) $val, false ) . '>' . esc_html( $label ) . '</option>';
	echo '</select>';
}

function fort_cq_form( $v, $errors = array() ) {
	$privacy = fort_url( 'privacy' );
	$text = function ( $k, $label, $type, $req, $extra = '' ) use ( $v, $errors ) { ?>
			<div class="bh-field">
				<label for="cq-<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $label ); ?><span class="<?php echo $req ? 'bh-req' : 'bh-opt'; ?>"><?php echo $req ? '必須' : '任意'; ?></span></label>
				<input class="bh-input" id="cq-<?php echo esc_attr( $k ); ?>" name="cq_<?php echo esc_attr( $k ); ?>" type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $v[ $k ] ); ?>"<?php echo $extra; // 固定の属性のみ ?><?php echo $req ? ' required' : ''; ?><?php echo fort_rsv_aria( $errors, $k ); ?>>
				<?php fort_rsv_err( $errors, $k ); ?>
			</div>
	<?php };
	if ( $errors ) : ?>
	<div class="bh-form__alert" role="alert" tabindex="-1" id="rsv-alert"><p>入力内容を確認してください（<?php echo count( $errors ); ?>か所）。</p></div>
	<?php endif; ?>
	<form class="bh-form" method="post" action="<?php echo esc_url( fort_url( 'contact' ) ); ?>#cq" novalidate>
		<input type="hidden" name="cq_step" value="confirm">
		<fieldset class="bh-form__group">
			<legend>お問い合わせについて</legend>
			<div class="bh-field">
				<label for="cq-kind">お問い合わせの種類<span class="bh-req">必須</span></label>
				<?php fort_cq_select( 'kind', array_combine( fort_cq_kinds(), fort_cq_kinds() ), $v['kind'], fort_rsv_aria( $errors, 'kind' ) . ' required' ); ?>
				<?php fort_rsv_err( $errors, 'kind' ); ?>
			</div>
			<div class="bh-field">
				<label for="cq-desk">ご希望の窓口<span class="bh-req">必須</span></label>
				<?php fort_cq_select( 'desk', fort_cq_desks(), $v['desk'], fort_rsv_aria( $errors, 'desk' ) . ' required' ); ?>
				<?php fort_rsv_err( $errors, 'desk' ); ?>
			</div>
			<div class="bh-field">
				<label for="cq-message">お問い合わせ内容<span class="bh-req">必須</span></label>
				<textarea class="bh-input" id="cq-message" name="cq_message" rows="6" required<?php echo fort_rsv_aria( $errors, 'message' ); ?>><?php echo esc_textarea( $v['message'] ); ?></textarea>
				<?php fort_rsv_err( $errors, 'message' ); ?>
			</div>
		</fieldset>
		<fieldset class="bh-form__group">
			<legend>お客様について</legend>
			<?php
			$text( 'name', 'お名前', 'text', true, ' autocomplete="name"' );
			$text( 'kana', 'ふりがな', 'text', false );
			$text( 'email', 'メールアドレス', 'email', true, ' inputmode="email" autocomplete="email"' );
			$text( 'tel', '電話番号', 'tel', false, ' inputmode="tel" autocomplete="tel" placeholder="09012345678"' );
			?>
		</fieldset>
		<div class="bh-field bh-field--agree">
			<label class="bh-check"><input type="checkbox" name="cq_agree" value="1"<?php checked( $v['agree'], '1' ); ?> required<?php echo fort_rsv_aria( $errors, 'agree' ); ?>>
				<span><?php if ( $privacy ) : ?><a href="<?php echo esc_url( $privacy ); ?>" target="_blank" rel="noopener">プライバシーポリシー</a><?php else : ?>プライバシーポリシー<?php endif; ?>に同意する<span class="bh-req">必須</span></span></label>
			<?php fort_rsv_err( $errors, 'agree' ); ?>
		</div>
		<div class="bh-form__actions"><button type="submit" class="bh-btn bh-btn--fill">入力内容を確認する</button></div>
	</form>
	<?php
}

function fort_cq_confirm( $v ) {
	$disp   = fort_cq_display( $v );
	$labels = fort_cq_fields();
	?>
	<div class="bh-form">
		<p class="bh-form__lead">以下の内容で送信します。よろしければ「この内容で送信する」を押してください。</p>
		<dl class="bh-spec bh-form__confirm">
			<?php foreach ( $disp as $k => $val ) : ?><div><dt><?php echo esc_html( $labels[ $k ] ); ?></dt><dd><?php echo nl2br( esc_html( $val ) ); ?></dd></div><?php endforeach; ?>
		</dl>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="bh-form__actions bh-form__actions--confirm">
			<input type="hidden" name="action" value="fort_contact">
			<?php wp_nonce_field( 'fort_cq_send', 'fort_cq_nonce' ); ?>
			<input type="hidden" name="fort_cq_t" value="<?php echo esc_attr( time() ); ?>">
			<div class="bh-hp" aria-hidden="true"><label>URL<input type="text" name="fort_cq_url" tabindex="-1" autocomplete="off"></label></div>
			<?php foreach ( $v as $k => $val ) : ?><input type="hidden" name="cq_<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php endforeach; ?>
			<button type="submit" class="bh-btn bh-btn--fill">この内容で送信する</button>
		</form>
		<form method="post" action="<?php echo esc_url( fort_url( 'contact' ) ); ?>#cq" class="bh-form__back">
			<input type="hidden" name="cq_step" value="edit">
			<?php foreach ( $v as $k => $val ) : ?><input type="hidden" name="cq_<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php endforeach; ?>
			<button type="submit" class="bh-linkbtn">← 入力内容を修正する</button>
		</form>
	</div>
	<?php
}

function fort_cq_done() {
	?>
	<div class="bh-form bh-form--done">
		<p class="bh-form__done-title">お問い合わせを受け付けました。</p>
		<p>ご入力のメールアドレスに、受付内容をお送りしました。担当者より折り返しご連絡いたします。</p>
		<p>お急ぎの場合はお電話ください。<br>岡山スタジオ <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', fort_opt( 'fort_tel_okayama', '086-236-9600' ) ) ); ?>"><?php echo esc_html( fort_opt( 'fort_tel_okayama', '086-236-9600' ) ); ?></a> ／ 福山スタジオ <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) ) ); ?>"><?php echo esc_html( fort_opt( 'fort_tel_fukuyama', '084-982-7404' ) ); ?></a>（9:00〜18:00 / 水曜定休）</p>
		<p class="bh-about__links"><a class="bh-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">施工事例を見る</a><a class="bh-more" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップへ</a></p>
	</div>
	<script>window.addEventListener('load',function(){window.fortTrack&&window.fortTrack('contact_complete','');});</script>
	<?php
}

function fort_cq_render() {
	$state = isset( $_GET['cq'] ) ? sanitize_key( $_GET['cq'] ) : '';
	$step  = isset( $_POST['cq_step'] ) ? sanitize_key( $_POST['cq_step'] ) : '';
	$now   = 'input';
	ob_start();
	if ( 'done' === $state ) {
		$now = 'done';
		fort_cq_done();
	} elseif ( 'confirm' === $step ) {
		$v = fort_cq_collect( $_POST );
		$errors = fort_cq_validate( $v );
		if ( $errors ) { fort_cq_form( $v, $errors ); } else { $now = 'confirm'; fort_cq_confirm( $v ); }
	} elseif ( 'edit' === $step ) {
		fort_cq_form( fort_cq_collect( $_POST ) );
	} else {
		if ( 'expired' === $state ) echo '<div class="bh-form__alert" role="alert"><p>時間が経って送信できませんでした。お手数ですが、もう一度入力してください。</p></div>';
		$v = fort_cq_collect( array() );
		$area = isset( $_GET['area'] ) ? sanitize_key( $_GET['area'] ) : '';
		if ( isset( fort_cq_desks()[ $area ] ) ) $v['desk'] = $area;
		fort_cq_form( $v );
	}
	$html = ob_get_clean();
	echo '<ol class="bh-steps" aria-label="送信の手順">';
	foreach ( array( 'input' => '入力', 'confirm' => '確認', 'done' => '完了' ) as $k => $label ) echo '<li' . ( $k === $now ? ' aria-current="step" class="is-current"' : '' ) . '>' . esc_html( $label ) . '</li>';
	echo '</ol>';
	echo $html; // 各関数内でエスケープ済み
}

add_action( 'wp_head', function () {
	if ( is_page( 'contact' ) && ( ! empty( $_POST ) || isset( $_GET['cq'] ) ) ) echo '<meta name="robots" content="noindex">' . "\n";
}, 1 );
