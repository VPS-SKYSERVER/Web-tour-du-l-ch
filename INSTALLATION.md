# Hướng dẫn cài đặt TravelTour Pro Theme

## Bước 1: Cài đặt Theme

1. Tải theme về máy tính
2. Đăng nhập vào WordPress Admin
3. Vào **Giao diện > Giao diện > Thêm mới**
4. Chọn **Tải lên giao diện**
5. Chọn file theme (file .zip)
6. Nhấn **Cài đặt ngay**
7. Sau khi cài đặt xong, nhấn **Kích hoạt**

## Bước 2: Cài đặt WooCommerce (Bắt buộc)

1. Vào **Plugin > Thêm mới**
2. Tìm kiếm "WooCommerce"
3. Nhấn **Cài đặt** và sau đó **Kích hoạt**
4. Làm theo hướng dẫn thiết lập WooCommerce

## Bước 3: Cấu hình Theme

### 3.1. Cài đặt Menu

1. Vào **Giao diện > Menu**, nhấn **Tạo trình đơn** nếu chưa có menu nào.
2. Đặt tên menu (ví dụ: *Header*) và tick **Main Menu** trong phần **Vị trí hiển thị**, sau đó nhấn **Lưu trình đơn**.
3. Thêm từng mục với văn bản và URL gợi ý:
   - **Trang chủ**: mở **Liên kết tự tạo**, nhập URL trang chủ (ví dụ `https://tenmiencuaban/`) và nhãn “Trang chủ”.
   - **Tour trong nước** (mục cha, không liên kết): mở **Liên kết tự tạo**, nhập URL tạm là `#` hoặc `javascript:void(0);` để khi bấm không dẫn tới trang nào, đặt nhãn “Tour trong nước”, rồi thêm vào menu.
   - **Tour quốc tế**: URL gợi ý `/tour-quoc-te/`.
   - **Vé máy bay**: URL gợi ý `/ve-may-bay/`.
   - **Khách sạn**: URL gợi ý `/khach-san/`.
   - **Blog**: nếu đã cấu hình trang blog, chọn từ danh sách; nếu chưa, nhập `/blog/`.
   - **Liên hệ**: chọn trang “Liên hệ” hoặc nhập `/lien-he/`.
4. Thêm các menu con cho “Tour trong nước”:
   - Tạo các trang con như: “Tour Đà Lạt”, “Tour Phú Yên”, “Tour Sapa”, … (vào **Trang > Thêm mới**), hoặc dùng **Liên kết tự tạo** với URL tương ứng (`/tour-da-lat/`, `/tour-phu-yen/`…).
   - Thêm các mục đó vào menu, rồi trong cột **Cấu trúc menu** kéo từng mục con đặt ngay bên dưới “Tour trong nước” và kéo lệch sang phải 1 nấc để nó trở thành menu con (WordPress sẽ hiển thị nhãn “Mục con của Tour trong nước”).
   - Bạn có thể lồng nhiều cấp (con của con) theo cách kéo lệch phải thêm nấc.
5. Sau khi các mục đã xuất hiện trong cột **Cấu trúc menu**, kéo thả để sắp xếp đúng thứ tự: Trang chủ → Tour trong nước (kèm các mục con) → Tour quốc tế → Vé máy bay → Khách sạn → Blog → Liên hệ.
5. Nhấn **Lưu trình đơn**. Từ thời điểm này, menu trên site sẽ hiển thị theo danh sách bạn vừa tạo thay vì danh sách mặc định trong mã nguồn.

### 3.2. Tùy chỉnh Theme

1. Vào **Giao diện > Tùy chỉnh**
2. Trong phần **Theme Options**, cấu hình:
   - **Số điện thoại**: Nhập số điện thoại liên hệ
   - **Email**: Nhập email liên hệ
   - **Facebook URL**: Nhập link Facebook (nếu có)
   - **Banner Image**: Tải lên hình ảnh banner trang chủ
   - **Banner Title**: Tiêu đề banner
   - **Banner Text**: Nội dung banner
   - **Banner Link**: Link khi click vào banner

3. Trong phần **Logo**, tải lên logo của bạn
4. Nhấn **Xuất bản** để lưu thay đổi

### 3.3. Cài đặt Widget

1. Vào **Giao diện > Widget**
2. Kéo các widget vào các khu vực:
   - **Sidebar**: Widget cho sidebar
   - **Footer Column 1-4**: Widget cho 4 cột footer

## Bước 4: Tạo Sản phẩm Tour

1. Vào **Sản phẩm > Thêm mới**
2. Điền thông tin cơ bản:
   - **Tên sản phẩm**: Tên tour
   - **Mô tả ngắn**: Mô tả ngắn về tour
   - **Mô tả đầy đủ**: Mô tả chi tiết tour
   - **Hình ảnh sản phẩm**: Hình ảnh chính
   - **Thư viện hình ảnh**: Thêm nhiều hình ảnh
3. Trong phần **Dữ liệu sản phẩm**, điền:
   - **Giá thường**: Giá gốc
   - **Giá khuyến mãi**: Giá giảm (nếu có)
4. Trong phần **Tùy chỉnh Tour**, điền:
   - **Thời gian tour**: Ví dụ: "3 ngày 2 đêm"
   - **Lịch trình tour**: Lịch trình chi tiết
   - **Điểm khởi hành**: Ví dụ: "Hà Nội"
   - **Điểm đến**: Ví dụ: "Đà Lạt"
5. Nhấn **Xuất bản**

## Bước 5: Tạo Trang

### 5.1. Trang "Tour trong nước"

1. Vào **Trang > Thêm mới**
2. Đặt tên: "Tour trong nước"
3. Chọn template (nếu có) hoặc để mặc định
4. Xuất bản

### 5.2. Trang "Tour quốc tế"

Tương tự như trên

### 5.3. Trang "Liên hệ"

1. Tạo trang "Liên hệ"
2. Có thể sử dụng plugin Contact Form 7 để tạo form liên hệ

### 5.4. Trang "Tour Landing" (ví dụ: Tour Nha Trang)

1. Tạo trang mới (ví dụ: "Tour du lịch Nha Trang").
2. Trong phần **Thuộc tính trang > Mẫu**, chọn template **Tour Landing Page**.
3. Điền nội dung giới thiệu chính trong trình soạn thảo (sẽ hiển thị ở phần mô tả).
4. Ở meta box **Tour Landing Settings** (bên dưới trình soạn thảo):
   - **Slug danh mục tour cha**: nhập slug `product_cat` mà bạn muốn hiển thị (ví dụ `tour-nha-trang`). Hệ thống sẽ tự lấy danh mục con và sản phẩm thuộc danh mục này.
   - **Danh sách điểm nổi bật**: mỗi dòng `icon|Tiêu đề|Mô tả ngắn`. Ví dụ `dashicons-airplane|Tour du lịch linh hoạt|Khởi hành hằng ngày`.
   - **Thời tiết / thông tin phụ**: nhập tiêu đề, giá trị chính (ví dụ `30°C`) và mô tả ngắn.
   - **Slug chuyên mục bài viết**: nhập slug của category bài viết chứa kinh nghiệm (ví dụ `kinh-nghiem-du-lich-nha-trang`).
5. Đặt ảnh nổi bật cho trang để dùng làm nền hero.
6. Xuất bản trang và gán vào menu (ví dụ làm menu con của "Tour trong nước").

### 5.5. Tạo Sản phẩm Tour Mẫu (để hiển thị đúng layout chi tiết)

1. Vào **Sản phẩm > Thêm mới** và đặt tên theo tour (ví dụ: `[LIMOUSINE] Nha Trang - BBQ Tôm Hùm - 3N3Đ`).
2. Ở khung soạn thảo chính, viết toàn bộ **Chương trình/Lịch trình tour** (ngày 1, ngày 2, …). Nội dung này sẽ hiển thị trong tab **“Lịch trình tour”** của trang chi tiết.
3. Thiết lập phần **Dữ liệu sản phẩm** như thường lệ (giá, khuyến mãi...).
4. Điền các trường tuỳ chỉnh của theme trong phần “Tùy chỉnh Tour” (bên phải/ dưới cùng trang):
   - **Thời gian tour**: ví dụ `3 ngày 3 đêm`
   - **Phương tiện**: ví dụ `Xe Limousine`, `Máy bay`
   - **Tiêu chuẩn**: ví dụ `4 sao`
   - (Tuỳ chọn) Các phần mở rộng cho accordion:
     - **Giá tour chi tiết**: Tìm khung **"Giá tour chi tiết"** (meta box riêng, thường nằm dưới phần mô tả sản phẩm). Điền đầy đủ 4 trường:
       - **Giá tour cơ bản (Người lớn)**: nhập số không dấu phẩy, ví dụ `3290000`
       - **Giá tour cơ bản (Trẻ em)**: nhập số không dấu phẩy, ví dụ `2632000`
       - **Giá tour cơ bản (Em bé)**: nhập số không dấu phẩy, ví dụ `0`
       - **Phụ thu phòng đơn**: nhập số không dấu phẩy, ví dụ `1000000`
       - Hệ thống sẽ tự động format thành định dạng VND (ví dụ: `3.290.000 đ`) khi hiển thị.
     - **Lịch khởi hành**: Tìm khung **"Lịch khởi hành"** (meta box riêng, thường nằm dưới phần mô tả sản phẩm). Nhấn nút **"+ Thêm lịch khởi hành"** để thêm từng lịch. Điền đầy đủ:
       - **Ngày khởi hành**: ví dụ `13/11/2025`
       - **Phương tiện**: ví dụ `Xe Limousine 28 chỗ`
       - **Giá (VND)**: nhập số không dấu phẩy, ví dụ `3290000` (hệ thống sẽ tự format thành `3.290.000 đ`)
       - Nhấn nút **"Xóa"** để xóa lịch không cần thiết.
     - **Giá tour bao gồm, Giá tour không bao gồm, Quy định trẻ em, Quy định hủy tour, Ghi chú, Hình thức thanh toán, Điểm đón khách**: điền nội dung để hiển thị ở từng ô xổ xuống.
5. Thêm **Ảnh đại diện sản phẩm** (ảnh lớn) và **Thư viện ảnh** (gallery) trong khung “Thư viện sản phẩm”. Các ảnh này sẽ hiển thị ở phần album và trong tab **“Hình ảnh”**.
6. Gán sản phẩm vào **Danh mục sản phẩm (product_cat)** phù hợp (ví dụ: `tour-trong-nuoc > tour-nha-trang`). Việc gán đúng danh mục giúp trang **Tour Landing Page** lấy đúng dữ liệu.
7. Xuất bản sản phẩm. Mở trang chi tiết để kiểm tra:
   - Cột trái: album ảnh + thumbnail
   - Cột phải: khối giá, thông số (thời gian, phương tiện, tiêu chuẩn), nút đặt/mua
   - Banner "Yêu cầu tư vấn" với form SĐT
   - Tabs: **Lịch trình tour** (lấy từ mô tả bạn đã viết ở bước 2) và **Hình ảnh** (lấy từ gallery)

**Lưu ý về format lịch trình tour:**
Khi viết mô tả tour trong WordPress editor, để các heading tự động format thành banner xanh, bạn cần:
- Sử dụng **Heading 2 (H2)** hoặc **Heading 3 (H3)**
- Viết theo format: `NGÀY X: Nội dung` hoặc `ĐÊM X: Nội dung`
- Ví dụ:
  - `NGÀY 1: KHÁM PHÁ ĐẢO BÌNH HƯNG- BÃI CÂY ME- TIỆC NƯỚNG TÔM HÙM- BUFFET HẢI SẢN`
  - `ĐÊM 1: TP. HỒ CHÍ MINH – BÌNH HƯNG (Nghỉ đêm trên xe)`
- Hệ thống sẽ tự động tách thành 2 phần: "NGÀY 1" (bên trái) và nội dung còn lại (bên phải)

## Bước 6: Cấu hình Trang chủ

1. Vào **Cài đặt > Đọc**
2. Chọn **Trang tĩnh** cho trang chủ
3. Chọn trang bạn muốn làm trang chủ (hoặc để mặc định)
4. Lưu thay đổi

## Bước 7: Kiểm tra

1. Truy cập website để kiểm tra:
   - Header hiển thị đúng
   - Menu hoạt động
   - Banner hiển thị
   - Sản phẩm tour hiển thị
   - Footer hiển thị đầy đủ
2. Kiểm tra trên mobile:
   - Giao diện responsive
   - Menu mobile hoạt động
   - Hình ảnh hiển thị đúng

## Lưu ý

- Theme yêu cầu WooCommerce để hoạt động đầy đủ
- Đảm bảo PHP version >= 7.4
- Nên sử dụng plugin cache để tối ưu tốc độ
- Nên cài đặt plugin SEO (Yoast SEO hoặc Rank Math)

## Hỗ trợ

Nếu gặp vấn đề, vui lòng:
1. Kiểm tra lại các bước cài đặt
2. Đảm bảo WooCommerce đã được cài đặt
3. Xóa cache nếu đang sử dụng plugin cache
4. Kiểm tra lỗi trong WordPress Debug Log

