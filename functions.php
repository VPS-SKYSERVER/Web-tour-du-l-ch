<?php
/**
 * TravelTour Pro Theme Functions
 *
 * @package TravelTour
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function traveltour_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Main Menu', 'traveltour'),
        'footer' => __('Footer Menu', 'traveltour'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'traveltour_setup');

// Enqueue scripts and styles
function traveltour_scripts() {
    // Styles
    wp_enqueue_style('traveltour-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('traveltour-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // Scripts
    wp_enqueue_script('traveltour-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('traveltour-main', 'traveltourAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('traveltour_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'traveltour_scripts');

// Register widget areas
function traveltour_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'traveltour'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'traveltour'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 1', 'traveltour'),
        'id' => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 2', 'traveltour'),
        'id' => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 3', 'traveltour'),
        'id' => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Column 4', 'traveltour'),
        'id' => 'footer-4',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'traveltour_widgets_init');

// WooCommerce Support
function traveltour_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'traveltour_woocommerce_setup');

// Customize WooCommerce
function traveltour_woocommerce_wrapper_start() {
    echo '<div class="woocommerce-wrapper">';
}
add_action('woocommerce_before_main_content', 'traveltour_woocommerce_wrapper_start', 10);

function traveltour_woocommerce_wrapper_end() {
    echo '</div>';
}
add_action('woocommerce_after_main_content', 'traveltour_woocommerce_wrapper_end', 10);

// Remove default WooCommerce wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// Custom product type for Tours
function traveltour_register_tour_product_type() {
    if (class_exists('WC_Product')) {
        require_once get_template_directory() . '/includes/class-wc-product-tour.php';
    }
}
add_action('init', 'traveltour_register_tour_product_type');

// Add custom fields to tour products
function traveltour_add_tour_fields() {
    global $woocommerce, $post;
    
    echo '<div class="options_group">';
    
    woocommerce_wp_text_input(array(
        'id' => '_tour_duration',
        'label' => __('Thời gian tour (ngày)', 'traveltour'),
        'placeholder' => '3 ngày 2 đêm',
        'desc_tip' => 'true',
        'description' => __('Nhập thời gian của tour', 'traveltour'),
    ));
    
    woocommerce_wp_textarea_input(array(
        'id' => '_tour_itinerary',
        'label' => __('Lịch trình tour', 'traveltour'),
        'placeholder' => __('Nhập lịch trình chi tiết...', 'traveltour'),
    ));
    
    woocommerce_wp_text_input(array(
        'id' => '_tour_departure',
        'label' => __('Điểm khởi hành', 'traveltour'),
        'placeholder' => 'Hà Nội',
    ));
    
    woocommerce_wp_text_input(array(
        'id' => '_tour_destination',
        'label' => __('Điểm đến', 'traveltour'),
        'placeholder' => 'Đà Lạt',
    ));
    
    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'traveltour_add_tour_fields');

// Save custom fields
function traveltour_save_tour_fields($post_id) {
    $tour_duration = $_POST['_tour_duration'];
    if (!empty($tour_duration)) {
        update_post_meta($post_id, '_tour_duration', esc_attr($tour_duration));
    }
    
    $tour_itinerary = $_POST['_tour_itinerary'];
    if (!empty($tour_itinerary)) {
        update_post_meta($post_id, '_tour_itinerary', esc_attr($tour_itinerary));
    }
    
    $tour_departure = $_POST['_tour_departure'];
    if (!empty($tour_departure)) {
        update_post_meta($post_id, '_tour_departure', esc_attr($tour_departure));
    }
    
    $tour_destination = $_POST['_tour_destination'];
    if (!empty($tour_destination)) {
        update_post_meta($post_id, '_tour_destination', esc_attr($tour_destination));
    }
}
add_action('woocommerce_process_product_meta', 'traveltour_save_tour_fields');

// Booking form handler
function traveltour_booking_form_handler() {
    check_ajax_referer('traveltour_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $booking_date = sanitize_text_field($_POST['booking_date']);
    $num_guests = intval($_POST['num_guests']);
    $customer_name = sanitize_text_field($_POST['customer_name']);
    $customer_email = sanitize_email($_POST['customer_email']);
    $customer_phone = sanitize_text_field($_POST['customer_phone']);
    $notes = sanitize_textarea_field($_POST['notes']);
    
    // Create booking entry (you can customize this to save to database)
    $booking_data = array(
        'product_id' => $product_id,
        'booking_date' => $booking_date,
        'num_guests' => $num_guests,
        'customer_name' => $customer_name,
        'customer_email' => $customer_email,
        'customer_phone' => $customer_phone,
        'notes' => $notes,
        'status' => 'pending',
        'created_at' => current_time('mysql'),
    );
    
    // Here you would save to database or send email
    // For now, we'll just return success
    
    wp_send_json_success(array(
        'message' => __('Đặt tour thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.', 'traveltour'),
    ));
}
add_action('wp_ajax_traveltour_booking', 'traveltour_booking_form_handler');
add_action('wp_ajax_nopriv_traveltour_booking', 'traveltour_booking_form_handler');

// Custom excerpt length
function traveltour_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'traveltour_excerpt_length');

// Custom excerpt more
function traveltour_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'traveltour_excerpt_more');

// Add customizer options
function traveltour_customize_register($wp_customize) {
    // Add section for theme options
    $wp_customize->add_section('traveltour_options', array(
        'title' => __('Theme Options', 'traveltour'),
        'priority' => 30,
    ));
    
    // Contact phone
    $wp_customize->add_setting('traveltour_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('traveltour_phone', array(
        'label' => __('Số điện thoại', 'traveltour'),
        'section' => 'traveltour_options',
        'type' => 'text',
    ));
    
    // Contact email
    $wp_customize->add_setting('traveltour_email', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('traveltour_email', array(
        'label' => __('Email', 'traveltour'),
        'section' => 'traveltour_options',
        'type' => 'email',
    ));
    
    // Social media
    $wp_customize->add_setting('traveltour_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('traveltour_facebook', array(
        'label' => __('Facebook URL', 'traveltour'),
        'section' => 'traveltour_options',
        'type' => 'url',
    ));
    
    // Banner settings
    $wp_customize->add_setting('traveltour_banner_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'traveltour_banner_image', array(
        'label' => __('Banner Image', 'traveltour'),
        'section' => 'traveltour_options',
    )));
    
    $wp_customize->add_setting('traveltour_banner_title', array(
        'default' => __('Khuyến mãi đặc biệt - Giảm giá lên đến 50%', 'traveltour'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('traveltour_banner_title', array(
        'label' => __('Banner Title', 'traveltour'),
        'section' => 'traveltour_options',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('traveltour_banner_text', array(
        'default' => __('Đặt tour ngay hôm nay để nhận ưu đãi tốt nhất!', 'traveltour'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('traveltour_banner_text', array(
        'label' => __('Banner Text', 'traveltour'),
        'section' => 'traveltour_options',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('traveltour_banner_link', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('traveltour_banner_link', array(
        'label' => __('Banner Link', 'traveltour'),
        'section' => 'traveltour_options',
        'type' => 'url',
    ));
}
add_action('customize_register', 'traveltour_customize_register');

// Performance optimization
function traveltour_optimize_scripts() {
    // Defer non-critical scripts
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), false, null, true);
    }
}
add_action('wp_enqueue_scripts', 'traveltour_optimize_scripts', 1);

// Remove unnecessary WordPress features
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

