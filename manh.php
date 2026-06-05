<?php

$host = "localhost";
$username = "root"; 
$password = "123456"; // <-- Điền mật khẩu MySQL của bạn vào đây
$dbname = "quan_ly_ban_hang";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối database thất bại: " . $e->getMessage());
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';
$filter_loai = isset($_GET['loai']) ? $_GET['loai'] : ''; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ Thống Quản Lý Đơn Hàng Cao Cấp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-width: 270px; 
            --navbar-height: 70px; 
            --primary-dark: #1e293b; 
            --sidebar-active: #334155;
            --accent-color: #3b82f6; 
            --accent-hover: #2563eb;
            --bg-light: #f1f5f9; 
            --card-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { display: flex; background-color: var(--bg-light); min-height: 100vh; color: #334155; }
        
        /* SIDEBAR DỌC HIỆN ĐẠI */
        .sidebar { width: var(--sidebar-width); background-color: var(--primary-dark); color: white; position: fixed; height: 100vh; padding: 25px 0; z-index: 10; box-shadow: 4px 0 10px rgba(0,0,0,0.05); }
        .sidebar .brand { padding: 0 25px 25px 25px; font-size: 20px; font-weight: 700; border-bottom: 1px solid #475569; text-transform: uppercase; letter-spacing: 1px; color: #f8fafc; display: flex; align-items: center; gap: 10px; }
        .sidebar ul { list-style: none; margin-top: 25px; padding: 0 12px; }
        .sidebar ul li { margin-bottom: 5px; }
        .sidebar ul li a { display: flex; align-items: center; gap: 12px; padding: 14px 20px; color: #94a3b8; text-decoration: none; border-radius: 8px; transition: all 0.25s ease; font-size: 14px; font-weight: 500; }
        .sidebar ul li a:hover { background-color: var(--sidebar-active); color: #f8fafc; }
        .sidebar ul li a.active { background-color: var(--accent-color); color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        
        /* NAVBAR NGANG SIÊU SANG - ĐÃ BỎ CHỮ THỪA */
        .navbar-ngang { position: fixed; top: 0; left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); height: var(--navbar-height); background: white; box-shadow: 0 1px 10px rgba(0,0,0,0.05); display: flex; align-items: center; padding: 0 40px; justify-content: space-between; z-index: 9; }
        .tabs-container { display: flex; gap: 12px; }
        .navbar-ngang a.nav-pill { text-decoration: none; color: #64748b; font-weight: 600; padding: 10px 24px; border-radius: 30px; transition: all 0.2s ease; display: flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0; font-size: 14px; }
        .navbar-ngang a.nav-pill:hover { background: #f1f5f9; color: #1e293b; }
        .navbar-ngang a.nav-pill.active { background: var(--accent-color); color: white; border-color: var(--accent-color); box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2); }
        
        /* USER PROFILE THÊM MỚI */
        .user-profile { display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; color: #475569; }
        .user-avatar { width: 36px; height: 36px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--accent-color); border: 2px solid #cbd5e1; }

        /* KHU VỰC HIỂN THỊ NỘI DUNG */
        .main-content { margin-left: var(--sidebar-width); margin-top: var(--navbar-height); width: calc(100% - var(--sidebar-width)); padding: 40px; }
        h1, h2 { font-weight: 700; color: #0f172a; }
        
        /* THẺ TIỆN ÍCH DASHBOARD */
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 40px; }
        .card { background: white; padding: 24px; border-radius: 12px; box-shadow: var(--card-shadow); display: flex; justify-content: space-between; align-items: center; border: 1px solid #f1f5f9; }
        .card h3 { font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .card p { font-size: 24px; font-weight: 700; color: #0f172a; margin-top: 6px; }
        .card-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        
        /* KHỐI NỘI DUNG TRẮNG BÊN TRONG */
        .content-block { background: white; padding: 30px; border-radius: 12px; box-shadow: var(--card-shadow); border: 1px solid #e2e8f0; }
        
        /* THANH TÌM KIẾM TINH CHỈNH */
        .search-box { display: flex; gap: 12px; margin-bottom: 30px; }
        .search-box input { padding: 14px 20px; width: 450px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; transition: all 0.2s; background: #f8fafc; }
        .search-box input:focus { outline: none; border-color: var(--accent-color); background: white; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
        .search-box button { padding: 14px 28px; background: var(--accent-color); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 14px; transition: background 0.2s; }
        .search-box button:hover { background: var(--accent-hover); }
        
        /* BẢNG DỮ LIỆU ĐẸP NHƯ TEMPLATE MUA */
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 16px 20px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        th { background-color: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; }
        tbody tr { transition: background-color 0.2s ease; }
        tbody tr:hover { background-color: #f8fafc; }
        
        /* BADGE PHÂN LOẠI TRẠNG THÁI BO TRÒN TINH TẾ */
        .badge { padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
        .badge::before { content: ""; width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        
        .status-success { background: #bbf7d0; color: #166534; }
        .status-success::before { background: #166534; }
        .status-warning { background: #fef08a; color: #854d0e; }
        .status-warning::before { background: #854d0e; }
        .status-danger { background: #fecaca; color: #991b1b; }
        .status-danger::before { background: #991b1b; }
        
        .badge-cate { background: #e0f2fe; color: #0369a1; font-weight: bold; }
    </style>
</head>
<body>

    <div class="navbar-ngang">
        <div class="tabs-container">
            <a href="?tab=tra_cuu&loai=ao" class="nav-pill <?= $filter_loai == 'ao' ? 'active' : '' ?>"><i class="fa-solid fa-shirt"></i> Đơn Hàng Áo</a>
            <a href="?tab=tra_cuu&loai=quan" class="nav-pill <?= $filter_loai == 'quan' ? 'active' : '' ?>"><i class="fa-solid fa-socks"></i> Đơn Hàng Quần</a>
        </div>
        
        <div class="user-profile">
            <div class="user-avatar"><i class="fa-solid fa-user-gear"></i></div>
            <span>Admin: Mạnh</span>
        </div>
    </div>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-shield-halved"></i> Store Console</div>
        <ul>
            <li><a href="?tab=dashboard" class="<?= $tab == 'dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-chart-line"></i> Thống kê hệ thống</a></li>
            <li><a href="?tab=tra_cuu" class="<?= $tab == 'tra_cuu' && $filter_loai == '' ? 'active' : '' ?>"><i class="fa-solid fa-list-check"></i> Toàn bộ đơn hàng</a></li>
            <li><a href="lich_su.php"><i class="fa-solid fa-user-clock"></i> Lịch sử khách hàng</a></li>
        </ul>
    </div>

    <div class="main-content">
        
        <?php if($tab == 'dashboard'): 
            $total_orders = $conn->query("SELECT COUNT(*) FROM don_hang")->fetchColumn();
            $success_revenue = $conn->query("SELECT SUM(tong_tien) FROM don_hang WHERE trang_thai = 'Đã giao hàng'")->fetchColumn() ?? 0;
            $total_ao = $conn->query("SELECT COUNT(*) FROM don_hang WHERE loai_san_pham = 'ao'")->fetchColumn();
            $total_quan = $conn->query("SELECT COUNT(*) FROM don_hang WHERE loai_san_pham = 'quan'")->fetchColumn();
        ?>
            <h2 style="margin-bottom: 25px;">Hệ Thống Phân Tích Tổng Quan</h2>
            <div class="cards-grid">
                <div class="card">
                    <div><h3>Tổng đơn toàn quốc</h3><p><?= $total_orders ?> đơn</p></div>
                    <div class="card-icon" style="background:#eff6ff; color:#3b82f6;"><i class="fa-solid fa-cubes"></i></div>
                </div>
                <div class="card">
                    <div><h3>Thực thu doanh số</h3><p><?= number_format($success_revenue, 0, ',', '.') ?>đ</p></div>
                    <div class="card-icon" style="background:#f0fdf4; color:#22c55e;"><i class="fa-solid fa-sack-dollar"></i></div>
                </div>
                <div class="card">
                    <div><h3>Tổng kho mẫu Áo</h3><p><?= $total_ao ?> sản phẩm</p></div>
                    <div class="card-icon" style="background:#fff7ed; color:#ea580c;"><i class="fa-solid fa-shirt"></i></div>
                </div>
                <div class="card">
                    <div><h3>Tổng kho mẫu Quần</h3><p><?= $total_quan ?> sản phẩm</p></div>
                    <div class="card-icon" style="background:#faf5ff; color:#a855f7;"><i class="fa-solid fa-socks"></i></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($tab == 'tra_cuu' || $tab == 'chi_tiet'): 
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        ?>
            <h2 style="margin-bottom: 25px;">
                <?php 
                    if($filter_loai == 'ao') echo "Phân Hệ Quản Lý: Đơn Hàng Áo (10 mẫu)";
                    elseif($filter_loai == 'quan') echo "Phân Hệ Quản Lý: Đơn Hàng Quần (10 mẫu)";
                    else echo "Toàn Bộ Dữ Liệu Đơn Đang Lưu Trữ";
                ?>
            </h2>

            <div class="content-block">
                <form action="" method="GET" class="search-box">
                    <input type="hidden" name="tab" value="tra_cuu">
                    <input type="hidden" name="loai" value="<?= $filter_loai ?>"> 
                    <input type="text" name="search" placeholder="Gõ tìm kiếm thông minh (Tìm theo Tên khách, Tên mẫu quần hoặc mẫu áo...)" value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Lọc Nhanh</button>
                    <?php if($search != '' || $filter_loai != ''): ?>
                        <a href="?tab=tra_cuu"><button type="button" style="background:#64748b;">Hủy Lọc</button></a>
                    <?php endif; ?>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Khách Hàng</th>
                            <th>Chi Tiết Sản Phẩm</th>
                            <th>Phân Loại</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th style="text-align:right;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM don_hang WHERE 1=1";
                        $params = [];

                        if ($filter_loai != '') {
                            $sql .= " AND loai_san_pham = :loai";
                            $params['loai'] = $filter_loai;
                        }

                        if ($search != '') {
                            $sql .= " AND (ten_khach_hang LIKE :search OR ten_san_pham LIKE :search)";
                            $params['search'] = "%$search%";
                        }

                        $stmt = $conn->prepare($sql);
                        $stmt->execute($params);

                        if($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status_badge = $row['trang_thai'] == 'Đã giao hàng' ? 'status-success' : ($row['trang_thai'] == 'Đang xử lý' ? 'status-warning' : 'status-danger');
                                echo "<tr>";
                                echo "<td><strong style='color:var(--accent-color); font-weight:600;'>{$row['ma_don_hang']}</strong></td>";
                                echo "<td><span style='font-weight:500; color:#1e293b;'>{$row['ten_khach_hang']}</span></td>";
                                echo "<td><strong style='color:#334155;'>{$row['ten_san_pham']}</strong></td>";
                                echo "<td><span class='badge badge-cate'>" . ($row['loai_san_pham'] == 'ao' ? 'Áo' : 'Quần') . "</span></td>";
                                echo "<td><span style='font-weight:600; color:#0f172a;'>" . number_format($row['tong_tien'], 0, ',', '.') . "đ</span></td>";
                                echo "<td><span class='badge $status_badge'>{$row['trang_thai']}</span></td>";
                                echo "<td style='text-align:right;'><a href='?tab=chi_tiet&id={$row['id']}&loai=$filter_loai' style='color:var(--accent-color); text-decoration:none; font-weight:600;'><i class='fa-regular fa-folder-open'></i> Chi tiết</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center; padding: 40px; color:#94a3b8; font-weight:500;'>Không tìm thấy bất kỳ bản ghi nào trùng khớp!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php if($tab == 'chi_tiet' && isset($_GET['id'])): 
                $stmt_ct = $conn->prepare("SELECT * FROM don_hang WHERE id = ?");
                $stmt_ct->execute([intval($_GET['id'])]);
                $ct = $stmt_ct->fetch(PDO::FETCH_ASSOC);
                if($ct):
            ?>
                <div class="content-block" style="margin-top:30px; border-left: 5px solid var(--accent-color); background: #f8fafc;">
                    <h3 style="color:#0f172a; display:flex; align-items:center; gap:8px;"><i class="fa-solid fa-receipt" style="color:var(--accent-color);"></i> Hóa Đơn Trích Xuất Hệ Thống</h3>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; margin-top:20px; font-size:14px;">
                        <div>Mã hóa đơn: <strong><?= $ct['ma_don_hang'] ?></strong></div>
                        <div>Chủ hộ mua hàng: <strong><?= $ct['ten_khach_hang'] ?></strong></div>
                        <div>Tên mẫu trang phục: <span style="color:#e11d48; font-weight:600;"><?= $ct['ten_san_pham'] ?></span> (SL: <?= $ct['so_luong'] ?>)</div>
                        <div>Tổng thanh toán tiền mặt: <strong style="color:#16a34a; font-size:16px;"><?= number_format($ct['tong_tien'], 0, ',', '.') ?> VNĐ</strong></div>
                    </div>
                </div>
            <?php endif; endif; ?>

        <?php endif; ?>

    </div>
</body>
</html>
//http://localhost:8000/manh.php
//D:\php\php.exe -S localhost:8000