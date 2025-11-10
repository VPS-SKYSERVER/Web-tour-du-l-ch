<?php
/**
 * The template for displaying search results
 *
 * @package TravelTour
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <header class="page-header" style="padding: 40px 0; text-align: center;">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Kết quả tìm kiếm cho: %s', 'traveltour'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="search-results">
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

