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
                    
                    <div class="product-rating">
                        <?php
                        $rating = $product->get_average_rating();
                        if ($rating > 0) {
                            echo '<div class="rating-stars">';
                            echo str_repeat('★', floor($rating));
                            echo str_repeat('☆', 5 - floor($rating));
                            echo '</div>';
                            echo '<span class="rating-text">' . $rating . ' / 5 (' . $product->get_rating_count() . ' ' . __('đánh giá', 'traveltour') . ')</span>';
                        }
                        ?>
                    </div>

                    <div class="product-price">
                        <?php echo $product->get_price_html(); ?>
                    </div>

                    <?php
                    // Tour specific information
                    $duration = get_post_meta(get_the_ID(), '_tour_duration', true);
                    $departure = get_post_meta(get_the_ID(), '_tour_departure', true);
                    $destination = get_post_meta(get_the_ID(), '_tour_destination', true);
                    ?>

                    <div class="tour-info">
                        <?php if ($duration) : ?>
                            <div class="info-item">
                                <strong><?php _e('Thời gian:', 'traveltour'); ?></strong> <?php echo esc_html($duration); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($departure) : ?>
                            <div class="info-item">
                                <strong><?php _e('Điểm khởi hành:', 'traveltour'); ?></strong> <?php echo esc_html($departure); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($destination) : ?>
                            <div class="info-item">
                                <strong><?php _e('Điểm đến:', 'traveltour'); ?></strong> <?php echo esc_html($destination); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-description">
                        <?php the_content(); ?>
                    </div>

                    <!-- Booking Form -->
                    <div class="booking-form-wrapper">
                        <h3><?php _e('Đặt tour', 'traveltour'); ?></h3>
                        <?php get_template_part('template-parts/booking', 'form'); ?>
                    </div>

                    <!-- Add to Cart -->
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>
            </div>

            <!-- Tour Itinerary -->
            <?php
            $itinerary = get_post_meta(get_the_ID(), '_tour_itinerary', true);
            if ($itinerary) :
                ?>
                <div class="tour-itinerary">
                    <h2><?php _e('Lịch trình tour', 'traveltour'); ?></h2>
                    <div class="itinerary-content">
                        <?php echo wpautop($itinerary); ?>
                    </div>
                </div>
            <?php endif; ?>

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

