<?php
/*
 * Template Name: 構造・性能
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
        <p class="subhero__eyebrow" data-reveal>PERFORMANCE</p>
        <h1 class="subhero__title" data-reveal>性能を選ぶのではない。暮らし方を選ぶ。</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>PERFORMANCE</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          FORTでは、ライフスタイルに合わせて4つの性能グレードをご用意しています。<br>
          デザイン・自由度・性能・耐震・保証。そのすべてのバランスを大切にした家づくりをご提案します。
        </p>

        <!-- 4つの考え方 -->
        <ul class="why__grid">
          <li class="why__card" data-reveal>
            <span class="why__num">01</span>
            <h2 class="why__card-title">高い断熱性能</h2>
            <p class="why__card-text">UA値0.56〜0.34以下。夏は涼しく冬はあたたかい、一年中心地よい室内環境へ。</p>
          </li>
          <li class="why__card" data-reveal>
            <span class="why__num">02</span>
            <h2 class="why__card-title">すきまの少ない高気密</h2>
            <p class="why__card-text">C値1.0〜0.3以下。第三者機関による気密測定で、確かな性能を一棟ずつ確認します。</p>
          </li>
          <li class="why__card" data-reveal>
            <span class="why__num">03</span>
            <h2 class="why__card-title">耐震へのこだわり</h2>
            <p class="why__card-text">耐震等級3を基本に、PLUS以上は設計性能評価を取得します。</p>
          </li>
          <li class="why__card" data-reveal>
            <span class="why__num">04</span>
            <h2 class="why__card-title">計画換気・空調</h2>
            <p class="why__card-text">第三種換気から、第一種熱交換換気「Air save」まで。空気の質まで考えた住まいへ。</p>
          </li>
        </ul>
      </div>
    </section>

    <!-- 性能グレード比較表 -->
    <section class="section section--gray">
      <div class="container">
        <header class="section__head">
          <p class="section__label" data-reveal>GRADE</p>
          <h2 class="section__title" data-reveal>4つの性能グレード</h2>
          <p class="section__desc" data-reveal>コスト重視から最高峰仕様まで。暮らし方とご予算に合わせてお選びいただけます。</p>
        </header>

        <p class="spec-note-scroll">▶ 表は横にスクロールできます</p>
        <div class="spec-scroll" data-reveal>
          <table class="spec-table">
            <thead>
              <tr>
                <th scope="col">項目</th>
                <th scope="col"><span class="spec-grade">SMART</span><span class="spec-sub">スマート／エントリー</span></th>
                <th scope="col"><span class="spec-grade">STANDARD</span><span class="spec-sub">スタンダード</span></th>
                <th scope="col" class="is-recommend"><span class="spec-grade">PLUS</span><span class="spec-sub">FORT推奨</span></th>
                <th scope="col"><span class="spec-grade">BLACK</span><span class="spec-sub">最高峰仕様</span></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">耐震</th>
                <td>等級3相当</td>
                <td>等級3相当</td>
                <td class="is-recommend">等級3</td>
                <td>等級3</td>
              </tr>
              <tr>
                <th scope="row">設計性能評価</th>
                <td class="spec-muted">−</td>
                <td class="spec-muted">−</td>
                <td class="is-recommend">取得</td>
                <td>取得</td>
              </tr>
              <tr>
                <th scope="row">断熱（UA値）</th>
                <td><strong>0.56</strong> 以下</td>
                <td><strong>0.46</strong> 以下</td>
                <td class="is-recommend"><strong>0.46</strong> 以下</td>
                <td><strong>0.34</strong> 以下<br><span class="spec-sub">HEAT20 G2.5〜G3</span></td>
              </tr>
              <tr>
                <th scope="row">気密（C値）</th>
                <td><strong>1.0</strong> 以下</td>
                <td><strong>0.7</strong> 以下</td>
                <td class="is-recommend"><strong>0.5</strong> 以下</td>
                <td><strong>0.3</strong> 以下</td>
              </tr>
              <tr>
                <th scope="row">気密測定</th>
                <td>第三者機関</td>
                <td>第三者機関</td>
                <td class="is-recommend">第三者機関</td>
                <td>第三者機関</td>
              </tr>
              <tr>
                <th scope="row">窓・サッシ</th>
                <td>APW330<br><span class="spec-sub">樹脂・ペアガラス</span></td>
                <td>APW330<br><span class="spec-sub">樹脂・ペアガラス</span></td>
                <td class="is-recommend">APW330<br><span class="spec-sub">樹脂・ペアガラス</span></td>
                <td>APW430<br><span class="spec-sub">樹脂・トリプルガラス</span></td>
              </tr>
              <tr>
                <th scope="row">換気</th>
                <td>第三種換気</td>
                <td>第三種換気</td>
                <td class="is-recommend">Air save<br><span class="spec-sub">第一種熱交換換気</span></td>
                <td>Air save<br><span class="spec-sub">第一種熱交換換気</span></td>
              </tr>
              <tr>
                <th scope="row">制振</th>
                <td class="spec-muted">−</td>
                <td class="spec-muted">−</td>
                <td class="is-recommend spec-muted">−</td>
                <td>evoltz<br><span class="spec-sub">制振ダンパー</span></td>
              </tr>
              <tr>
                <th scope="row">保証</th>
                <td>躯体10年</td>
                <td>躯体20年<br><span class="spec-sub">最長60年</span></td>
                <td class="is-recommend">躯体20年<br><span class="spec-sub">最長60年</span>／設備10年</td>
                <td>躯体20年<br><span class="spec-sub">最長60年</span>／設備10年</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="spec-note-scroll" style="margin-top:14px;">
          ※ 上記は標準仕様の一例です。仕様・数値は予告なく変更する場合があります。
        </p>
      </div>
    </section>

    <!-- 断熱・気密の詳細 -->
    <section class="section">
      <div class="container">
        <article class="product" id="insulation">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>ldk.jpg" alt="高断熱・高気密の住まい" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <span class="product__type">断熱・気密</span>
            <h2 class="product__name">一年中、心地よい温度で。</h2>
            <p class="product__text">
              しっかりとした断熱・気密性能は、夏の暑さ・冬の寒さをやわらげ、冷暖房の効率を高めます。
              部屋ごとの温度差も少なくなり、ヒートショックのリスク低減にもつながります。
            </p>
            <ul class="product__features">
              <li>UA値0.34〜、C値0.3〜の高い断熱・気密（グレード別）</li>
              <li>樹脂サッシ APW330／APW430 を採用</li>
              <li>光熱費を抑え、家計にもやさしい暮らしへ</li>
            </ul>
          </div>
        </article>
      </div>
    </section>

    <!-- 耐震の詳細 -->
    <section class="section section--gray">
      <div class="container">
        <article class="product" id="earthquake">
          <figure class="product__figure" data-reveal>
            <img src="<?php echo $img; ?>hero.jpg" alt="地震に強い構造" loading="lazy" decoding="async">
          </figure>
          <div data-reveal>
            <span class="product__type">耐震・構造</span>
            <h2 class="product__name">家族を守る、強い構造。</h2>
            <p class="product__text">
              耐震等級3を基本に、PLUS以上のグレードでは設計性能評価を取得。
              最高峰のBLACKでは制振システム「evoltz」も採用し、地震の揺れそのものを抑えます。
            </p>
            <ul class="product__features">
              <li>耐震等級3を基本に、PLUS以上は設計性能評価を取得</li>
              <li>制振ダンパー evoltz で揺れを軽減（BLACK）</li>
              <li>長く住み継げる、丈夫な住まいづくり</li>
            </ul>
          </div>
        </article>
      </div>
    </section>

    <section class="reserve section" id="reserve">
      <div class="reserve__bg">
        <img src="<?php echo $img; ?>exterior.jpg" alt="" aria-hidden="true" loading="lazy" decoding="async">
        <div class="reserve__overlay"></div>
      </div>
      <div class="container reserve__inner">
        <p class="section__label section__label--light" data-reveal>RESERVE &amp; CONTACT</p>
        <h2 class="section__title section__title--light" data-reveal>性能のこと、詳しくご説明します。</h2>
        <p class="reserve__lead" data-reveal>数値だけではわからない「住み心地」も、ぜひ見学会で体感してください。</p>
        <ul class="reserve__actions" data-reveal>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">見学会予約</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'fort_event' ) ); ?>" class="btn btn--accent btn--block">モデルハウス予約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">資料請求</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#reserve' ) ); ?>" class="btn btn--light btn--block">お問い合わせ</a></li>
        </ul>
      </div>
    </section>

<?php get_footer(); ?>
