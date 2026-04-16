<!DOCTYPE html>
<html>
<head>
    <title>AI Logs PDF</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        .card { border: 1px solid #000; margin-bottom: 15px; padding: 10px; }
        .title { font-weight: bold; margin-bottom: 5px; }
    </style>
</head>
<body>

    <h2>AI Chat Logs Report</h2>
    <p>Date: {{ now()->format('d-m-Y') }}</p>

    @foreach($logs as $log)
        <div class="card">
            <div class="title">User: {{ $log->user->name ?? 'Guest' }}</div>
            <div><strong>Symptoms:</strong> {{ $log->symptoms_input }}</div>

            @php
                $aiData = json_decode($log->ai_response, true);
            @endphp

            @if(is_array($aiData))
                <div><strong>Analysis:</strong> {{ $aiData['analysis'] ?? 'N/A' }}</div>

                @if(!empty($aiData['recommendations']))
                    <div><strong>Recommendations:</strong></div>
                    <ul>
                        @foreach($aiData['recommendations'] as $rec)
                            <li>{{ $rec['medicine_name'] }} - {{ $rec['reason'] }}</li>
                        @endforeach
                    </ul>
                @endif
            @else
                <div>{{ $log->ai_response }}</div>
            @endif

            <div><strong>Date:</strong> {{ $log->created_at->format('d-m-Y H:i') }}</div>
        </div>
    @endforeach

</body>
</html>