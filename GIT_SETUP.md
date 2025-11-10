# Hướng dẫn thiết lập Git cho TravelTour Pro Theme

## Bước 1: Khởi tạo Git Repository

Mở Terminal/PowerShell trong thư mục theme và chạy các lệnh sau:

```bash
# Khởi tạo git repository
git init

# Kiểm tra trạng thái
git status
```

## Bước 2: Cấu hình Git (nếu chưa có)

```bash
# Cấu hình tên và email (thay bằng thông tin của bạn)
git config user.name "Your Name"
git config user.email "your.email@example.com"
```

## Bước 3: Thêm các file vào Git

```bash
# Thêm tất cả các file
git add .

# Kiểm tra lại các file đã được thêm
git status
```

## Bước 4: Tạo commit đầu tiên

```bash
# Tạo commit
git commit -m "Initial commit: TravelTour Pro WordPress Theme v1.0.0"
```

## Bước 5: Tạo Repository trên GitHub/GitLab

1. Đăng nhập vào GitHub/GitLab
2. Tạo repository mới (không khởi tạo README)
3. Copy URL của repository (ví dụ: `https://github.com/username/traveltour-pro.git`)

## Bước 6: Kết nối với Remote Repository

```bash
# Thêm remote repository (thay URL bằng URL của bạn)
git remote add origin https://github.com/username/traveltour-pro.git

# Kiểm tra remote đã được thêm
git remote -v
```

## Bước 7: Push code lên Git

```bash
# Đổi tên branch thành main (nếu cần)
git branch -M main

# Push code lên remote
git push -u origin main
```

## Lệnh Git hữu ích

### Xem lịch sử commit
```bash
git log
```

### Xem thay đổi
```bash
git diff
```

### Tạo branch mới
```bash
git checkout -b feature/new-feature
```

### Commit thay đổi
```bash
git add .
git commit -m "Mô tả thay đổi"
git push
```

### Xem các branch
```bash
git branch
```

### Chuyển branch
```bash
git checkout branch-name
```

## Lưu ý

- File `.gitignore` đã được cấu hình để bỏ qua các file không cần thiết
- File `.gitattributes` đã được tạo để xử lý line endings đúng cách
- Không commit file `wp-config.php` hoặc các file nhạy cảm
- Nên tạo file `LICENSE` nếu muốn công khai theme

## Troubleshooting

### Nếu gặp lỗi "fatal: not a git repository"
- Đảm bảo bạn đang ở đúng thư mục theme
- Chạy `git init` để khởi tạo repository

### Nếu gặp lỗi khi push
- Kiểm tra kết nối internet
- Kiểm tra quyền truy cập repository
- Thử `git push -u origin main --force` (cẩn thận với lệnh này)

### Nếu muốn xóa remote
```bash
git remote remove origin
```

