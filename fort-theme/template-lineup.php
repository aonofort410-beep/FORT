<?php
/*
 * Template Name: 商品ラインナップ
 * 固定ページ用テンプレート（独立ページ）
 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>


    <section class="subhero">
      <div class="subhero__media">
        <img src="<?php echo $img; ?>ldk.jpg" alt="" aria-hidden="true" loading="eager" decoding="async">
        <div class="subhero__overlay"></div>
      </div>
      <div class="container subhero__inner">
        <p class="subhero__eyebrow" data-reveal>LINEUP</p>
        <h1 class="subhero__title" data-reveal>あなたらしい家づくりを選ぶ。</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>LINEUP</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          FORTには、ご予算やご希望のかたちに合わせて選べる3つの商品があります。<br>
          どれを選んでも、FORTらしいデザインと性能はそのまま。
          あなたの家づくりに、ちょうどいい答えを見つけてください。
        </p>

        <!-- ▼ 商品1：FORT STYLE -->
        <article class="product" id="fort-style">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>exterior.jpg" alt="FORT STYLEの住まい" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <h2 class="product__name">FORT STYLE</h2>
            <span class="product__type">建売住宅</span>
            <p class="product__text">
              土地・建物・外構まで含めて、わかりやすい価格設定。
              FORTらしいデザイン性と暮らしやすさを大切にした、すぐに住める住まいです。
            </p>
            <ul class="product__features">
              <li>土地＋建物＋外構の総額がわかりやすい</li>
              <li>完成した住まいを見てから決められる安心感</li>
              <li>打ち合わせの手間が少なく、スピーディに入居可能</li>
            </ul>
            <p class="product__price">
              <span class="product__price-label">建物本体価格（税別）</span>
              <strong>1,900万円〜</strong>
            </p>
            <div class="product__btns">
              <a href="https://www.fortstyle.org/" class="btn btn--accent" target="_blank" rel="noopener">FORT STYLE 公式サイトへ</a>
              <a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--outline">この商品について相談する</a>
            </div>
          </div>
        </article>

        <!-- ▼ 商品2：FORT PRO -->
        <article class="product" id="fort-pro">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>hero.jpg" alt="FORT PROの住まい" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <h2 class="product__name">FORT PRO</h2>
            <span class="product__type">規格・セミオーダー住宅 ／ スタンダードモデル</span>
            <p class="product__text">
              人気の間取りをベースに、自分たちらしくカスタマイズできる住まい。
              性能・デザイン・価格のバランスを重視した、FORTのスタンダードモデルです。
            </p>
            <ul class="product__features">
              <li>実績のある間取りベースで、失敗しにくい</li>
              <li>内装・設備を選んで“自分たちらしく”できる</li>
              <li>PLAN A〜F のたたき台プランからお選びいただけます</li>
            </ul>
            <p class="product__price">
              <span class="product__price-label">建物本体価格（30坪2階建て・PLUS基準・税別）</span>
              <strong>2,100万円〜</strong>
            </p>
            <div class="product__btns">
              <a href="<?php echo esc_url( home_url( '/fort-pro/' ) ); ?>" class="btn btn--accent">PLAN A〜F を見る</a>
              <a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--outline">この商品について相談する</a>
            </div>
          </div>
        </article>

        <!-- ▼ 商品3：FORT DESIGN -->
        <article class="product" id="fort-design">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>kitchen-view.jpg" alt="FORT DESIGNの住まい" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <h2 class="product__name">FORT DESIGN</h2>
            <span class="product__type">自由設計</span>
            <p class="product__text">
              理想の暮らしをゼロから形にする住まい。
              土地条件やライフスタイルに合わせた、完全自由設計でつくりあげます。
            </p>
            <ul class="product__features">
              <li>間取り・デザインを一からプランニング</li>
              <li>変形地や狭小地など、難しい土地にも対応</li>
              <li>設計士とつくる、世界にひとつの住まい</li>
            </ul>
            <p class="product__price">
              <span class="product__price-label">建物本体価格（税別・自由設計／仕様により変動）</span>
              <strong>2,500万円〜</strong>
            </p>
            <div class="product__btns">
              <a href="<?php echo esc_url( home_url( '/fort-design/' ) ); ?>" class="btn btn--accent">FORT DESIGN の世界を見る</a>
              <a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--outline">この商品について相談する</a>
            </div>
          </div>
        </article>
      </div>
    </section>

    <section class="reserve section" id="reserve">
      <div class="reserve__bg">
        <img src="<?php echo $img; ?>hero.jpg" alt="" aria-hidden="true" loading="lazy" decoding="async">
        <div class="reserve__overlay"></div>
      </div>
      <div class="container reserve__inner">
        <p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
        <h2 class="section__title section__title--light" data-reveal>どの商品が合うか、一緒に考えます。</h2>
        <p class="reserve__lead" data-reveal>「うちの場合はどれ？」も大歓迎。スタッフがご予算とご希望をうかがいます。</p>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
        </ul>
      </div>
    </section>

<?php get_footer(); ?>
