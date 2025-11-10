<?php
/**
 * The template for displaying archive pages
 *
 * @package TravelTour
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="archive-header">
        <div class="container">
            <?php
            the_archive_title('<h1 class="archive-title">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
            ?>
        </div>
    </div>

    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', get_post_type());
                endwhile;
                ?>
            </div>

            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('&laquo; Trước', 'traveltour'),
                'next_text' => __('Sau &raquo;', 'traveltour'),
            ));
            ?>

        <?php else : ?>
            <?php get_template_part('template-parts/content', 'none'); ?>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();

