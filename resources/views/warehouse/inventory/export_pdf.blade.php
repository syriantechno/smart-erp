<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Export</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background: #f3f3f3; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
<h2>Inventory Snapshot</h2>
<p>Exported at: {{ $exportedAt }}</p>
<p><strong>Total Inventory Value:</strong> {{ number_format($totalInventoryValue ?? 0, 2) }}</p>

<table>
    <thead>
    <tr>
        <th>Warehouse</th>
        <th>Material</th>
        <th>Unit</th>
        <th class="text-right">Quantity</th>
        <th class="text-right">Unit Price</th>
        <th class="text-right">Total Value</th>
    </tr>
    </thead>
    <tbody>
    @foreach($inventories as $inventory)
        @php
            $material = $inventory->material;
            $warehouse = $inventory->warehouse;
            $unit = $material?->unit;
            $unitLabel = '';
            if ($unit) {
                $name = $unit->name ?? null;
                $symbol = $unit->symbol ?? null;
                if ($name && $symbol) {
                    $unitLabel = $name . ' (' . $symbol . ')';
                } else {
                    $unitLabel = $name ?: ($symbol ?: '');
                }
            }
            $total = (float) $inventory->quantity * (float) $inventory->unit_price;
        @endphp
        <tr>
            <td>{{ $warehouse?->name ?? '' }}</td>
            <td>{{ $material?->name ?? '' }}</td>
            <td>{{ $unitLabel }}</td>
            <td class="text-right">{{ number_format($inventory->quantity, 4) }}</td>
            <td class="text-right">{{ number_format($inventory->unit_price, 2) }}</td>
            <td class="text-right">{{ number_format($total, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
