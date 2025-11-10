<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package TravelTour
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php _e('Không tìm thấy nội dung', 'traveltour'); ?></h1>
    </header>

    <div class="page-content">
        <p><?php _e('Xin lỗi, không tìm thấy nội dung bạn đang tìm kiếm. Vui lòng thử lại với từ khóa khác.', 'traveltour'); ?></p>
        <?php get_search_form(); ?>
    </div>
</section>

