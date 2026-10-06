<?php

class OperationsController extends Controller
{
    public function inventory(): void
    {
        $this->authorize(['admin', 'manager', 'warehouse', 'production']);
        $erp = new ErpModel();
        $data = $erp->inventorySummary();

        $this->render('operations.index', [
            'pageTitle' => 'Xomashyo va Ombor',
            'sectionName' => 'inventory',
            'materials' => $data['materials'],
            'stock' => $data['stock'],
        ]);
    }

    public function production(): void
    {
        $this->authorize(['admin', 'manager', 'production']);
        $erp = new ErpModel();

        $this->render('operations.index', [
            'pageTitle' => 'Ishlab chiqarish',
            'sectionName' => 'production',
            'orders' => $erp->productionOrders(),
        ]);
    }

    public function quality(): void
    {
        $this->authorize(['admin', 'manager', 'qc']);
        $erp = new ErpModel();

        $this->render('operations.index', [
            'pageTitle' => 'Sifat nazorati',
            'sectionName' => 'quality',
            'checks' => $erp->qualityChecks(),
            'defects' => $erp->defects(),
        ]);
    }

    public function warehouse(): void
    {
        $this->authorize(['admin', 'manager', 'warehouse']);
        $erp = new ErpModel();

        $this->render('operations.index', [
            'pageTitle' => 'Ombor boshqaruvi',
            'sectionName' => 'warehouse',
            'stock' => $erp->inventorySummary()['stock'],
        ]);
    }

    public function rolls(): void
    {
        $this->authorize(['admin', 'manager', 'warehouse', 'production', 'qc']);
        $erp = new ErpModel();

        $this->render('operations.index', [
            'pageTitle' => 'Rulonlar',
            'sectionName' => 'rolls',
            'rolls' => $erp->rolls(),
        ]);
    }
}
