<?php

// Giỏ hàng (danh sách sản phẩm với số lượng và đơn giá)
$cart = [
    ['ten' => 'Laptop', 'so_luong' => 1, 'don_gia' => 15000000],
    ['ten' => 'Chuột', 'so_luong' => 2, 'don_gia' => 500000],
    ['ten' => 'Bàn phím', 'so_luong' => 1, 'don_gia' => 2000000],
];

$ma_giam_gia = 'GDUOUGDE'; // mã giảm giá (hoặc để '' nếu không có)
$giam_gia_code = 500000;   // giảm thêm số tiền này nếu có mã

// Tính tổng tiền giỏ hàng (toán tử số học +, *)
$tong = 0;
foreach ($cart as $sp) {
    $tong = $tong + ($sp['so_luong'] * $sp['don_gia']);
}

// Áp dụng giảm giá 10% nếu tổng >= 1,000,000 (toán tử so sánh >=, logic &&)
$giam_gia_10 = 0;
if ($tong >= 1000000) {
    $giam_gia_10 = $tong * 0.1;
}

// Kiểm tra điều kiện miễn phí vận chuyển (so sánh, logic ||)
$dieu_kien = ($tong >= 500000) || ($ma_giam_gia !== '');
$phi_van_chuyen = 0;
if (!$dieu_kien) {
    $phi_van_chuyen = 50000;
}

// Xác định trạng thái đơn hàng (toán tử ba ngôi ?:)
$trang_thai = ($tong == 0) ? 'Giỏ hàng trống' : 'Đang xử lý';

// Tính tổng sau giảm giá
$tong_sau_giam = $tong - $giam_gia_10;

// Áp dụng mã giảm giá (toán tử gán kết hợp -=)
if ($ma_giam_gia !== '') {
    $tong_sau_giam -= $giam_gia_code;
}

// Cộng phí vận chuyển (toán tử gán kết hợp +=)
$tong_cuoi_cung = $tong_sau_giam;
$tong_cuoi_cung += $phi_van_chuyen;

// Đảm bảo không âm
if ($tong_cuoi_cung < 0) {
    $tong_cuoi_cung = 0;
}

?><!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Quản lý đơn hàng</title>
  <style>
    body { font-family: Arial; line-height: 1.8; margin: 20px; }
    table { border-collapse: collapse; width: 100%; max-width: 600px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f0f0f0; }
    .result { margin-top: 20px; background: #f9f9f9; padding: 15px; border-left: 4px solid #007bff; }
  </style>
</head>
<body>
  <h1>QUẢN LÝ ĐƠN HÀNG</h1>

  <h2>Chi tiết sản phẩm</h2>
  <table>
    <tr>
      <th>Sản phẩm</th>
      <th>Số lượng</th>
      <th>Đơn giá</th>
      <th>Thành tiền</th>
    </tr>
    <?php foreach ($cart as $sp): ?>
      <tr>
        <td><?php echo $sp['ten']; ?></td>
        <td><?php echo $sp['so_luong']; ?></td>
        <td><?php echo number_format($sp['don_gia'], 0, ',', '.'); ?> đ</td>
        <td><?php echo number_format($sp['so_luong'] * $sp['don_gia'], 0, ',', '.'); ?> đ</td>
      </tr>
    <?php endforeach; ?>
  </table>

  <div class="result">
    <h2>Kết quả tính toán</h2>
    <!-- Toán tử chuỗi (.) để nối các thông báo -->
    <?php
      $thong_bao = '';
      $thong_bao .= 'Tổng tiền hàng: ' . number_format($tong, 0, ',', '.') . ' đ<br>';
      $thong_bao .= 'Giảm giá 10%: -' . number_format($giam_gia_10, 0, ',', '.') . ' đ<br>';
      if ($ma_giam_gia !== '') {
          $thong_bao .= 'Mã giảm giá (' . $ma_giam_gia . '): -' . number_format($giam_gia_code, 0, ',', '.') . ' đ<br>';
      }
      $thong_bao .= 'Phí vận chuyển: ' . number_format($phi_van_chuyen, 0, ',', '.') . ' đ<br>';
      $thong_bao .= '<strong>Tổng cộng: ' . number_format($tong_cuoi_cung, 0, ',', '.') . ' đ</strong><br>';
      $thong_bao .= 'Trạng thái: ' . $trang_thai;
      
      echo $thong_bao;
    ?>
  </div>

  <hr>
  <p style="color: #666; font-size: 12px;">
    Để thay đổi, hãy sửa các biến: <code>$cart</code>, <code>$ma_giam_gia</code>, <code>$giam_gia_code</code> ở đầu file.
  </p>
</body>
</html>
