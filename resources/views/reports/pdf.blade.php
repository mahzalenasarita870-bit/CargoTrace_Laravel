<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengiriman CargoTrace</title>

    <style>
        @page {
            margin: 24px 28px;
        }

        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #102A43;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }

        /* ================= HEADER / KOP LAPORAN ================= */
        .header-banner {
            background-color: #132A46;
            color: #ffffff;
            padding: 20px 24px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .brand-tag {
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #7FB3D5;
            margin-bottom: 4px;
        }

        .doc-title {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            margin: 0 0 4px 0;
            letter-spacing: 0.3px;
        }

        .doc-subtitle {
            font-size: 10.5px;
            color: #CBD5E1;
            margin: 0;
        }

        .doc-meta {
            text-align: right;
            font-size: 9.5px;
            color: #E2E8F0;
            line-height: 1.6;
        }

        .doc-meta strong {
            color: #ffffff;
        }

        /* ================= FILTER INFO STRIP ================= */
        .meta-bar {
            background-color: #F0F6FC;
            border: 1px solid #CBDCEB;
            border-left: 4px solid #2B6CB0;
            border-radius: 6px;
            padding: 9px 14px;
            margin-bottom: 16px;
            font-size: 10px;
            color: #334E68;
        }

        .meta-bar strong {
            color: #132A46;
        }

        /* ================= KPI SUMMARY CARDS ================= */
        .kpi-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin: 0 -10px 18px -10px;
        }

        .kpi-box {
            background-color: #F8FAFC;
            border: 1px solid #D9E2EC;
            border-top: 3px solid #2B6CB0;
            border-radius: 6px;
            padding: 10px 12px;
            width: 25%;
            vertical-align: top;
        }

        .kpi-box.k-transit   { border-top-color: #D97706; }
        .kpi-box.k-delivered { border-top-color: #1D7A68; }
        .kpi-box.k-weight    { border-top-color: #132A46; }

        .kpi-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #627D98;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .kpi-value {
            font-size: 16px;
            font-weight: bold;
            color: #102A43;
        }

        .kpi-sub {
            font-size: 8.5px;
            color: #829AB1;
            margin-top: 2px;
        }

        /* ================= DATA TABLE ================= */
        .section-heading {
            font-size: 12px;
            font-weight: bold;
            color: #132A46;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1.5px solid #D9E2EC;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .data-table th {
            background-color: #1E3A5F;
            color: #ffffff;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 9px 10px;
            text-align: left;
            border: 1px solid #1E3A5F;
        }

        .data-table td {
            padding: 8.5px 10px;
            border: 1px solid #D9E2EC;
            font-size: 10px;
            color: #102A43;
            vertical-align: middle;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #F8FAFC;
        }

        .shp-num {
            font-weight: bold;
            color: #132A46;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #E2E8F0;
            color: #334E68;
        }

        .badge-delivered  { background-color: #D1FAE5; color: #065F46; }
        .badge-in_transit { background-color: #FEF3C7; color: #92400E; }
        .badge-at_port    { background-color: #E0E7FF; color: #3730A3; }
        .badge-created    { background-color: #DBEAFE; color: #1E40AF; }
        .badge-delayed    { background-color: #FEE2E2; color: #991B1B; }

        /* ================= SIGNATURE & FOOTER ================= */
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 28px;
        }

        .sign-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .sign-note {
            font-size: 9px;
            color: #627D98;
            line-height: 1.5;
        }

        .sign-box {
            text-align: center;
            width: 210px;
            font-size: 10px;
            color: #102A43;
        }

        .sign-line {
            margin-top: 48px;
            border-top: 1px solid #334E68;
            padding-top: 4px;
            font-weight: bold;
        }

        .doc-footer {
            margin-top: 22px;
            padding-top: 8px;
            border-top: 1px solid #D9E2EC;
            font-size: 8.5px;
            color: #829AB1;
            text-align: center;
        }
    </style>
</head>
<body>

    @php
        $inTransitCount = $shipments->where('current_status', 'IN_TRANSIT')->count();
        $deliveredCount = $shipments->where('current_status', 'DELIVERED')->count();
        $totalWeight    = $shipments->sum('weight');
    @endphp

    <!-- Kop Laporan Resmi -->
    <div class="header-banner">
        <table class="header-table">
            <tr>
                <td style="width: 65%;">
                    <div class="brand-tag">CARGOTRACE • MARITIME SUPPLY VISIBILITY</div>
                    <h2 class="doc-title">LAPORAN PENGIRIMAN CARGOTRACE</h2>
                    <p class="doc-subtitle">Rekapitulasi Manifest Logistik, Status Pelayaran, dan Pelacakan Kargo</p>
                </td>
                <td style="width: 35%;" class="doc-meta">
                    <div><strong>No. Dokumen:</strong> RPT-{{ now()->format('Ymd-Hi') }}</div>
                    <div><strong>Tanggal Cetak:</strong> {{ now()->format('d-m-Y H:i') }} WIB</div>
                    <div><strong>Dicetak Oleh:</strong> {{ auth()->user()->name ?? 'System Administrator' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Bar Informasi Filter -->
    <div class="meta-bar">
        <strong>Parameter Laporan:</strong>
        Status = <strong>{{ request('status') ?: 'Semua Status' }}</strong>
        &nbsp;|&nbsp;
        Periode = <strong>{{ request('start_date') ?: 'Awal' }}</strong> s/d <strong>{{ request('end_date') ?: 'Sekarang' }}</strong>
    </div>

    <!-- 4 Kartu Ringkasan KPI -->
    <table class="kpi-table">
        <tr>
            <td class="kpi-box">
                <div class="kpi-label">Total Pengiriman</div>
                <div class="kpi-value">{{ $totalShipments }}</div>
                <div class="kpi-sub">Manifest terdaftar</div>
            </td>
            <td class="kpi-box k-transit">
                <div class="kpi-label">In Transit</div>
                <div class="kpi-value" style="color: #B45309;">{{ $inTransitCount }}</div>
                <div class="kpi-sub">Dalam pelayaran</div>
            </td>
            <td class="kpi-box k-delivered">
                <div class="kpi-label">Delivered</div>
                <div class="kpi-value" style="color: #1D7A68;">{{ $deliveredCount }}</div>
                <div class="kpi-sub">Tiba di tujuan</div>
            </td>
            <td class="kpi-box k-weight">
                <div class="kpi-label">Total Tonase Kargo</div>
                <div class="kpi-value">{{ number_format($totalWeight, 2) }} kg</div>
                <div class="kpi-sub">Akumulasi berat</div>
            </td>
        </tr>
    </table>

    <!-- Tabel Rekapitulasi Pengiriman -->
    <div class="section-heading">Rincian Data Pengiriman</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 18%;">No. Pengiriman</th>
                <th style="width: 24%;">Pelanggan</th>
                <th style="width: 19%;">Kurir / Carrier</th>
                <th style="width: 18%;">Status</th>
                <th style="width: 16%;">Tanggal Dibuat</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($shipments as $shipment)
                @php
                    $stLower = strtolower($shipment->current_status ?? 'created');
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td class="shp-num">{{ $shipment->shipment_number }}</td>
                    <td>{{ $shipment->customer->name ?? '-' }}</td>
                    <td>{{ $shipment->carrier->name ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $stLower }}">
                            {{ str_replace('_', ' ', $shipment->current_status) }}
                        </span>
                    </td>
                    <td>{{ $shipment->created_at?->format('d-m-Y') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 18px; color: #627D98;">
                        Tidak ada data pengiriman pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pengesahan / Tanda Tangan -->
    <table class="sign-table">
        <tr>
            <td class="sign-note" style="width: 65%;">
                <strong>Catatan Sistem:</strong><br>
                Dokumen ini dihasilkan secara otomatis oleh sistem <em>CargoTrace Maritime Supply Visibility</em> dan sah digunakan sebagai rekapitulasi operasional logistik.
            </td>
            <td style="width: 35%;" align="right">
                <div class="sign-box">
                    <div>Mengetahui,</div>
                    <div>Koordinator Operasional Logistik</div>
                    <div class="sign-line">{{ auth()->user()->name ?? 'CargoTrace Admin' }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="doc-footer">
        CargoTrace Logistics &amp; Shipment Tracking System • Dicetak pada {{ now()->format('d/m/Y H:i:s') }}
    </div>

</body>
</html>