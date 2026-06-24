<?php
// Bước 1: Khởi tạo dữ liệu tài xế
// Cache buster: 2026-06-20 v2
$drivers = [
    ['id' => 'TX001', 'name' => 'Nguyễn Văn A', 'distance' => 2.5, 'rating' => 4.8, 'status' => 'sẵn sàng', 'revenue' => 0],
    ['id' => 'TX002', 'name' => 'Trần Thị B', 'distance' => 3.2, 'rating' => 5.0, 'status' => 'sẵn sàng', 'revenue' => 0],
    ['id' => 'TX003', 'name' => 'Lê Văn C', 'distance' => 4.5, 'rating' => 4.2, 'status' => 'sẵn sàng', 'revenue' => 0],
    ['id' => 'TX004', 'name' => 'Phạm Thị D', 'distance' => 2.1, 'rating' => 4.6, 'status' => 'bận', 'revenue' => 0],
    ['id' => 'TX005', 'name' => 'Hoàng Văn E', 'distance' => 3.8, 'rating' => 4.9, 'status' => 'sẵn sàng', 'revenue' => 0],
];

// Bước 2: Xử lý logic phân bổ 2 cuốc xe
$assignedCount = 0;
$i = 0;

while ($i < count($drivers) && $assignedCount < 2) {
    $driver = &$drivers[$i];
    
    // Kiểm tra điều kiện
    if ($driver['status'] === 'sẵn sàng' && 
        $driver['rating'] >= 4.5 && 
        $driver['distance'] < 4) {
        
        // Cập nhật trạng thái
        $driver['status'] = 'đã nhận cuốc';
        
        // Tính doanh thu: khoảng cách x 15.000
        $driver['revenue'] = $driver['distance'] * 15000;
        
        // Nếu sao = 5.0, thưởng thêm 50.000
        if ($driver['rating'] == 5.0) {
            $driver['revenue'] += 50000;
        }
        
        $assignedCount++;
    }
    
    $i++;
}

function formatMoney($value) {
    return number_format($value, 0, ',', '.') . ' đ';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý điều phối phân bổ chuyến xe</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
        .container { max-width: 1000px; margin: 0 auto; }
        h1 { color: #333; }
        .notification { 
            margin: 20px 0; 
            padding: 15px; 
            background: #d4edda; 
            border: 1px solid #c3e6cb; 
            color: #155724; 
            border-radius: 5px;
            font-weight: bold;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td { 
            padding: 12px; 
            border: 1px solid #ddd; 
            text-align: left; 
        }
        th { 
            background: #007bff; 
            color: white;
            font-weight: bold;
        }
        .assigned { background: #e6ffed; }
        .busy { background: #f5f5f5; }
        .low-rating { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản lý điều phối phân bổ chuyến xe</h1>
        
        <div class="notification">
            ✅ Đã phân bổ thành công <?php echo $assignedCount; ?> cuốc xe
        </div>

        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã tài xế</th>
                    <th>Tên tài xế</th>
                    <th>Khoảng cách (km)</th>
                    <th>Số sao</th>
                    <th>Trạng thái</th>
                    <th>Doanh thu dự tính</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($drivers as $index => $driver) :
                    $rowClass = '';
                    if ($driver['status'] === 'đã nhận cuốc') {
                        $rowClass = 'assigned';
                    } elseif ($driver['status'] === 'bận') {
                        $rowClass = 'busy';
                    }
                    
                    $ratingClass = $driver['rating'] < 4.0 ? 'low-rating' : '';
                ?>
                    <tr class="<?php echo $rowClass; ?>">
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($driver['id']); ?></td>
                        <td><?php echo htmlspecialchars($driver['name']); ?></td>
                        <td><?php echo $driver['distance']; ?></td>
                        <td class="<?php echo $ratingClass; ?>"><?php echo $driver['rating']; ?></td>
                        <td><?php echo htmlspecialchars($driver['status']); ?></td>
                        <td><?php echo $driver['revenue'] > 0 ? formatMoney($driver['revenue']) : '-'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
