<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation - {{ $evaluation->employee->full_name ?? 'Employee' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #1e293b;
            background: white;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #1e293b;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header p {
            font-size: 11px;
            color: #64748b;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label, .info-value {
            display: table-cell;
            padding: 5px 10px;
            border: 1px solid #e2e8f0;
        }
        .info-label {
            background: #f8fafc;
            font-weight: bold;
            width: 35%;
        }
        .overall-rating {
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .overall-rating .score {
            font-size: 48px;
            font-weight: bold;
        }
        .overall-rating .score.excellent { color: #16a34a; }
        .overall-rating .score.good { color: #d97706; }
        .overall-rating .score.low { color: #dc2626; }
        .overall-rating .label {
            font-size: 14px;
            margin-top: 5px;
        }
        .stars {
            margin: 10px 0;
            font-size: 18px;
        }
        .star-filled { color: #fbbf24; }
        .star-empty { color: #e2e8f0; }
        .criteria-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .criteria-table th,
        .criteria-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            text-align: left;
        }
        .criteria-table th {
            background: #1e293b;
            color: white;
            font-weight: bold;
        }
        .criteria-table tr:nth-child(even) {
            background: #f8fafc;
        }
        .score-cell {
            text-align: center;
            font-weight: bold;
        }
        .score-excellent { color: #16a34a; }
        .score-good { color: #d97706; }
        .score-low { color: #dc2626; }
        .progress-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
        }
        .progress-excellent { background: #16a34a; }
        .progress-good { background: #d97706; }
        .progress-low { background: #dc2626; }
        .comments-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 15px;
            margin-top: 10px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 15px;
            border: 1px solid #e2e8f0;
        }
        .summary-item.excellent { background: #dcfce7; }
        .summary-item.good { background: #fef3c7; }
        .summary-item.low { background: #fee2e2; }
        .summary-number {
            font-size: 24px;
            font-weight: bold;
        }
        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }
        .signature-grid {
            display: table;
            width: 100%;
            margin-top: 40px;
        }
        .signature-box {
            display: table-cell;
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #1e293b;
            margin-top: 40px;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <h1>Employee Performance Evaluation</h1>
            <p>{{ config('app.name') }} | Generated on {{ now()->format('F d, Y') }}</p>
        </div>

        {{-- Employee Information --}}
        <div class="section">
            <div class="section-title">Employee Information</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Employee Name</div>
                    <div class="info-value">{{ $evaluation->employee->full_name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Employee ID</div>
                    <div class="info-value">{{ $evaluation->employee->employee_number ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Department</div>
                    <div class="info-value">{{ $evaluation->employee->department->name ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Position</div>
                    <div class="info-value">{{ $evaluation->employee->position ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Evaluation Date</div>
                    <div class="info-value">{{ $evaluation->evaluated_at ? $evaluation->evaluated_at->format('F d, Y') : '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Evaluated By</div>
                    <div class="info-value">{{ $evaluation->evaluator->name ?? 'System' }}</div>
                </div>
            </div>
        </div>

        {{-- Overall Rating --}}
        <div class="overall-rating">
            @php
                $ratingClass = $evaluation->overall_rating >= 8 ? 'excellent' : ($evaluation->overall_rating >= 5 ? 'good' : 'low');
                $ratingLabel = $evaluation->overall_rating >= 8 ? 'Excellent Performance' : ($evaluation->overall_rating >= 5 ? 'Good Performance' : 'Needs Improvement');
            @endphp
            <div class="score {{ $ratingClass }}">{{ $evaluation->overall_rating }}/10</div>
            <div class="stars">
                @for($i = 1; $i <= 10; $i++)
                    <span class="{{ $i <= $evaluation->overall_rating ? 'star-filled' : 'star-empty' }}">★</span>
                @endfor
            </div>
            <div class="label">{{ $ratingLabel }}</div>
        </div>

        {{-- Criteria Details --}}
        @if($evaluation->items->count() > 0)
            <div class="section">
                <div class="section-title">Evaluation Criteria</div>
                <table class="criteria-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 40%;">Criterion</th>
                            <th style="width: 15%;">Score</th>
                            <th style="width: 40%;">Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluation->items as $index => $item)
                            @php
                                $scoreClass = $item->score >= 8 ? 'excellent' : ($item->score >= 5 ? 'good' : 'low');
                            @endphp
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $item->criterion->name ?? 'Unknown' }}</td>
                                <td class="score-cell score-{{ $scoreClass }}">{{ $item->score }}/10</td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-fill progress-{{ $scoreClass }}" style="width: {{ $item->score * 10 }}%;"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Performance Summary --}}
            <div class="section">
                <div class="section-title">Performance Summary</div>
                <div class="summary-grid">
                    <div class="summary-item excellent">
                        <div class="summary-number" style="color: #16a34a;">{{ $evaluation->items->where('score', '>=', 8)->count() }}</div>
                        <div class="summary-label">Excellent (8-10)</div>
                    </div>
                    <div class="summary-item good">
                        <div class="summary-number" style="color: #d97706;">{{ $evaluation->items->whereBetween('score', [5, 7])->count() }}</div>
                        <div class="summary-label">Good (5-7)</div>
                    </div>
                    <div class="summary-item low">
                        <div class="summary-number" style="color: #dc2626;">{{ $evaluation->items->where('score', '<', 5)->count() }}</div>
                        <div class="summary-label">Needs Work (1-4)</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Comments --}}
        @if($evaluation->comments)
            <div class="section">
                <div class="section-title">Comments & Remarks</div>
                <div class="comments-box">
                    {{ $evaluation->comments }}
                </div>
            </div>
        @endif

        {{-- Signatures --}}
        <div class="footer">
            <div class="signature-grid">
                <div class="signature-box">
                    <div class="signature-line">
                        <strong>Evaluator Signature</strong><br>
                        <small>{{ $evaluation->evaluator->name ?? 'N/A' }}</small>
                    </div>
                </div>
                <div class="signature-box" style="width: 10%;"></div>
                <div class="signature-box">
                    <div class="signature-line">
                        <strong>Employee Signature</strong><br>
                        <small>{{ $evaluation->employee->full_name ?? 'N/A' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
