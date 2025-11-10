<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package TravelTour
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <section class="error-404 not-found" style="text-align: center; padding: 80px 20px;">
            <header class="page-header">
                <h1 class="page-title" style="font-size: 120px; color: var(--primary-color); margin-bottom: 20px;">404</h1>
                <h2 style="font-size: 32px; margin-bottom: 20px;"><?php _e('Trang không tìm thấy', 'traveltour'); ?></h2>
            </header>

            <div class="page-content">
                <p style="font-size: 18px; color: var(--text-light); margin-bottom: 40px;">
                    <?php _e('Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.', 'traveltour'); ?>
                </p>
                
                <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                        <?php _e('Về trang chủ', 'traveltour'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/tour-trong-nuoc')); ?>" class="btn-primary">
                        <?php _e('Xem tour', 'traveltour'); ?>
                    </a>
                </div>
                
                <div style="margin-top: 40px;">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();

