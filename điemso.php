<?php
$diem_so = [8.5, 4.0, 9.2, 5.5, 3.5, 7.0, 6.8, 10.0];

// Tính điểm trung bình
$tong = array_sum($diem_so);
$so_luong = count($diem_so);
$diem_trung_binh = $so_luong > 0 ? $tong / $so_luong : 0;

// Tính điểm cao nhất và thấp nhất
$diem_cao_nhat = max($diem_so);
$diem_thap_nhat = min($diem_so);

// Tìm số sinh viên trượt (điểm < 5.0)
$so_sinh_vien_truot = 0;
foreach ($diem_so as $diem) {
    if ($diem < 5.0) {
        $so_sinh_vien_truot++;
    }
}

// Hiển thị kết quả
echo "Điểm trung bình: " . number_format($diem_trung_binh, 2) . "<br>";
echo "Điểm cao nhất: " . $diem_cao_nhat . "<br>";
echo "Điểm thấp nhất: " . $diem_thap_nhat . "<br>";
echo "Số sinh viên trượt: " . $so_sinh_vien_truot . "<br>";
?>      
