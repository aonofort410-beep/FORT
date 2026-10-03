<?php
/**
 * STAFF（/staff/）
 * ------------------------------------------------------------
 * ・冒頭：FORT → comFORT → efFORT → FORTune と言葉が入れ替わる（FORTの文字は残ったまま）
 * ・部門で絞り込み（ALL / SALES / DESIGN / ENGINEERING / ADMIN）
 * ・写真はモノクロ → 触れるとカラーに。押すとプロフィールが開く（JSが無ければ個別ページへ）
 * ・写真が無いスタッフはローマ字の頭文字で表示（仮の写真は使わない）
 */
get_header();
$depts = fort_staff_depts();
$q     = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ) ) );
$staff = array_map( 'fort_staff_data', $q->posts );
$has   = array();
foreach ( $staff as $s ) if ( $s['dept'] ) $has[ $s['dept'] ] = true;
$words = array(
	array( '', 'FORT', '', '堅固性' ),
	array( 'com', 'FORT', '', '快適性' ),
	array( 'ef', 'FORT', '', '企業努力' ),
	array( '', 'FORT', 'une', '資産価値' ),
);
?>
	<header class="st-head">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'STAFF', '' ) ) ); ?>
			<p class="bh-label">TEAM</p>
			<h1 class="st-head__title"><span class="bh-nb">担当者まかせにしない、</span><span class="bh-nb">チームの家づくり。</span></h1>
			<!-- 4つの想い：FORTの文字を軸に、前後の文字だけが入れ替わる -->
			<div class="st-words" data-st-words aria-label="FORT・comFORT・efFORT・FORTune">
				<span class="st-words__pre" aria-hidden="true"><?php foreach ( $words as $i => $w ) : ?><i class="<?php echo 0 === $i ? 'is-on' : ''; ?>"><?php echo esc_html( $w[0] ); ?></i><?php endforeach; ?></span><span class="st-words__core" aria-hidden="true">FORT</span><span class="st-words__post" aria-hidden="true"><?php foreach ( $words as $i => $w ) : ?><i class="<?php echo 0 === $i ? 'is-on' : ''; ?>"><?php echo esc_html( $w[2] ); ?></i><?php endforeach; ?></span>
				<span class="st-words__ja" aria-hidden="true"><?php foreach ( $words as $i => $w ) : ?><i class="<?php echo 0 === $i ? 'is-on' : ''; ?>"><?php echo esc_html( $w[3] ); ?></i><?php endforeach; ?></span>
			</div>
			<p class="st-head__lead">堅固性（FORT）・快適性（comFORT）・企業努力（efFORT）・資産価値（FORTune）。この4つの想いを胸に、営業・設計・工務の各コーディネーターと総務が、ひとつのチームとなって理想の住まいをかたちにします。</p>
		</div>
	</header>

	<section class="st-points">
		<div class="bh-wrap">
			<ol class="st-points__list">
				<li><span>01</span><b>情報を共有するチーム</b>お打ち合わせの内容はチーム全体で共有。「言ったのに伝わっていない」をなくします。</li>
				<li><span>02</span><b>専門性を持ち寄る</b>営業・設計・工務それぞれのコーディネーターの視点で、最適なバランスを一緒に考えます。</li>
				<li><span>03</span><b>引渡し後も同じ顔ぶれで</b>建てて終わりではなく、点検やメンテナンスも顔の見えるチームが対応します。</li>
			</ol>
		</div>
	</section>

	<section class="st-members" id="members">
		<div class="bh-wrap">
			<?php if ( count( $has ) > 1 ) : ?>
			<div class="bh-tabs st-tabs" role="group" aria-label="部門で絞り込む" data-st-filter>
				<button type="button" aria-pressed="true" data-dept="">ALL<small><?php echo count( $staff ); ?></small></button>
				<?php foreach ( $depts as $k => $d ) : if ( empty( $has[ $k ] ) ) continue; ?>
				<button type="button" aria-pressed="false" data-dept="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $d[0] ); ?><small><?php echo esc_html( $d[1] ); ?></small></button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<?php if ( $staff ) : ?>
			<ul class="st-grid">
				<?php foreach ( $staff as $i => $s ) : ?>
				<li class="st-card" data-dept="<?php echo esc_attr( $s['dept'] ); ?>" style="--i:<?php echo (int) $i; ?>">
					<a href="<?php echo esc_url( $s['url'] ); ?>" class="st-card__link" data-st-open="<?php echo (int) $s['id']; ?>" data-cursor="PROFILE">
						<figure class="st-card__fig<?php echo $s['photo'] ? '' : ' is-mono'; ?>">
							<?php if ( $s['photo'] ) : ?><img src="<?php echo esc_url( $s['photo'] ); ?>" alt="<?php echo esc_attr( $s['name'] ); ?>" loading="lazy" decoding="async"><?php else : ?><span class="st-card__ini" aria-hidden="true"><?php echo esc_html( $s['ini'] ); ?></span><?php endif; ?>
							<span class="st-card__en" aria-hidden="true"><?php echo esc_html( $s['en'] ); ?></span>
						</figure>
						<p class="st-card__dept"><?php echo esc_html( $s['dept_en'] ); ?></p>
						<h2 class="st-card__name"><?php echo esc_html( $s['name'] ); ?></h2>
						<p class="st-card__role"><?php echo esc_html( $s['role'] ); ?><?php echo $s['cred'] ? '<br><span>' . esc_html( $s['cred'] ) . '</span>' : ''; ?></p>
					</a>
					<!-- プロフィール（モーダルで開く中身） -->
					<template id="st-profile-<?php echo (int) $s['id']; ?>">
						<div class="st-modal__grid">
							<figure class="st-modal__fig<?php echo $s['photo'] ? '' : ' is-mono'; ?>"><?php if ( $s['photo'] ) : ?><img src="<?php echo esc_url( $s['photo'] ); ?>" alt="<?php echo esc_attr( $s['name'] ); ?>"><?php else : ?><span class="st-card__ini"><?php echo esc_html( $s['ini'] ); ?></span><?php endif; ?></figure>
							<div class="st-modal__body">
								<p class="st-card__dept"><?php echo esc_html( $s['dept_en'] ); ?></p>
								<h2 class="st-modal__name"><?php echo esc_html( $s['name'] ); ?></h2>
								<p class="st-modal__en"><?php echo esc_html( $s['en'] ); ?></p>
								<dl class="bh-spec"><div><dt>役職</dt><dd><?php echo esc_html( $s['role'] ); ?></dd></div><?php if ( $s['cred'] ) : ?><div><dt>資格</dt><dd><?php echo esc_html( $s['cred'] ); ?></dd></div><?php endif; ?></dl>
								<?php if ( $s['msg'] ) : ?><p class="st-modal__msg"><?php echo nl2br( esc_html( $s['msg'] ) ); ?></p><?php endif; ?>
							</div>
						</div>
					</template>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else : ?>
			<p class="bh-event__none">スタッフ紹介は準備中です。</p>
			<?php endif; ?>
		</div>
	</section>

	<dialog class="st-modal" id="st-modal" aria-label="スタッフのプロフィール">
		<button type="button" class="st-modal__close" data-st-close aria-label="閉じる"><span></span><span></span></button>
		<div class="st-modal__inner" data-st-body></div>
	</dialog>

	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'staff', 'title' => 'チームに、<br>会いに来てください。' ) ); ?>
<?php get_footer(); ?>
