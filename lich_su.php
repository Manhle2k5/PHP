<?php
$host = "localhost"; $username = "root"; $password = "123456"; $dbname = "quan_ly_ban_hang";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch(PDOException $e) { die("Lỗi: " . $e->getMessage()); }
$customer = isset($_GET['customer']) ? trim($_GET['customer']) : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Mua Hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary-color: #2c3e50; --accent-color: #8e44ad; --bg-light: #f8f9fa; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: var(--bg-light); min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background-color: var(--primary-color); color: white; position: fixed; height: 100vh; padding-top: 20px; }
        .sidebar .brand { padding: 0 25px 20px 25px; font-size: 18px; font-weight: bold; border-bottom: 1px solid #34495e; }
        .sidebar ul { list-style: none; margin-top: 15px; }
        .sidebar ul li a { display: flex; align-items: center; gap: 15px; padding: 15px 25px; color: #bdc3c7; text-decoration: none; }
        .sidebar ul li a.active { background-color: #34495e; color: white; border-left: 4px solid var(--accent-color); }
        .main-content { margin-left: var(--sidebar-width); padding: 40px; margin-top:60px; width:calc(100% - var(--sidebar-width));}
        .content-block { background: white; padding: 30px; border-radius: 8px; }
        .search-box { display: flex; gap: 10px; margin-bottom: 25px; }
        .search-box input { padding: 12px; width: 450px; border: 1px solid #dcdde1; border-radius: 6px; }
        .search-box button { padding: 12px 25px; background: var(--accent-color); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 16px; border-bottom: 1px solid #edf2f7; font-size: 14px; }
        th { background-color: #f8f9fa; color: #718096; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-boxes-packing"></i> Hệ Thống Đơn</div>
        <ul>
            <li><a href="manh.php?tab=dashboard"><i class="fa-solid fa-chart-pie"></i> Thống kê hệ thống</a></li>
            <li><a href="manh.php?tab=tra_cuu"><i class="fa-solid fa-magnifying-glass"></i> Toàn bộ đơn hàng</a></li>
            <li><a href="lich_su.php" class="active"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử khách hàng</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="content-block">
            <h2 style="margin-bottom:20px;">Tra cứu lịch sử theo khách</h2>
            <form action="" method="GET" class="search-box">
                <input type="text" name="customer" placeholder="Nhập họ tên khách hàng cần kiểm tra..." value="<?= htmlspecialchars($customer) ?>" required>
                <button type="submit">Truy xuất</button>
            </form>
            <?php if($customer != ''): 
                $stmt = $conn->prepare("SELECT * FROM don_hang WHERE ten_khach_hang = ? ORDER BY ngay_mua DESC");
                $stmt->execute([$customer]);
                if($stmt->rowCount() > 0):
            ?>
                <table>
                    <thead>
                        <tr><th>Mã Đơn</th><th>Sản phẩm</th><th>Tổng Tiền</th><th>Trạng Thái</th></tr>
                    </thead>
                    <tbody>
                        <?php while($h_row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><strong><?= $h_row['ma_don_hang'] ?></strong></td>
                                <td><?= $h_row['ten_san_pham'] ?></td>
                                <td><?= number_format($h_row['tong_tien'], 0, ',', '.') ?>đ</td>
                                <td><?= $h_row['trang_thai'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: echo "<p style='color:red;'>Không tìm thấy lịch sử khách này.</p>"; endif; endif; ?>
        </div>
    </div>
</body>
</html>