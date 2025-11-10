#!/bin/bash
# Bash Script để thiết lập Git cho TravelTour Pro Theme
# Chạy script này trong thư mục theme

echo "=== Thiết lập Git cho TravelTour Pro Theme ==="
echo ""

# Kiểm tra xem đã có git chưa
if [ -d .git ]; then
    echo "Git repository đã được khởi tạo!"
    read -p "Bạn có muốn khởi tạo lại? (y/n) " continue
    if [ "$continue" != "y" ]; then
        echo "Đã hủy."
        exit
    fi
    rm -rf .git
    echo "Đã xóa repository cũ."
fi

# Khởi tạo git
echo "Đang khởi tạo Git repository..."
git init
echo "✓ Git repository đã được khởi tạo"

# Kiểm tra cấu hình git
echo ""
echo "Kiểm tra cấu hình Git..."
userName=$(git config user.name)
userEmail=$(git config user.email)

if [ -z "$userName" ]; then
    echo "Chưa cấu hình user.name"
    read -p "Nhập tên của bạn: " name
    git config user.name "$name"
fi

if [ -z "$userEmail" ]; then
    echo "Chưa cấu hình user.email"
    read -p "Nhập email của bạn: " email
    git config user.email "$email"
fi

echo "✓ Cấu hình Git: $userName <$userEmail>"

# Thêm các file
echo ""
echo "Đang thêm các file vào Git..."
git add .
echo "✓ Đã thêm các file"

# Kiểm tra trạng thái
echo ""
echo "Trạng thái Git:"
git status

# Tạo commit
echo ""
read -p "Nhập message cho commit đầu tiên (hoặc Enter để dùng mặc định): " commitMessage
if [ -z "$commitMessage" ]; then
    commitMessage="Initial commit: TravelTour Pro WordPress Theme v1.0.0"
fi

echo "Đang tạo commit..."
git commit -m "$commitMessage"
echo "✓ Đã tạo commit đầu tiên"

# Hỏi có muốn thêm remote không
echo ""
read -p "Bạn có muốn thêm remote repository? (y/n) " addRemote
if [ "$addRemote" = "y" ]; then
    read -p "Nhập URL của remote repository (ví dụ: https://github.com/username/repo.git): " remoteUrl
    if [ -n "$remoteUrl" ]; then
        git remote add origin "$remoteUrl"
        echo "✓ Đã thêm remote: $remoteUrl"
        
        read -p "Bạn có muốn push code lên remote ngay bây giờ? (y/n) " pushNow
        if [ "$pushNow" = "y" ]; then
            echo "Đang push code lên remote..."
            git branch -M main
            git push -u origin main
            echo "✓ Đã push code lên remote"
        fi
    fi
fi

echo ""
echo "=== Hoàn tất! ==="
echo ""
echo "Các lệnh hữu ích:"
echo "  git status          - Xem trạng thái"
echo "  git log             - Xem lịch sử commit"
echo "  git add .           - Thêm tất cả thay đổi"
echo "  git commit -m 'msg' - Tạo commit"
echo "  git push            - Push lên remote"
echo ""

