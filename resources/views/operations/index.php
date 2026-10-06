<?php
$sectionName = $sectionName ?? 'inventory';
$materials = $materials ?? [];
$stock = $stock ?? [];
$orders = $orders ?? [];
$checks = $checks ?? [];
$defects = $defects ?? [];
$rolls = $rolls ?? [];
?>
<h1><?= e($pageTitle ?? 'Operations') ?></h1>

<?php if ($sectionName === 'inventory'): ?>
    <div class="card-grid">
        <?php foreach ($materials as $material): ?>
            <div class="card">
                <h4><?= e($material['name']) ?></h4>
                <p>Stock: <strong><?= e($material['stock_level']) ?></strong></p>
                <p>Reorder: <strong><?= e($material['reorder_level']) ?></strong></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Material</th>
                <th>Ombor</th>
                <th>Birlik</th>
                <th>Oxirgi yangilanish</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($stock as $row): ?>
                <tr>
                    <td><?= e($row['material_name'] ?? '') ?></td>
                    <td><?= e($row['stock_quantity'] ?? 0) ?></td>
                    <td><?= e($row['unit'] ?? 'kg') ?></td>
                    <td><?= e($row['updated_at'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($sectionName === 'production'): ?>
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Buyurtma</th>
                <th>Mahsulot</th>
                <th>Miqdor</th>
                <th>Holat</th>
                <th>Vaqt</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= e($order['order_number'] ?? '') ?></td>
                    <td><?= e($order['product_name'] ?? '') ?></td>
                    <td><?= e($order['quantity'] ?? 0) ?></td>
                    <td><span class="status-pill status-active"><?= e($order['status'] ?? 'new') ?></span></td>
                    <td><?= e($order['created_at'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($sectionName === 'quality'): ?>
    <div class="card-grid">
        <div class="card">
            <h3>QC natijalari</h3>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Rulon</th>
                        <th>Natija</th>
                        <th>Tekshiruvchi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($checks as $check): ?>
                        <tr>
                            <td><?= e($check['roll_number'] ?? '') ?></td>
                            <td><?= e($check['result'] ?? 'pending') ?></td>
                            <td><?= e($check['inspector_name'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <h3>Nuqsonlar</h3>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Turi</th>
                        <th>Daraja</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($defects as $defect): ?>
                        <tr>
                            <td><?= e($defect['defect_name'] ?? '') ?></td>
                            <td><?= e($defect['defect_type'] ?? '') ?></td>
                            <td><?= e($defect['severity'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php elseif ($sectionName === 'warehouse'): ?>
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Material</th>
                <th>Miqdor</th>
                <th>Holat</th>
                <th>Yangilangan</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($stock as $row): ?>
                <tr>
                    <td><?= e($row['material_name'] ?? '') ?></td>
                    <td><?= e($row['stock_quantity'] ?? 0) ?></td>
                    <td><span class="status-pill status-active">Ready</span></td>
                    <td><?= e($row['updated_at'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($sectionName === 'rolls'): ?>
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Rulon raqami</th>
                <th>Batch</th>
                <th>QR</th>
                <th>Uzunlik</th>
                <th>Holat</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rolls as $roll): ?>
                <tr>
                    <td><?= e($roll['roll_number'] ?? '') ?></td>
                    <td><?= e($roll['batch_code'] ?? '') ?></td>
                    <td><?= e($roll['qr_code'] ?? '') ?></td>
                    <td><?= e($roll['length_m'] ?? 0) ?> m</td>
                    <td><span class="status-pill status-active"><?= e($roll['status'] ?? 'active') ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
