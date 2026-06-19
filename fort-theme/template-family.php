<?php
/* Template Name: お客様の声（FORT FAMILY） */
get_header();
$img = get_template_directory_uri() . "/assets/images/";
$voices = array(
  array('family-01.jpg','倉敷市 ／ T様邸（フルオーダー）','「チームで親身に向き合ってくれて、はじめての家づくりも安心でした。打ち合わせのたびに不安が一つずつ消えていきました。」'),
  array('family-02.jpg','岡山市 ／ K様邸（セミオーダー）','「性能もデザインも妥協せず、予算内で理想の住まいになりました。冬もあたたかく、光熱費まで下がって大満足です。」'),
  array('family-03.jpg','福山市 ／ M様邸（フルオーダー）','「引渡し後も同じ顔ぶれで対応してくれるのが心強いです。点検のたびに顔を見せてくれて、長く付き合える会社だと感じます。」'),
  array('ldk.jpg','岡山市 ／ S様邸（平屋）','「平屋の家事動線が本当にラク。毎日の暮らしがスムーズになって、家族との時間が増えました。」'),
  array('kitchen-view.jpg','倉敷市 ／ N様邸（中庭のある家）','「中庭から入る光が気持ちよくて、家にいる時間が好きになりました。来客にも必ずほめられます。」'),
  array('exterior.jpg','福山市 ／ Y様邸（セミオーダー）','「予算の相談にも正直に向き合ってくれました。無理のない資金計画で、安心して建てられました。」'),
);
?>

    <section class="subhero">
      <div class="subhero__media"><img src="<?php echo $img; ?>family-01.jpg" alt="" aria-hidden="true"><div class="subhero__overlay"></div></div>
      <div class="container subhero__inner">
        <p class="subhero__eyebrow" data-reveal>FORT FAMILY</p>
        <h1 class="subhero__title" data-reveal>お客様の声</h1>
        <nav class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>お客様の声</span></nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          FORTで家を建てたご家族の、リアルな暮らしの声をご紹介します。<br>
          これからも、新しいFORT FAMILYの声をどんどん追加していきます。
        </p>
        <ul class="family__grid">
          <?php foreach ( $voices as $v ) : ?>
          <li class="family__card" data-reveal>
            <figure class="family__figure"><img src="<?php echo esc_url( $img . $v[0] ); ?>" alt="<?php echo esc_attr( $v[1] ); ?>" loading="lazy"></figure>
            <div class="family__body">
              <p class="family__voice"><?php echo esc_html( $v[2] ); ?></p>
              <p class="family__name"><?php echo esc_html( $v[1] ); ?></p>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>

    <section class="reserve section" id="reserve">
      <div class="reserve__bg"><img src="<?php echo $img; ?>hero.jpg" alt="" aria-hidden="true"><div class="reserve__overlay"></div></div>
      <div class="container reserve__inner">
        <p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
        <h2 class="section__title section__title--light" data-reveal>次のFORT FAMILYは、あなたです。</h2>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" class="btn btn--accent btn--block">ご来場予約</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会・モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/request/' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--light btn--block">お問合せ</a></li>
        </ul>
      </div>
    </section>

<?php get_footer(); ?>
