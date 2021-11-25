<?php
/**
 * @package WordPress
 * @subpackage Londres
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-above" role="article">
		<h1 class="section-heading"><?php esc_html_e( 'Post navigation', 'londres' ); ?></h1>
		<div class="nav-previous"><?php next_posts_link( esc_html__( '<span class="meta-nav">&larr;</span> Older posts', 'londres' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'londres' ) ); ?></div>
	</nav><!-- #nav-above -->
<?php endif; ?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php esc_attr(the_ID()); ?>" <?php post_class(); ?> role="article">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php esc_url(the_permalink()); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'londres' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php esc_html(the_title()); ?></a></h1>

			<div class="entry-meta">
				<?php
					wp_kses_post(printf( esc_html__( '<span class="sep">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'londres' ),
						get_permalink(),
						get_the_date( 'c' ),
						get_the_date(),
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
						sprintf( esc_attr__( 'View all posts by %s', 'londres' ), get_the_author() ),
						get_the_author()
					));
				?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<?php if ( is_archive() || is_search() ) : // Only display Excerpts for archives & search ?>
		<div class="entry-summary">
			<?php wp_kses_post(the_excerpt()); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php wp_kses_post(the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'londres' ) )); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'londres' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<span class="cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links"><?php esc_html_e( 'Posted in ', 'londres' ); ?></span><?php the_category( ', ' ); ?></span>
			<span class="meta-sep"> | </span>
			<?php wp_kses_post(the_tags( '<span class="tag-links">' . esc_html__( 'Tagged ', 'londres' ) . '</span>', ', ', '<span class="meta-sep"> | </span>' )); ?>
			<span class="comments-link"><?php wp_kses_post(comments_popup_link( esc_html__( 'Leave a comment', 'londres' ), esc_html__( '1 Comment', 'londres' ), esc_html__( '% Comments', 'londres' ) )); ?></span>
			<?php wp_kses_post(edit_post_link( esc_html__( 'Edit', 'londres' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' )); ?>
		</footer><!-- #entry-meta -->
	</article><!-- #post-<?php the_ID(); ?> -->

	<?php comments_template( '', true ); ?>

<?php endwhile; ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-below" role="article">
		<h1 class="section-heading"><?php esc_html_e( 'Post navigation', 'londres' ); ?></h1>
		<div class="nav-previous"><?php next_posts_link( esc_html__( '<span class="meta-nav">&larr;</span> Older posts', 'londres' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'londres' ) ); ?></div>
	</nav><!-- #nav-below -->
<?php endif; ?>
