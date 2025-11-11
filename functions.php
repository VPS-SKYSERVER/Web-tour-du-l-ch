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

    // Optional: Transport
    woocommerce_wp_text_input(array(
        'id' => '_tour_transport',
        'label' => __('Phương tiện', 'traveltour'),
        'placeholder' => __('Xe Limousine / Máy bay ...', 'traveltour'),
    ));

    // Optional: Standard/Rating text
    woocommerce_wp_text_input(array(
        'id' => '_tour_standard',
        'label' => __('Tiêu chuẩn', 'traveltour'),
        'placeholder' => __('3 sao / 4 sao ...', 'traveltour'),
    ));
    
    $accordion_fields = array(
        '_tour_price_detail'   => __('Giá tour chi tiết', 'traveltour'),
        '_tour_schedule'       => __('Lịch khởi hành', 'traveltour'),
        '_tour_included'       => __('Giá tour bao gồm', 'traveltour'),
        '_tour_excluded'       => __('Giá tour không bao gồm', 'traveltour'),
        '_tour_child_policy'   => __('Quy định trẻ em', 'traveltour'),
        '_tour_cancel_policy'  => __('Quy định hủy tour', 'traveltour'),
        '_tour_note'           => __('Ghi chú', 'traveltour'),
        '_tour_payment'        => __('Hình thức thanh toán', 'traveltour'),
        '_tour_pickup'         => __('Điểm đón khách', 'traveltour'),
    );

    foreach ($accordion_fields as $field_id => $field_label) {
        if ($field_id === '_tour_price_detail') {
            // Skip - will use custom meta box instead
            continue;
        } elseif ($field_id === '_tour_schedule') {
            // Skip - will use custom meta box instead
            continue;
        } else {
            woocommerce_wp_textarea_input(array(
                'id' => $field_id,
                'label' => $field_label,
                'placeholder' => __('Nhập nội dung...', 'traveltour'),
            ));
        }
    }

    // Optional: Callback banner video URL
    woocommerce_wp_text_input(array(
        'id' => '_callback_video_url',
        'label' => __('Video banner (MP4) cho form tư vấn', 'traveltour'),
        'placeholder' => __('https://example.com/video.mp4', 'traveltour'),
        'desc_tip' => true,
        'description' => __('Nếu nhập link video .mp4, banner tư vấn sẽ dùng video nền thay cho ảnh đại diện.', 'traveltour'),
    ));
    
    // Tour Manager Information
    woocommerce_wp_text_input(array(
        'id' => '_tour_manager_name',
        'label' => __('Tên người phụ trách tour', 'traveltour'),
        'placeholder' => __('VÕ THỊ QUỲNH NHƯ', 'traveltour'),
    ));
    
    woocommerce_wp_text_input(array(
        'id' => '_tour_manager_phone',
        'label' => __('Số điện thoại người phụ trách', 'traveltour'),
        'placeholder' => __('0915289840', 'traveltour'),
    ));
    
    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'traveltour_add_tour_fields');

// Add Schedule Meta Box
function traveltour_add_schedule_metabox() {
    add_meta_box(
        'traveltour_schedule_metabox',
        __('Lịch khởi hành', 'traveltour'),
        'traveltour_schedule_metabox_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'traveltour_add_schedule_metabox');

// Schedule Meta Box Callback
function traveltour_schedule_metabox_callback($post) {
    wp_nonce_field('traveltour_schedule_metabox', 'traveltour_schedule_nonce');
    
    $schedules = get_post_meta($post->ID, '_tour_schedule_data', true);
    if (empty($schedules) || !is_array($schedules)) {
        $schedules = array();
    }
    
    ?>
    <div id="traveltour-schedule-repeater" style="margin: 15px 0;">
        <div class="schedule-items">
            <?php if (!empty($schedules)) : ?>
                <?php foreach ($schedules as $index => $schedule) : ?>
                    <div class="schedule-item" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center; padding: 12px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ngày khởi hành</label>
                            <input type="text" name="tour_schedule[<?php echo $index; ?>][date]" value="<?php echo esc_attr($schedule['date']); ?>" placeholder="13/11/2025" style="width: 100%; padding: 8px;" />
                        </div>
                        <div style="flex: 2;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Phương tiện</label>
                            <input type="text" name="tour_schedule[<?php echo $index; ?>][vehicle]" value="<?php echo esc_attr($schedule['vehicle']); ?>" placeholder="Xe Limousine 28 chỗ" style="width: 100%; padding: 8px;" />
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Giá (VND)</label>
                            <input type="text" name="tour_schedule[<?php echo $index; ?>][price]" value="<?php echo esc_attr($schedule['price']); ?>" placeholder="3290000" style="width: 100%; padding: 8px;" />
                        </div>
                        <div style="margin-top: 24px;">
                            <button type="button" class="button remove-schedule-item" style="background: #dc3232; color: #fff; border-color: #dc3232;">Xóa</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" id="add-schedule-item" class="button button-primary" style="margin-top: 10px;">+ Thêm lịch khởi hành</button>
        <p class="description" style="margin-top: 10px; color: #666;">
            Nhập từng lịch khởi hành với đầy đủ thông tin. Giá nhập số không dấu phẩy (ví dụ: 3290000), hệ thống sẽ tự format.
        </p>
    </div>
    
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var scheduleIndex = <?php echo count($schedules); ?>;
        
        $('#add-schedule-item').on('click', function() {
            var html = '<div class="schedule-item" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center; padding: 12px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">' +
                '<div style="flex: 1;">' +
                '<label style="display: block; margin-bottom: 5px; font-weight: 600;">Ngày khởi hành</label>' +
                '<input type="text" name="tour_schedule[' + scheduleIndex + '][date]" value="" placeholder="13/11/2025" style="width: 100%; padding: 8px;" />' +
                '</div>' +
                '<div style="flex: 2;">' +
                '<label style="display: block; margin-bottom: 5px; font-weight: 600;">Phương tiện</label>' +
                '<input type="text" name="tour_schedule[' + scheduleIndex + '][vehicle]" value="" placeholder="Xe Limousine 28 chỗ" style="width: 100%; padding: 8px;" />' +
                '</div>' +
                '<div style="flex: 1;">' +
                '<label style="display: block; margin-bottom: 5px; font-weight: 600;">Giá (VND)</label>' +
                '<input type="text" name="tour_schedule[' + scheduleIndex + '][price]" value="" placeholder="3290000" style="width: 100%; padding: 8px;" />' +
                '</div>' +
                '<div style="margin-top: 24px;">' +
                '<button type="button" class="button remove-schedule-item" style="background: #dc3232; color: #fff; border-color: #dc3232;">Xóa</button>' +
                '</div>' +
                '</div>';
            $('.schedule-items').append(html);
            scheduleIndex++;
        });
        
        $(document).on('click', '.remove-schedule-item', function() {
            if (confirm('Bạn có chắc muốn xóa lịch khởi hành này?')) {
                $(this).closest('.schedule-item').remove();
            }
        });
    });
    </script>
    <?php
}

// Save Schedule Meta Box
function traveltour_save_schedule_metabox($post_id) {
    if (!isset($_POST['traveltour_schedule_nonce']) || !wp_verify_nonce($_POST['traveltour_schedule_nonce'], 'traveltour_schedule_metabox')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['tour_schedule']) && is_array($_POST['tour_schedule'])) {
        $schedules = array();
        foreach ($_POST['tour_schedule'] as $schedule) {
            if (!empty($schedule['date']) && !empty($schedule['vehicle']) && !empty($schedule['price'])) {
                $schedules[] = array(
                    'date' => sanitize_text_field($schedule['date']),
                    'vehicle' => sanitize_text_field($schedule['vehicle']),
                    'price' => sanitize_text_field($schedule['price'])
                );
            }
        }
        update_post_meta($post_id, '_tour_schedule_data', $schedules);
    } else {
        delete_post_meta($post_id, '_tour_schedule_data');
    }
}
add_action('save_post', 'traveltour_save_schedule_metabox');

// Add Price Detail Meta Box
function traveltour_add_price_detail_metabox() {
    add_meta_box(
        'traveltour_price_detail_metabox',
        __('Giá tour chi tiết', 'traveltour'),
        'traveltour_price_detail_metabox_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'traveltour_add_price_detail_metabox');

// Price Detail Meta Box Callback
function traveltour_price_detail_metabox_callback($post) {
    wp_nonce_field('traveltour_price_detail_metabox', 'traveltour_price_detail_nonce');
    
    // Try new format first
    $price_data = get_post_meta($post->ID, '_tour_price_detail_data', true);
    
    // Fallback to old format
    if (empty($price_data) || !is_array($price_data)) {
        $price_data = array(
            'adult' => get_post_meta($post->ID, '_tour_price_adult', true),
            'child' => get_post_meta($post->ID, '_tour_price_child', true),
            'infant' => get_post_meta($post->ID, '_tour_price_infant', true),
            'single_surcharge' => get_post_meta($post->ID, '_tour_single_surcharge', true),
        );
    }
    
    $adult = isset($price_data['adult']) ? $price_data['adult'] : '';
    $child = isset($price_data['child']) ? $price_data['child'] : '';
    $infant = isset($price_data['infant']) ? $price_data['infant'] : '';
    $single_surcharge = isset($price_data['single_surcharge']) ? $price_data['single_surcharge'] : '';
    
    ?>
    <div id="traveltour-price-detail" style="margin: 15px 0;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div style="padding: 12px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Giá tour cơ bản (Người lớn)</label>
                <input type="text" name="tour_price_detail[adult]" value="<?php echo esc_attr($adult); ?>" placeholder="3290000" style="width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 3px;" />
                <p class="description" style="margin: 5px 0 0 0; color: #666; font-size: 12px;">Nhập số không dấu phẩy (ví dụ: 3290000)</p>
            </div>
            <div style="padding: 12px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Giá tour cơ bản (Trẻ em)</label>
                <input type="text" name="tour_price_detail[child]" value="<?php echo esc_attr($child); ?>" placeholder="2632000" style="width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 3px;" />
                <p class="description" style="margin: 5px 0 0 0; color: #666; font-size: 12px;">Nhập số không dấu phẩy (ví dụ: 2632000)</p>
            </div>
            <div style="padding: 12px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Giá tour cơ bản (Em bé)</label>
                <input type="text" name="tour_price_detail[infant]" value="<?php echo esc_attr($infant); ?>" placeholder="0" style="width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 3px;" />
                <p class="description" style="margin: 5px 0 0 0; color: #666; font-size: 12px;">Nhập số không dấu phẩy (ví dụ: 0)</p>
            </div>
            <div style="padding: 12px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Phụ thu phòng đơn</label>
                <input type="text" name="tour_price_detail[single_surcharge]" value="<?php echo esc_attr($single_surcharge); ?>" placeholder="1000000" style="width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 3px;" />
                <p class="description" style="margin: 5px 0 0 0; color: #666; font-size: 12px;">Nhập số không dấu phẩy (ví dụ: 1000000)</p>
            </div>
        </div>
        <p class="description" style="margin-top: 15px; color: #666; font-size: 13px;">
            <strong>Lưu ý:</strong> Tất cả giá nhập số không dấu phẩy, hệ thống sẽ tự động format thành định dạng VND (ví dụ: 3.290.000 đ) khi hiển thị.
        </p>
    </div>
    <?php
}

// Save Price Detail Meta Box
function traveltour_save_price_detail_metabox($post_id) {
    if (!isset($_POST['traveltour_price_detail_nonce']) || !wp_verify_nonce($_POST['traveltour_price_detail_nonce'], 'traveltour_price_detail_metabox')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['tour_price_detail']) && is_array($_POST['tour_price_detail'])) {
        $price_data = array(
            'adult' => sanitize_text_field($_POST['tour_price_detail']['adult']),
            'child' => sanitize_text_field($_POST['tour_price_detail']['child']),
            'infant' => sanitize_text_field($_POST['tour_price_detail']['infant']),
            'single_surcharge' => sanitize_text_field($_POST['tour_price_detail']['single_surcharge']),
        );
        update_post_meta($post_id, '_tour_price_detail_data', $price_data);
        
        // Also save to old format for backward compatibility
        if (!empty($price_data['adult'])) {
            update_post_meta($post_id, '_tour_price_adult', $price_data['adult']);
        } else {
            delete_post_meta($post_id, '_tour_price_adult');
        }
        if (!empty($price_data['child'])) {
            update_post_meta($post_id, '_tour_price_child', $price_data['child']);
        } else {
            delete_post_meta($post_id, '_tour_price_child');
        }
        if (!empty($price_data['infant'])) {
            update_post_meta($post_id, '_tour_price_infant', $price_data['infant']);
        } else {
            delete_post_meta($post_id, '_tour_price_infant');
        }
        if (!empty($price_data['single_surcharge'])) {
            update_post_meta($post_id, '_tour_single_surcharge', $price_data['single_surcharge']);
        } else {
            delete_post_meta($post_id, '_tour_single_surcharge');
        }
    } else {
        delete_post_meta($post_id, '_tour_price_detail_data');
    }
}
add_action('save_post', 'traveltour_save_price_detail_metabox');

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

    // Transport
    $tour_transport = isset($_POST['_tour_transport']) ? $_POST['_tour_transport'] : '';
    if (!empty($tour_transport)) {
        update_post_meta($post_id, '_tour_transport', esc_attr($tour_transport));
    } else {
        delete_post_meta($post_id, '_tour_transport');
    }

    // Standard
    $tour_standard = isset($_POST['_tour_standard']) ? $_POST['_tour_standard'] : '';
    if (!empty($tour_standard)) {
        update_post_meta($post_id, '_tour_standard', esc_attr($tour_standard));
    } else {
        delete_post_meta($post_id, '_tour_standard');
    }

    $accordion_fields = array(
        // '_tour_price_detail' - handled by separate meta box
        // '_tour_schedule' - handled by separate meta box
        '_tour_included',
        '_tour_excluded',
        '_tour_child_policy',
        '_tour_cancel_policy',
        '_tour_note',
        '_tour_payment',
        '_tour_pickup',
    );

    foreach ($accordion_fields as $field_id) {
        $value = isset($_POST[$field_id]) ? wp_kses_post($_POST[$field_id]) : '';
        if (!empty($value)) {
            update_post_meta($post_id, $field_id, $value);
        } else {
            delete_post_meta($post_id, $field_id);
        }
    }

    // Callback video URL
    $callback_video_url = isset($_POST['_callback_video_url']) ? $_POST['_callback_video_url'] : '';
    if (!empty($callback_video_url)) {
        update_post_meta($post_id, '_callback_video_url', esc_url_raw($callback_video_url));
    } else {
        delete_post_meta($post_id, '_callback_video_url');
    }
    
    // Tour Manager Information
    $tour_manager_name = isset($_POST['_tour_manager_name']) ? sanitize_text_field($_POST['_tour_manager_name']) : '';
    if (!empty($tour_manager_name)) {
        update_post_meta($post_id, '_tour_manager_name', $tour_manager_name);
    } else {
        delete_post_meta($post_id, '_tour_manager_name');
    }
    
    $tour_manager_phone = isset($_POST['_tour_manager_phone']) ? sanitize_text_field($_POST['_tour_manager_phone']) : '';
    if (!empty($tour_manager_phone)) {
        update_post_meta($post_id, '_tour_manager_phone', $tour_manager_phone);
    } else {
        delete_post_meta($post_id, '_tour_manager_phone');
    }
}
add_action('woocommerce_process_product_meta', 'traveltour_save_tour_fields');

// Format itinerary headings
function traveltour_format_itinerary_headings($content) {
    if (!is_singular('product')) {
        return $content;
    }
    
    // Pattern to match headings with "NGÀY X:" or "ĐÊM X:" - improved to handle various formats
    // Matches: NGÀY 1:, ĐÊM 1:, NGÀY 1 :, etc.
    $pattern = '/<(h[2-3])[^>]*>((?:NGÀY|ĐÊM)\s+\d+)\s*:?\s*(.*?)<\/\1>/iu';
    
    $content = preg_replace_callback($pattern, function($matches) {
        $tag = $matches[1];
        $day_label = trim($matches[2]); // "NGÀY 1" or "ĐÊM 1"
        $day_content = trim($matches[3]); // Rest of the content after ":"
        
        if (empty($day_content)) {
            // If no content after colon, return original
            return $matches[0];
        }
        
        return '<' . $tag . ' class="itinerary-day-header"><span class="day-label">' . esc_html($day_label) . '</span><span class="day-content">' . esc_html($day_content) . '</span></' . $tag . '>';
    }, $content);
    
    return $content;
}
add_filter('the_content', 'traveltour_format_itinerary_headings', 20);

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

// Callback request (phone) handler
function traveltour_callback_request_handler() {
    check_ajax_referer('traveltour_nonce', 'nonce');

    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (empty($phone)) {
        wp_send_json_error(array('message' => __('Vui lòng nhập số điện thoại.', 'traveltour')));
    }

    // Very basic phone validation (digits and +, spaces, - allowed)
    if (!preg_match('/^[0-9+\-\s().]{8,20}$/', $phone)) {
        wp_send_json_error(array('message' => __('Số điện thoại không hợp lệ.', 'traveltour')));
    }

    $product_title = $product_id ? get_the_title($product_id) : __('Không xác định', 'traveltour');
    $admin_email = get_option('admin_email');
    $subject = sprintf(__('Yêu cầu tư vấn tour: %s', 'traveltour'), $product_title);
    $message = sprintf(
        "Số điện thoại: %s\nSản phẩm/Tour: %s (ID %d)\nThời gian: %s",
        $phone,
        $product_title,
        $product_id,
        current_time('mysql')
    );

    // Send email (ignore failures quietly)
    @wp_mail($admin_email, $subject, $message);

    wp_send_json_success(array('message' => __('Đã nhận yêu cầu. Chúng tôi sẽ liên hệ trong ít phút!', 'traveltour')));
}
add_action('wp_ajax_traveltour_callback_request', 'traveltour_callback_request_handler');
add_action('wp_ajax_nopriv_traveltour_callback_request', 'traveltour_callback_request_handler');
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

    // Callback banner video (optional)
    if (class_exists('WP_Customize_Media_Control')) {
        $wp_customize->add_setting('traveltour_callback_video', array(
            'default' => '',
            'sanitize_callback' => 'absint', // stores attachment ID
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'traveltour_callback_video', array(
            'label' => __('Video cho banner tư vấn (tùy chọn)', 'traveltour'),
            'section' => 'traveltour_options',
            'mime_type' => 'video',
        )));
    }
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

// Enqueue assets for the tour landing template
function traveltour_tour_landing_assets() {
    if (is_page_template('page-tour-landing.php')) {
        wp_enqueue_style(
            'traveltour-tour-landing',
            get_template_directory_uri() . '/assets/css/page-tour.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'traveltour_tour_landing_assets');

// Tour landing page meta box
function traveltour_add_tour_landing_metabox() {
    add_meta_box(
        'traveltour-tour-landing-settings',
        __('Tour Landing Settings', 'traveltour'),
        'traveltour_render_tour_landing_metabox',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'traveltour_add_tour_landing_metabox');

function traveltour_render_tour_landing_metabox($post) {
    wp_nonce_field('traveltour_tour_landing_meta', 'traveltour_tour_landing_meta_nonce');

    $template = get_page_template_slug($post->ID);
    if ('page-tour-landing.php' !== $template) {
        echo '<p>' . esc_html__('Hãy gán template "Tour Landing Page" cho trang này để áp dụng các thiết lập bên dưới.', 'traveltour') . '</p>';
    }

    $parent_cat = get_post_meta($post->ID, 'tour_landing_parent_cat', true);
    $icons = get_post_meta($post->ID, 'tour_landing_icons', true);
    $weather_title = get_post_meta($post->ID, 'tour_landing_weather_title', true);
    $weather_temp = get_post_meta($post->ID, 'tour_landing_weather_temp', true);
    $weather_desc = get_post_meta($post->ID, 'tour_landing_weather_desc', true);
    $post_category = get_post_meta($post->ID, 'tour_landing_post_category', true);

    ?>
    <p>
        <label for="tour_landing_parent_cat"><strong><?php esc_html_e('Slug danh mục tour cha (product_cat):', 'traveltour'); ?></strong></label><br>
        <input type="text" id="tour_landing_parent_cat" name="tour_landing_parent_cat" value="<?php echo esc_attr($parent_cat); ?>" class="widefat" placeholder="vi-du: tour-nha-trang">
        <em><?php esc_html_e('Dùng để lấy các danh mục con và sản phẩm tour hiển thị ở trang này.', 'traveltour'); ?></em>
    </p>
    <p>
        <label for="tour_landing_icons"><strong><?php esc_html_e('Danh sách điểm nổi bật (mỗi dòng: icon|Tiêu đề|Mô tả ngắn):', 'traveltour'); ?></strong></label>
        <textarea id="tour_landing_icons" name="tour_landing_icons" rows="4" class="widefat" placeholder="dashicons-airplane|Tour du lịch mát mẻ|Khởi hành hàng tuần&#10;dashicons-location|Khám phá địa danh|Hướng dẫn viên nhiệt tình"><?php echo esc_textarea($icons); ?></textarea>
        <em><?php esc_html_e('Icon có thể dùng class Dashicons hoặc Font Awesome (nếu đã cài).', 'traveltour'); ?></em>
    </p>
    <p>
        <label for="tour_landing_weather_title"><strong><?php esc_html_e('Tiêu đề khối thông tin phụ (ví dụ: Thời tiết Nha Trang):', 'traveltour'); ?></strong></label><br>
        <input type="text" id="tour_landing_weather_title" name="tour_landing_weather_title" value="<?php echo esc_attr($weather_title); ?>" class="widefat">
    </p>
    <p style="display:flex; gap:12px;">
        <span style="flex:1;">
            <label for="tour_landing_weather_temp"><strong><?php esc_html_e('Thông tin chính (ví dụ: 30°C):', 'traveltour'); ?></strong></label>
            <input type="text" id="tour_landing_weather_temp" name="tour_landing_weather_temp" value="<?php echo esc_attr($weather_temp); ?>" class="widefat">
        </span>
        <span style="flex:1;">
            <label for="tour_landing_weather_desc"><strong><?php esc_html_e('Mô tả bổ sung:', 'traveltour'); ?></strong></label>
            <input type="text" id="tour_landing_weather_desc" name="tour_landing_weather_desc" value="<?php echo esc_attr($weather_desc); ?>" class="widefat">
        </span>
    </p>
    <p>
        <label for="tour_landing_post_category"><strong><?php esc_html_e('Slug chuyên mục bài viết liên quan:', 'traveltour'); ?></strong></label><br>
        <input type="text" id="tour_landing_post_category" name="tour_landing_post_category" value="<?php echo esc_attr($post_category); ?>" class="widefat" placeholder="vi-du: kinh-nghiem-du-lich">
        <em><?php esc_html_e('Dùng để lấy bài viết kinh nghiệm, bí kíp du lịch.', 'traveltour'); ?></em>
    </p>
    <?php
}

function traveltour_save_tour_landing_meta($post_id) {
    if (!isset($_POST['traveltour_tour_landing_meta_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['traveltour_tour_landing_meta_nonce'], 'traveltour_tour_landing_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    $fields = array(
        'tour_landing_parent_cat' => 'sanitize_title',
        'tour_landing_weather_title' => 'sanitize_text_field',
        'tour_landing_weather_temp' => 'sanitize_text_field',
        'tour_landing_weather_desc' => 'sanitize_text_field',
        'tour_landing_post_category' => 'sanitize_title',
    );

    foreach ($fields as $field => $sanitize_callback) {
        if (isset($_POST[$field])) {
            $value = call_user_func($sanitize_callback, wp_unslash($_POST[$field]));
            update_post_meta($post_id, $field, $value);
        } else {
            delete_post_meta($post_id, $field);
        }
    }

    if (isset($_POST['tour_landing_icons'])) {
        $icons = implode("\n", array_filter(array_map('trim', explode("\n", wp_unslash($_POST['tour_landing_icons'])))));
        update_post_meta($post_id, 'tour_landing_icons', sanitize_textarea_field($icons));
    } else {
        delete_post_meta($post_id, 'tour_landing_icons');
    }
}
add_action('save_post', 'traveltour_save_tour_landing_meta');

