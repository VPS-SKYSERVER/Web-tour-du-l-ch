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
                    // Build slides: featured + gallery images
                    $slides = array();
                    if (has_post_thumbnail()) {
                        $slides[] = get_post_thumbnail_id(get_the_ID());
                    }
                    $attachment_ids = $product->get_gallery_image_ids();
                    if (!empty($attachment_ids)) {
                        $slides = array_merge($slides, $attachment_ids);
                    }
                    ?>
                    <div class="product-slider" data-product-slider>
                        <?php if (!empty($slides)) : ?>
                            <?php foreach ($slides as $idx => $img_id) : ?>
                                <div class="product-slide<?php echo $idx === 0 ? ' is-active' : ''; ?>" data-slide-index="<?php echo esc_attr($idx); ?>">
                                    <?php echo wp_get_attachment_image($img_id, 'large'); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php if (has_post_thumbnail()) { the_post_thumbnail('large'); } ?>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($slides)) : ?>
                        <div class="product-gallery-thumbs" data-slider-thumbs>
                            <?php foreach ($slides as $idx => $img_id) : ?>
                                <div class="product-thumb<?php echo $idx === 0 ? ' is-active' : ''; ?>" data-thumb-index="<?php echo esc_attr($idx); ?>">
                                    <?php echo wp_get_attachment_image($img_id, 'thumbnail'); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
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

            <!-- Short Description box -->
            <?php
            $short_description = '';
            if (function_exists('wc_get_product')) {
                $wc_product = wc_get_product(get_the_ID());
                if ($wc_product) {
                    $short_description = $wc_product->get_short_description();
                }
            } else {
                global $post;
                $short_description = isset($post->post_excerpt) ? $post->post_excerpt : '';
            }
            if (!empty($short_description)) :
            ?>
            <section class="tour-short-desc">
                <div class="container">
                    <div class="tour-short-desc__box">
                        <?php echo wpautop($short_description); ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Callback Request Banner -->
            <?php
            $hero = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $callback_video_url = get_post_meta(get_the_ID(), '_callback_video_url', true);
            if (empty($callback_video_url)) {
                $video_att_id = get_theme_mod('traveltour_callback_video');
                if ($video_att_id) {
                    $callback_video_url = wp_get_attachment_url($video_att_id);
                }
            }
            ?>
            <section class="callback-banner<?php echo $callback_video_url ? ' has-video' : ''; ?>" <?php if ($hero && empty($callback_video_url)) : ?>style="background-image: url('<?php echo esc_url($hero); ?>');"<?php endif; ?>>
                <?php if (!empty($callback_video_url)) : ?>
                    <video class="callback-banner__video" autoplay loop muted playsinline>
                        <source src="<?php echo esc_url($callback_video_url); ?>" type="video/mp4">
                    </video>
                <?php endif; ?>
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

            <!-- Tour Accordion: Price Detail, Schedule, etc. -->
            <?php
            $accordion_sections = array(
                array('title' => __('Giá tour chi tiết', 'traveltour'), 'meta' => '_tour_price_detail'),
                array('title' => __('Lịch khởi hành', 'traveltour'), 'meta' => '_tour_schedule'),
                array('title' => __('Giá tour bao gồm', 'traveltour'), 'meta' => '_tour_included'),
                array('title' => __('Giá tour không bao gồm', 'traveltour'), 'meta' => '_tour_excluded'),
                array('title' => __('Quy định trẻ em', 'traveltour'), 'meta' => '_tour_child_policy'),
                array('title' => __('Quy định hủy tour', 'traveltour'), 'meta' => '_tour_cancel_policy'),
                array('title' => __('Ghi chú', 'traveltour'), 'meta' => '_tour_note'),
                array('title' => __('Hình thức thanh toán', 'traveltour'), 'meta' => '_tour_payment'),
                array('title' => __('Điểm đón khách', 'traveltour'), 'meta' => '_tour_pickup'),
            );
            $has_accordion = false;
            foreach ($accordion_sections as $section) {
                if ($section['meta'] === '_tour_price_detail' || $section['meta'] === '_tour_schedule') {
                    // Check new format first
                    if ($section['meta'] === '_tour_price_detail') {
                        $price_data = get_post_meta(get_the_ID(), '_tour_price_detail_data', true);
                        if (empty($price_data) || !is_array($price_data)) {
                            $price_data = array(
                                'adult' => get_post_meta(get_the_ID(), '_tour_price_adult', true),
                                'child' => get_post_meta(get_the_ID(), '_tour_price_child', true),
                                'infant' => get_post_meta(get_the_ID(), '_tour_price_infant', true),
                                'single_surcharge' => get_post_meta(get_the_ID(), '_tour_single_surcharge', true),
                            );
                        }
                        if ($price_data['adult'] || $price_data['child'] || $price_data['infant'] || $price_data['single_surcharge']) {
                            $has_accordion = true;
                            break;
                        }
                    } elseif ($section['meta'] === '_tour_schedule') {
                        $schedules = get_post_meta(get_the_ID(), '_tour_schedule_data', true);
                        if (empty($schedules) || !is_array($schedules)) {
                            $schedule_text = get_post_meta(get_the_ID(), '_tour_schedule', true);
                            if (!empty($schedule_text)) {
                                $has_accordion = true;
                                break;
                            }
                        } elseif (!empty($schedules)) {
                            $has_accordion = true;
                            break;
                        }
                    }
                } else {
                    if (get_post_meta(get_the_ID(), $section['meta'], true)) {
                        $has_accordion = true;
                        break;
                    }
                }
            }
            if ($has_accordion) :
            ?>
            <section class="tour-accordion-section">
                <div class="container">
                    <div class="tour-accordion" data-tour-accordion>
                        <?php
                        foreach ($accordion_sections as $section) :
                            $content = '';
                            if ($section['meta'] === '_tour_price_detail') {
                                // Try new format first (_tour_price_detail_data), fallback to old format
                                $price_data = get_post_meta(get_the_ID(), '_tour_price_detail_data', true);
                                
                                // If no new format, try old format
                                if (empty($price_data) || !is_array($price_data)) {
                                    $price_data = array(
                                        'adult' => get_post_meta(get_the_ID(), '_tour_price_adult', true),
                                        'child' => get_post_meta(get_the_ID(), '_tour_price_child', true),
                                        'infant' => get_post_meta(get_the_ID(), '_tour_price_infant', true),
                                        'single_surcharge' => get_post_meta(get_the_ID(), '_tour_single_surcharge', true),
                                    );
                                }
                                
                                $price_adult = isset($price_data['adult']) ? $price_data['adult'] : '';
                                $price_child = isset($price_data['child']) ? $price_data['child'] : '';
                                $price_infant = isset($price_data['infant']) ? $price_data['infant'] : '';
                                $single_surcharge = isset($price_data['single_surcharge']) ? $price_data['single_surcharge'] : '';
                                
                                if ($price_adult || $price_child || $price_infant || $single_surcharge) {
                                    ob_start();
                                    ?>
                                    <table class="tour-price-table">
                                        <thead>
                                            <tr>
                                                <th><?php esc_html_e('Hạng mục', 'traveltour'); ?></th>
                                                <th><?php esc_html_e('Người lớn', 'traveltour'); ?></th>
                                                <th><?php esc_html_e('Trẻ em', 'traveltour'); ?></th>
                                                <th><?php esc_html_e('Em bé', 'traveltour'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php esc_html_e('Giá tour cơ bản', 'traveltour'); ?></td>
                                                <td class="text-right"><?php echo esc_html( number_format((float)preg_replace('/[^\d]/', '', (string)$price_adult), 0, ',', '.') . ' đ' ); ?></td>
                                                <td class="text-right"><?php echo esc_html( number_format((float)preg_replace('/[^\d]/', '', (string)$price_child), 0, ',', '.') . ' đ' ); ?></td>
                                                <td class="text-right"><?php echo esc_html( number_format((float)preg_replace('/[^\d]/', '', (string)$price_infant), 0, ',', '.') . ' đ' ); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php esc_html_e('Phụ thu phòng đơn', 'traveltour'); ?></td>
                                                <td colspan="3" class="text-right"><?php echo esc_html( number_format((float)preg_replace('/[^\d]/', '', (string)$single_surcharge), 0, ',', '.') . ' đ' ); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    $content = ob_get_clean();
                                }
                            } elseif ($section['meta'] === '_tour_schedule') {
                                // Try new format first (_tour_schedule_data), fallback to old format (_tour_schedule)
                                $schedules = get_post_meta(get_the_ID(), '_tour_schedule_data', true);
                                
                                // If no new format, try old format
                                if (empty($schedules) || !is_array($schedules)) {
                                    $schedule_text = get_post_meta(get_the_ID(), '_tour_schedule', true);
                                    if (!empty($schedule_text)) {
                                        $lines = array_filter(array_map('trim', explode("\n", $schedule_text)));
                                        $schedules = array();
                                        foreach ($lines as $line) {
                                            $parts = array_map('trim', explode('|', $line));
                                            if (count($parts) >= 3) {
                                                $schedules[] = array(
                                                    'date' => $parts[0],
                                                    'vehicle' => $parts[1],
                                                    'price' => $parts[2]
                                                );
                                            }
                                        }
                                    }
                                }
                                
                                if (!empty($schedules) && is_array($schedules)) {
                                    ob_start();
                                    ?>
                                    <table class="tour-schedule-table">
                                        <thead>
                                            <tr>
                                                <th><?php esc_html_e('STT', 'traveltour'); ?></th>
                                                <th><?php esc_html_e('Ngày khởi hành', 'traveltour'); ?></th>
                                                <th><?php esc_html_e('Phương tiện', 'traveltour'); ?></th>
                                                <th class="text-right"><?php esc_html_e('Giá', 'traveltour'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stt = 1;
                                            foreach ($schedules as $schedule) {
                                                $date = esc_html($schedule['date']);
                                                $vehicle = esc_html($schedule['vehicle']);
                                                $price_raw = preg_replace('/[^\d]/', '', (string)$schedule['price']);
                                                $price_formatted = number_format((float)$price_raw, 0, ',', '.') . ' đ';
                                                ?>
                                                <tr>
                                                    <td><?php echo $stt++; ?></td>
                                                    <td><?php echo $date; ?></td>
                                                    <td><?php echo $vehicle; ?></td>
                                                    <td class="text-right"><?php echo esc_html($price_formatted); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <p class="tour-schedule-note"><?php esc_html_e('Liên hệ để biết thêm lịch khởi hành', 'traveltour'); ?></p>
                                    <?php
                                    $content = ob_get_clean();
                                }
                            } else {
                                $content = get_post_meta(get_the_ID(), $section['meta'], true);
                            }
                            if (empty($content)) {
                                continue;
                            }
                            ?>
                            <div class="tour-accordion__item">
                                <button class="tour-accordion__header" type="button">
                                    <span><?php echo esc_html($section['title']); ?></span>
                                    <span class="tour-accordion__icon" aria-hidden="true">+</span>
                                </button>
                                <div class="tour-accordion__body">
                                    <div class="tour-accordion__content">
                                        <?php echo wpautop(wp_kses_post($content)); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Price Check Section -->
            <?php
            // Get price data
            $price_data = get_post_meta(get_the_ID(), '_tour_price_detail_data', true);
            if (empty($price_data) || !is_array($price_data)) {
                $price_data = array(
                    'adult' => get_post_meta(get_the_ID(), '_tour_price_adult', true),
                    'child' => get_post_meta(get_the_ID(), '_tour_price_child', true),
                    'infant' => get_post_meta(get_the_ID(), '_tour_price_infant', true),
                );
            }
            $price_adult = isset($price_data['adult']) ? (float)preg_replace('/[^\d]/', '', (string)$price_data['adult']) : 0;
            $price_child = isset($price_data['child']) ? (float)preg_replace('/[^\d]/', '', (string)$price_data['child']) : 0;
            $price_infant = isset($price_data['infant']) ? (float)preg_replace('/[^\d]/', '', (string)$price_data['infant']) : 0;
            
            // Get schedule data for date picker
            $schedules = get_post_meta(get_the_ID(), '_tour_schedule_data', true);
            $schedule_dates = array();
            if (!empty($schedules) && is_array($schedules)) {
                foreach ($schedules as $schedule) {
                    if (!empty($schedule['date'])) {
                        $schedule_dates[] = $schedule['date'];
                    }
                }
            }
            
            // Get standard
            $standard = get_post_meta(get_the_ID(), '_tour_standard', true);
            ?>
            <section class="price-check-section">
                <div class="container">
                    <h2 class="price-check-title"><?php _e('KIỂM TRA GIÁ', 'traveltour'); ?></h2>
                    
                    <form class="price-check-form" id="price-check-form">
                        <div class="price-check-row">
                            <div class="price-check-field">
                                <label><?php _e('Người lớn', 'traveltour'); ?> / <?php echo number_format((float)$price_adult, 0, ',', '.'); ?> ₫</label>
                                <input type="number" name="adult" id="price-adult" value="1" min="0" data-price="<?php echo esc_attr($price_adult); ?>">
                            </div>
                            <div class="price-check-field">
                                <label><?php _e('Ngày khởi hành', 'traveltour'); ?></label>
                                <select name="departure_date" id="price-departure-date">
                                    <option value=""><?php _e('Chọn ngày', 'traveltour'); ?></option>
                                    <?php if (!empty($schedule_dates)) : ?>
                                        <?php foreach ($schedule_dates as $date) : ?>
                                            <option value="<?php echo esc_attr($date); ?>"><?php echo esc_html($date); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="price-check-field">
                                <label><?php _e('Trẻ em', 'traveltour'); ?> / <?php echo number_format((float)$price_child, 0, ',', '.'); ?> ₫</label>
                                <input type="number" name="child" id="price-child" value="1" min="0" data-price="<?php echo esc_attr($price_child); ?>">
                            </div>
                            <div class="price-check-field">
                                <label><?php _e('Tiêu chuẩn', 'traveltour'); ?></label>
                                <select name="standard" id="price-standard">
                                    <?php if ($standard) : ?>
                                        <option value="<?php echo esc_attr($standard); ?>"><?php echo esc_html($standard); ?></option>
                                    <?php else : ?>
                                        <option value=""><?php _e('Chọn tiêu chuẩn', 'traveltour'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="price-check-field">
                                <label><?php _e('Trẻ nhỏ', 'traveltour'); ?> / <?php echo number_format((float)$price_infant, 0, ',', '.'); ?> ₫</label>
                                <input type="number" name="infant" id="price-infant" value="1" min="0" data-price="<?php echo esc_attr($price_infant); ?>">
                            </div>
                            <div class="price-check-field price-check-submit">
                                <button type="button" class="price-check-btn" id="continue-booking-btn"><?php _e('TIẾP TỤC ĐẶT TOUR', 'traveltour'); ?></button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="price-summary-table">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php _e('Bắt buộc', 'traveltour'); ?></th>
                                    <th><?php _e('Số lượng', 'traveltour'); ?></th>
                                    <th><?php _e('Giá tiền', 'traveltour'); ?></th>
                                    <th><?php _e('Tổng cộng', 'traveltour'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php _e('Người lớn', 'traveltour'); ?></td>
                                    <td class="qty-adult">1</td>
                                    <td class="price-adult"><?php echo number_format((float)$price_adult, 0, ',', '.'); ?> ₫</td>
                                    <td class="total-adult"><?php echo number_format((float)$price_adult, 0, ',', '.'); ?> ₫</td>
                                </tr>
                                <tr>
                                    <td><?php _e('Trẻ em', 'traveltour'); ?></td>
                                    <td class="qty-child">1</td>
                                    <td class="price-child"><?php echo number_format((float)$price_child, 0, ',', '.'); ?> ₫</td>
                                    <td class="total-child"><?php echo number_format((float)$price_child, 0, ',', '.'); ?> ₫</td>
                                </tr>
                                <tr>
                                    <td><?php _e('Em bé', 'traveltour'); ?></td>
                                    <td class="qty-infant">1</td>
                                    <td class="price-infant"><?php echo number_format((float)$price_infant, 0, ',', '.'); ?> ₫</td>
                                    <td class="total-infant"><?php echo number_format((float)$price_infant, 0, ',', '.'); ?> ₫</td>
                                </tr>
                                <tr class="grand-total-row">
                                    <td colspan="3" class="grand-total-label"><?php _e('Tổng cộng', 'traveltour'); ?></td>
                                    <td class="grand-total"><?php echo number_format($price_adult + $price_child + $price_infant, 0, ',', '.'); ?> ₫</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php
                    $manager_name = get_post_meta(get_the_ID(), '_tour_manager_name', true);
                    $manager_phone = get_post_meta(get_the_ID(), '_tour_manager_phone', true);
                    if (!empty($manager_name) || !empty($manager_phone)) :
                    ?>
                    <div class="contact-manager-section">
                        <table class="contact-manager-table">
                            <tbody>
                                <tr>
                                    <td class="contact-manager-col-btn">
                                        <span class="contact-manager-text"><?php _e('LIÊN HỆ QUẢN LÝ', 'traveltour'); ?></span>
                                    </td>
                                    <td class="contact-manager-col-name">
                                        <div class="contact-manager-info">
                                            <span class="contact-label"><?php _e('Người phụ trách tour', 'traveltour'); ?></span>
                                            <span class="contact-name"><?php echo esc_html($manager_name ?: ''); ?></span>
                                        </div>
                                    </td>
                                    <?php if (!empty($manager_phone)) : ?>
                                    <td class="contact-manager-col-phone">
                                        <div class="contact-phone-group">
                                            <a href="tel:<?php echo esc_attr($manager_phone); ?>" class="contact-item">
                                                <span class="contact-icon">S</span>
                                                <span><?php echo esc_html($manager_phone); ?></span>
                                            </a>
                                            <a href="tel:<?php echo esc_attr($manager_phone); ?>" class="contact-item">
                                                <span class="contact-icon">📞</span>
                                                <span><?php echo esc_html($manager_phone); ?></span>
                                            </a>
                                        </div>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
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

