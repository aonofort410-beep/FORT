<?php
/*
 * Template Name: お問い合わせ
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
        <p class="subhero__eyebrow" data-reveal>CONTACT</p>
        <h1 class="subhero__title" data-reveal>お問合せ</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>お問合せ</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          家づくりのご相談・ご質問など、お気軽にお問い合わせください。<br>
          内容を確認のうえ、担当者より折り返しご連絡いたします。<br>
          <span style="font-size:13px;color:var(--t-sub);">※ ご来場予約は<a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>" style="text-decoration:underline;">ご来場予約ページ</a>、資料請求は<a href="<?php echo esc_url( home_url( '/request/' ) ); ?>" style="text-decoration:underline;">資料請求ページ</a>が便利です。</span>
        </p>

        <!-- ★ action を実際の送信先（Formspree等）に変更してください -->
        <form class="form" action="#" method="POST" data-reveal>
          <div class="form__row">
            <label class="form__label" for="f-type">お問い合わせ種別<span class="form__req">必須</span></label>
            <select class="form__select" id="f-type" name="種別" required>
              <option value="">選択してください</option>
              <option>来場・見学会のご予約</option>
              <option>モデルハウス見学のご予約</option>
              <option>資料請求</option>
              <option>プラン・お見積りのご相談</option>
              <option>その他のお問い合わせ</option>
            </select>
          </div>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="f-name">お名前<span class="form__req">必須</span></label>
              <input class="form__input" id="f-name" name="お名前" type="text" placeholder="山田 太郎" required>
            </div>
            <div>
              <label class="form__label" for="f-kana">ふりがな</label>
              <input class="form__input" id="f-kana" name="ふりがな" type="text" placeholder="やまだ たろう">
            </div>
          </div>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="f-email">メールアドレス<span class="form__req">必須</span></label>
              <input class="form__input" id="f-email" name="メール" type="email" placeholder="example@email.com" required>
            </div>
            <div>
              <label class="form__label" for="f-tel">電話番号</label>
              <input class="form__input" id="f-tel" name="電話番号" type="tel" placeholder="090-0000-0000">
            </div>
          </div>

          <div class="form__row">
            <label class="form__label" for="f-studio">ご希望のスタジオ</label>
            <select class="form__select" id="f-studio" name="希望スタジオ">
              <option value="">指定なし</option>
              <option>岡山スタジオ</option>
              <option>福山スタジオ</option>
              <option>どちらでも可</option>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="f-msg">ご相談内容・ご希望</label>
            <textarea class="form__textarea" id="f-msg" name="内容" placeholder="ご希望の間取り・ご予算・土地の有無・ご希望の連絡方法など、何でもお書きください。"></textarea>
          </div>

          <div class="form__row">
            <label class="form__agree">
              <input type="checkbox" name="同意" required>
              <span><a href="#">プライバシーポリシー</a>に同意のうえ送信します。<span class="form__req">必須</span></span>
            </label>
          </div>

          <div class="form__submit">
            <button type="submit" class="btn btn--accent">この内容で送信する</button>
            <p class="form__note">
              ※ 現在このフォームは表示確認用です。送信を有効にするには、フォームの送信先（Formspree等）またはWordPressの「Contact Form 7」への接続が必要です。
            </p>
          </div>
        </form>

        <p class="form__tel">お電話：<a href="tel:0862369600">086-236-9600</a>（岡山）／ <a href="tel:0849827404">084-982-7404</a>（福山）<br><span style="font-size:12px;">受付 9:00〜18:00 / 水曜定休</span></p>
      </div>
    </section>

<?php get_footer(); ?>
