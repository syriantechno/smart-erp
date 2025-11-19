<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class PdfExporter
{
    public function stream(string $view, array $data = [], string $filename = 'document.pdf', array $options = [])
    {
        $mpdf = $this->makeInstance($options);

        $html = view($view, $data)->render();

        $mpdf->WriteHTML($html);

        $output = $mpdf->Output($filename, Destination::STRING_RETURN);

        return response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    protected function makeInstance(array $overrides = []): Mpdf
    {
        $pdfConfig = config('pdf', []);

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $defaultFontConfig = (new FontVariables())->getDefaults();

        $config = [
            'mode' => Arr::get($pdfConfig, 'mode', 'utf-8'),
            'format' => Arr::get($pdfConfig, 'format', 'A4'),
            'directionality' => Arr::get($pdfConfig, 'directionality', 'rtl'),
            'default_font' => Arr::get($pdfConfig, 'default_font', 'cairo'),
            'fontDir' => array_merge($defaultConfig['fontDir'], Arr::get($pdfConfig, 'font_dir', [])),
            'fontdata' => $defaultFontConfig['fontdata'] + Arr::get($pdfConfig, 'fonts', []),
        ];

        $options = array_merge(Arr::get($pdfConfig, 'options', []), $overrides);

        return new Mpdf(array_merge($config, $options));
    }
}
