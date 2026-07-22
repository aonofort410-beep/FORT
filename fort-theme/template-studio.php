<?php
/*
 * Template Name: スタジオ・モデルハウス
 * 固定ページ用テンプレート（独立ページ）
 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>


    <section class="subhero">
      <div class="subhero__media">
        <img src="<?php echo $img; ?>exterior.jpg" alt="" aria-hidden="true" loading="eager" decoding="async">
        <div class="subhero__overlay"></div>
      </div>
      <div class="container subhero__inner">
        <p class="subhero__eyebrow" data-reveal>STUDIO</p>
        <h1 class="subhero__title" data-reveal>スタジオ・モデルハウス案内</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>STUDIO</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          家づくりのご相談は、岡山・福山の2つのスタジオで承っています。<br>
          実際の素材に触れたり、モデルハウスで暮らしを体感したり。
          まずはお近くのスタジオへ、お気軽にお越しください。
        </p>

        <!-- ▼ 岡山スタジオ -->
        <article class="product" id="okayama">
          <figure class="product__figure" data-reveal>
            <!-- IMAGE: 岡山スタジオの写真（推奨 1200×800px） -->
            <img src="<?php echo $img; ?>studio-okayama.jpg" alt="FORT 岡山スタジオ" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <h2 class="product__name">岡山スタジオ</h2>
            <span class="product__type">OKAYAMA STUDIO</span>
            <dl class="info-list">
              <div><dt>住所</dt><dd>〒700-0977<br>岡山県岡山市北区問屋町9-101 タイルビル 1F</dd></div>
              <div><dt>電話番号</dt><dd><a href="tel:0862369600">086-236-9600</a></dd></div>
              <div><dt>営業時間</dt><dd>9:00〜18:00</dd></div>
              <div><dt>定休日</dt><dd>水曜日</dd></div>
              <div><dt>ご相談</dt><dd>ご予約優先。お子さま連れも歓迎です。</dd></div>
            </dl>
            <a href="https://share.google/80W9x7bPLtNcHsrXQ" class="btn btn--outline" target="_blank" rel="noopener">Googleマップで開く</a>
            <a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent">岡山スタジオに来場予約する</a>
          </div>
        </article>

        <!-- 岡山スタジオの地図 -->
        <div class="map-frame" data-reveal style="margin-top:28px;">
          <!-- 地図：GoogleマップのiframeをこのIMGと差し替えできます -->
          <img src="<?php echo $img; ?>map-okayama.jpg" alt="岡山スタジオの地図" loading="lazy" decoding="async">
        </div>
      </div>
    </section>

    <section class="section section--gray">
      <div class="container">
        <!-- ▼ 福山スタジオ -->
        <article class="product" id="fukuyama">
          <figure class="product__figure" data-reveal>
            <!-- IMAGE: 福山スタジオの写真（推奨 1200×800px） -->
            <img src="<?php echo $img; ?>studio-fukuyama.jpg" alt="FORT 福山スタジオ" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <h2 class="product__name">福山スタジオ</h2>
            <span class="product__type">FUKUYAMA STUDIO</span>
            <dl class="info-list">
              <div><dt>住所</dt><dd>〒720-0821<br>広島県福山市東川口町2丁目1-18 中国情報ビル 1F</dd></div>
              <div><dt>電話番号</dt><dd><a href="tel:0849827404">084-982-7404</a></dd></div>
              <div><dt>営業時間</dt><dd>9:00〜18:00</dd></div>
              <div><dt>定休日</dt><dd>水曜日</dd></div>
              <div><dt>ご相談</dt><dd>ご予約優先。お子さま連れも歓迎です。</dd></div>
            </dl>
            <a href="https://share.google/qFB14aVeN0XyfuxtH" class="btn btn--outline" target="_blank" rel="noopener">Googleマップで開く</a>
            <a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent">福山スタジオに来場予約する</a>
          </div>
        </article>

        <!-- 福山スタジオの地図 -->
        <div class="map-frame" data-reveal style="margin-top:28px;">
          <img src="<?php echo $img; ?>map-fukuyama.jpg" alt="福山スタジオの地図" loading="lazy" decoding="async">
        </div>
      </div>
    </section>

    <!-- ▼ モデルハウス -->
    <section class="section" id="modelhouse">
      <div class="container">
        <header class="section__head">
          <p class="section__label" data-reveal>MODEL HOUSE</p>
          <h2 class="section__title" data-reveal>モデルハウスで体感する。</h2>
          <p class="section__desc" data-reveal>
            写真やカタログだけでは伝わらない、空気感や心地よさ。
            FORTのデザインと性能を、実際の住まいでご体感いただけます。
          </p>
        </header>

        <article class="product">
          <figure class="product__figure" data-reveal>
            <!-- IMAGE: モデルハウスの写真（推奨 1200×800px） -->
            <img src="<?php echo $img; ?>ldk.jpg" alt="FORTのモデルハウス" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <h3 class="product__name">FORT モデルハウス</h3>
            <span class="product__type">いつでも見学いただけます（ご予約優先）</span>
            <p class="product__text">
              FORTがこだわる「性能とデザインの両立」を、五感で確かめてください。
              間取りの工夫や素材の質感、光や風の通り方まで、
              スタッフがご案内しながらじっくりご覧いただけます。
            </p>
            <ul class="product__features">
              <li>実際の生活サイズで間取りを体感できる</li>
              <li>断熱・空調などの“住んでからの快適さ”を確認できる</li>
              <li>家づくりの疑問をその場で相談できる</li>
            </ul>
            <a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent">モデルハウスを予約する</a>
          </div>
        </article>
      </div>
    </section>

    <!-- CTA -->
    <section class="reserve section" id="reserve">
      <div class="reserve__bg">
        <img src="<?php echo $img; ?>hero.jpg" alt="" aria-hidden="true" loading="lazy" decoding="async">
        <div class="reserve__overlay"></div>
      </div>
      <div class="container reserve__inner">
        <p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
        <h2 class="section__title section__title--light" data-reveal>お近くのスタジオでお待ちしています。</h2>
        <p class="reserve__lead" data-reveal>ご来場のご予約・ご相談は、お電話またはフォームから承ります。</p>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent btn--block">来場予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
        </ul>
        <p class="reserve__tel" data-reveal>
          お電話でのご予約：<a href="tel:0862369600">086-236-9600</a>（岡山）／ <a href="tel:0849827404">084-982-7404</a>（福山）
          <span class="reserve__tel-note">（受付時間 9:00〜18:00 / 水曜定休）</span>
        </p>
      </div>
    </section>

<?php get_footer(); ?>
