<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - CargoTrace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f1f5f9; color: #1e293b; padding: 30px; }
        .container {
            max-width: 1100px; margin: auto; background: white; padding: 30px;
            border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
        .header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;
        }
        h1 { font-size: 24px; color: #0f172a; }
        .subtitle { color: #64748b; font-size: 14px; margin-top: 4px; }
        .btn {
            display: inline-block; padding: 10px 16px; border-radius: 8px;
            text-decoration: none; font-size: 13px; font-weight: bold;
        }
        .btn-back { background: #64748b; color: white; }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 14px; }
        th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th {
            background: #f8fafc; color: #475569; font-size: 12px;
            text-transform: uppercase; letter-spacing: 0.4px;
        }
        tr:hover { background: #f8fafc; }
        .badge {
            display: inline-block; padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: bold; background: #e0e7ff; color: #3730a3;
        }
        .empty-state {
            text-align: center; padding: 50px 20px; color: #64748b;
            background: #f8fafc; border-radius: 10px; border: 1px dashed #cbd5e1;
        }
        .pagination { margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h1>🛡️ Audit Logs Aktivitas Sistem</h1>
            <p class="subtitle">Rekam jejak perubahan data, akses pengguna, dan aktivitas operasional CargoTrace.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-back">← Dashboard</a>
    </div>

    @if($logs->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                        <th>Modul / Target</th>
                        <th>Keterangan</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td style="white-space: nowrap; color: #64748b;">
                                {{ $log->created_at ? $log->created_at->format('d-m-Y H:i:s') : '-' }}
                            </td>
                            <td>
                                <strong>{{ $log->user->name ?? 'System' }}</strong><br>
                                <small style="color:#64748b;">{{ $log->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <span class="badge">{{ strtoupper($log->action ?? $log->event ?? 'ACTIVITY') }}</span>
                            </td>
                            <td>
                                {{ class_basename($log->auditable_type ?? $log->model_type ?? '-') }}
                                @if($log->auditable_id ?? $log->model_id ?? null)
                                    #{{ $log->auditable_id ?? $log->model_id }}
                                @endif
                            </td>
                            <td>{{ $log->description ?? $log->details ?? '-' }}</td>
                            <td style="color: #64748b; font-size: 13px;">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $logs->links() }}
        </div>
    @else
        <div class="empty-state">
            <p style="font-size: 16px; font-weight: bold; color: #334155; margin-bottom: 6px;">Belum ada catatan audit log</p>
            <p style="font-size: 14px;">Setiap aktivitas penting di dalam sistem akan otomatis tercatat di halaman ini.</p>
        </div>
    @endif
</div>

</body>
</html>