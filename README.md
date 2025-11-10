# TravelTour Pro - WordPress Theme

Theme WordPress đa năng chuyên về Du lịch với tích hợp E-commerce mạnh mẽ.

## Mô tả

TravelTour Pro là một theme WordPress hiện đại, được thiết kế đặc biệt cho các website du lịch và bán tour. Theme tích hợp đầy đủ các tính năng cần thiết cho một website du lịch chuyên nghiệp, bao gồm:

- **Giao diện hiện đại**: Thiết kế trực quan, tập trung vào hình ảnh chất lượng cao
- **Tích hợp WooCommerce**: Hỗ trợ bán tour, dịch vụ và sản phẩm du lịch
- **Hệ thống đặt tour**: Form đặt tour với tùy chọn ngày, số lượng khách
- **Đánh giá và xếp hạng**: Hệ thống đánh giá tour tích hợp
- **Responsive Design**: Hiển thị hoàn hảo trên mọi thiết bị
- **Tối ưu hóa tốc độ**: Code sạch, tối ưu cho hiệu suất cao

## Yêu cầu hệ thống

- WordPress 5.0 trở lên
- PHP 7.4 trở lên
- WooCommerce plugin (bắt buộc)
- MySQL 5.6 trở lên

## Cài đặt

1. Tải theme và giải nén vào thư mục `wp-content/themes/`
2. Đăng nhập vào WordPress Admin
3. Vào **Giao diện > Giao diện** và kích hoạt theme "TravelTour Pro"
4. Cài đặt và kích hoạt plugin **WooCommerce** (nếu chưa có)
5. Vào **Giao diện > Tùy chỉnh** để cấu hình theme

## Cấu hình

### 1. Cài đặt Menu

1. Vào **Giao diện > Menu**
2. Tạo menu mới hoặc chỉnh sửa menu hiện có
3. Gán menu vào vị trí "Main Menu"

### 2. Cài đặt Widget

1. Vào **Giao diện > Widget**
2. Thêm widget vào các khu vực:
   - Sidebar
   - Footer Column 1-4

### 3. Tùy chỉnh Theme

Vào **Giao diện > Tùy chỉnh** để cấu hình:
- Logo
- Số điện thoại liên hệ
- Email liên hệ
- Liên kết mạng xã hội
- Banner trang chủ

### 4. Cấu hình WooCommerce

1. Vào **WooCommerce > Cài đặt**
2. Cấu hình các tùy chọn cơ bản
3. Tạo sản phẩm tour với các trường tùy chỉnh:
   - Thời gian tour
   - Lịch trình tour
   - Điểm khởi hành
   - Điểm đến

## Cấu trúc Theme

```
traveltour/
├── assets/
│   ├── css/
│   │   └── main.css
│   └── js/
│       └── main.js
├── includes/
│   └── class-wc-product-tour.php
├── template-parts/
│   ├── booking-form.php
│   ├── content-homepage.php
│   ├── content-none.php
│   ├── content-product-card.php
│   └── content.php
├── 404.php
├── archive.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── search.php
├── single-product.php
├── style.css
└── README.md
```

## Tính năng chính

### 1. Trang chủ

- **Banner quảng cáo**: Banner lớn với CTA rõ ràng
- **Dịch vụ nổi bật**: Hiển thị các dịch vụ chính
- **Tour nổi bật**: Slider/carousel tour được đề xuất
- **Tour khuyến mãi**: Hiển thị tour đang giảm giá
- **Blog/Cẩm nang**: Tin tức và bài viết du lịch
- **Cảm nhận khách hàng**: Testimonials
- **Banner phụ**: Quảng cáo dịch vụ bổ sung

### 2. Trang sản phẩm/Tour

- Gallery hình ảnh
- Thông tin tour chi tiết
- Lịch trình tour
- Form đặt tour
- Đánh giá và bình luận

### 3. Hệ thống đặt tour

- Chọn ngày khởi hành
- Chọn số lượng khách
- Thông tin khách hàng
- Ghi chú đặc biệt
- Xử lý AJAX không reload trang

## Tùy chỉnh

### Thay đổi màu sắc

Chỉnh sửa file `style.css`, tìm phần `:root` và thay đổi các biến màu:

```css
:root {
    --primary-color: #FF5722;
    --primary-dark: #E64A19;
    --secondary-color: #FF9800;
    /* ... */
}
```

### Thêm Custom Post Type

Thêm vào file `functions.php`:

```php
function traveltour_register_custom_post_types() {
    // Your custom post type code
}
add_action('init', 'traveltour_register_custom_post_types');
```

## Hỗ trợ

Nếu gặp vấn đề hoặc cần hỗ trợ, vui lòng:
- Kiểm tra lại yêu cầu hệ thống
- Đảm bảo WooCommerce đã được cài đặt và kích hoạt
- Xóa cache nếu đang sử dụng plugin cache

## Tương thích

Theme tương thích với:
- **Page Builders**: Elementor, Gutenberg
- **SEO Plugins**: Yoast SEO, Rank Math
- **Cache Plugins**: WP Super Cache, W3 Total Cache
- **Contact Forms**: Contact Form 7, WPForms

## Bản quyền

Theme này được phát hành dưới giấy phép GPL v2 hoặc mới hơn.

## Phiên bản

**Version**: 1.0.0

## Tác giả

TravelTour Pro Theme

---

**Lưu ý**: Theme này yêu cầu plugin WooCommerce để hoạt động đầy đủ. Vui lòng cài đặt WooCommerce trước khi sử dụng theme.

