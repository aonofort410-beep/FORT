<?php
/*
 * Template Name: FORT DESIGN（自由設計・特設）
 * ------------------------------------------------------------
 * FORT DESIGN だけの特設ページ。黒を基調に、スクロールで物語が進む。
 *   OPENING（文字が浮かぶ）→ APERTURE（窓から写真が広がる）→ CONCEPT
 *   → CHAPTERS（横に流れる3章）→ DRAWING（図面が描かれる）→ FOR YOU
 *   → WORKS → PRICE → WORDS → VISIT
 * ・情報の順番は他の商品ページと同じ（考え方 → 向いている人 → 自由度 → 実例 → 価格 → 予約）
 * ・動きは assets/design.js が CSS変数 --p（0〜1の進み具合）を更新するだけ。描画は CSS
 * ・「動きを減らす」設定の端末では演出を止め、普通の縦長ページとして読める
 */
add_filter( 'body_class', function ( $c ) { $c[] = 'dz-page'; return $c; } );
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'fort-dz-font', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap', array(), null );
	wp_enqueue_script( 'fort-design', get_template_directory_uri() . '/assets/design.js', array(), '1.0.0', true );
} );
get_header();
$img   = get_template_directory_uri() . '/assets/images/';
$it    = fort_house_items()['design'];
$works = get_posts( array( 'post_type' => 'works', 'posts_per_page' => 8, 'meta_key' => 'fort_w_series', 'meta_value' => 'design' ) );
$works = array_values( array_filter( $works, 'has_post_thumbnail' ) );
$title = str_split( 'FORT DESIGN' );
?>
	<div class="dz">

	<!-- OPENING：文字が1文字ずつ浮かぶ -->
	<section class="dz-open" aria-labelledby="dz-title">
		<p class="dz-open__eyebrow">FULL ORDER HOUSE</p>
		<h1 class="dz-open__title" id="dz-title" aria-label="FORT DESIGN">
			<?php foreach ( $title as $i => $ch ) : ?><span style="--i:<?php echo (int) $i; ?>" aria-hidden="true"><?php echo ' ' === $ch ? '&nbsp;' : esc_html( $ch ); ?></span><?php endforeach; ?>
		</h1>
		<span class="dz-open__rule" aria-hidden="true"></span>
		<p class="dz-open__sub">設計士とつくる、唯一無二の住まい。</p>
		<p class="dz-open__scroll" aria-hidden="true">SCROLL</p>
	</section>

	<!-- APERTURE：小さな窓から、写真が画面いっぱいに広がる -->
	<section class="dz-ap" data-progress aria-label="FORT DESIGN の住まい">
		<div class="dz-ap__sticky">
			<figure class="dz-ap__fig"><img src="<?php echo esc_url( fort_media( 'design' ) ); ?>" alt="FORT DESIGN の住まい" width="2000" height="1333" decoding="async"></figure>
			<p class="dz-ap__words"><span>土地の個性、</span><span>光の入り方、</span><span>家族の時間。</span></p>
		</div>
	</section>

	<!-- CONCEPT -->
	<section class="dz-concept">
		<div class="dz-wrap">
			<p class="dz-label">CONCEPT</p>
			<h2 class="dz-concept__title" data-dz-lines>
				<span>「ちょうどいい」を超えて、</span>
				<span>理想を、その先へ。</span>
			</h2>
			<div class="dz-concept__body" data-dz-lines>
				<span>性能・デザイン・価格のバランスを大切にするFORT。</span>
				<span>その思想はそのままに、FORT DESIGN は</span>
				<span>“もう一段上の理想”を叶えるための自由設計です。</span>
				<span>素材の質感、空間の余白、光と影の設計まで。</span>
				<span>暮らす人のためだけに、ていねいに仕立てます。</span>
			</div>
		</div>
	</section>

	<!-- CHAPTERS：縦スクロールで横に流れる3章 -->
	<section class="dz-ch" data-progress aria-label="FORT DESIGN の3つのこだわり">
		<div class="dz-ch__sticky">
			<div class="dz-ch__track">
				<article class="dz-ch__panel">
					<figure class="dz-ch__fig"><img src="<?php echo esc_url( $img . 'hero.jpg' ); ?>" alt="素材の質感が見えるキッチンとダイニング" width="2400" height="1600" loading="lazy" decoding="async"></figure>
					<div class="dz-ch__text">
						<p class="dz-ch__no">01 — MATERIAL</p>
						<h3>本物の素材が、<br>時を味方にする。</h3>
						<p>無垢材、塗り壁、石、タイル。年月を重ねるほどに表情を増す素材を、適材適所で。深まる質感が、住まいに静かな風格を与えます。</p>
					</div>
				</article>
				<article class="dz-ch__panel">
					<figure class="dz-ch__fig"><img src="<?php echo esc_url( fort_media( 'design' ) ); ?>" alt="光と余白のある空間" width="2000" height="1333" loading="lazy" decoding="async"></figure>
					<div class="dz-ch__text">
						<p class="dz-ch__no">02 — LIGHT &amp; SPACE</p>
						<h3>光を、<br>間取りの主役に。</h3>
						<p>窓の位置・高さ・大きさを一邸ごとに計算し、時間とともに移ろう光を取り込みます。余白のある空間が、暮らしにゆとりをもたらします。</p>
					</div>
				</article>
				<article class="dz-ch__panel dz-ch__panel--site">
					<svg class="dz-ch__contour" viewBox="0 0 600 600" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
						<?php for ( $r = 1; $r <= 9; $r++ ) : $a = 40 + $r * 26; $b = 28 + $r * 20; ?>
						<ellipse cx="<?php echo 300 + $r * 6; ?>" cy="<?php echo 320 - $r * 4; ?>" rx="<?php echo $a; ?>" ry="<?php echo $b; ?>" transform="rotate(<?php echo -18 + $r * 3; ?> 300 300)"></ellipse>
						<?php endfor; ?>
					</svg>
					<div class="dz-ch__text">
						<p class="dz-ch__no">03 — SITE</p>
						<h3>土地の個性を、<br>価値に変える。</h3>
						<p>変形地・狭小地・眺望のある敷地。条件を制約ではなく個性ととらえ、その土地でしか生まれない住まいへと昇華させます。</p>
					</div>
				</article>
			</div>
			<div class="dz-ch__bar" aria-hidden="true"><span></span></div>
		</div>
	</section>

	<!-- DRAWING：スクロールで図面が描かれる -->
	<section class="dz-draw" data-progress aria-label="対話から図面へ">
		<div class="dz-draw__sticky">
			<div class="dz-wrap dz-draw__grid">
				<div class="dz-draw__head">
					<p class="dz-label">PROCESS</p>
					<h2 class="dz-draw__title">対話から、<br>一本の線へ。</h2>
					<ol class="dz-draw__steps">
						<li style="--i:0"><span>HEARING</span>暮らしと理想を、聞かせていただく</li>
						<li style="--i:1"><span>SITE</span>土地の光・風・眺めを読む</li>
						<li style="--i:2"><span>DRAWING</span>その家族のためだけの線を引く</li>
						<li style="--i:3"><span>BUILD</span>図面を、住まいへ</li>
					</ol>
				</div>
				<svg class="dz-draw__svg" viewBox="0 0 640 440" aria-hidden="true">
					<g class="dz-draw__lines" fill="none">
						<path pathLength="1" d="M40 40 H600 V400 H40 Z"/>
						<path pathLength="1" d="M40 220 H230 M230 40 V160 M230 200 V400 M330 40 V130 M330 300 V400"/>
						<path pathLength="1" d="M330 130 H470 V300 H330 Z"/>
						<path pathLength="1" d="M470 220 H600 M520 40 V120 M520 160 V220"/>
						<path pathLength="1" d="M230 160 A40 40 0 0 1 270 200 M330 260 A40 40 0 0 0 290 300 M520 120 A40 40 0 0 1 560 160"/>
						<path pathLength="1" d="M100 40 H180 M400 400 H540 M600 270 V350 M40 280 V350"/>
					</g>
					<g class="dz-draw__notes">
						<text x="120" y="135">LIVING</text>
						<text x="365" y="222">COURT</text>
						<text x="110" y="315">KITCHEN</text>
						<text x="520" y="320">ROOM</text>
					</g>
				</svg>
			</div>
		</div>
	</section>

	<!-- FOR YOU（他の商品ページと同じ項目） -->
	<section class="dz-for">
		<div class="dz-wrap dz-for__grid">
			<div>
				<p class="dz-label">FOR YOU</p>
				<h2 class="dz-h2">こんな方に。</h2>
			</div>
			<div>
				<p class="dz-for__list" data-dz-lines><?php foreach ( $it['for'] as $f ) : ?><span><?php echo esc_html( $f ); ?></span><?php endforeach; ?></p>
				<dl class="dz-dl">
					<div><dt>設計の自由度</dt><dd><?php echo esc_html( $it['freedom'] ); ?></dd></div>
					<div><dt>選べる範囲</dt><dd><?php echo esc_html( $it['choose'] ); ?></dd></div>
					<div><dt>対応できる土地</dt><dd>変形地・狭小地など、難しい土地にも対応</dd></div>
				</dl>
			</div>
		</div>
	</section>

	<?php if ( $works ) : ?>
	<!-- WORKS：FORT DESIGN の実例（横にスクロール） -->
	<section class="dz-works">
		<div class="dz-wrap"><p class="dz-label">WORKS</p><h2 class="dz-h2">FORT DESIGN の実例</h2></div>
		<ul class="dz-works__rail" data-drag>
			<?php foreach ( $works as $p ) : ?>
			<li><a href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-cursor="VIEW">
				<figure><?php echo get_the_post_thumbnail( $p, 'fort-hero', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?></figure>
				<p><?php echo esc_html( get_the_title( $p ) ); ?></p>
			</a></li>
			<?php endforeach; ?>
		</ul>
		<div class="dz-wrap"><a class="dz-more" href="<?php echo esc_url( fort_url( 'works' ) ); ?>">すべての施工事例</a></div>
	</section>
	<?php endif; ?>

	<!-- PRICE -->
	<section class="dz-price">
		<div class="dz-wrap dz-for__grid">
			<div><p class="dz-label">PRICE</p><h2 class="dz-h2">価格の考え方</h2></div>
			<div>
				<p class="dz-price__num"><?php echo esc_html( $it['price'] ); ?></p>
				<p class="dz-price__note"><?php echo esc_html( $it['price_note'] ); ?></p>
				<p class="dz-price__text">完全自由設計のため、まずはご予算とご要望をお聞かせください。どこに力を注ぎ、どこを抑えるか。最適なバランスを一緒に考えます。</p>
				<p class="dz-links"><a class="dz-more" href="<?php echo esc_url( fort_url( 'flow' ) ); ?>">家づくりの流れ</a><a class="dz-more" href="<?php echo esc_url( fort_url( 'performance' ) ); ?>">構造・性能</a><a class="dz-more" href="<?php echo esc_url( fort_url( 'house' ) ); ?>">3つを比べる</a></p>
			</div>
		</div>
	</section>

	<!-- WORDS -->
	<section class="dz-words">
		<div class="dz-wrap">
			<blockquote data-dz-lines>
				<span>家は、家族のいちばん長い時間を過ごす場所。</span>
				<span>だからこそ、妥協のない一邸を。</span>
			</blockquote>
			<p class="dz-words__by">FORT DESIGN</p>
		</div>
	</section>

	<!-- VISIT -->
	<section class="dz-visit" id="visit">
		<div class="dz-wrap">
			<p class="dz-label">CONTACT</p>
			<h2 class="dz-visit__title">あなたの理想を、<br>聞かせてください。</h2>
			<p class="dz-visit__text">FORT DESIGN の家づくりは、対話からはじまります。<br>まずはスタジオで、お話を聞かせてください。</p>
			<div class="dz-visit__choices">
				<a href="<?php echo esc_url( fort_visit_url( array( 'area' => 'okayama' ) ) ); ?>" data-track="reservation_start" data-track-label="design_okayama" data-cursor="VISIT"><span>岡山スタジオで相談する</span><small>OKAYAMA</small></a>
				<a href="<?php echo esc_url( fort_visit_url( array( 'area' => 'fukuyama' ) ) ); ?>" data-track="reservation_start" data-track-label="design_fukuyama" data-cursor="VISIT"><span>福山スタジオで相談する</span><small>FUKUYAMA</small></a>
			</div>
			<p class="dz-links"><a class="dz-more" href="<?php echo esc_url( fort_url( 'request' ) ); ?>">資料請求</a><a class="dz-more" href="<?php echo esc_url( fort_url( 'contact' ) ); ?>">お問い合わせ</a></p>
		</div>
	</section>

	</div>
<?php get_footer(); ?>
