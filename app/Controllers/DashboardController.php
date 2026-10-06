<?php

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->authorize(['admin', 'manager', 'operator', 'qc', 'warehouse', 'production']);

        $erp = new ErpModel();
        $stats = $erp->dashboardStats();
        $alerts = $erp->alerts();
        $insights = AiAdvisor::analyze($stats);

        $this->render('dashboard.index', [
            'pageTitle' => 'Dashboard',
            'stats' => $stats,
            'alerts' => $alerts,
            'insights' => $insights,
        ]);
    }
}
