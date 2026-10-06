<?php
$stats = $stats ?? [];
$alerts = $alerts ?? [];
$insights = $insights ?? [];
?>
<h1>Dashboard</h1>
<div class="card-grid">
    <div class="card">
        <div class="metric-label">Umumiy foydalanuvchilar</div>
        <div class="kpi"><?= e($stats['total_users'] ?? 0) ?></div>
    </div>
    <div class="card">
        <div class="metric-label">Faol buyurtmalar</div>
        <div class="kpi"><?= e($stats['active_orders'] ?? 0) ?></div>
    </div>
    <div class="card">
        <div class="metric-label">Umumiy zaxira</div>
        <div class="kpi"><?= e($stats['total_stock'] ?? 0) ?></div>
    </div>
    <div class="card">
        <div class="metric-label">Rulonlar</div>
        <div class="kpi"><?= e($stats['total_rolls'] ?? 0) ?></div>
    </div>
    <div class="card">
        <div class="metric-label">Nuqsonlar</div>
        <div class="kpi"><?= e($stats['defect_total'] ?? 0) ?></div>
    </div>
    <div class="card">
        <div class="metric-label">QC sifat darajasi</div>
        <div class="kpi"><?= e($stats['defect_rate'] ?? 0) ?>%</div>
    </div>
</div>

<div class="card-grid">
    <div class="card">
        <h3>AI maslahatlari</h3>
        <div class="insight-list">
            <?php foreach ($insights as $insight): ?>
                <div class="insight-item">
                    <strong><?= e($insight['title']) ?></strong>
                    <p><?= e($insight['message']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card">
        <h3>Real-time bildirishnomalar</h3>
        <div id="live-alerts"></div>
    </div>
</div>

<div class="table-wrap">
    <table>
        <thead>
        <tr>
            <th>Yozuv</th>
            <th>Xabar</th>
            <th>Holat</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($alerts as $alert): ?>
            <tr>
                <td><?= e($alert['title'] ?? 'Bildirishnoma') ?></td>
                <td><?= e($alert['message'] ?? '') ?></td>
                <td>
                    <span class="status-pill <?= ($alert['is_active'] ?? 0) ? 'status-active' : 'status-warn' ?>">
                        <?= ($alert['is_active'] ?? 0) ? 'Faol' : 'Yopiq' ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
