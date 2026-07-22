<?php
/*
 * Template Name: 資料請求
 * ※ 実際の送信は WordPress プラグイン「Contact Form 7」推奨。
 *   作成したフォームのショートコードを下の <form> と置き換えてください。
 */
get_header();
$img = get_template_directory_uri() . "/assets/images/";
?>


    <section class="subhero">
      <div class="subhero__media">
        <img src="<?php echo $img; ?>exterior.jpg" alt="" aria-hidden="true" loading="eager" decoding="async">
        <div class="subhero__overlay"></div>
      </div>
      <div class="container subhero__inner">
        <p class="subhero__eyebrow" data-reveal>DOCUMENT REQUEST</p>
        <h1 class="subhero__title" data-reveal>資料請求</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>資料請求</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          会社案内・商品カタログ・施工事例集を無料でお送りします。<br>
          郵送のほか、メール（PDF）でのお届けも承ります。お気軽にご請求ください。
        </p>

        <ul class="why__grid" style="grid-template-columns:1fr;">
          <li class="why__card" data-reveal>
            <span class="why__num">01</span>
            <h2 class="why__card-title">会社案内・コンセプトブック</h2>
            <p class="why__card-text">FORTの家づくりの考え方や、性能・デザイン・価格のバランスについてご紹介します。</p>
          </li>
          <li class="why__card" data-reveal>
            <span class="why__num">02</span>
            <h2 class="why__card-title">商品ラインナップ・施工事例集</h2>
            <p class="why__card-text">FORT STYLE／FORT PRO／FORT DESIGN の特長と、実際の施工事例をまとめています。</p>
          </li>
        </ul>

        <!-- ★ action を実際の送信先（Formspree等）に変更してください -->
        <form class="form" action="#" method="POST" data-reveal style="margin-top:8px;">

          <div class="form__row">
            <label class="form__label" for="r-doc">ご希望の資料<span class="form__req">必須</span></label>
            <select class="form__select" id="r-doc" name="希望資料" required>
              <option value="">選択してください</option>
              <option>すべての資料（おすすめ）</option>
              <option>会社案内・コンセプトブック</option>
              <option>商品カタログ（FORT STYLE）</option>
              <option>商品カタログ（FORT PRO）</option>
              <option>商品カタログ（FORT DESIGN）</option>
              <option>施工事例集</option>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="r-method">お届け方法<span class="form__req">必須</span></label>
            <select class="form__select" id="r-method" name="お届け方法" required>
              <option value="">選択してください</option>
              <option>郵送でのお届け</option>
              <option>メール（PDF）でのお届け</option>
              <option>どちらでも可</option>
            </select>
          </div>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="r-name">お名前<span class="form__req">必須</span></label>
              <input class="form__input" id="r-name" name="お名前" type="text" placeholder="山田 太郎" required>
            </div>
            <div>
              <label class="form__label" for="r-kana">ふりがな</label>
              <input class="form__input" id="r-kana" name="ふりがな" type="text" placeholder="やまだ たろう">
            </div>
          </div>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="r-email">メールアドレス<span class="form__req">必須</span></label>
              <input class="form__input" id="r-email" name="メール" type="email" placeholder="example@email.com" required>
            </div>
            <div>
              <label class="form__label" for="r-tel">電話番号</label>
              <input class="form__input" id="r-tel" name="電話番号" type="tel" placeholder="090-0000-0000">
            </div>
          </div>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="r-zip">郵便番号<span class="form__req">郵送の場合必須</span></label>
              <input class="form__input" id="r-zip" name="郵便番号" type="text" inputmode="numeric" placeholder="700-0000">
            </div>
            <div>
              <label class="form__label" for="r-pref">都道府県</label>
              <input class="form__input" id="r-pref" name="都道府県" type="text" placeholder="岡山県">
            </div>
          </div>

          <div class="form__row">
            <label class="form__label" for="r-addr">ご住所（市区町村・番地）<span class="form__req">郵送の場合必須</span></label>
            <input class="form__input" id="r-addr" name="住所" type="text" placeholder="岡山市北区〇〇町1-2-3">
          </div>

          <div class="form__row">
            <label class="form__label" for="r-bld">建物名・部屋番号（任意）</label>
            <input class="form__input" id="r-bld" name="建物名" type="text" placeholder="〇〇マンション 101号室">
          </div>

          <div class="form__row">
            <label class="form__label" for="r-timing">建築（ご入居）希望時期</label>
            <select class="form__select" id="r-timing" name="建築希望時期">
              <option value="">選択してください</option>
              <option>半年以内</option>
              <option>1年以内</option>
              <option>1〜2年以内</option>
              <option>2年以降・未定</option>
              <option>情報収集中</option>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="r-msg">ご質問・ご要望（任意）</label>
            <textarea class="form__textarea" id="r-msg" name="内容" placeholder="気になっていること、知りたい情報などがあればお書きください。"></textarea>
          </div>

          <div class="form__row">
            <label class="form__agree">
              <input type="checkbox" name="同意" required>
              <span><a href="#">プライバシーポリシー</a>に同意のうえ送信します。<span class="form__req">必須</span></span>
            </label>
          </div>

          <div class="form__submit">
            <button type="submit" class="btn btn--accent">この内容で資料請求する</button>
            <p class="form__note">
              ※ 資料は無料です。しつこい営業のご連絡はいたしませんのでご安心ください。<br>
              ※ 現在このフォームは表示確認用です。送信を有効にするには、フォームの送信先（Formspree等）またはWordPressの「Contact Form 7」への接続が必要です。
            </p>
          </div>
        </form>

        <p class="form__tel">お電話でのご請求：<a href="tel:0862369600">086-236-9600</a>（岡山）／ <a href="tel:0849827404">084-982-7404</a>（福山）<br><span style="font-size:12px;">受付 9:00〜18:00 / 水曜定休</span></p>
      </div>
    </section>

<?php get_footer(); ?>
