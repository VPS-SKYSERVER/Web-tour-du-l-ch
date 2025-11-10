# PowerShell Script để thiết lập Git cho TravelTour Pro Theme
# Chạy script này trong thư mục theme

Write-Host "=== Thiết lập Git cho TravelTour Pro Theme ===" -ForegroundColor Green
Write-Host ""

# Kiểm tra xem đã có git chưa
if (Test-Path .git) {
    Write-Host "Git repository đã được khởi tạo!" -ForegroundColor Yellow
    $continue = Read-Host "Bạn có muốn khởi tạo lại? (y/n)"
    if ($continue -ne "y") {
        Write-Host "Đã hủy." -ForegroundColor Red
        exit
    }
    Remove-Item -Recurse -Force .git
    Write-Host "Đã xóa repository cũ." -ForegroundColor Yellow
}

# Khởi tạo git
Write-Host "Đang khởi tạo Git repository..." -ForegroundColor Cyan
git init
Write-Host "✓ Git repository đã được khởi tạo" -ForegroundColor Green

# Kiểm tra cấu hình git
Write-Host ""
Write-Host "Kiểm tra cấu hình Git..." -ForegroundColor Cyan
$userName = git config user.name
$userEmail = git config user.email

if (-not $userName) {
    Write-Host "Chưa cấu hình user.name" -ForegroundColor Yellow
    $name = Read-Host "Nhập tên của bạn"
    git config user.name $name
}

if (-not $userEmail) {
    Write-Host "Chưa cấu hình user.email" -ForegroundColor Yellow
    $email = Read-Host "Nhập email của bạn"
    git config user.email $email
}

Write-Host "✓ Cấu hình Git: $userName <$userEmail>" -ForegroundColor Green

# Thêm các file
Write-Host ""
Write-Host "Đang thêm các file vào Git..." -ForegroundColor Cyan
git add .
Write-Host "✓ Đã thêm các file" -ForegroundColor Green

# Kiểm tra trạng thái
Write-Host ""
Write-Host "Trạng thái Git:" -ForegroundColor Cyan
git status

# Tạo commit
Write-Host ""
$commitMessage = Read-Host "Nhập message cho commit đầu tiên (hoặc Enter để dùng mặc định)"
if ([string]::IsNullOrWhiteSpace($commitMessage)) {
    $commitMessage = "Initial commit: TravelTour Pro WordPress Theme v1.0.0"
}

Write-Host "Đang tạo commit..." -ForegroundColor Cyan
git commit -m $commitMessage
Write-Host "✓ Đã tạo commit đầu tiên" -ForegroundColor Green

# Hỏi có muốn thêm remote không
Write-Host ""
$addRemote = Read-Host "Bạn có muốn thêm remote repository? (y/n)"
if ($addRemote -eq "y") {
    $remoteUrl = Read-Host "Nhập URL của remote repository (ví dụ: https://github.com/username/repo.git)"
    if (-not [string]::IsNullOrWhiteSpace($remoteUrl)) {
        git remote add origin $remoteUrl
        Write-Host "✓ Đã thêm remote: $remoteUrl" -ForegroundColor Green
        
        $pushNow = Read-Host "Bạn có muốn push code lên remote ngay bây giờ? (y/n)"
        if ($pushNow -eq "y") {
            Write-Host "Đang push code lên remote..." -ForegroundColor Cyan
            git branch -M main
            git push -u origin main
            Write-Host "✓ Đã push code lên remote" -ForegroundColor Green
        }
    }
}

Write-Host ""
Write-Host "=== Hoàn tất! ===" -ForegroundColor Green
Write-Host ""
Write-Host "Các lệnh hữu ích:" -ForegroundColor Cyan
Write-Host "  git status          - Xem trạng thái" -ForegroundColor White
Write-Host "  git log             - Xem lịch sử commit" -ForegroundColor White
Write-Host "  git add .           - Thêm tất cả thay đổi" -ForegroundColor White
Write-Host "  git commit -m 'msg' - Tạo commit" -ForegroundColor White
Write-Host "  git push            - Push lên remote" -ForegroundColor White
Write-Host ""

