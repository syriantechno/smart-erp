# Unified PDF Export Guide

This project now uses a shared mPDF-based exporter (`App\Services\PdfExporter`). Use this guide to adopt it anywhere in the system.

## 1. Service Overview
- **Config file**: `config/pdf.php`
  - Controls page format, font directories, registered fonts (Cairo/XB Riyaz), and RTL options.
- **Service class**: `App\Services\PdfExporter`
  - Wraps mPDF creation and streams the rendered Blade view as a PDF response.
  - Automatically loads settings from `config/pdf.php` but accepts overrides per export.

## 2. Basic Usage in a Controller
```php
use App\Services\PdfExporter;

class SampleController extends Controller
{
    public function __construct(private PdfExporter $pdfExporter)
    {
    }

    public function export()
    {
        $data = [
            'records' => Model::latest()->get(),
            'exportedAt' => now(),
        ];

        return $this->pdfExporter->stream(
            'reports.sample_pdf', // Blade view path
            $data,
            'sample-report.pdf'
        );
    }
}
```

### Optional Overrides
```php
return $this->pdfExporter->stream(
    'reports.sample_pdf',
    $data,
    'sample-report.pdf',
    [
        'format' => 'A4',
        'directionality' => 'ltr',
    ]
);
```

## 3. Blade View Tips
- Build a plain HTML table with inline styles (mPDF supports standard CSS).
- Keep headings/LTR labels in English if desired; Arabic content inside table cells renders correctly thanks to Cairo font + `autoLangToFont`.
- Pass timestamps or metadata from the controller (`exportedAt`) for consistent footers/headers.

## 4. Adding Fonts
Place new TTF files in `public/fonts` and register them in `config/pdf.php` under `fonts`. Example:
```php
'fonts' => [
    'cairo' => [...],
    'amiri' => [ 'R' => 'Amiri-Regular.ttf', 'B' => 'Amiri-Bold.ttf' ],
]
```

## 5. Migrating Existing Exports
1. Move any custom mPDF logic out of controllers.
2. Inject `PdfExporter` and call `stream()`.
3. Remove pdfMake/jsPDF scripts or HTML test pages (already cleaned for employees module).

Following this guide keeps PDF exports uniform, ensures Arabic shaping works everywhere, and simplifies maintenance. Place any new report views under `resources/views/reports` (or module-specific folders) and reuse the same pattern.
