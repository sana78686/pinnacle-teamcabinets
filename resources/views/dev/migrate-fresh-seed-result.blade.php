<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database setup</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 2rem; max-width: 900px; color: #1e293b; }
        h1 { font-size: 1.35rem; margin-bottom: 0.5rem; }
        .ok { color: #166534; }
        .fail { color: #991b1b; }
        .meta { color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem; }
        .step { border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1rem; overflow: hidden; }
        .step-head { background: #f8fafc; padding: 0.65rem 1rem; font-weight: 600; font-size: 0.9rem; }
        .step-cmd { padding: 0.35rem 1rem; font-size: 0.8rem; color: #475569; font-family: ui-monospace, monospace; }
        pre { margin: 0; padding: 0.75rem 1rem; background: #0f172a; color: #e2e8f0; font-size: 0.75rem; overflow-x: auto; white-space: pre-wrap; }
        ul.errors { background: #fef2f2; border: 1px solid #fecaca; padding: 0.75rem 1rem; border-radius: 8px; }
    </style>
</head>
<body>
    <h1 class="{{ $success ? 'ok' : 'fail' }}">
        {{ $success ? 'Database setup completed' : 'Database setup finished with errors' }}
    </h1>
    <p class="meta">Environment: <strong>{{ $appEnv }}</strong> · Tenants processed: <strong>{{ $tenantCount }}</strong></p>

    @if (!empty($errors))
        <ul class="errors">
            @foreach ($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @foreach ($log as $entry)
        <div class="step">
            <div class="step-head">{{ $entry['step'] }} @if($entry['exit_code'] !== 0)<span class="fail">(exit {{ $entry['exit_code'] }})</span>@endif</div>
            <div class="step-cmd">{{ $entry['command'] }}</div>
            <pre>{{ $entry['output'] }}</pre>
        </div>
    @endforeach
</body>
</html>
