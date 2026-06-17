<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $announcement->title }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8fafc;
            font-family: Arial, sans-serif;
            color: #111827;
        }

        .excel-wrapper {
            width: 100%;
            height: 100vh;
            overflow: auto;
            background: #f8fafc;
        }

        .excel-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #111827;
            color: white;
            padding: 12px 16px;
            font-weight: 600;
            font-size: 15px;
        }

        .excel-content {
            padding: 14px;
        }

        table {
            border-collapse: collapse;
            width: max-content;
            min-width: 100%;
            background: white;
            font-size: 13px;
        }

        td,
        th {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            min-width: 90px;
            white-space: nowrap;
        }

        tr:first-child td {
            font-weight: 700;
            background: #f3f4f6;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        td:empty {
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="excel-wrapper">
        <div class="excel-header">
            {{ $announcement->title }}
        </div>

        <div class="excel-content">
            <table>
                @foreach ($rows as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>