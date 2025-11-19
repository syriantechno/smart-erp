<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Departments Report</title>
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
    <h1>Departments Report</h1>
    <p>Export date: {{ optional($exportedAt)->format('Y-m-d') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Name</th>
                <th>Company</th>
                <th>Manager</th>
                <th>Employees</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $department->code }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->company->name ?? '-' }}</td>
                <td>{{ $department->manager->full_name ?? '-' }}</td>
                <td>{{ $department->employees_count ?? 0 }}</td>
                <td>{{ $department->is_active ? 'Active' : 'Inactive' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
