/**
 * TravelTour Theme JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Booking Form Handler
        $('#traveltour-booking-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $message = $('#booking-message');
            
            // Disable button and show loading
            $button.prop('disabled', true);
            $button.html('<span class="loading"></span> ' + traveltourAjax.loading || 'Đang xử lý...');
            $message.removeClass('success error').hide();
            
            // Get form data
            var formData = {
                action: 'traveltour_booking',
                nonce: traveltourAjax.nonce,
                product_id: $form.find('input[name="product_id"]').val(),
                booking_date: $form.find('input[name="booking_date"]').val(),
                num_guests: $form.find('select[name="num_guests"]').val(),
                customer_name: $form.find('input[name="customer_name"]').val(),
                customer_email: $form.find('input[name="customer_email"]').val(),
                customer_phone: $form.find('input[name="customer_phone"]').val(),
                notes: $form.find('textarea[name="notes"]').val(),
            };
            
            // Send AJAX request
            $.ajax({
                url: traveltourAjax.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $message.addClass('success').text(response.data.message).show();
                        $form[0].reset();
                    } else {
                        $message.addClass('error').text(response.data.message || 'Có lỗi xảy ra. Vui lòng thử lại.').show();
                    }
                },
                error: function() {
                    $message.addClass('error').text('Có lỗi xảy ra. Vui lòng thử lại.').show();
                },
                complete: function() {
                    $button.prop('disabled', false);
                    $button.html('Gửi yêu cầu đặt tour');
                }
            });

        // Tour tabs switch
        $('.tour-tab-button').on('click', function() {
            var tab = $(this).data('tab');
            $('.tour-tab-button').removeClass('is-active').attr('aria-selected', 'false');
            $(this).addClass('is-active').attr('aria-selected', 'true');

            $('.tour-tab-panel').removeClass('is-active');
            $('#tour-tab-' + tab).addClass('is-active');
        });
        });
        
        // Product Gallery Thumbnail Click
        $('.product-gallery-thumbs img').on('click', function() {
            var src = $(this).attr('src').replace('-150x150', '').replace('-300x300', '');
            $('.product-gallery img:first').attr('src', src);
        });
        
        // Mobile Menu Toggle
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('active');
        });
        
        // Smooth Scroll for Anchor Links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
            }
        });
        
        // Newsletter Form
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            var email = $(this).find('input[type="email"]').val();
            if (email) {
                alert('Cảm ơn bạn đã đăng ký nhận tin!');
                $(this)[0].reset();
            }
        });

        // Callback request form
        $('#traveltour-callback-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            var $msg = $('#callback-message');

            $btn.prop('disabled', true).text('Đang gửi...');
            $msg.hide().removeClass('success error');

            $.ajax({
                url: traveltourAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'traveltour_callback_request',
                    nonce: $form.find('input[name="nonce"]').val() || traveltourAjax.nonce,
                    product_id: $form.find('input[name="product_id"]').val(),
                    phone: $form.find('input[name="phone"]').val()
                },
                success: function(res) {
                    if (res.success) {
                        $msg.addClass('success').text(res.data.message).show();
                        $form[0].reset();
                    } else {
                        $msg.addClass('error').text(res.data.message || 'Có lỗi xảy ra').show();
                    }
                },
                error: function() {
                    $msg.addClass('error').text('Có lỗi xảy ra. Vui lòng thử lại.').show();
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Gửi');
                }
            });
        });
        
        // Lazy Load Images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            observer.unobserve(img);
                        }
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Search Form Enhancement
        $('.search-form input[type="date"]').on('change', function() {
            var selectedDate = new Date($(this).val());
            var today = new Date();
            if (selectedDate < today) {
                alert('Vui lòng chọn ngày trong tương lai');
                $(this).val('');
            }
        });
        
    });
    
    // Window Load
    $(window).on('load', function() {
        // Hide any loading spinners
        $('.loading-overlay').fadeOut();
    });
    
    // Scroll Events
    $(window).on('scroll', function() {
        var scrollTop = $(window).scrollTop();
        
        // Sticky Header Enhancement
        if (scrollTop > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });

})(jQuery);

