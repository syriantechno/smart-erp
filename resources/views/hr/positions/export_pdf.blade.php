<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Positions Report</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: ltr;
            text-align: left;
            color: #1f2937;
            margin: 0;
            padding: 24px;
        }

        h1 {
            margin-bottom: 4px;
        }

        p {
            margin-top: 0;
            margin-bottom: 16px;
            color: #475569;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            direction: ltr;
        }

        th, td {
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #e2e8f0;
            font-size: 12px;
        }

        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #0f172a;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>
    <h1>Positions Report</h1>
    <p>Export date: {{ optional($exportedAt)->format('Y-m-d') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Title</th>
                <th>Department</th>
                <th>Salary Range</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($positions as $index => $position)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $position->code }}</td>
                    <td>{{ $position->title }}</td>
                    <td>{{ optional($position->department)->name ?: '-' }}</td>
                    <td>
                        @if(!is_null($position->salary_range_min) && !is_null($position->salary_range_max))
                            {{ number_format($position->salary_range_min, 2) }} - {{ number_format($position->salary_range_max, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $position->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
