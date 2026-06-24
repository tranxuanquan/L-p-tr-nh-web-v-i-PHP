<?php

// Thông tin khách hàng
$ten_kh = 'Nguyễn Văn A';
$so_du_ban_dau = 5000000; // 5 triệu đồng
$so_du = $so_du_ban_dau;
$lai_suat = 0.05; // 5% / năm

// Danh sách giao dịch (nạp: +, rút: -, chuyển: c)
$giao_dich = [
    ['loai' => 'nap', 'so_tien' => 2000000, 'mo_ta' => 'Nạp tiền qua ATM'],
    ['loai' => 'rut', 'so_tien' => 1000000, 'mo_ta' => 'Rút tiền'],
    ['loai' => 'chuyen', 'so_tien' => 500000, 'mo_ta' => 'Chuyển khoản'],
];

$tong_phi = 0;
$lich_su_giao_dich = [];

// Xử lý từng giao dịch (toán tử gán kết hợp +=, -=)
foreach ($giao_dich as $gd) {
    $loai = $gd['loai'];
    $so_tien = $gd['so_tien'];
    $mo_ta = $gd['mo_ta'];
    
    $phi = 0;
    $trang_thai = '';
    
    if ($loai === 'nap') {
        // Nạp tiền (toán tử gán kết hợp +=)
        $so_du += $so_tien;
        $trang_thai = 'Thành công';
        
    } elseif ($loai === 'rut' || $loai === 'chuyen') {
        // Tính phí 1% (toán tử số học *)
        $phi = $so_tien * 0.01;
        $tong_tai_tru = $so_tien + $phi;
        
        // Kiểm tra đủ số dư (toán tử so sánh >=, logic &&)
        if ($so_du >= $tong_tai_tru && $so_du > 0) {
            // Trừ tiền (toán tử gán kết hợp -=)
            $so_du -= $tong_tai_tru;
            $tong_phi += $phi;
            $trang_thai = 'Thành công';
        } else {
            $trang_thai = 'Không đủ số dư';
            $phi = 0;
        }
    }
    
    // Lưu lịch sử giao dịch
    $lich_su_giao_dich[] = [
        'mo_ta' => $mo_ta,
        'loai' => $loai,
        'so_tien' => $so_tien,
        'phi' => $phi,
        'trang_thai' => $trang_thai,
    ];
}

// Tính lãi suất tiết kiệm cho năm (toán tử số học *)
$tien_lai = $so_du * $lai_suat;
$so_du_sau_lai = $so_du + $tien_lai;

// Phân loại khách hàng theo số dư (toán tử ba ngôi ?:)
if ($so_du >= 10000000) {
    $hang_the = 'VIP → Thẻ Vàng';
} elseif ($so_du >= 1000000) {
    $hang_the = 'Thường → Thẻ Bạc';
} else {
    $hang_the = 'Cảnh báo → Không cấp thẻ';
}

// Kiểm tra trạng thái tài khoản (toán tử ba ngôi ?:)
$trang_thai_tk = ($so_du > 0) ? 'Hoạt động' : 'Bị khóa';

?><!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Quản lý tài khoản ngân hàng</title>
  <style>
    body { font-family: Arial; line-height: 1.8; margin: 20px; }
    table { border-collapse: collapse; width: 100%; max-width: 700px; margin-top: 15px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background: #007bff; color: white; }
    .success { background: #d4edda; }
    .error { background: #f8d7da; }
    .info { background: #f9f9f9; padding: 15px; border-left: 4px solid #007bff; margin-top: 20px; }
    .summary { background: #e7f3ff; padding: 15px; border-left: 4px solid #007bff; margin-top: 20px; }
  </style>
</head>
<body>
  <h1>QUẢN LÝ TÀI KHOẢN NGÂN HÀNG</h1>

  <div class="info">
    <p><strong>Khách hàng:</strong> <?php echo $ten_kh; ?></p>
    <p><strong>Số dư ban đầu:</strong> <?php echo number_format($so_du_ban_dau, 0, ',', '.'); ?> đ</p>
    <p><strong>Hạng thẻ:</strong> <?php echo $hang_the; ?></p>
    <p><strong>Trạng thái:</strong> <?php echo $trang_thai_tk; ?></p>
  </div>

  <h2>Lịch sử giao dịch</h2>
  <table>
    <tr>
      <th>Mô tả</th>
      <th>Loại</th>
      <th>Số tiền</th>
      <th>Phí</th>
      <th>Kết quả</th>
    </tr>
    <?php foreach ($lich_su_giao_dich as $ld): ?>
      <tr class="<?php echo ($ld['trang_thai'] === 'Thành công') ? 'success' : 'error'; ?>">
        <td><?php echo $ld['mo_ta']; ?></td>
        <td><?php echo ucfirst($ld['loai']); ?></td>
        <td><?php echo number_format($ld['so_tien'], 0, ',', '.'); ?> đ</td>
        <td><?php echo ($ld['phi'] > 0) ? number_format($ld['phi'], 0, ',', '.') . ' đ' : '-'; ?></td>
        <td><?php echo $ld['trang_thai']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <div class="summary">
    <h2>Tóm tắt tài khoản</h2>
    <p><strong>Số dư hiện tại:</strong> <?php echo number_format($so_du, 0, ',', '.'); ?> đ</p>
    <p><strong>Tổng phí đã trừ:</strong> <?php echo number_format($tong_phi, 0, ',', '.'); ?> đ</p>
    <p><strong>Lãi suất (5%/năm):</strong> <?php echo number_format($tien_lai, 0, ',', '.'); ?> đ</p>
    <p><strong>Số dư sau 1 năm:</strong> <?php echo number_format($so_du_sau_lai, 0, ',', '.'); ?> đ</p>
  </div>

  <hr>
  <p style="color: #666; font-size: 12px;">
    Để thay đổi, hãy sửa các biến: <code>$so_du_ban_dau</code>, <code>$giao_dich</code> ở đầu file.
  </p>
</body>
</html>
