<?php
function locTuNhieuXo($binh_luan) {
    $tu_nhay_cam = ['xau_tinh', 'dot_nat', 'luoi_bieng'];
    $thay_the = array_fill(0, count($tu_nhay_cam), '***');
    return str_replace($tu_nhay_cam, $thay_the, $binh_luan);
}

// Ví dụ
echo locTuNhieuXo('Bình luận có xau_tinh và dot_nat trong đó.');
?>