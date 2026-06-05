USE quan_ly_ban_hang;

DROP TABLE IF EXISTS don_hang;

CREATE TABLE don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_don_hang VARCHAR(20) NOT NULL UNIQUE,
    ten_khach_hang VARCHAR(100) NOT NULL,
    ngay_mua DATE NOT NULL,
    tong_tien DECIMAL(10,2) NOT NULL,
    trang_thai VARCHAR(50) NOT NULL,
    ten_san_pham VARCHAR(150) NOT NULL, -- Dùng để tìm kiếm theo tên quần/áo
    loai_san_pham VARCHAR(20) NOT NULL,  -- 'quan' hoặc 'ao' để phân loại lên thanh ngang
    so_luong INT NOT NULL
);

-- Chèn 10 đơn hàng mua Áo và 10 đơn hàng mua Quần cố định
INSERT INTO don_hang (ma_don_hang, ten_khach_hang, ngay_mua, tong_tien, trang_thai, ten_san_pham, loai_san_pham, so_luong) VALUES
-- 10 ĐƠN HÀNG ÁO
('DH_AO01', 'Nguyen Van A', '2026-06-01', 300000, 'Đã giao hàng', 'Áo thun Polo Classic', 'ao', 1),
('DH_AO02', 'Tran Thi B', '2026-06-02', 450000, 'Đang xử lý', 'Áo sơ mi trắng công sở', 'ao', 1),
('DH_AO03', 'Le Van C', '2026-06-02', 250000, 'Đã giao hàng', 'Áo thun Unisex Oversize', 'ao', 1),
('DH_AO04', 'Pham Minh M', '2026-06-03', 600000, 'Đã hủy', 'Áo khoác Bomber Jacket', 'ao', 1),
('DH_AO05', 'Hoang Van D', '2026-06-03', 350000, 'Đã giao hàng', 'Áo Hoodie nỉ ngoại', 'ao', 1),
('DH_AO06', 'Vu Thi E', '2026-06-04', 280000, 'Đã giao hàng', 'Áo len dệt kim cổ lọ', 'ao', 1),
('DH_AO07', 'Dang Van F', '2026-06-04', 320000, 'Đang xử lý', 'Áo thun thể thao Dry-fit', 'ao', 1),
('DH_AO08', 'Bui Thi G', '2026-06-05', 500000, 'Đã giao hàng', 'Áo khoác gió chống nước', 'ao', 1),
('DH_AO09', 'Ngo Van H', '2026-06-05', 400000, 'Đã giao hàng', 'Áo sơ mi Flanel kẻ caro', 'ao', 1),
('DH_AO10', 'Ly Thi K', '2026-06-06', 220000, 'Đang xử lý', 'Áo ba lỗ tập gym', 'ao', 1),
-- 10 ĐƠN HÀNG QUẦN
('DH_QUAN01', 'Nguyen Van A', '2026-06-01', 400000, 'Đã giao hàng', 'Quần Jean Slimfit xanh', 'quan', 1),
('DH_QUAN02', 'Tran Thi B', '2026-06-02', 350000, 'Đang xử lý', 'Quần Tây âu ống đứng', 'quan', 1),
('DH_QUAN03', 'Le Van C', '2026-06-02', 200000, 'Đã giao hàng', 'Quần Short Kaki basic', 'quan', 1),
('DH_QUAN04', 'Hoang Van D', '2026-06-03', 450000, 'Đã giao hàng', 'Quần Jogger nỉ thể thao', 'quan', 1),
('DH_QUAN05', 'Bui Thi G', '2026-06-04', 380000, 'Đã hủy', 'Quần Kaki túi hộp Cargo', 'quan', 1),
('DH_QUAN06', 'Vu Thi E', '2026-06-04', 550000, 'Đã giao hàng', 'Quần Jean rách gối phố', 'quan', 1),
('DH_QUAN07', 'Dang Van F', '2026-06-05', 300000, 'Đang xử lý', 'Quần vải đũi ống rộng', 'quan', 1),
('DH_QUAN08', 'Ngo Van H', '2026-06-05', 250000, 'Đã giao hàng', 'Quần Short thun mặc nhà', 'quan', 1),
('DH_QUAN09', 'Ly Thi K', '2026-06-06', 420000, 'Đã giao hàng', 'Quần Chino thanh lịch', 'quan', 1),
('DH_QUAN10', 'Pham Minh M', '2026-06-06', 480000, 'Đang xử lý', 'Quần Baggy vải cao cấp', 'quan', 1);