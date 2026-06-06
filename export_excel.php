<?php

ob_start();
include 'connect.php'; 
ob_end_clean(); 

// 2. Cấu hình Header chuẩn cho file CSV tải về
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="bao_cao_ke_toan_don_hang.csv"');

// 3. Mở luồng xuất dữ liệu (Đã sửa lỗi thêm tham số 'w' chuẩn đét)
$output = fopen('php://output', 'w');

// 4. Ghi byte-order mark (BOM) để Excel hiển thị đúng font Tiếng Việt không lỗi font
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// 5. Định nghĩa tiêu đề các cột trong Excel
$header = [
    'Mã Đơn Hàng', 
    'Đối Tác Khách Hàng', 
    'Nội Dung Sản Phẩm Phân Phối', 
    'Phân Loại Mặt Hàng', 
    'Tổng Giá Trị (VND)', 
    'Trạng Thái Vận Chuyển', 
    'Tình Trạng Tài Chính',
    'Ngày Mua'
];
fputcsv($output, $header);

// 6. Truy vấn lấy dữ liệu từ database đơn hàng của ông
$query = "SELECT ma_don, khach_hang, chi_tiet_sp, phan_loai, tong_tien, trang_thai_don_hang, trang_thai_thanh_toan, ngay_mua FROM don_hang";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Ghi dữ liệu sạch từng dòng vào Excel
        fputcsv($output, [
            $row['ma_don'],
            $row['khach_hang'],
            $row['chi_tiet_sp'],
            $row['phan_loai'],
            $row['tong_tien'], // Database lưu số int thuần túy thì Excel sẽ hiển thị số rất đẹp
            $row['trang_thai_don_hang'],
            $row['trang_thai_thanh_toan'],
            $row['ngay_mua']
        ]);
    }
}

// 7. Đóng luồng và thoát hoàn toàn để không dính code thừa
fclose($output);
mysqli_close($conn);
exit();
?>