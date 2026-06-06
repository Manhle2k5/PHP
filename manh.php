<?php

include 'connect.php';

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'tra_cuu';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý Đơn Hàng Vận Hành</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
      
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
            font-family: 'Inter', sans-serif; 
        }
        body { 
            background-color: #f8fafc; 
            color: #1e293b; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        
        .top-banner {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #334155;
        }
        .brand-logo {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-logo i {
            color: #3b82f6;
        }
        .user-profile {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

       
        .top-navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 5px;
        }
        .nav-menu li a {
            display: block;
            padding: 18px 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            border-bottom: 3px solid transparent;
        }
        .nav-menu li a:hover {
            color: #3b82f6;
        }
        .nav-menu li.active a {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }
        .nav-menu li a i {
            margin-right: 8px;
        }

        /* KHU VỰC CHỨA NỘI DUNG CHÍNH */
        .main-container {
            flex: 1;
            padding: 30px;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
        }

        /* KHỐI BO TRÒN TRẮNG HIỆN ĐẠI */
        .card-panel {
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 25px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        /* THANH ĐIỀU HƯỚNG TÌM KIẾM & XUẤT FILE */
        .action-flex-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }
        .search-wrapper {
            display: flex;
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        .search-wrapper input {
            width: 100%;
            padding: 11px 16px;
            padding-right: 100px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-wrapper input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .search-wrapper button {
            position: absolute;
            right: 4px;
            top: 4px;
            bottom: 4px;
            background-color: #2563eb;
            color: #fff;
            border: none;
            padding: 0 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: background 0.2s;
        }
        .search-wrapper button:hover {
            background-color: #1d4ed8;
        }
        
        .btn-download-excel {
            background-color: #16a34a;
            color: white;
            padding: 11px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
            border: 1px solid #15803d;
        }
        .btn-download-excel:hover {
            background-color: #15803d;
        }

        
        .table-scroll-container {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: left;
            min-width: 1000px; 
        }
        table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        table tr:last-child td {
            border-bottom: none;
        }
        table tr:hover {
            background-color: #f8fafc;
        }

       
        .col-code { width: 11%; font-weight: 700; color: #2563eb; }
        .col-customer { width: 15%; font-weight: 600; color: #0f172a; }
        .col-detail { width: 26%; line-height: 1.5; }
        .col-type { width: 10%; }
        .col-price { width: 12%; font-weight: 700; color: #0f172a; }
        .col-status { width: 13%; }
        .col-pay { width: 13%; }
        .col-action { width: 10%; text-align: right; }

        
        .badge {
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .bg-waiting { background-color: #fef3c7; color: #d97706; }
        .bg-success { background-color: #dcfce7; color: #15803d; }
        .bg-cancel { background-color: #fee2e2; color: #b91c1c; }
        .bg-pay-done { background-color: #e0f2fe; color: #0369a1; }
        .bg-pay-wait { background-color: #f1f5f9; color: #475569; }
        .bg-category { background-color: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0; font-size: 11px; }

        
        .btn-action-print {
            background-color: transparent;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-action-print:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        /* GRID THỐNG KÊ (ANALYTICS) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .stat-card {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .stat-number {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
        }
        .stat-icon-box {
            width: 48px;
            height: 48px;
            background-color: #f1f5f9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #475569;
        }
    </style>
</head>
<body>

    <div class="top-banner">
        <div class="brand-logo"><i class="fa-solid fa-layer-group"></i> ENTERPRISE ERP</div>
        <div class="user-profile"><i class="fa-solid fa-circle-user"></i> Nhân viên: Mạnh</div>
    </div>

    <div class="top-navbar">
        <ul class="nav-menu">
            <li class="<?php echo $tab == 'tra_cuu' ? 'active' : ''; ?>">
                <a href="manh.php?tab=tra_cuu"><i class="fa-solid fa-magnifying-glass"></i> 1. Tra cứu đơn hàng</a>
            </li>
            <li class="<?php echo $tab == 'lich_su' ? 'active' : ''; ?>">
                <a href="manh.php?tab=lich_su"><i class="fa-solid fa-clock-rotate-left"></i> 2. Lịch sử khách hàng</a>
            </li>
            <li class="<?php echo $tab == 'thong_ke' ? 'active' : ''; ?>">
                <a href="manh.php?tab=thong_ke"><i class="fa-solid fa-chart-line"></i> 3. Thống kê doanh thu</a>
            </li>
        </ul>
    </div>

    <div class="main-container">
        
        <?php if($tab == 'tra_cuu'): ?>
        <div class="page-title">Danh Sách Quản Lý Đơn Hàng Toàn Hệ Thống</div>
        <div class="card-panel">
            <div class="action-flex-bar">
                <form action="manh.php" method="GET" class="search-wrapper">
                    <input type="hidden" name="tab" value="tra_cuu">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm nhanh theo mã đơn, đối tác khách hàng...">
                    <button type="submit">Tìm kiếm</button>
                </form>
                <a href="export_excel.php" class="btn-download-excel"><i class="fa-solid fa-file-excel"></i> Xuất Báo Cáo Excel</a>
            </div>

            <div class="table-scroll-container">
                <table>
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Khách Hàng</th>
                            <th>Chi Tiết Sản Phẩm</th>
                            <th>Phân Loại</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái Đơn</th>
                            <th>Thanh Toán</th>
                            <th style="text-align: right;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM don_hang WHERE 1=1";
                        if(!empty($search)) {
                            $sql .= " AND (ma_don LIKE '%$search%' OR khach_hang LIKE '%$search%' OR chi_tiet_sp LIKE '%$search%')";
                        }
                        $res = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($res) > 0) {
                            while($row = mysqli_fetch_assoc($res)):
                                
                                $s_badge = 'bg-waiting';
                                if($row['trang_thai_don_hang'] == 'Đã giao hàng') $s_badge = 'bg-success';
                                if($row['trang_thai_don_hang'] == 'Đã hủy') $s_badge = 'bg-cancel';
                                
                               
                                $p_badge = ($row['trang_thai_thanh_toan'] == 'Đã thanh toán') ? 'bg-pay-done' : 'bg-pay-wait';
                        ?>
                        <tr>
                            <td class="col-code">#<?php echo $row['ma_don']; ?></td>
                            <td class="col-customer"><?php echo $row['khach_hang']; ?></td>
                            <td class="col-detail"><?php echo $row['chi_tiet_sp']; ?></td>
                            <td class="col-type"><span class="badge bg-category"><?php echo $row['phan_loai']; ?></span></td>
                            <td class="col-price"><?php echo number_format($row['tong_tien'], 0, ',', '.'); ?>đ</td>
                            <td class="col-status"><span class="badge <?php echo $s_badge; ?>"><?php echo $row['trang_thai_don_hang']; ?></span></td>
                            <td class="col-pay"><span class="badge <?php echo $p_badge; ?>"><?php echo $row['trang_thai_thanh_toan']; ?></span></td>
                            <td class="col-action">
                                <button onclick="inDonHang('<?php echo $row['ma_don']; ?>', '<?php echo $row['khach_hang']; ?>', '<?php echo $row['chi_tiet_sp']; ?>', '<?php echo number_format($row['tong_tien'], 0, ',', '.'); ?>đ')" class="btn-print btn-action-print">
                                    <i class="fa-solid fa-print"></i> In
                                </button>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        } else {
                            echo "<tr><td colspan='8' style='text-align: center; color: #94a3b8; padding: 40px;'>Không tìm thấy dữ liệu phù hợp với bộ lọc.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php if($tab == 'lich_su'): ?>
        <div class="page-title">Phân Tích Lịch Sử Mua Hàng Của Khách Hàng</div>
        <div class="card-panel">
            <div class="table-scroll-container">
                <table style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th>Tên Khách Hàng</th>
                            <th>Tần Suất Đơn</th>
                            <th>Danh Mục Sản Phẩm Tích Lũy</th>
                            <th style="text-align: right;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_group = "SELECT khach_hang, COUNT(ma_don) as so_don, GROUP_CONCAT(chi_tiet_sp SEPARATOR ' + ') as ds_sp FROM don_hang GROUP BY khach_hang";
                        $res_group = mysqli_query($conn, $sql_group);
                        while($g = mysqli_fetch_assoc($res_group)):
                        ?>
                        <tr>
                            <td style="font-weight: 600; color:#0f172a;"><?php echo $g['khach_hang']; ?></td>
                            <td><span class="badge bg-success"><?php echo $g['so_don']; ?> Đơn Hàng</span></td>
                            <td style="color:#475569; font-size:13px; line-height: 1.5;"><?php echo $g['ds_sp']; ?></td>
                            <td style="text-align: right;">
                                <a href="manh.php?tab=tra_cuu&search=<?php echo urlencode($g['khach_hang']); ?>" class="btn-action-print" style="text-decoration:none;">
                                    <i class="fa-solid fa-filter"></i> Lọc đơn
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php if($tab == 'thong_ke'): ?>
        <?php
            $sql_cal = "SELECT * FROM don_hang";
            $res_cal = mysqli_query($conn, $sql_cal);
            $total_revenue = 0; $count_success = 0; $count_cancel = 0; $total_records = mysqli_num_rows($res_cal);
            while($c = mysqli_fetch_assoc($res_cal)) {
                if($c['trang_thai_don_hang'] == 'Đã giao hàng') {
                    $total_revenue += intval($c['tong_tien']);
                    $count_success++;
                } elseif($c['trang_thai_don_hang'] == 'Đã hủy') {
                    $count_cancel++;
                }
            }
            $rate_cancel = ($total_records > 0) ? round(($count_cancel / $total_records) * 100, 1) : 0;
        ?>
        <div class="page-title">Báo Cáo Hiệu Suất & Doanh Thu Kinh Doanh</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div>
                    <div class="stat-label">Doanh thu thực tế (Đã Giao)</div>
                    <div class="stat-number" style="color: #16a34a;"><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</div>
                </div>
                <div class="stat-icon-box" style="background-color: #dcfce7; color: #16a34a;"><i class="fa-solid fa-money-bill-wave"></i></div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-label">Đơn hàng thành công</div>
                    <div class="stat-number"><?php echo $count_success; ?> Đơn</div>
                </div>
                <div class="stat-icon-box" style="background-color: #e0f2fe; color: #0284c7;"><i class="fa-solid fa-box-open"></i></div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-label">Tỷ lệ hủy đơn hàng</div>
                    <div class="stat-number" style="color:#dc2626;"><?php echo $rate_cancel; ?>%</div>
                </div>
                <div class="stat-icon-box" style="background-color: #fee2e2; color:#dc2626;"><i class="fa-solid fa-ban"></i></div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
    function inDonHang(maDon, khachHang, sanPham, tongTien) {
        var myWindow = window.open('', 'PRINT', 'height=650,width=850');
        myWindow.document.write('<html><head><title>Hóa đơn - ' + maDon + '</title>');
        myWindow.document.write('<style>body{font-family:sans-serif;padding:40px;color:#334155;}.header{text-align:center;border-bottom:2px dashed #cbd5e1;padding-bottom:15px;margin-bottom:25px;}.header h2{margin:0;color:#0f172a;}table{width:100%;border-collapse:collapse;margin:20px 0;}th,td{border:1px solid #e2e8f0;padding:12px;text-align:left;}th{background-color:#f8fafc;color:#475569;}.total{text-align:right;font-size:1.3em;font-weight:700;margin-top:25px;color:#2563eb;}</style></head><body>');
        myWindow.document.write('<div class="header"><h2>HÓA ĐƠN BÁN HÀNG ĐIỆN TỬ</h2><p>Mã hóa đơn: ' + maDon + '</p></div>');
        myWindow.document.write('<p style="margin-bottom:8px;"><b>Khách hàng:</b> ' + khachHang + '</p>');
        myWindow.document.write('<table><thead><tr><th>Nội dung mặt hàng</th><th>Thành tiền</th></tr></thead><tbody>');
        myWindow.document.write('<tr><td>' + sanPham + '</td><td>' + tongTien + '</td></tr>');
        myWindow.document.write('</tbody></table>');
        myWindow.document.write('<div class="total">Tổng cộng thanh toán: ' + tongTien + '</div>');
        myWindow.document.write('</body></html>');
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function() { myWindow.print(); myWindow.close(); }, 500);
    }
    </script>
</body>
</html>
//http://localhost:8000/manh.php
//D:\php\php.exe -S localhost:8000
