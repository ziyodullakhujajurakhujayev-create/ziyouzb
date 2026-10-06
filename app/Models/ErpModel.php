<?php

class ErpModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function dashboardStats(): array
    {
        $stats = $this->db->fetch(
            'SELECT
                (SELECT COUNT(*) FROM users) AS total_users,
                (SELECT COUNT(*) FROM production_orders WHERE status <> "completed") AS active_orders,
                (SELECT COUNT(*) FROM warehouse_inventory) AS inventory_rows,
                (SELECT COALESCE(SUM(stock_quantity),0) FROM warehouse_inventory) AS total_stock,
                (SELECT COUNT(*) FROM rolls) AS total_rolls,
                (SELECT COUNT(*) FROM defects) AS defect_total,
                (SELECT COUNT(*) FROM quality_checks WHERE result = "pass") AS qc_pass,
                (SELECT COUNT(*) FROM quality_checks WHERE result = "fail") AS qc_fail,
                (SELECT COUNT(*) FROM alerts WHERE is_active = 1) AS active_alerts,
                (SELECT COUNT(*) FROM raw_materials WHERE stock_level < reorder_level) AS low_stock_items'
        );

        $totalQc = (int) ($stats['qc_pass'] ?? 0) + (int) ($stats['qc_fail'] ?? 0);
        $defectRate = $totalQc > 0 ? round(((int) ($stats['qc_fail'] ?? 0) / $totalQc) * 100, 2) : 0;

        return [
            'total_users' => (int) ($stats['total_users'] ?? 0),
            'active_orders' => (int) ($stats['active_orders'] ?? 0),
            'inventory_rows' => (int) ($stats['inventory_rows'] ?? 0),
            'total_stock' => (float) ($stats['total_stock'] ?? 0),
            'total_rolls' => (int) ($stats['total_rolls'] ?? 0),
            'defect_total' => (int) ($stats['defect_total'] ?? 0),
            'qc_pass' => (int) ($stats['qc_pass'] ?? 0),
            'qc_fail' => (int) ($stats['qc_fail'] ?? 0),
            'active_alerts' => (int) ($stats['active_alerts'] ?? 0),
            'low_stock_items' => (int) ($stats['low_stock_items'] ?? 0),
            'defect_rate' => $defectRate,
        ];
    }

    public function inventorySummary(): array
    {
        $materials = $this->db->fetchAll('SELECT * FROM raw_materials ORDER BY name ASC');
        $stock = $this->db->fetchAll('SELECT * FROM warehouse_inventory ORDER BY updated_at DESC LIMIT 20');

        return [
            'materials' => $materials,
            'stock' => $stock,
        ];
    }

    public function productionOrders(): array
    {
        return $this->db->fetchAll('SELECT * FROM production_orders ORDER BY created_at DESC LIMIT 20');
    }

    public function rolls(): array
    {
        return $this->db->fetchAll('SELECT * FROM rolls ORDER BY created_at DESC LIMIT 30');
    }

    public function qualityChecks(): array
    {
        return $this->db->fetchAll('SELECT * FROM quality_checks ORDER BY checked_at DESC LIMIT 20');
    }

    public function defects(): array
    {
        return $this->db->fetchAll('SELECT * FROM defects ORDER BY created_at DESC LIMIT 20');
    }

    public function operators(): array
    {
        return $this->db->fetchAll('SELECT * FROM operators ORDER BY created_at DESC LIMIT 20');
    }

    public function alerts(): array
    {
        return $this->db->fetchAll('SELECT * FROM alerts ORDER BY created_at DESC LIMIT 10');
    }

    public function auditLogs(): array
    {
        return $this->db->fetchAll('SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 30');
    }

    public function traceability(string $q): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM rolls WHERE roll_number = :q OR qr_code = :q OR batch_code = :q ORDER BY created_at DESC LIMIT 10',
            ['q' => $q]
        );
    }

    public function addAuditLog(string $action, string $details, int $userId = 0): void
    {
        $this->db->execute(
            'INSERT INTO audit_logs (user_id, action, details, created_at) VALUES (:user_id, :action, :details, NOW())',
            [
                'user_id' => $userId,
                'action' => $action,
                'details' => $details,
            ]
        );
    }
}
