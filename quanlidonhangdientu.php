<?php
// Bước 1: Khởi tạo dữ liệu kho hàng
$products = [
    ['code' => 'SP001', 'name' => 'Laptop văn phòng', 'qty' => 12, 'price' => 15000000, 'status' => 'đang bán'],
    ['code' => 'SP002', 'name' => 'Chuột không dây', 'qty' => 8, 'price' => 250000, 'status' => 'đang bán'],
    ['code' => 'SP003', 'name' => 'Tai nghe Bluetooth', 'qty' => 4, 'price' => 550000, 'status' => 'đang bán'],
    ['code' => 'SP004', 'name' => 'Màn hình 24 inch', 'qty' => 2, 'price' => 3200000, 'status' => 'ngừng kinh doanh'],
];

// Bước 2: Xử lý logic cập nhật kho hàng
$products[0]['qty'] -= 3; // xuất kho sản phẩm thứ nhất
$products[1]['qty'] += 5; // nhập kho sản phẩm thứ hai

$totalValue = 0;
$lowStock = [];
foreach ($products as $product) {
    $totalValue += $product['qty'] * $product['price'];
    if ($product['qty'] < 5) {
        $lowStock[] = $product;
    }
}

function formatMoney($value) {
    return number_format($value, 0, ',', '.') . ' đ';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý kho hàng điện tử</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #f5f5f5; }
        .discontinued { background: #f2f2f2; }
        .low-stock { color: red; font-weight: bold; }
        .summary { font-weight: bold; }
        .warning { margin: 15px 0; padding: 10px; background: #fff4e5; border: 1px solid #ffcc80; }
    </style>
</head>
<body>
    <h1>Quản lý kho hàng điện tử</h1>

    <?php if (!empty($lowStock)) : ?>
        <div class="warning">
            <strong>Cảnh báo:</strong> Các sản phẩm sắp hết hàng:
            <ul>
                <?php foreach ($lowStock as $item) : ?>
                    <li><?php echo htmlspecialchars($item['code'] . ' - ' . $item['name'] . ' (Còn ' . $item['qty'] . ' chiếc)'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $index => $product) :
                $total = $product['qty'] * $product['price'];
                $rowClass = $product['status'] === 'ngừng kinh doanh' ? 'discontinued' : '';
                $qtyClass = $product['qty'] < 5 ? 'low-stock' : '';
            ?>
                <tr class="<?php echo $rowClass; ?>">
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($product['code']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td class="<?php echo $qtyClass; ?>"><?php echo $product['qty']; ?></td>
                    <td><?php echo formatMoney($product['price']); ?></td>
                    <td><?php echo formatMoney($total); ?></td>
                    <td><?php echo htmlspecialchars($product['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="summary">
                <td colspan="3">Tổng</td>
                <td><?php echo array_sum(array_column($products, 'qty')); ?></td>
                <td></td>
                <td><?php echo formatMoney($totalValue); ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
