<?php
/**
 * The template for displaying single product/tour
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
            global $product;
            ?>
            <div class="product-detail-wrapper">
                <div class="product-gallery">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('large');
                    }
                    
                    // Get product gallery
                    $attachment_ids = $product->get_gallery_image_ids();
                    if ($attachment_ids) {
                        echo '<div class="product-gallery-thumbs">';
                        foreach ($attachment_ids as $attachment_id) {
                            echo wp_get_attachment_image($attachment_id, 'thumbnail');
                        }
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="product-summary">
                    <h1 class="product-title"><?php the_title(); ?></h1>

                    <?php
                    // Tour specific information
                    $duration = get_post_meta(get_the_ID(), '_tour_duration', true);
                    $departure = get_post_meta(get_the_ID(), '_tour_departure', true);
                    $destination = get_post_meta(get_the_ID(), '_tour_destination', true);
                    $transport = get_post_meta(get_the_ID(), '_tour_transport', true); // optional
                    $standard  = get_post_meta(get_the_ID(), '_tour_standard', true);  // optional
                    ?>

                    <div class="product-summary-card">
                        <div class="summary-price">
                            <span class="summary-price__label"><?php _e('Giá đang khuyến mãi', 'traveltour'); ?></span>
                            <div class="summary-price__value"><?php echo $product->get_price_html(); ?></div>
                        </div>

                        <div class="summary-specs">
                            <div class="spec-pair">
                                <div class="spec-cell">
                                    <span class="spec-title"><?php _e('Thời gian', 'traveltour'); ?>:</span>
                                    <span class="spec-val"><?php echo esc_html($duration ?: ''); ?></span>
                                </div>
                                <div class="spec-cell">
                                    <span class="spec-title"><?php _e('Phương tiện', 'traveltour'); ?>:</span>
                                    <span class="spec-val"><?php echo esc_html($transport ?: ''); ?></span>
                                </div>
                            </div>
                            <?php if ($standard) : ?>
                                <div class="spec-row-full">
                                    <span class="spec-title"><?php _e('Tiêu chuẩn', 'traveltour'); ?>:</span>
                                    <span class="spec-val"><?php echo esc_html($standard); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="summary-rating">
                            <?php
                            $rating = $product->get_average_rating();
                            if ($rating > 0) {
                                echo '<span class="rating-stars">';
                                echo str_repeat('★', floor($rating));
                                echo str_repeat('☆', 5 - floor($rating));
                                echo '</span>';
                                echo '<span class="rating-text"> (' . $product->get_rating_count() . ' ' . __('lượt đánh giá', 'traveltour') . ')</span>';
                            } else {
                                echo '<span class="rating-text">' . __('Chưa có đánh giá', 'traveltour') . '</span>';
                            }
                            ?>
                        </div>

                        <div class="summary-actions">
                            <?php
                            if (function_exists('woocommerce_template_single_add_to_cart')) {
                                // Temporarily remove quantity field before rendering button
                                remove_action('woocommerce_before_add_to_cart_button', 'woocommerce_quantity_input', 10);
                                woocommerce_template_single_add_to_cart();
                                // Re-add quantity for other product renders
                                add_action('woocommerce_before_add_to_cart_button', 'woocommerce_quantity_input', 10);
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Feature checklist (visual boxes) -->
                    <div class="tour-feature-grid">
                        <div class="tour-feature-item">
                            <span class="tour-feature-icon">🧾</span>
                            <span class="tour-feature-label"><?php _e('Vé tham quan', 'traveltour'); ?></span>
                        </div>
                        <div class="tour-feature-item">
                            <span class="tour-feature-icon">🚗</span>
                            <span class="tour-feature-label"><?php _e('Phương tiện', 'traveltour'); ?></span>
                        </div>
                        <div class="tour-feature-item">
                            <span class="tour-feature-icon">🍽️</span>
                            <span class="tour-feature-label"><?php _e('Ăn uống', 'traveltour'); ?></span>
                        </div>
                        <div class="tour-feature-item">
                            <span class="tour-feature-icon">🏨</span>
                            <span class="tour-feature-label"><?php _e('Khách sạn', 'traveltour'); ?></span>
                        </div>
                        <div class="tour-feature-item">
                            <span class="tour-feature-icon">🧭</span>
                            <span class="tour-feature-label"><?php _e('Hướng dẫn viên', 'traveltour'); ?></span>
                        </div>
                        <div class="tour-feature-item">
                            <span class="tour-feature-icon">🛟</span>
                            <span class="tour-feature-label"><?php _e('Bảo hiểm', 'traveltour'); ?></span>
                        </div>
                    </div>

                    <!-- Booking Form removed by request -->
                </div>
            </div>

            <!-- Callback Request Banner -->
            <?php
            $hero = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
            <section class="callback-banner" <?php if ($hero) : ?>style="background-image: url('<?php echo esc_url($hero); ?>');"<?php endif; ?>>
                <div class="callback-banner__overlay">
                    <div class="container">
                        <div class="callback-banner__inner">
                            <h2 class="callback-banner__title"><?php _e('Yêu cầu tư vấn miễn phí', 'traveltour'); ?></h2>
                            <p class="callback-banner__subtitle"><?php _e('Nhập SĐT chúng tôi sẽ liên lạc với bạn trong 5 phút !!!', 'traveltour'); ?></p>
                            <form id="traveltour-callback-form" class="callback-form">
                                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('traveltour_nonce')); ?>">
                                <input type="hidden" name="product_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                                <input type="tel" name="phone" class="callback-input" placeholder="<?php esc_attr_e('Nhập số điện thoại tại đây', 'traveltour'); ?>" required>
                                <button type="submit" class="callback-button"><?php _e('Gửi', 'traveltour'); ?></button>
                            </form>
                            <div id="callback-message" class="callback-message" style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tour Tabs: Itinerary (from content) & Gallery -->
            <?php
            // Build gallery ids: include featured + gallery images
            $gallery_ids = is_object($product) ? $product->get_gallery_image_ids() : array();
            $featured_id = get_post_thumbnail_id(get_the_ID());
            if ($featured_id) {
                array_unshift($gallery_ids, $featured_id);
                $gallery_ids = array_unique($gallery_ids);
            }
            ?>
            <section class="tour-tabs">
                <div class="container">
                    <div class="tour-tabs__nav" role="tablist">
                        <button class="tour-tab-button is-active" data-tab="itinerary" aria-selected="true">
                            <?php _e('Lịch trình tour', 'traveltour'); ?>
                        </button>
                        <button class="tour-tab-button" data-tab="gallery" aria-selected="false">
                            <?php _e('Hình ảnh', 'traveltour'); ?>
                        </button>
                    </div>
                    <div class="tour-tabs__content">
                        <div id="tour-tab-itinerary" class="tour-tab-panel is-active" role="tabpanel">
                            <div class="itinerary-content">
                                <?php
                                // Render the main description as the itinerary/program
                                the_content();
                                ?>
                            </div>
                        </div>
                        <div id="tour-tab-gallery" class="tour-tab-panel" role="tabpanel">
                            <?php if (!empty($gallery_ids)) : ?>
                                <div class="tour-gallery-grid">
                                    <?php foreach ($gallery_ids as $gid) : ?>
                                        <a href="<?php echo esc_url(wp_get_attachment_image_url($gid, 'large')); ?>" class="tour-gallery-item" target="_blank" rel="noopener">
                                            <?php echo wp_get_attachment_image($gid, 'medium_large'); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p><?php _e('Chưa có hình ảnh cho tour này.', 'traveltour'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Reviews -->
            <div class="product-reviews">
                <?php comments_template(); ?>
            </div>

            <?php
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();

