<?php
/**
 * HOUSE（家づくりの方法）と性能・設備の共通データ
 * ------------------------------------------------------------
 * ・3シリーズの説明・価格、性能グレード（STANDARD / PLUS）、設備グレード比較表を、ここ1か所で管理
 * ・内容は FORT の資料（シリーズセレクト／パフォーマンス／設備グレード比較表／PERFORMANCE STANDARD）による
 * ・数値を変えるときは、このファイルだけを書き換えれば全ページに反映される
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** 3つのシリーズ */
function fort_house_items() {
	return array(
		'design' => array(
			'name'    => 'FORT DESIGN',
			'method'  => 'フルオーダー住宅',
			'en'      => 'FULL ORDER',
			'catch'   => '理想を、ゼロからカタチにする。',
			'text'    => '設計・素材・設備のすべてを自由に選べるフルオーダー住宅。専属設計士と共に、世界にひとつだけの理想の住まいを実現します。',
			'for'     => array( '理想を追求したい', '素材や設備にこだわりたい', 'あなただけの一邸を建てたい' ),
			'points'  => array( '完全自由設計', '素材・設備を自由に選択', '専属設計士と家づくり' ),
			'freedom' => '完全自由設計',
			'choose'  => '素材・設備を自由に選択',
			'price'   => '',
			'price_text' => '価格は仕様・プランにより変動します',
			'price_note' => '詳細はスタッフまでお問い合わせください',
			'photo'   => 'design',
		),
		'pro' => array(
			'name'    => 'FORT PRO',
			'method'  => 'セミオーダー住宅',
			'en'      => 'SEMI ORDER',
			'catch'   => '選んでつくる、自分らしい住まい。',
			'text'    => 'キッチンや床材、建具などの設備や内装をお好みに合わせてセレクト。自由度と価格のバランスを両立した、人気のセミオーダー住宅です。',
			'for'     => array( '自分らしさも大切にしたい', 'バランスを取りたい', '選択しながらつくりたい' ),
			'points'  => array( 'プランはベースから選択', '設備・内装を自由にセレクト可能', '納得感のあるコストと仕上がり' ),
			'freedom' => 'プランはベースから選択',
			'choose'  => '設備・内装を自由にセレクト',
			'price'   => '2,200万円〜',
			'price_text' => '',
			'price_note' => '本体価格（税別）・30坪・2階建の目安価格',
			'photo'   => 'pro',
		),
		'style' => array(
			'name'    => 'FORT STYLE',
			'method'  => '規格住宅',
			'en'      => 'STANDARD PLAN',
			'catch'   => '完成されたプランを、高品質・適正価格で。',
			'text'    => 'FORTが厳選した間取り・デザイン・設備を採用し、無駄を省いた効率的な家づくりを実現。仕様・間取りの変更はできません。',
			'for'     => array( 'コストを抑えたい', '実際に見て安心したい', 'スムーズに進めたい' ),
			'points'  => array( '間取り・仕様の変更はできません', '厳選されたプランをご提供', '手の届きやすい価格で高品質' ),
			'freedom' => '完成されたプラン（変更なし）',
			'choose'  => '厳選されたプランから選ぶ',
			'price'   => '1,900万円〜',
			'price_text' => '',
			'price_note' => '本体価格（税別）・30坪・2階建の目安価格',
			'photo'   => 'style',
		),
	);
}

/** 価格の表示（金額があれば金額、無ければ文章） */
function fort_house_price( $it ) {
	return $it['price'] ? $it['price'] : $it['price_text'];
}

/** 設備グレード比較表（順番：STYLE / PRO / DESIGN）。[項目, 補足, [STYLE, PRO, DESIGN]] */
function fort_equipment_table() {
	return array(
		array( '外壁', 'デザイン・耐久性', array( '窯業系サイディング（指定品）', "窯業系サイディング\n＋ガルバリウム鋼板", '自由選択（塗壁・タイル・ガルバなど）' ) ),
		array( 'サッシ（窓）', '断熱性・快適性', array( 'APW330 樹脂サッシ Low-Eペアガラス', 'APW330 樹脂サッシ Low-Eペアガラス', 'APW430 樹脂サッシ Low-Eトリプルガラス' ) ),
		array( '玄関ドア', '断熱性・防犯性', array( 'YKK AP ヴェナート D30（ポケットKey）', 'YKK AP ヴェナート D30（ポケットKey）', 'YKK AP ヴェナート D30（ポケットKey）' ) ),
		array( 'キッチン', '使いやすさ・お手入れ', array( 'Panasonic Sクラス', "Panasonic Sクラス\nクリナップ ステディア\nタカラスタンダード オフェリア", 'メーカー自由選択' ) ),
		array( '浴室', 'くつろぎ・お手入れ', array( 'Panasonic オフローラ 1616', "Panasonic オフローラ 1616\nクリナップ RVT\nタカラスタンダード リラクシア", 'メーカー自由選択' ) ),
		array( '洗面化粧台', '収納力・お手入れ', array( 'Panasonic シーライン', 'アイカ スタイリッシュカウンター', 'アイカ スマートサニタリー など自由選択' ) ),
		array( 'トイレ', '清潔・節水', array( "1F：Panasonic アラウーノZ\n2F：Panasonic アラウーノV", "1F：TOTO NJ2\n2F：TOTO ZJ2", "1F：TOTO NJ2\n2F：TOTO ZJ2" ) ),
		array( '床材', '足ざわり・高級感', array( 'Panasonic PLフロア（シート）', 'ikuta 銘木フローラスティック', '無垢材／突板／タイル など自由選択' ) ),
		array( '建具（室内ドア）', 'デザイン・機能性', array( 'Panasonic ベリティス（H2400）', 'Panasonic ベリティス（H2400）', 'メーカー等自由選択' ) ),
		array( '収納', '収納力・使いやすさ', array( '南海プライウッド', '南海プライウッド', 'メーカー等自由選択（造作収納・WIC など）' ) ),
		array( '換気システム', '空気環境・健康', array( '第三種換気', '第一種換気（熱交換）', '第一種換気（熱交換）' ) ),
		array( '給湯器', '省エネ・快適', array( 'エコキュート / ガス給湯器 選択可能', 'エコキュート / ガス給湯器 選択可能', 'エコキュート / ガス給湯器 選択可能' ) ),
		array( '保証・点検', '安心のサポート', array( '躯体10年', '躯体20年（最長60年）／設備10年', '躯体20年（最長60年）／設備10年' ) ),
	);
}

/** 性能：FORTの考え方と最高基準・実績。[項目, 考え方, 最高基準・実績, 構造・性能ページの章ID] */
function fort_performance_grades() {
	return array(
		array( '耐震', '建物・間取り・予算に合わせて設計', '耐震等級3まで対応', 'structure' ),
		array( '構造計算', '必要に応じて選択', '許容応力度計算 対応', 'structure' ),
		array( '制振', '求める安心に合わせて選択', 'evoltz 対応', 'damping' ),
		array( '断熱', 'UA値0.46以下を基準に設計', 'UA値0.34以下まで対応', 'insulation' ),
		array( '気密', '<b>C値0.5以下</b>を基準', '現在の実測平均 C値0.2以下', 'airtight' ),
		array( '窓', '方角・開口・デザインに合わせて選定', 'APW430等まで対応', 'window' ),
		array( '換気', '暮らし・空調計画に合わせて選択', '第一種熱交換換気まで対応', 'ventilation' ),
	);
}

/** 性能の表（構造・性能ページ／HOUSEページ共通） */
function fort_performance_table( $link = '' ) {
	ob_start(); ?>
	<div class="pf-std__table" role="table" aria-label="FORTの考え方と最高基準・実績">
		<div class="pf-std__row pf-std__row--head" role="row"><span role="columnheader"></span><span role="columnheader">FORTの考え方</span><span role="columnheader">最高基準・実績</span></div>
		<?php foreach ( fort_performance_grades() as $r ) : ?>
		<a class="pf-std__row" role="row" href="<?php echo esc_url( $link ) . '#' . esc_attr( $r[3] ); ?>"><b role="rowheader"><?php echo esc_html( $r[0] ); ?></b><span role="cell" data-h="FORTの考え方"><?php echo wp_kses( $r[1], array( 'b' => array() ) ); ?></span><strong role="cell" data-h="最高基準・実績"><?php echo esc_html( $r[2] ); ?></strong></a>
		<?php endforeach; ?>
	</div>
	<?php return ob_get_clean();
}

/** 改行入りの文字列を安全に表示 */
function fort_br( $text ) {
	return nl2br( esc_html( $text ), false );
}
