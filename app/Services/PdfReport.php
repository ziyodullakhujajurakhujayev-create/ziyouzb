<?php

class PdfReport
{
    public static function build(string $title, array $rows): string
    {
        $lines = [$title];

        foreach ($rows as $index => $row) {
            $parts = [];
            foreach ($row as $value) {
                $parts[] = (string) $value;
            }
            $lines[] = ($index + 1) . '. ' . implode(' | ', $parts);
        }

        $content = "BT\n/F1 14 Tf\n50 800 Td\n(" . self::escapePdfText($title) . ") Tj\nET\n";
        $y = 770;

        foreach ($lines as $lineIndex => $line) {
            if ($lineIndex === 0) {
                continue;
            }
            $content .= "BT\n/F1 10 Tf\n50 {$y} Td\n(" . self::escapePdfText(substr($line, 0, 120)) . ") Tj\nET\n";
            $y -= 18;
        }

        $objects = [
            "<< /Type /Catalog /Pages 2 0 R >>",
            "<< /Type /Pages /Kids [3 0 R] /Count 1 >>",
            "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>",
            "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>",
            "<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream"
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $objIndex => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($objIndex + 1) . " 0 obj\n" . $object . "\nendobj\n";
        }

        $xrefPosition = strlen($pdf);
        $pdf .= "xref\n0 " . count($offsets) . "\n";
        $pdf .= "0000000000 65535 f \n";
        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size " . count($offsets) . " /Root 1 0 R >>\nstartxref\n" . $xrefPosition . "\n%%EOF";

        return $pdf;
    }

    private static function escapePdfText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
