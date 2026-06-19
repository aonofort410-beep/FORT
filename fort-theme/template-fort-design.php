<?php
/* Template Name: FORT DESIGN（自由設計・特設） */
add_filter( 'body_class', function ( $c ) { $c[] = 'lux'; return $c; } );
get_header();
$img = get_template_directory_uri() . "/assets/images/";
?>

    <section class="lux-hero">
      <div class="lux-hero__media"><img src="<?php echo $img; ?>kitchen-view.jpg" alt="FORT DESIGN の住まい" loading="eager" decoding="async"></div>
      <div class="container lux-hero__inner">
        <p class="lux-hero__eyebrow" data-reveal>FORT DESIGN</p>
        <h1 class="lux-hero__title" data-reveal>設計士とつくる、<br>唯一無二の住まい。</h1>
        <p class="lux-hero__lead" data-reveal>
          土地の個性、光の入り方、家族の時間。<br>
          そのすべてを読み解き、世界にひとつの邸宅を描く。<br>
          FORTのもっとも自由な、フルオーダーの家づくり。
        </p>
      </div>
      <span class="lux-hero__scroll">SCROLL</span>
    </section>

    <section class="lux-section lux-section--dark">
      <div class="container">
        <p class="lux-label" data-reveal>CONCEPT</p>
        <h2 class="lux-title" data-reveal>「ちょうどいい」を超えて、<br>理想を、その先へ。</h2>
        <p class="lux-text" data-reveal>
          性能・デザイン・価格のバランスを大切にするFORT。その思想はそのままに、
          FORT DESIGN は“もう一段上の理想”を叶えるための自由設計です。
          素材の質感、空間の余白、光と影の設計まで。暮らす人のためだけに、ていねいに仕立てます。
        </p>
      </div>
    </section>

    <section class="lux-figure lux-figure--fixed" style="background-image:url('<?php echo $img; ?>ldk.jpg')" aria-hidden="true"></section>

    <section class="lux-section lux-section--mid">
      <div class="container">
        <div class="lux-feature" data-reveal>
          <figure class="lux-feature__figure"><img src="<?php echo $img; ?>ldk.jpg" alt="素材へのこだわり" loading="lazy"></figure>
          <div>
            <p class="lux-feature__num">01 — MATERIAL</p>
            <h3 class="lux-feature__title">本物の素材が、時を味方にする。</h3>
            <p class="lux-feature__text">無垢材、塗り壁、石、タイル。年月を重ねるほどに表情を増す自然素材を、適材適所で。年月とともに深まる質感が、住まいに静かな風格を与えます。</p>
          </div>
        </div>
        <div class="lux-feature" data-reveal>
          <figure class="lux-feature__figure"><img src="<?php echo $img; ?>kitchen-view.jpg" alt="光と余白の設計" loading="lazy"></figure>
          <div>
            <p class="lux-feature__num">02 — LIGHT &amp; SPACE</p>
            <h3 class="lux-feature__title">光を、間取りの主役に。</h3>
            <p class="lux-feature__text">窓の位置・高さ・大きさを一邸ごとに計算し、時間とともに移ろう光を住まいに取り込みます。余白のある空間が、暮らしに豊かなゆとりをもたらします。</p>
          </div>
        </div>
        <div class="lux-feature" data-reveal>
          <figure class="lux-feature__figure"><img src="<?php echo $img; ?>exterior.jpg" alt="土地を読む設計" loading="lazy"></figure>
          <div>
            <p class="lux-feature__num">03 — SITE</p>
            <h3 class="lux-feature__title">土地の個性を、価値に変える。</h3>
            <p class="lux-feature__text">変形地・狭小地・眺望のある敷地。条件を制約ではなく個性ととらえ、その土地でしか生まれない住まいへと昇華させます。</p>
          </div>
        </div>
      </div>
    </section>

    <section class="lux-section lux-section--dark">
      <div class="container">
        <p class="lux-label" data-reveal>GALLERY</p>
        <h2 class="lux-title" data-reveal>FORT DESIGN の実例</h2>
        <p class="lux-text" data-reveal>これまでFORTが手がけた、自由設計の住まいの一部をご紹介します。</p>
        <div class="lux-gallery" data-reveal style="margin-top:36px;">
          <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>"><img src="<?php echo $img; ?>hero.jpg" alt="自由設計の事例 1" loading="lazy"></a>
          <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>"><img src="<?php echo $img; ?>ldk.jpg" alt="自由設計の事例 2" loading="lazy"></a>
          <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>"><img src="<?php echo $img; ?>kitchen-view.jpg" alt="自由設計の事例 3" loading="lazy"></a>
          <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>"><img src="<?php echo $img; ?>exterior.jpg" alt="自由設計の事例 4" loading="lazy"></a>
          <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>"><img src="<?php echo $img; ?>niche.jpg" alt="自由設計の事例 5" loading="lazy"></a>
          <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>"><img src="<?php echo $img; ?>hero.jpg" alt="自由設計の事例 6" loading="lazy"></a>
        </div>
      </div>
    </section>

    <section class="lux-figure lux-figure--fixed" style="background-image:url('<?php echo $img; ?>exterior.jpg')" aria-hidden="true"></section>

    <section class="lux-section lux-section--mid">
      <div class="container">
        <p class="lux-label" data-reveal>PRICE</p>
        <h2 class="lux-title" data-reveal>参考価格</h2>
        <p class="lux-text" data-reveal>
          建物本体価格 <strong style="color:#fff;font-size:1.3em;">2,500万円〜</strong>（税別）<br>
          <span style="font-size:13px;color:#9aa0a6;">※ 完全自由設計のため、仕様・面積・土地条件により変動します。<br>
          まずはご予算とご要望をお聞かせください。最適なプランをご提案します。</span>
        </p>
      </div>
    </section>

    <section class="lux-section lux-section--dark">
      <div class="container">
        <div class="lux-quote" data-reveal>
          <p>「家は、家族のいちばん長い時間を過ごす場所。<br>だからこそ、妥協のない一邸を。」</p>
          <span>FORT DESIGN ／ 設計チーム</span>
        </div>
      </div>
    </section>

    <section class="lux-section lux-section--mid">
      <div class="container lux-cta">
        <p class="lux-label" data-reveal>CONTACT</p>
        <h2 class="lux-title" data-reveal>あなたの理想を、聞かせてください。</h2>
        <p class="lux-text" data-reveal>FORT DESIGN の家づくりは、対話からはじまります。<br>まずはお気軽にご相談・ご来場ください。</p>
        <div style="margin-top:34px;display:flex;gap:14px;justify-content:center;flex-wrap:wrap;" data-reveal>
          <a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--gold">ご来場予約</a>
          <a href="<?php echo esc_url( home_url( '/request/' ) ); ?>" class="btn btn--ghostlight">資料請求</a>
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--ghostlight">お問合せ</a>
        </div>
      </div>
    </section>

<?php get_footer(); ?>
