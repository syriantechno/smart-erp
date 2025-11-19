<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Employees Report</title>
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
    <h1>Employees Report</h1>
    <p>Export date: {{ now()->format('Y-m-d') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employee->code }}</td>
                <td>{{ $employee->full_name }}</td>
                <td>{{ $employee->department->name ?? '-' }}</td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->is_active ? 'Active' : 'Inactive' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
