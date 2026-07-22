<?php
/*
 * Template Name: 特集
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
        <p class="subhero__eyebrow" data-reveal>FEATURE</p>
        <h1 class="subhero__title" data-reveal>テーマで深掘りする家づくり</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>FEATURE</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          FORTがつくる住まいには、いくつもの「考え方」が詰まっています。<br>
          テーマごとに、その魅力やアイデアをじっくりご紹介します。
        </p>

        <!-- ▼ 特集1：平屋という選択 -->
        <article class="product" id="hiraya">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>exterior.jpg" alt="平屋という選択" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <span class="product__type">FEATURE 01</span>
            <h2 class="product__name">平屋という選択</h2>
            <p class="product__text">
              階段のない、ワンフロアで完結する暮らし。家族の気配を感じながら、
              ゆるやかにつながる空間は、子育て世代にもセカンドライフにも心地よい選択です。
            </p>
            <ul class="product__features">
              <li>上下移動のない、家事ラクで安全な生活動線</li>
              <li>庭や外とつながる、開放感のある間取り</li>
              <li>将来も住みやすい、バリアフリーな住まい</li>
            </ul>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="btn btn--accent">平屋の施工事例を見る</a>
          </div>
        </article>

        <!-- ▼ 特集2：中庭のある暮らし -->
        <article class="product" id="courtyard">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>hero.jpg" alt="中庭のある暮らし" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <span class="product__type">FEATURE 02</span>
            <h2 class="product__name">中庭のある暮らし</h2>
            <p class="product__text">
              街の視線を気にせず、光と風をたっぷり取り込む。プライベートを守りながら、
              開放的に暮らせる中庭は、住まいの中心にもうひとつの「外」をつくります。
            </p>
            <ul class="product__features">
              <li>外からの視線を抑えながら採光・通風を確保</li>
              <li>リビングと一体になる、第二の屋外リビング</li>
              <li>四季を感じる、暮らしの中の特等席</li>
            </ul>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>" class="btn btn--accent">中庭のある事例を見る</a>
          </div>
        </article>

        <!-- ▼ 特集3：土地さがしから一緒に -->
        <article class="product" id="land">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>kitchen-view.jpg" alt="土地さがしから一緒に" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <span class="product__type">FEATURE 03</span>
            <h2 class="product__name">土地さがしから一緒に</h2>
            <p class="product__text">
              「どこに建てる？」も、FORTにご相談ください。土地の条件や周辺環境を読み解き、
              建物とセットで考えることで、暮らしに本当に合う一邸へとつなげます。
            </p>
            <ul class="product__features">
              <li>建物の視点から土地を一緒に検討</li>
              <li>変形地・狭小地もデザインで魅力に</li>
              <li>資金計画もまとめてサポート</li>
            </ul>
            <a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--accent">土地さがしを相談する</a>
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
        <h2 class="section__title section__title--light" data-reveal>気になるテーマがあれば、ぜひご相談を。</h2>
        <p class="reserve__lead" data-reveal>あなたの「こんな暮らしがしたい」を、かたちにするお手伝いをします。</p>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
        </ul>
      </div>
    </section>

<?php get_footer(); ?>
