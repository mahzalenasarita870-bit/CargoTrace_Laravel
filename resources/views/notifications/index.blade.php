<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - CargoTrace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f1f5f9; color: #1e293b; padding: 30px; }
        .container {
            max-width: 900px; margin: auto; background: white; padding: 30px;
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
            text-decoration: none; border: none; cursor: pointer;
            font-size: 13px; font-weight: bold;
        }
        .btn-back { background: #64748b; color: white; }
        .btn-read { background: #2563eb; color: white; padding: 7px 12px; font-size: 12px; }
        .notif-list { display: flex; flex-direction: column; gap: 12px; }
        .notif-card {
            display: flex; justify-content: space-between; align-items: center;
            gap: 16px; padding: 16px 18px; border-radius: 10px;
            border: 1px solid #e2e8f0; background: #f8fafc;
        }
        .notif-card.unread {
            background: #eff6ff; border-color: #bfdbfe; border-left: 4px solid #2563eb;
        }
        .notif-title { font-weight: bold; font-size: 15px; color: #0f172a; margin-bottom: 4px; }
        .notif-body { font-size: 14px; color: #334155; line-height: 1.4; }
        .notif-meta { font-size: 12px; color: #64748b; margin-top: 6px; }
        .badge-read {
            background: #dcfce7; color: #15803d; padding: 5px 10px;
            border-radius: 20px; font-size: 11px; font-weight: bold; white-space: nowrap;
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
            <h1>🔔 Notifikasi Operasional</h1>
            <p class="subtitle">Pemberitahuan keterlambatan, perubahan status, dan kendala pengiriman.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-back">← Dashboard</a>
    </div>

    @if($notifications->count() > 0)
        <div class="notif-list">
            @foreach($notifications as $notif)
                <div class="notif-card {{ is_null($notif->read_at) ? 'unread' : '' }}">
                    <div>
                        <div class="notif-title">
                            {{ $notif->title ?? str_replace('_', ' ', $notif->type ?? 'Notifikasi Pengiriman') }}
                        </div>
                        <div class="notif-body">
                            {{ $notif->message ?? $notif->body ?? '-' }}
                        </div>
                        <div class="notif-meta">
                            {{ $notif->created_at ? $notif->created_at->format('d-m-Y H:i') : '' }}
                            @if($notif->shipment_id)
                                • <a href="{{ route('shipments.show', $notif->shipment_id) }}" style="color:#2563eb; text-decoration:none; font-weight:bold;">Lihat Shipment →</a>
                            @endif
                        </div>
                    </div>

                    <div>
                        @if(is_null($notif->read_at))
                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-read">✓ Tandai Dibaca</button>
                            </form>
                        @else
                            <span class="badge-read">✓ Dibaca</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="empty-state">
            <p style="font-size: 16px; font-weight: bold; color: #334155; margin-bottom: 6px;">Belum ada notifikasi</p>
            <p style="font-size: 14px;">Semua aktivitas pengiriman Anda berjalan normal tanpa peringatan baru.</p>
        </div>
    @endif
</div>

</body>
</html>