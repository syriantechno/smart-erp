<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories Export</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; }
        th { background: #f3f4f6; font-weight: bold; }
    </style>
</head>
<body>
<h2>Categories</h2>
<p>Exported at: {{ $exportedAt }}</p>
<table>
    <thead>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Parent</th>
        <th>Description</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->code }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent?->name ?? 'Root' }}</td>
            <td>{{ $category->description }}</td>
            <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
