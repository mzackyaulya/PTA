<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $announcement->title }}</title>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #e5e7eb;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        .pdf-wrapper {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .pdf-header {
            height: 55px;
            background: #111827;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .pdf-title {
            font-size: 16px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pdf-content {
            flex: 1;
            background: #f3f4f6;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="pdf-wrapper">
        <div class="pdf-header">
            <div class="pdf-title">
                {{ $announcement->title }}
            </div>
        </div>

        <div class="pdf-content">
            <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}"></iframe>
        </div>
    </div>
</body>
</html>