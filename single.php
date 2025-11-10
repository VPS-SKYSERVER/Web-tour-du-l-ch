<?php
/**
 * The template for displaying all single posts
 *
 * @package TravelTour
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'single');
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();

