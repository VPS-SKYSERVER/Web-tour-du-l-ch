<?php
/**
 * Template part for displaying product card
 *
 * @package TravelTour
 */
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
            <?php
            $duration = get_post_meta(get_the_ID(), '_tour_duration', true);
            if ($duration) {
                echo '<span class="tour-duration">⏱️ ' . esc_html($duration) . '</span>';
            }
            ?>
            <div class="product-rating">
                <?php
                $rating = $product->get_average_rating();
                if ($rating > 0) {
                    echo str_repeat('★', floor($rating));
                    echo str_repeat('☆', 5 - floor($rating));
                    echo ' (' . $product->get_rating_count() . ')';
                } else {
                    echo __('Chưa có đánh giá', 'traveltour');
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

