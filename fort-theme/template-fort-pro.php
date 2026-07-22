<?php
/*
 * Template Name: FORT PRO 規格プラン
 * 固定ページ用テンプレート（独立ページ）
 */
get_header();
$img = get_template_directory_uri() . '/assets/images/';
?>


    <section class="subhero">
      <div class="subhero__media">
        <img src="<?php echo $img; ?>pro/persp-e.jpg" alt="" aria-hidden="true" loading="eager" decoding="async">
        <div class="subhero__overlay"></div>
      </div>
      <div class="container subhero__inner">
        <p class="subhero__eyebrow" data-reveal>FORT PRO</p>
        <h1 class="subhero__title" data-reveal>規格プラン PLAN A〜F</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><a href="<?php echo esc_url( home_url( '/lineup/' ) ); ?>">LINEUP</a><span>／</span><span>FORT PRO</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          FORT PROは、人気の間取りをベースにした規格・セミオーダー住宅です。<br>
          PLAN A〜F の「たたき台プラン」を出発点に、内装や設備を選びながら、
          自分たちらしい住まいへと仕上げていきます。建物本体 <strong>2,100万円〜</strong>（30坪2階建て・PLUS基準・税別）。
        </p>

        <!-- ▼ PLAN A -->
        <article class="plan" id="plan-a" data-reveal>
          <div class="plan__head">
            <span class="plan__badge">A</span>
            <span class="plan__name">スタンダードな2階建て</span>
            <span class="plan__tags">3LDK ／ 延床 約100㎡（約30坪）</span>
          </div>
          <div class="plan__media">
            <figure class="plan__persp">
              <img src="<?php echo $img; ?>pro/persp-a.jpg" alt="PLAN A 外観パース" loading="lazy" decoding="async">
            </figure>
            <figure class="plan__sheet">
              <a href="<?php echo $img; ?>pro/plan-a.jpg" target="_blank" rel="noopener">
                <img src="<?php echo $img; ?>pro/plan-a.jpg" alt="PLAN A 平面図（1階・2階）" loading="lazy" decoding="async">
              </a>
              <figcaption class="plan__caption">タップで平面図を拡大</figcaption>
            </figure>
          </div>
          <div class="plan__body">
            <dl class="plan__spec">
              <div><dt>間取り</dt><dd>3LDK</dd></div>
              <div><dt>LDK</dt><dd>約18帖</dd></div>
              <div><dt>延床面積</dt><dd>約100㎡（約30坪）</dd></div>
              <div><dt>タイプ</dt><dd>2階建て</dd></div>
            </dl>
            <p class="plan__text">使い勝手のよい王道の間取り。寝室＋子ども室2部屋を2階にまとめた、ご家族で暮らしやすいスタンダードプランです。</p>
          </div>
        </article>

        <!-- ▼ PLAN B -->
        <article class="plan" id="plan-b" data-reveal>
          <div class="plan__head">
            <span class="plan__badge">B</span>
            <span class="plan__name">吹抜けのある2階建て</span>
            <span class="plan__tags">3LDK ／ 延床 約100㎡（約30坪）</span>
          </div>
          <div class="plan__media">
            <figure class="plan__persp">
              <img src="<?php echo $img; ?>pro/persp-b.jpg" alt="PLAN B 外観パース" loading="lazy" decoding="async">
            </figure>
            <figure class="plan__sheet">
              <a href="<?php echo $img; ?>pro/plan-b.jpg" target="_blank" rel="noopener">
                <img src="<?php echo $img; ?>pro/plan-b.jpg" alt="PLAN B 平面図（1階・2階）" loading="lazy" decoding="async">
              </a>
              <figcaption class="plan__caption">タップで平面図を拡大</figcaption>
            </figure>
          </div>
          <div class="plan__body">
            <dl class="plan__spec">
              <div><dt>間取り</dt><dd>3LDK</dd></div>
              <div><dt>LDK</dt><dd>約18帖＋吹抜け</dd></div>
              <div><dt>延床面積</dt><dd>約100㎡（約30坪）</dd></div>
              <div><dt>タイプ</dt><dd>2階建て</dd></div>
            </dl>
            <p class="plan__text">LDK上部に吹抜けを設けた開放的なプラン。WIC・SICなど収納も充実し、光がたっぷり届く明るい住まいです。</p>
          </div>
        </article>

        <!-- ▼ PLAN C -->
        <article class="plan" id="plan-c" data-reveal>
          <div class="plan__head">
            <span class="plan__badge">C</span>
            <span class="plan__name">ゆとりのLDKの2階建て</span>
            <span class="plan__tags">3LDK ／ 延床 約105㎡（約32坪）</span>
          </div>
          <div class="plan__media">
            <figure class="plan__persp">
              <img src="<?php echo $img; ?>pro/persp-c.jpg" alt="PLAN C 外観パース" loading="lazy" decoding="async">
            </figure>
            <figure class="plan__sheet">
              <a href="<?php echo $img; ?>pro/plan-c.jpg" target="_blank" rel="noopener">
                <img src="<?php echo $img; ?>pro/plan-c.jpg" alt="PLAN C 平面図（1階・2階）" loading="lazy" decoding="async">
              </a>
              <figcaption class="plan__caption">タップで平面図を拡大</figcaption>
            </figure>
          </div>
          <div class="plan__body">
            <dl class="plan__spec">
              <div><dt>間取り</dt><dd>3LDK</dd></div>
              <div><dt>LDK</dt><dd>約20.5帖</dd></div>
              <div><dt>延床面積</dt><dd>約105㎡（約32坪）</dd></div>
              <div><dt>タイプ</dt><dd>2階建て</dd></div>
            </dl>
            <p class="plan__text">20.5帖のゆとりあるLDKが主役。シューズクロークやWICを備え、すっきり片付く暮らしやすい間取りです。</p>
          </div>
        </article>

        <!-- ▼ PLAN D -->
        <article class="plan" id="plan-d" data-reveal>
          <div class="plan__head">
            <span class="plan__badge">D</span>
            <span class="plan__name">ワンフロアで暮らす平屋</span>
            <span class="plan__tags">3LDK ／ 延床 97.50㎡（29.49坪）</span>
          </div>
          <div class="plan__media">
            <figure class="plan__persp">
              <img src="<?php echo $img; ?>pro/persp-d.jpg" alt="PLAN D 外観パース" loading="lazy" decoding="async">
            </figure>
            <figure class="plan__sheet">
              <a href="<?php echo $img; ?>pro/plan-d.jpg" target="_blank" rel="noopener">
                <img src="<?php echo $img; ?>pro/plan-d.jpg" alt="PLAN D 平面図" loading="lazy" decoding="async">
              </a>
              <figcaption class="plan__caption">タップで平面図を拡大</figcaption>
            </figure>
          </div>
          <div class="plan__body">
            <dl class="plan__spec">
              <div><dt>間取り</dt><dd>3LDK（平屋）</dd></div>
              <div><dt>LDK</dt><dd>約20.5帖</dd></div>
              <div><dt>延床面積</dt><dd>97.50㎡（29.49坪）</dd></div>
              <div><dt>タイプ</dt><dd>平屋</dd></div>
            </dl>
            <p class="plan__text">階段のないワンフロア完結の平屋プラン。寝室＋子ども室2部屋、パントリーやWICも備え、家事ラクで安全な暮らしを実現します。</p>
          </div>
        </article>

        <!-- ▼ PLAN E -->
        <article class="plan" id="plan-e" data-reveal>
          <div class="plan__head">
            <span class="plan__badge">E</span>
            <span class="plan__name">開放感の吹抜けプラン</span>
            <span class="plan__tags">3LDK ／ 延床 約105㎡（約32坪）</span>
          </div>
          <div class="plan__media">
            <figure class="plan__persp">
              <img src="<?php echo $img; ?>pro/persp-e.jpg" alt="PLAN E 外観パース" loading="lazy" decoding="async">
            </figure>
            <figure class="plan__sheet">
              <a href="<?php echo $img; ?>pro/plan-e.jpg" target="_blank" rel="noopener">
                <img src="<?php echo $img; ?>pro/plan-e.jpg" alt="PLAN E 平面図（1階・2階）" loading="lazy" decoding="async">
              </a>
              <figcaption class="plan__caption">タップで平面図を拡大</figcaption>
            </figure>
          </div>
          <div class="plan__body">
            <dl class="plan__spec">
              <div><dt>間取り</dt><dd>3LDK</dd></div>
              <div><dt>LDK</dt><dd>約20帖＋吹抜け</dd></div>
              <div><dt>延床面積</dt><dd>約105㎡（約32坪）</dd></div>
              <div><dt>タイプ</dt><dd>2階建て</dd></div>
            </dl>
            <p class="plan__text">20帖のLDKに上部吹抜けを重ねた、縦にも横にも広がりを感じるプラン。家族の気配を感じながら、のびやかに暮らせます。</p>
          </div>
        </article>

        <!-- ▼ PLAN F -->
        <article class="plan" id="plan-f" data-reveal>
          <div class="plan__head">
            <span class="plan__badge">F</span>
            <span class="plan__name">中庭のある2階建て</span>
            <span class="plan__tags">3LDK ／ 延床 約104㎡（約31坪）</span>
          </div>
          <div class="plan__media">
            <figure class="plan__persp">
              <img src="<?php echo $img; ?>pro/persp-f.jpg" alt="PLAN F 外観パース" loading="lazy" decoding="async">
            </figure>
            <figure class="plan__sheet">
              <a href="<?php echo $img; ?>pro/plan-f.jpg" target="_blank" rel="noopener">
                <img src="<?php echo $img; ?>pro/plan-f.jpg" alt="PLAN F 平面図（1階・2階）" loading="lazy" decoding="async">
              </a>
              <figcaption class="plan__caption">タップで平面図を拡大</figcaption>
            </figure>
          </div>
          <div class="plan__body">
            <dl class="plan__spec">
              <div><dt>間取り</dt><dd>3LDK</dd></div>
              <div><dt>LDK</dt><dd>約19.7帖</dd></div>
              <div><dt>延床面積</dt><dd>約104㎡（約31坪）</dd></div>
              <div><dt>タイプ</dt><dd>2階建て・中庭</dd></div>
            </dl>
            <p class="plan__text">住まいの中心に中庭を取り込み、プライバシーを守りながら採光・通風を確保。街中でも開放的に暮らせるプランです。</p>
          </div>
        </article>

        <p class="spec-note-scroll" style="margin-top:28px;">
          ※ 掲載のプラン・図面・パースはたたき台の一例です。間取り・仕様・面積は実際の計画により変更となります。
        </p>
      </div>
    </section>

    <section class="reserve section" id="reserve">
      <div class="reserve__bg">
        <img src="<?php echo $img; ?>pro/persp-c.jpg" alt="" aria-hidden="true" loading="lazy" decoding="async">
        <div class="reserve__overlay"></div>
      </div>
      <div class="container reserve__inner">
        <p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
        <h2 class="section__title section__title--light" data-reveal>気になるプランから、相談を始めましょう。</h2>
        <p class="reserve__lead" data-reveal>「このプランをベースにしたい」も大歓迎。ご予算・ご希望に合わせて一緒に育てていきます。</p>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
        </ul>
      </div>
    </section>

<?php get_footer(); ?>
