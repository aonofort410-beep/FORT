<?php
/*
 * Template Name: ご来場予約
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
        <p class="subhero__eyebrow" data-reveal>VISIT RESERVATION</p>
        <h1 class="subhero__title" data-reveal>ご来場予約</h1>
        <nav class="breadcrumb" aria-label="現在地">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a><span>／</span><span>ご来場予約</span>
        </nav>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <p class="page-lead" data-reveal>
          スタジオへのご来場は、ご予約優先で承っています。<br>
          ご希望の日時・スタジオ・建築のご予定をお選びください。担当者より折り返しご連絡いたします。
        </p>

        <!-- ★ action を実際の送信先（Formspree等）に変更してください -->
        <form class="form" action="#" method="POST" data-reveal>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="v-date">ご希望日<span class="form__req">必須</span></label>
              <input class="form__input" id="v-date" name="希望日" type="date" required>
            </div>
            <div>
              <label class="form__label" for="v-time">ご希望時間帯<span class="form__req">必須</span></label>
              <select class="form__select" id="v-time" name="希望時間帯" required>
                <option value="">選択してください</option>
                <option>10:00〜</option>
                <option>11:00〜</option>
                <option>13:00〜</option>
                <option>14:00〜</option>
                <option>15:00〜</option>
                <option>16:00〜</option>
              </select>
            </div>
          </div>

          <div class="form__row">
            <label class="form__label" for="v-date2">第2希望日（任意）</label>
            <input class="form__input" id="v-date2" name="第2希望日" type="date">
          </div>

          <div class="form__row">
            <label class="form__label" for="v-studio">ご希望のスタジオ<span class="form__req">必須</span></label>
            <select class="form__select" id="v-studio" name="希望スタジオ" required>
              <option value="">選択してください</option>
              <option>岡山スタジオ（岡山市北区問屋町）</option>
              <option>福山スタジオ（広島県福山市）</option>
              <option>岡山玉野モデルハウス</option>
              <option>福山下加茂モデルハウス</option>
              <option>どちらでも可・相談したい</option>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="v-timing">建築（ご入居）希望時期<span class="form__req">必須</span></label>
            <select class="form__select" id="v-timing" name="建築希望時期" required>
              <option value="">選択してください</option>
              <option>3ヶ月以内</option>
              <option>半年以内</option>
              <option>1年以内</option>
              <option>1〜2年以内</option>
              <option>2年以降・未定</option>
              <option>情報収集中</option>
            </select>
          </div>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="v-name">お名前<span class="form__req">必須</span></label>
              <input class="form__input" id="v-name" name="お名前" type="text" placeholder="山田 太郎" required>
            </div>
            <div>
              <label class="form__label" for="v-kana">ふりがな</label>
              <input class="form__input" id="v-kana" name="ふりがな" type="text" placeholder="やまだ たろう">
            </div>
          </div>

          <div class="form__row form__row--2">
            <div>
              <label class="form__label" for="v-email">メールアドレス<span class="form__req">必須</span></label>
              <input class="form__input" id="v-email" name="メール" type="email" placeholder="example@email.com" required>
            </div>
            <div>
              <label class="form__label" for="v-tel">電話番号<span class="form__req">必須</span></label>
              <input class="form__input" id="v-tel" name="電話番号" type="tel" placeholder="090-0000-0000" required>
            </div>
          </div>

          <div class="form__row">
            <label class="form__label" for="v-num">ご来場人数</label>
            <select class="form__select" id="v-num" name="来場人数">
              <option value="">指定なし</option>
              <option>大人1名</option>
              <option>大人2名</option>
              <option>大人2名＋お子さま</option>
              <option>その他（ご相談欄にご記入ください）</option>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="v-msg">ご相談内容・ご希望（任意）</label>
            <textarea class="form__textarea" id="v-msg" name="内容" placeholder="ご予算・土地の有無・気になっている商品（STYLE／PRO／DESIGN）など、何でもお書きください。"></textarea>
          </div>

          <div class="form__row">
            <label class="form__agree">
              <input type="checkbox" name="同意" required>
              <span><a href="#">プライバシーポリシー</a>に同意のうえ送信します。<span class="form__req">必須</span></span>
            </label>
          </div>

          <div class="form__submit">
            <button type="submit" class="btn btn--accent">この内容で来場予約する</button>
            <p class="form__note">
              ※ ご予約日時は確定ではありません。内容を確認のうえ、担当者より日程確定のご連絡をいたします。<br>
              ※ 現在このフォームは表示確認用です。送信を有効にするには、フォームの送信先（Formspree等）またはWordPressの「Contact Form 7」への接続が必要です。
            </p>
          </div>
        </form>

        <p class="form__tel">お電話でのご予約：<a href="tel:0862369600">086-236-9600</a>（岡山）／ <a href="tel:0849827404">084-982-7404</a>（福山）<br><span style="font-size:12px;">受付 9:00〜18:00 / 水曜定休</span></p>
      </div>
    </section>

<?php get_footer(); ?>
