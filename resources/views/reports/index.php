<?php
$auditLogs = $auditLogs ?? [];
?>
<h1><?= e($pageTitle ?? 'Hisobotlar') ?></h1>

<div class="report-actions">
    <a class="btn" href="/reports/export?format=csv">CSV export</a>
    <a class="btn success" href="/reports/export?format=pdf">PDF export</a>
    <a class="btn secondary" href="/reports/audit">Audit log</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Harakat</th>
            <th>Detallar</th>
            <th>Vaqt</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($auditLogs as $log): ?>
            <tr>
                <td><?= e($log['id'] ?? '') ?></td>
                <td><?= e($log['action'] ?? '') ?></td>
                <td><?= e($log['details'] ?? '') ?></td>
                <td><?= e($log['created_at'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
