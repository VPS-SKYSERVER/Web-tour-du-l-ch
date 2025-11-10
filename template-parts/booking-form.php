<?php
/**
 * Template part for booking form
 *
 * @package TravelTour
 */
global $product;
?>

<form id="traveltour-booking-form" class="booking-form">
    <?php wp_nonce_field('traveltour_booking', 'traveltour_booking_nonce'); ?>
    <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
    
    <div class="form-row">
        <div class="form-group">
            <label for="booking_date"><?php _e('Ngày khởi hành', 'traveltour'); ?> <span class="required">*</span></label>
            <input type="date" id="booking_date" name="booking_date" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="num_guests"><?php _e('Số lượng khách', 'traveltour'); ?> <span class="required">*</span></label>
            <select id="num_guests" name="num_guests" required>
                <option value=""><?php _e('Chọn số lượng', 'traveltour'); ?></option>
                <?php for ($i = 1; $i <= 20; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?> <?php _e('khách', 'traveltour'); ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="customer_name"><?php _e('Họ và tên', 'traveltour'); ?> <span class="required">*</span></label>
            <input type="text" id="customer_name" name="customer_name" required>
        </div>
        
        <div class="form-group">
            <label for="customer_email"><?php _e('Email', 'traveltour'); ?> <span class="required">*</span></label>
            <input type="email" id="customer_email" name="customer_email" required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="customer_phone"><?php _e('Số điện thoại', 'traveltour'); ?> <span class="required">*</span></label>
            <input type="tel" id="customer_phone" name="customer_phone" required>
        </div>
    </div>
    
    <div class="form-group">
        <label for="notes"><?php _e('Ghi chú thêm', 'traveltour'); ?></label>
        <textarea id="notes" name="notes" rows="4" placeholder="<?php _e('Nhập yêu cầu đặc biệt hoặc ghi chú...', 'traveltour'); ?>"></textarea>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn-primary btn-booking"><?php _e('Gửi yêu cầu đặt tour', 'traveltour'); ?></button>
    </div>
    
    <div id="booking-message" class="booking-message"></div>
</form>

<style>
.booking-form {
    background: var(--bg-light);
    padding: 25px;
    border-radius: 10px;
    margin-top: 30px;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-dark);
}

.form-group .required {
    color: var(--primary-color);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
}

.btn-booking {
    width: 100%;
    padding: 15px;
    font-size: 16px;
}

.booking-message {
    margin-top: 15px;
    padding: 15px;
    border-radius: 5px;
    display: none;
}

.booking-message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    display: block;
}

.booking-message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    display: block;
}
</style>

