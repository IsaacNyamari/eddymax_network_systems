<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfReportService
{
    public function generateDashboardReport($data)
    {
        // Add logo path (adjust according to your logo location)
        $logoPath = public_path('images/edymax-logo.png');
        $logoBase64 = null;
        
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $html = view('reports.print', [
            'data' => $data,
            'logo' => $logoBase64
        ])->render();

        return Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'sans-serif');
    }
}