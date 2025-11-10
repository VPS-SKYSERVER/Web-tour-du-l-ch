<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <?php if (get_theme_mod('traveltour_phone')) : ?>
                        <span><i class="icon-phone"></i> <?php echo esc_html(get_theme_mod('traveltour_phone')); ?></span>
                    <?php endif; ?>
                    <?php if (get_theme_mod('traveltour_email')) : ?>
                        <span><i class="icon-email"></i> <?php echo esc_html(get_theme_mod('traveltour_email')); ?></span>
                    <?php endif; ?>
                </div>
                <div class="top-bar-right">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php _e('Đăng xuất', 'traveltour'); ?></a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url()); ?>"><?php _e('Đăng nhập', 'traveltour'); ?></a>
                        <a href="<?php echo esc_url(wp_registration_url()); ?>"><?php _e('Đăng ký', 'traveltour'); ?></a>
                    <?php endif; ?>
                    <span class="language-switcher">
                        <a href="#">VN</a> | <a href="#">EN</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="site-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <h1><?php bloginfo('name'); ?></h1>
                        </a>
                    <?php endif; ?>
                </div>

                <nav class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'nav-menu',
                        'container' => false,
                        'fallback_cb' => 'traveltour_default_menu',
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </div>

    <!-- Search/Filter Bar -->
    <?php if (is_front_page() || is_home()) : ?>
    <div class="search-filter-bar">
        <div class="container">
            <form class="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="text" name="s" placeholder="<?php _e('Tìm kiếm tour, điểm đến...', 'traveltour'); ?>" value="<?php echo get_search_query(); ?>">
                <select name="tour_type">
                    <option value=""><?php _e('Loại tour', 'traveltour'); ?></option>
                    <option value="domestic"><?php _e('Tour trong nước', 'traveltour'); ?></option>
                    <option value="international"><?php _e('Tour quốc tế', 'traveltour'); ?></option>
                </select>
                <input type="date" name="departure_date" placeholder="<?php _e('Ngày khởi hành', 'traveltour'); ?>">
                <select name="destination">
                    <option value=""><?php _e('Điểm đến', 'traveltour'); ?></option>
                    <option value="dalat"><?php _e('Đà Lạt', 'traveltour'); ?></option>
                    <option value="sapa"><?php _e('Sapa', 'traveltour'); ?></option>
                    <option value="halong"><?php _e('Hạ Long', 'traveltour'); ?></option>
                    <option value="phuquoc"><?php _e('Phú Quốc', 'traveltour'); ?></option>
                </select>
                <button type="submit"><?php _e('Tìm kiếm', 'traveltour'); ?></button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</header>

<?php
// Default menu fallback
function traveltour_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Trang chủ', 'traveltour') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/tour-trong-nuoc')) . '">' . __('Tour trong nước', 'traveltour') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/tour-quoc-te')) . '">' . __('Tour quốc tế', 'traveltour') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/ve-may-bay')) . '">' . __('Vé máy bay', 'traveltour') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/khach-san')) . '">' . __('Khách sạn', 'traveltour') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog')) . '">' . __('Blog', 'traveltour') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/lien-he')) . '">' . __('Liên hệ', 'traveltour') . '</a></li>';
    echo '</ul>';
}
?>

