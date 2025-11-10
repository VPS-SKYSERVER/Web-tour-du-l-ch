<?php
/**
 * Template Name: Tour Landing Page
 *
 * Custom layout hiển thị các tour và nội dung liên quan cho từng điểm đến.
 *
 * @package TravelTour
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$page_id = get_the_ID();
$parent_cat_slug = get_post_meta($page_id, 'tour_landing_parent_cat', true);
$icon_lines = get_post_meta($page_id, 'tour_landing_icons', true);
$weather_title = get_post_meta($page_id, 'tour_landing_weather_title', true);
$weather_temp = get_post_meta($page_id, 'tour_landing_weather_temp', true);
$weather_desc = get_post_meta($page_id, 'tour_landing_weather_desc', true);
$post_category_slug = get_post_meta($page_id, 'tour_landing_post_category', true);

$icon_items = array();
if (!empty($icon_lines)) {
    $icon_rows = array_filter(array_map('trim', explode("\n", $icon_lines)));
    foreach ($icon_rows as $row) {
        $parts = array_map('trim', explode('|', $row));
        $icon_items[] = array(
            'icon' => $parts[0] ?? '',
            'title' => $parts[1] ?? '',
            'description' => $parts[2] ?? '',
        );
    }
}

$hero_image = get_the_post_thumbnail_url($page_id, 'full');

$featured_term = null;
$child_terms = array();
if (!empty($parent_cat_slug) && class_exists('WooCommerce')) {
    $featured_term = get_term_by('slug', $parent_cat_slug, 'product_cat');
    if ($featured_term && !is_wp_error($featured_term)) {
        $child_terms = get_terms(array(
            'taxonomy' => 'product_cat',
            'parent' => $featured_term->term_id,
            'hide_empty' => false,
        ));
    }
}
?>

<main id="main" class="site-main tour-landing-page">
    <section class="tour-landing-hero" <?php if ($hero_image) : ?>style="background-image: url('<?php echo esc_url($hero_image); ?>');"<?php endif; ?>>
        <div class="tour-landing-hero__overlay"></div>
        <div class="container">
            <div class="tour-landing-hero__content">
                <nav class="tour-landing-breadcrumb">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Trang chủ', 'traveltour'); ?></a>
                    <span aria-hidden="true">/</span>
                    <span><?php the_title(); ?></span>
                </nav>
                <h1 class="tour-landing-hero__title"><?php the_title(); ?></h1>
                <?php if (has_excerpt($page_id)) : ?>
                    <p class="tour-landing-hero__excerpt"><?php echo esc_html(get_the_excerpt($page_id)); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (!empty($child_terms)) : ?>
    <section class="tour-landing-category-grid">
        <div class="container">
            <h2 class="section-heading"><?php echo esc_html($featured_term ? $featured_term->name : get_the_title()); ?></h2>
            <div class="tour-landing-category-grid__items">
                <?php foreach ($child_terms as $term) : ?>
                    <?php
                    $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                    $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : '';
                    ?>
                    <a class="tour-landing-category-card" href="<?php echo esc_url(get_term_link($term)); ?>">
                        <?php if ($thumb_url) : ?>
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($term->name); ?>">
                        <?php endif; ?>
                        <span class="tour-landing-category-card__name"><?php echo esc_html($term->name); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($icon_items)) : ?>
    <section class="tour-landing-icons">
        <div class="container">
            <div class="tour-landing-icons__grid">
                <?php foreach ($icon_items as $icon_item) : ?>
                    <div class="tour-landing-icon-card">
                        <?php if (!empty($icon_item['icon'])) : ?>
                            <span class="tour-landing-icon-card__icon <?php echo esc_attr($icon_item['icon']); ?>"></span>
                        <?php endif; ?>
                        <?php if (!empty($icon_item['title'])) : ?>
                            <h3><?php echo esc_html($icon_item['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($icon_item['description'])) : ?>
                            <p><?php echo esc_html($icon_item['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="tour-landing-content">
        <div class="container">
            <div class="tour-landing-content__inner">
                <div class="tour-landing-content__main">
                    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    wp_reset_postdata();
                    ?>
                </div>
                <?php if ($weather_title || $weather_temp || $weather_desc) : ?>
                    <aside class="tour-landing-content__aside">
                        <?php if ($weather_title) : ?>
                            <h3><?php echo esc_html($weather_title); ?></h3>
                        <?php endif; ?>
                        <?php if ($weather_temp) : ?>
                            <p class="tour-landing-content__highlight"><?php echo esc_html($weather_temp); ?></p>
                        <?php endif; ?>
                        <?php if ($weather_desc) : ?>
                            <p><?php echo esc_html($weather_desc); ?></p>
                        <?php endif; ?>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="tour-landing-product-section">
        <div class="container">
            <header class="section-heading">
                <h2><?php esc_html_e('Danh sách tour nổi bật', 'traveltour'); ?></h2>
                <?php if ($featured_term) : ?>
                    <a class="tour-landing-view-all" href="<?php echo esc_url(get_term_link($featured_term)); ?>">
                        <?php esc_html_e('Xem tất cả tour', 'traveltour'); ?>
                    </a>
                <?php endif; ?>
            </header>
            <?php
            if (class_exists('WooCommerce') && !empty($parent_cat_slug)) :
                $product_query = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => 12,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $parent_cat_slug,
                            'include_children' => true,
                        ),
                    ),
                ));

                if ($product_query->have_posts()) :
                    ?>
                    <div class="tour-landing-products-grid">
                        <?php
                        while ($product_query->have_posts()) :
                            $product_query->the_post();
                            global $product;
                            $product = wc_get_product(get_the_ID());
                            if (!$product) {
                                continue;
                            }
                            get_template_part('template-parts/content', 'product-card');
                        endwhile;
                        wp_reset_postdata();
                        if (function_exists('wc_reset_loop')) {
                            wc_reset_loop();
                        }
                        ?>
                    </div>
                    <?php
                else :
                    ?>
                    <p class="tour-landing-empty"><?php esc_html_e('Hiện chưa có tour nào cho khu vực này.', 'traveltour'); ?></p>
                    <?php
                endif;
            else :
                ?>
                <p class="tour-landing-empty"><?php esc_html_e('WooCommerce chưa được kích hoạt hoặc chưa cấu hình danh mục tour.', 'traveltour'); ?></p>
                <?php
            endif;
            ?>
        </div>
    </section>

    <?php
    if (!empty($post_category_slug)) :
        $articles = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $post_category_slug,
                ),
            ),
        ));
        if ($articles->have_posts()) :
            ?>
            <section class="tour-landing-articles">
                <div class="container">
                    <header class="section-heading">
                        <h2><?php esc_html_e('Kinh nghiệm & bí kíp du lịch', 'traveltour'); ?></h2>
                        <?php
                        $article_category = get_category_by_slug($post_category_slug);
                        $article_category_link = $article_category ? get_category_link($article_category->term_id) : '#';
                        ?>
                        <a class="tour-landing-view-all" href="<?php echo esc_url($article_category_link); ?>">
                            <?php esc_html_e('Xem thêm bài viết', 'traveltour'); ?>
                        </a>
                    </header>
                    <div class="tour-landing-articles__grid">
                        <?php
                        while ($articles->have_posts()) :
                            $articles->the_post();
                            ?>
                            <article class="tour-landing-article-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" class="tour-landing-article-card__thumb">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="tour-landing-article-card__content">
                                    <span class="tour-landing-article-card__date"><?php echo esc_html(get_the_date()); ?></span>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </section>
            <?php
        endif;
    endif;
    ?>
</main>

<?php
get_footer();


