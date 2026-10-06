<?php

class ReportsController extends Controller
{
    public function index(): void
    {
        $this->authorize(['admin', 'manager', 'qc', 'warehouse', 'production']);

        $erp = new ErpModel();
        $this->render('reports.index', [
            'pageTitle' => 'Hisobotlar',
            'auditLogs' => $erp->auditLogs(),
        ]);
    }

    public function export(): void
    {
        $this->authorize(['admin', 'manager', 'qc', 'warehouse', 'production']);

        $format = $_GET['format'] ?? 'csv';
        $model = new ErpModel();
        $rows = $model->auditLogs();

        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="lux-yan-tex-report.csv"');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID', 'Action', 'Details', 'Created At']);
            foreach ($rows as $row) {
                fputcsv($output, [$row['id'], $row['action'], $row['details'], $row['created_at']]);
            }
            fclose($output);
            exit;
        }

        if ($format === 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="lux-yan-tex-report.pdf"');

            $pdfRows = [];
            foreach ($rows as $row) {
                $pdfRows[] = [$row['id'], $row['action'], $row['details'], $row['created_at']];
            }

            echo PdfReport::build('LUX YAN TEX ERP Report', $pdfRows);
            exit;
        }

        redirect('/reports');
    }

    public function audit(): void
    {
        $this->authorize(['admin', 'manager']);
        $erp = new ErpModel();

        $this->render('reports.index', [
            'pageTitle' => 'Audit Log',
            'auditLogs' => $erp->auditLogs(),
            'sectionName' => 'audit',
        ]);
    }

    public function apiAlerts(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $erp = new ErpModel();
        echo json_encode($erp->alerts(), JSON_PRETTY_PRINT);
        exit;
    }
}
