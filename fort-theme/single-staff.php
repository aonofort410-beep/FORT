<?php
/** スタッフ 個別ページ（スタッフ一覧のプロフィールと同じ内容。JSが無い環境・直接来た人向け） */
get_header();
while ( have_posts() ) : the_post();
	$s = fort_staff_data( get_post() ); ?>
	<article class="st-single">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( 'STAFF', fort_url( 'staff' ) ), array( $s['name'], '' ) ) ); ?>
			<div class="st-modal__grid st-single__grid">
				<figure class="st-modal__fig<?php echo $s['photo'] ? '' : ' is-mono'; ?>"><?php if ( $s['photo'] ) : ?><img src="<?php echo esc_url( $s['photo'] ); ?>" alt="<?php echo esc_attr( $s['name'] ); ?>"><?php else : ?><span class="st-card__ini"><?php echo esc_html( $s['ini'] ); ?></span><?php endif; ?></figure>
				<div class="st-modal__body">
					<p class="st-card__dept"><?php echo esc_html( $s['dept_en'] ); ?></p>
					<h1 class="st-modal__name"><?php echo esc_html( $s['name'] ); ?></h1>
					<p class="st-modal__en"><?php echo esc_html( $s['en'] ); ?></p>
					<dl class="bh-spec"><div><dt>役職</dt><dd><?php echo esc_html( $s['role'] ); ?></dd></div><?php if ( $s['cred'] ) : ?><div><dt>資格</dt><dd><?php echo esc_html( $s['cred'] ); ?></dd></div><?php endif; ?></dl>
					<?php if ( $s['msg'] ) : ?><p class="st-modal__msg"><?php echo nl2br( esc_html( $s['msg'] ) ); ?></p><?php endif; ?>
					<p><a class="bh-more" href="<?php echo esc_url( fort_url( 'staff' ) ); ?>">スタッフ一覧へ</a></p>
				</div>
			</div>
		</div>
	</article>
	<?php get_template_part( 'parts/visit-cta', null, array( 'from' => 'staff_single' ) ); ?>
<?php endwhile; get_footer(); ?>
