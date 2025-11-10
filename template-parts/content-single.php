<?php
/**
 * Template part for displaying single posts
 *
 * @package TravelTour
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

        <div class="entry-meta">
            <span class="posted-on">
                <time datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date(); ?>
                </time>
            </span>
            <span class="byline">
                <?php _e('bởi', 'traveltour'); ?> 
                <span class="author vcard">
                    <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php echo get_the_author(); ?>
                    </a>
                </span>
            </span>
            <?php if (has_category()) : ?>
                <span class="cat-links">
                    <?php _e('Danh mục:', 'traveltour'); ?> <?php the_category(', '); ?>
                </span>
            <?php endif; ?>
        </div>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'traveltour'),
            'after' => '</div>',
        ));
        ?>
    </div>

    <footer class="entry-footer">
        <?php if (has_tag()) : ?>
            <div class="tags-links">
                <?php _e('Tags:', 'traveltour'); ?> <?php the_tags('', ', ', ''); ?>
            </div>
        <?php endif; ?>
    </footer>
</article>

<?php
// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()) :
    comments_template();
endif;
?>

