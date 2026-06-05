DROP TABLE IF EXISTS don_hang;

CREATE TABLE don_hang (
  ma_don VARCHAR(50) NOT NULL PRIMARY KEY,
  khach_hang VARCHAR(100) NOT NULL,
  chi_tiet_sp TEXT NOT NULL,
  phan_loai VARCHAR(50) NOT NULL,
  tong_tien INT NOT NULL, -- Đổi lại thành INT để lưu số nguyên thuần túy
  trang_thai_don_hang VARCHAR(50) DEFAULT 'Chờ xử lý',
  trang_thai_thanh_toan VARCHAR(50) DEFAULT 'Chưa thanh toán',
  ngay_mua DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Chèn full 25 khách hàng mua Quần/Áo với giá tiền số nguyên chuẩn đét
INSERT INTO don_hang (ma_don, khach_hang, chi_tiet_sp, phan_loai, tong_tien, trang_thai_don_hang, trang_thai_thanh_toan, ngay_mua) VALUES
('DH_AO01', 'Nguyen Van A', 'Áo thun Polo Classic', 'Áo', 300000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-01'),
('DH_AO02', 'Tran Thi B', 'Áo sơ mi trắng công sở', 'Áo', 450000, 'Chờ xử lý', 'Chưa thanh toán', '2026-06-02'),
('DH_AO03', 'Le Van C', 'Áo thun Unisex Oversize', 'Áo', 250000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-03'),
('DH_AO04', 'Pham Minh M', 'Áo khoác Bomber Jacket', 'Áo', 600000, 'Đã hủy', 'Chưa thanh toán', '2026-06-04'),
('DH_AO05', 'Hoang Van D', 'Áo Hoodie nỉ ngoại', 'Áo', 350000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-05'),
('DH_AO06', 'Vu Thi E', 'Áo len dệt kim cổ lọ', 'Áo', 280000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-05'),
('DH_QN07', 'Cao Minh Thang', 'Quần Jean Baggy Ống Rộng', 'Quần', 380000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-05'),
('DH_QN08', 'Bui Quoc Trung', 'Quần Tây Âu Công Sở Suông', 'Quần', 350000, 'Chờ xử lý', 'Chưa thanh toán', '2026-06-06'),
('DH_AO09', 'Ngo Thuy Linh', 'Áo Croptop Sọc Ngang', 'Áo', 150000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-06'),
('DH_QN10', 'Dang Huy Hoang', 'Quần Kaki Túi Hộp Dáng Rộng', 'Quần', 340000, 'Đã hủy', 'Chưa thanh toán', '2026-06-07'),
('DH_AO11', 'Phung Hoai Bao', 'Áo Polo Nam Premium Cộc Tay', 'Áo', 240000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-07'),
('DH_QN12', 'Duong Thuy Vi', 'Quần Kaki Baggy Hàn Quốc', 'Quần', 260000, 'Chờ xử lý', 'Chưa thanh toán', '2026-06-08'),
('DH_QN13', 'Ly Gia Thanh', 'Quần Đùi Thể Thao Thoáng Khí', 'Quần', 210000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-08'),
('DH_AO14', 'Trinh Cong Son', 'Áo Sơ Mi Nhung Tăm Dài Tay', 'Áo', 310000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-09'),
('DH_QN15', 'Lam Tam Nhu', 'Quần Culottes Ống Rộng', 'Quần', 290000, 'Đã hủy', 'Chưa thanh toán', '2026-06-10'),
('DH_AO16', 'Doan Nguyen Duc', 'Áo Thun Cotton Oversize', 'Áo', 180000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-10'),
('DH_QN17', 'Nguyen Hong Nhung', 'Quần Jean Skinny Co Giãn', 'Quần', 420000, 'Chờ xử lý', 'Đã thanh toán', '2026-06-11'),
('DH_AO18', 'Vu Khanh Hoai', 'Áo Len Thêu Họa Tiết', 'Áo', 550000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-11'),
('DH_QN19', 'Ta Dinh Phong', 'Quần Kaki Suông Khóa Lệch', 'Quần', 380000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-12'),
('DH_AO20', 'Ha Anh Tuan', 'Áo Giữ Nhiệt Cổ Lọ', 'Áo', 220000, 'Đã hủy', 'Chưa thanh toán', '2026-06-12'),
('DH_QN21', 'Vuong Phi', 'Quần Legging Thể Thao', 'Quần', 180000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-13'),
('DH_AO22', 'Dang Le Nguyen Vu', 'Áo Blazer Dáng Rộng', 'Áo', 680000, 'Chờ xử lý', 'Chưa thanh toán', '2026-06-14'),
('DH_QN23', 'Le Cat Trong Ly', 'Quần Baggy Kaki Khuy Bấm', 'Quần', 320000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-14'),
('DH_AO24', 'Tran Lap', 'Áo Thun Trơn Cổ Tròn', 'Áo', 190000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-15'),
('DH_QN25', 'Hoang Ngoc Anh', 'Quần Short Kaki Túi Hộp', 'Quần', 195000, 'Đã giao hàng', 'Đã thanh toán', '2026-06-15');
