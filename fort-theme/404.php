<?php
/** 404：見つからないページ。主要な入口へ案内する */
get_header(); ?>
	<header class="bh-pagehead bh-404">
		<div class="bh-wrap">
			<p class="bh-label">404 — NOT FOUND</p>
			<h1 class="bh-pagehead__title">お探しのページは、<br>見つかりませんでした。</h1>
			<p class="bh-pagehead__lead">移動したか、URLが変わった可能性があります。こちらからお探しください。</p>
			<ul class="bh-404__links">
				<?php foreach ( array( array( 'WORKS', '施工事例', 'works' ), array( 'EVENT', '見学会・相談会', 'event' ), array( 'HOUSE', '家づくり', 'house' ), array( 'VISIT', '来場予約', 'visit' ) ) as $l ) : ?>
				<li><a href="<?php echo esc_url( fort_url( $l[2] ) ); ?>"><span><?php echo esc_html( $l[0] ); ?></span><?php echo esc_html( $l[1] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<p class="bh-404__home"><a class="bh-more" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップへ</a></p>
		</div>
	</header>
<?php get_footer();
