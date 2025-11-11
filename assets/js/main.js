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
        
        // Product slider
        (function(){
            var $slider = $('[data-product-slider]');
            if (!$slider.length) return;
            var $slides = $slider.find('.product-slide');
            var $thumbsWrap = $('[data-slider-thumbs]');
            var $thumbs = $thumbsWrap.find('.product-thumb');
            var current = 0;
            var timer = null;
            var intervalMs = 4000; // auto slide every 4s
            function goTo(index){
                if (index < 0) index = $slides.length - 1;
                if (index >= $slides.length) index = 0;
                current = index;
                $slides.removeClass('is-active').eq(current).addClass('is-active');
                $thumbs.removeClass('is-active').eq(current).addClass('is-active');
            }
            function startAuto(){
                stopAuto();
                timer = setInterval(function(){ goTo(current + 1); }, intervalMs);
            }
            function stopAuto(){
                if (timer) { clearInterval(timer); timer = null; }
            }
            // No arrows (removed from markup)
            $thumbs.on('click', function(){
                var idx = parseInt($(this).attr('data-thumb-index'), 10);
                goTo(idx);
                startAuto();
            });
            // pause on hover, resume on leave
            $slider.on('mouseenter', stopAuto).on('mouseleave', startAuto);
            startAuto();
        })();

        // Tour accordion
        (function(){
            var $accordion = $('[data-tour-accordion]');
            if (!$accordion.length) return;
            $accordion.on('click', '.tour-accordion__header', function(){
                var $header = $(this);
                var $body = $header.next('.tour-accordion__body');
                var isOpen = $body.hasClass('is-open');
                if (isOpen) {
                    $body.removeClass('is-open').stop().slideUp(180);
                    $header.removeClass('is-open');
                } else {
                    $accordion.find('.tour-accordion__body').removeClass('is-open').stop().slideUp(180);
                    $accordion.find('.tour-accordion__header').removeClass('is-open');
                    $body.addClass('is-open').stop().slideDown(220);
                    $header.addClass('is-open');
                }
            });
            // open first section if any
            var $first = $accordion.find('.tour-accordion__header').first();
            if ($first.length) {
                $first.trigger('click');
            }
        })();
        
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
        
        // Price Check Calculator
        function updatePriceSummary() {
            var adultQty = parseInt($('#price-adult').val()) || 0;
            var childQty = parseInt($('#price-child').val()) || 0;
            var infantQty = parseInt($('#price-infant').val()) || 0;
            
            var adultPrice = parseFloat($('#price-adult').data('price')) || 0;
            var childPrice = parseFloat($('#price-child').data('price')) || 0;
            var infantPrice = parseFloat($('#price-infant').data('price')) || 0;
            
            var adultTotal = adultQty * adultPrice;
            var childTotal = childQty * childPrice;
            var infantTotal = infantQty * infantPrice;
            var grandTotal = adultTotal + childTotal + infantTotal;
            
            // Update quantities
            $('.qty-adult').text(adultQty);
            $('.qty-child').text(childQty);
            $('.qty-infant').text(infantQty);
            
            // Update totals
            $('.total-adult').text(formatPrice(adultTotal));
            $('.total-child').text(formatPrice(childTotal));
            $('.total-infant').text(formatPrice(infantTotal));
            $('.grand-total').text(formatPrice(grandTotal));
        }
        
        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(Math.round(price)) + ' ₫';
        }
        
        // Auto-calculate on input change
        $('#price-adult, #price-child, #price-infant').on('input change', function() {
            updatePriceSummary();
        });
        
        // Initialize calculation
        if ($('#price-check-form').length) {
            updatePriceSummary();
        }
        
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

