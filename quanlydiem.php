<?php

$toan = 80; // sửa giá trị tại đây
$ly   = 70; // sửa giá trị tại đây
$hoa  = 80; // sửa giá trị tại đây

// Kiểm tra hợp lệ đơn giản
foreach (['Toán'=>$toan,'Lý'=>$ly,'Hóa'=>$hoa] as $k=>$v) {
    if (!is_numeric($v) || $v < 0 || $v > 100) {
        echo "Giá trị $k không hợp lệ (phải là số 0-100).";
        exit;
    }
}

$avg = ($toan + $ly + $hoa) / 3;
$passed = ($avg >= 5) && ($toan >= 3) && ($ly >= 3) && ($hoa >= 3);
$hocluc = ($avg >= 8) ? 'Giỏi' : (($avg >= 6.5) ? 'Khá' : (($avg >= 5) ? 'Trung bình' : 'Yếu'));

?><!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Kết quả điểm</title>
  <style>body{font-family:Arial;line-height:1.6}</style>
</head>
<body>
  <h1>KẾT QUẢ</h1>
  <p>Điểm Toán: <?php echo number_format($toan,2); ?></p>
  <p>Điểm Lý: <?php echo number_format($ly,2); ?></p>
  <p>Điểm Hóa: <?php echo number_format($hoa,2); ?></p>
  <p>Điểm TB: <?php echo number_format($avg,2); ?></p>
  <p>Kết luận: <?php echo $passed ? 'Đạt yêu cầu' : 'Không đạt yêu cầu'; ?></p>
  <p>Học lực: <?php echo $hocluc; ?></p>
</body>
</html>