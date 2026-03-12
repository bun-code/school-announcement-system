<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcements Export</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 24px;
        }
        h1 {
            font-size: 18px;
            margin: 0 0 6px 0;
        }
        .meta {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f3f4f6;
            font-weight: 700;
        }
        .nowrap { white-space: nowrap; }
    </style>
</head>
<body>
    <h1>Announcements Export</h1>
    <div class="meta">
        Generated at {{ now()->format('Y-m-d H:i') }} | Total: {{ $announcements->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="nowrap">ID</th>
                <th>Title</th>
                <th class="nowrap">Category</th>
                <th class="nowrap">Status</th>
                <th class="nowrap">Pinned</th>
                <th class="nowrap">Post Date</th>
                <th class="nowrap">Author</th>
            </tr>
        </thead>
        <tbody>
            @foreach($announcements as $ann)
                <tr>
                    <td class="nowrap">{{ $ann->id }}</td>
                    <td>{{ $ann->title }}</td>
                    <td class="nowrap">{{ $ann->category }}</td>
                    <td class="nowrap">{{ ucfirst($ann->status) }}</td>
                    <td class="nowrap">{{ $ann->is_pinned ? 'Yes' : 'No' }}</td>
                    <td class="nowrap">{{ optional($ann->post_date)->format('Y-m-d') }}</td>
                    <td class="nowrap">{{ $ann->author?->name ?? 'Admin' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
