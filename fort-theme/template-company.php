<?php
/*
 * Template Name: 会社概要
 * 固定ページ用テンプレート（独立ページ）
 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>


    <!-- ページ見出し -->
    <section class="subhero">
      <div class="subhero__media">
        <img src="<?php echo $img; ?>exterior.jpg" alt="" aria-hidden="true" loading="eager" decoding="async">
        <div class="subhero__overlay"></div>
      </div>
      <div class="container subhero__inner">
        <p class="subhero__eyebrow" data-reveal>COMPANY</p>
        <h1 class="subhero__title" data-reveal>会社概要</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>COMPANY</span>
        </nav>
      </div>
    </section>

    <!-- 会社情報テーブル -->
    <section class="section section--gray">
      <div class="container">
        <header class="section__head">
          <p class="section__label" data-reveal>OVERVIEW</p>
          <h2 class="section__title" data-reveal>会社情報</h2>
        </header>

        <dl class="company-table" data-reveal>
          <div><dt>会社名</dt><dd>株式会社FORT（フォート）</dd></div>
          <div><dt>設立</dt><dd>平成28年</dd></div>
          <div><dt>代表者</dt><dd>代表取締役　中村 亜樹</dd></div>
          <div><dt>資本金</dt><dd>1,000万円</dd></div>
          <div>
            <dt>所在地</dt>
            <dd>
              <strong>岡山スタジオ</strong><br>
              〒700-0977　岡山県岡山市北区問屋町9-101 タイルビル 1F<br>
              TEL 086-236-9600<br><br>
              <strong>福山スタジオ</strong><br>
              〒720-0821　広島県福山市東川口町2丁目1-18 中国情報ビル 1F<br>
              TEL 084-982-7404
            </dd>
          </div>
          <div><dt>登録番号</dt><dd>2級建築士事務所　岡山県知事登録　第6548号</dd></div>
          <div><dt>事業内容</dt><dd>注文住宅・規格住宅・建売住宅の設計および施工 ほか</dd></div>
          <div><dt>対応エリア</dt><dd>岡山県全域　※一部エリアについてはご相談ください<br>福山市・尾道市・三原市<br>施工エリア拡大中</dd></div>
        </dl>
      </div>
    </section>

    <!-- アクセス（2つのスタジオ） -->
    <section class="section">
      <div class="container">
        <header class="section__head">
          <p class="section__label" data-reveal>ACCESS</p>
          <h2 class="section__title" data-reveal>2つのスタジオ</h2>
          <p class="section__desc" data-reveal>岡山と福山に、家づくりのご相談ができるスタジオがあります。</p>
        </header>

        <div class="studio-grid">
          <!-- 岡山スタジオ -->
          <article class="studio-card" data-reveal>
            <div class="map-frame">
              <!-- 地図：GoogleマップのiframeをここにIMAGEの代わりに貼り付けできます -->
              <img src="<?php echo $img; ?>map-okayama.jpg" alt="岡山スタジオの地図" loading="lazy" decoding="async">
            </div>
            <h3 class="studio-card__name">岡山スタジオ</h3>
            <p class="studio-card__addr">〒700-0977<br>岡山県岡山市北区問屋町9-101 タイルビル 1F</p>
          </article>
          <!-- 福山スタジオ -->
          <article class="studio-card" data-reveal>
            <div class="map-frame">
              <img src="<?php echo $img; ?>map-fukuyama.jpg" alt="福山スタジオの地図" loading="lazy" decoding="async">
            </div>
            <h3 class="studio-card__name">福山スタジオ</h3>
            <p class="studio-card__addr">〒720-0821<br>広島県福山市東川口町2丁目1-18 中国情報ビル 1F</p>
          </article>
        </div>

        <div class="section__more" data-reveal>
          <a href="<?php echo esc_url( home_url( '/studio/' ) ); ?>" class="btn btn--outline">スタジオ・モデルハウスの詳細を見る</a>
        </div>
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
        <h2 class="section__title section__title--light" data-reveal>まずはお気軽にご相談ください。</h2>
        <p class="reserve__lead" data-reveal>家づくりのこと、土地のこと、予算のこと。どんな小さなことでもお気軽に。</p>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
        </ul>
      </div>
    </section>

<?php get_footer(); ?>
