<?php

class AiAdvisor
{
    public static function analyze(array $stats): array
    {
        $insights = [];

        if (($stats['defect_rate'] ?? 0) > 8) {
            $insights[] = [
                'severity' => 'high',
                'title' => 'Sifat koeffitsientlari past',
                'message' => 'Nuqsonlar darajasi 8% dan yuqori. QC tizimini qayta tekshirish tavsiya etiladi.',
            ];
        }

        if (($stats['low_stock_items'] ?? 0) > 0) {
            $insights[] = [
                'severity' => 'medium',
                'title' => 'Xomashyo tanqisligi',
                'message' => 'Ba’zi xomashyo turidagi zaxira limitdan past. Ta’minotni yaxshilang.',
            ];
        }

        if (($stats['active_orders'] ?? 0) > 0) {
            $insights[] = [
                'severity' => 'info',
                'title' => 'Ishlab chiqarish faol',
                'message' => 'Hozirda faol buyurtmalar mavjud. Smena bilan muvofiqlashtirishni rejalashtiring.',
            ];
        }

        if (empty($insights)) {
            $insights[] = [
                'severity' => 'success',
                'title' => 'Kutilgan holat',
                'message' => 'Asosiy KPI ko‘rsatkichlari normada. Operatsion jarayonlar barqaror ishlamoqda.',
            ];
        }

        return $insights;
    }
}
