<?php
/**
 * Template part for displaying homepage content
 *
 * @package TravelTour
 */
?>

<!-- Main Banner -->
<?php
$banner_image = get_theme_mod('traveltour_banner_image', '');
$banner_title = get_theme_mod('traveltour_banner_title', __('Khuyến mãi đặc biệt - Giảm giá lên đến 50%', 'traveltour'));
$banner_text = get_theme_mod('traveltour_banner_text', __('Đặt tour ngay hôm nay để nhận ưu đãi tốt nhất!', 'traveltour'));
$banner_link = get_theme_mod('traveltour_banner_link', '#');
?>
<section class="main-banner">
    <?php if ($banner_image) : ?>
        <img src="<?php echo esc_url($banner_image); ?>" alt="<?php echo esc_attr($banner_title); ?>" class="banner-image">
    <?php else : ?>
        <div class="banner-image" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); height: 400px;"></div>
    <?php endif; ?>
    <div class="banner-content">
        <h2><?php echo esc_html($banner_title); ?></h2>
        <p><?php echo esc_html($banner_text); ?></p>
        <a href="<?php echo esc_url($banner_link); ?>" class="btn-primary"><?php _e('Đặt ngay', 'traveltour'); ?></a>
    </div>
</section>

<!-- Featured Services -->
<section class="featured-services">
    <div class="container">
        <div class="services-grid">
            <div class="service-item">
                <div class="service-icon">✈️</div>
                <h3><?php _e('Tour trọn gói', 'traveltour'); ?></h3>
                <p><?php _e('Tour du lịch chất lượng cao', 'traveltour'); ?></p>
            </div>
            <div class="service-item">
                <div class="service-icon">🏨</div>
                <h3><?php _e('Khách sạn', 'traveltour'); ?></h3>
                <p><?php _e('Đặt phòng khách sạn giá tốt', 'traveltour'); ?></p>
            </div>
            <div class="service-item">
                <div class="service-icon">🎫</div>
                <h3><?php _e('Vé máy bay', 'traveltour'); ?></h3>
                <p><?php _e('Vé máy bay giá rẻ nhất', 'traveltour'); ?></p>
            </div>
            <div class="service-item">
                <div class="service-icon">🛡️</div>
                <h3><?php _e('Bảo hiểm du lịch', 'traveltour'); ?></h3>
                <p><?php _e('Bảo vệ chuyến đi của bạn', 'traveltour'); ?></p>
            </div>
            <div class="service-item">
                <div class="service-icon">📖</div>
                <h3><?php _e('Cẩm nang du lịch', 'traveltour'); ?></h3>
                <p><?php _e('Thông tin hữu ích cho chuyến đi', 'traveltour'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Tours -->
<?php if (class_exists('WooCommerce')) : ?>
<section class="category-section">
    <div class="container">
        <h2 class="section-title"><?php _e('Tour nổi bật', 'traveltour'); ?></h2>
        <div class="products-grid">
            <?php
            $featured_tours = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'meta_key' => '_featured',
                'meta_value' => 'yes',
                'orderby' => 'date',
                'order' => 'DESC',
            ));

            if ($featured_tours->have_posts()) :
                while ($featured_tours->have_posts()) : $featured_tours->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ($product->is_on_sale()) : ?>
                                <span class="product-badge"><?php _e('Giảm giá', 'traveltour'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <?php
                                    $rating = $product->get_average_rating();
                                    if ($rating > 0) {
                                        echo str_repeat('★', floor($rating));
                                        echo str_repeat('☆', 5 - floor($rating));
                                        echo ' (' . $product->get_rating_count() . ')';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="product-price">
                                <span class="price-current"><?php echo $product->get_price_html(); ?></span>
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="price-old"><?php echo wc_price($product->get_regular_price()); ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="product-button"><?php _e('Xem chi tiết', 'traveltour'); ?></a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback: Show regular products
                $tours = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => 8,
                ));
                if ($tours->have_posts()) :
                    while ($tours->have_posts()) : $tours->the_post();
                        global $product;
                        get_template_part('template-parts/content', 'product-card');
                    endwhile;
                    wp_reset_postdata();
                endif;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Promotional Tours -->
<section class="category-section" style="background-color: var(--bg-light);">
    <div class="container">
        <h2 class="section-title"><?php _e('Tour khuyến mãi', 'traveltour'); ?></h2>
        <div class="products-grid">
            <?php
            $sale_tours = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'meta_query' => array(
                    array(
                        'key' => '_sale_price',
                        'value' => '',
                        'compare' => '!=',
                    ),
                ),
            ));

            if ($sale_tours->have_posts()) :
                while ($sale_tours->have_posts()) : $sale_tours->the_post();
                    global $product;
                    get_template_part('template-parts/content', 'product-card');
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Blog Section -->
<section class="blog-section">
    <div class="container">
        <h2 class="section-title"><?php _e('Tin tức & Cẩm nang du lịch', 'traveltour'); ?></h2>
        <div class="blog-grid">
            <?php
            $blog_posts = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC',
            ));

            if ($blog_posts->have_posts()) :
                while ($blog_posts->have_posts()) : $blog_posts->the_post();
                    ?>
                    <article class="blog-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="blog-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="blog-content">
                            <div class="blog-date"><?php echo get_the_date(); ?></div>
                            <h3 class="blog-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="blog-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-primary"><?php _e('Đọc thêm', 'traveltour'); ?></a>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title"><?php _e('Cảm nhận khách hàng', 'traveltour'); ?></h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-text">
                    "Tour rất tuyệt vời! Hướng dẫn viên nhiệt tình, lịch trình hợp lý. Chúng tôi đã có một chuyến đi đáng nhớ."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: #ddd; width: 50px; height: 50px; border-radius: 50%;"></div>
                    <div class="author-info">
                        <h4>Nguyễn Văn A</h4>
                        <p>Khách hàng</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    "Dịch vụ chuyên nghiệp, giá cả hợp lý. Sẽ quay lại đặt tour trong tương lai."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: #ddd; width: 50px; height: 50px; border-radius: 50%;"></div>
                    <div class="author-info">
                        <h4>Trần Thị B</h4>
                        <p>Khách hàng</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    "Rất hài lòng với chất lượng tour. Đặc biệt là khách sạn và bữa ăn rất tốt."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background: #ddd; width: 50px; height: 50px; border-radius: 50%;"></div>
                    <div class="author-info">
                        <h4>Lê Văn C</h4>
                        <p>Khách hàng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Secondary Banner -->
<section class="secondary-banner" style="margin: 40px 0;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #4CAF50, #45a049); padding: 40px; border-radius: 10px; text-align: center; color: #fff;">
            <h2 style="margin-bottom: 15px;"><?php _e('Đặt vé tàu hỏa - Giá tốt nhất', 'traveltour'); ?></h2>
            <p style="margin-bottom: 20px;"><?php _e('Đặt vé tàu hỏa nhanh chóng, tiện lợi với giá ưu đãi', 'traveltour'); ?></p>
            <a href="#" class="btn-primary" style="background: #fff; color: #4CAF50;"><?php _e('Đặt vé ngay', 'traveltour'); ?></a>
        </div>
    </div>
</section>

