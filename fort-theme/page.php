<?php
/** 固定ページ（プライバシーポリシー など、専用テンプレートの無いページ） */
get_header();
while ( have_posts() ) : the_post(); ?>
	<header class="bh-pagehead">
		<div class="bh-wrap">
			<?php fort_breadcrumb( array( array( get_the_title(), '' ) ) ); ?>
			<h1 class="bh-pagehead__title"><?php the_title(); ?></h1>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?><figure class="bh-case__main"><?php the_post_thumbnail( 'fort-hero', array( 'loading' => 'eager', 'alt' => '' ) ); ?></figure><?php endif; ?>
	<section class="bh-article">
		<div class="bh-wrap"><div class="bh-prose"><?php the_content(); ?></div></div>
	</section>
<?php endwhile;
get_footer();
