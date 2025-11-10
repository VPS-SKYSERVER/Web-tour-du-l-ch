<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <!-- Footer Column 1: Company Info -->
            <div class="footer-widget">
                <h3><?php _e('Về chúng tôi', 'traveltour'); ?></h3>
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else : ?>
                    <p><?php _e('Chúng tôi là công ty du lịch hàng đầu, chuyên cung cấp các tour du lịch chất lượng cao trong và ngoài nước.', 'traveltour'); ?></p>
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Footer Column 2: Useful Links -->
            <div class="footer-widget">
                <h3><?php _e('Liên kết hữu ích', 'traveltour'); ?></h3>
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else : ?>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/tour-trong-nuoc')); ?>"><?php _e('Tour trong nước', 'traveltour'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/tour-quoc-te')); ?>"><?php _e('Tour quốc tế', 'traveltour'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/ve-may-bay')); ?>"><?php _e('Vé máy bay', 'traveltour'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/khach-san')); ?>"><?php _e('Khách sạn', 'traveltour'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php _e('Blog du lịch', 'traveltour'); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Footer Column 3: Customer Support -->
            <div class="footer-widget">
                <h3><?php _e('Hỗ trợ khách hàng', 'traveltour'); ?></h3>
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else : ?>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/huong-dan-dat-tour')); ?>"><?php _e('Hướng dẫn đặt tour', 'traveltour'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/chinh-sach-hoan-ve')); ?>"><?php _e('Chính sách hoàn vé', 'traveltour'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/cau-hoi-thuong-gap')); ?>"><?php _e('Câu hỏi thường gặp', 'traveltour'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/lien-he')); ?>"><?php _e('Liên hệ', 'traveltour'); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Footer Column 4: Newsletter & Social -->
            <div class="footer-widget">
                <h3><?php _e('Đăng ký nhận tin', 'traveltour'); ?></h3>
                <?php if (is_active_sidebar('footer-4')) : ?>
                    <?php dynamic_sidebar('footer-4'); ?>
                <?php else : ?>
                    <p><?php _e('Nhận thông tin về các tour mới và khuyến mãi đặc biệt', 'traveltour'); ?></p>
                    <form class="newsletter-form" method="post">
                        <input type="email" name="newsletter_email" placeholder="<?php _e('Nhập email của bạn', 'traveltour'); ?>" required>
                        <button type="submit" class="btn-primary"><?php _e('Đăng ký', 'traveltour'); ?></button>
                    </form>
                    <div class="social-links" style="margin-top: 20px;">
                        <?php if (get_theme_mod('traveltour_facebook')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('traveltour_facebook')); ?>" target="_blank" rel="noopener">
                                <i class="icon-facebook"></i> Facebook
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Tất cả quyền được bảo lưu.', 'traveltour'); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

