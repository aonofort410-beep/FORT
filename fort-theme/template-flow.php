<?php
/*
 * Template Name: 家づくりの流れ
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
        <p class="subhero__eyebrow" data-reveal>FLOW</p>
        <h1 class="subhero__title" data-reveal>家づくりの流れ</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>FLOW</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          はじめての家づくりは、わからないことばかりで当然です。<br>
          FORTは、ご相談からお引渡し、そしてその後まで、一つひとつ一緒に進めていきます。
        </p>

        <ol class="flow__list">
          <li class="flow__step" data-reveal>
            <span class="flow__num">01</span>
            <div class="flow__body">
              <h2 class="flow__title">ご相談・ご来場</h2>
              <p class="flow__text">見学会やスタジオで、暮らしのご希望・ご予算・お悩みなどをお聞かせください。まずは情報収集だけでも大歓迎です。</p>
            </div>
          </li>
          <li class="flow__step" data-reveal>
            <span class="flow__num">02</span>
            <div class="flow__body">
              <h2 class="flow__title">プランご提案・お見積り</h2>
              <p class="flow__text">ご要望をかたちにした間取りプランと、わかりやすいお見積りをご提示。資金計画もあわせてご相談いただけます。</p>
            </div>
          </li>
          <li class="flow__step" data-reveal>
            <span class="flow__num">03</span>
            <div class="flow__body">
              <h2 class="flow__title">ご契約</h2>
              <p class="flow__text">プラン・お見積り・スケジュールにご納得いただいたうえで、ご契約。ここから本格的に家づくりが進みます。</p>
            </div>
          </li>
          <li class="flow__step" data-reveal>
            <span class="flow__num">04</span>
            <div class="flow__body">
              <h2 class="flow__title">詳細打ち合わせ</h2>
              <p class="flow__text">間取りの最終調整、設備・内装・色決めなど、暮らしの細部まで一緒に決めていきます。じっくりお選びいただけます。</p>
            </div>
          </li>
          <li class="flow__step" data-reveal>
            <span class="flow__num">05</span>
            <div class="flow__body">
              <h2 class="flow__title">着工・施工</h2>
              <p class="flow__text">地鎮祭・上棟を経て、いよいよ施工へ。工事中も現場の状況を随時ご報告し、安心して見守っていただけます。</p>
            </div>
          </li>
          <li class="flow__step" data-reveal>
            <span class="flow__num">06</span>
            <div class="flow__body">
              <h2 class="flow__title">完成・お引渡し</h2>
              <p class="flow__text">完成検査で仕上がりを確認し、設備の使い方などをご説明のうえお引渡し。新しい暮らしのはじまりです。</p>
            </div>
          </li>
          <li class="flow__step" data-reveal>
            <span class="flow__num">07</span>
            <div class="flow__body">
              <h2 class="flow__title">アフターサポート</h2>
              <p class="flow__text">お引渡しはゴールではなくスタート。定期点検やメンテナンスで、住みはじめてからも長く安心をお届けします。</p>
            </div>
          </li>
        </ol>
      </div>
    </section>

    <section class="reserve section" id="reserve">
      <div class="reserve__bg">
        <img src="<?php echo $img; ?>hero.jpg" alt="" aria-hidden="true" loading="lazy" decoding="async">
        <div class="reserve__overlay"></div>
      </div>
      <div class="container reserve__inner">
        <p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
        <h2 class="section__title section__title--light" data-reveal>まずは「相談」から始めましょう。</h2>
        <p class="reserve__lead" data-reveal>何から始めればいいか分からない、その状態こそスタートにぴったりです。</p>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
        </ul>
      </div>
    </section>

<?php get_footer(); ?>
