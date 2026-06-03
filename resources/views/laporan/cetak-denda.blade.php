<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Denda — {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
        .page-wrapper { max-width: 900px; margin: 0 auto; padding: 32px 24px; }

        .print-header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #dc2626; padding-bottom: 16px; margin-bottom: 20px; }
        .logo-box { width: 44px; height: 44px; background: #dc2626; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-box span { color: white; font-weight: 900; font-size: 18px; }
        .org-name { font-size: 16px; font-weight: 800; color: #0f172a; }
        .org-sub  { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-title { font-size: 14px; font-weight: 700; color: #dc2626; text-align: right; }
        .doc-date  { font-size: 10px; color: #94a3b8; margin-top: 3px; text-align: right; }

        /* Summary */
        .summary-box { background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; }
        .summary-box .label { font-size: 11px; font-weight: 700; color: #7f1d1d; text-transform: uppercase; letter-spacing: 0.05em; }
        .summary-box .amount { font-size: 28px; font-weight: 900; color: #dc2626; }
        .summary-box .count  { font-size: 11px; color: #991b1b; margin-top: 2px; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        thead tr { background: #7f1d1d; color: white; }
        thead th { padding: 9px 12px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
        tbody tr:nth-child(even) { background: #fef2f2; }
        tbody td { padding: 8px 12px; border-bottom: 1px solid #fee2e2; vertical-align: top; }
        .buku-title  { font-weight: 600; color: #0f172a; }
        .buku-penulis{ font-size: 10px; color: #94a3b8; margin-top: 1px; }
        .anggota-nama{ font-weight: 600; color: #1e293b; }
        .anggota-nis { font-size: 10px; color: #94a3b8; margin-top: 1px; }
        .denda-amount{ font-weight: 800; color: #dc2626; font-size: 13px; }
        .tgl { color: #475569; white-space: nowrap; }
        .badge-status { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: 700; }
        .badge-dipinjam  { background: #dbeafe; color: #1d4ed8; }
        .badge-kembali   { background: #dcfce7; color: #166534; }
        .badge-terlambat { background: #fee2e2; color: #991b1b; }

        /* Action Bar */
        .action-bar { display: flex; gap: 12px; margin-bottom: 24px; }
        .btn-print { display: flex; align-items: center; gap: 8px; background: #dc2626; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-back  { display: flex; align-items: center; gap: 8px; background: white; color: #475569; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; }
        .logo-area { display: flex; align-items: center; gap: 12px; }

        .print-footer { margin-top: 20px; padding-top: 12px; border-top: 1px solid #fee2e2; display: flex; justify-content: space-between; }
        .print-footer p { font-size: 10px; color: #94a3b8; }

        @media print {
            .action-bar { display: none !important; }
            .page-wrapper { padding: 0; }
            thead tr { background: #7f1d1d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .summary-box { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            tbody tr:nth-child(even) { background: #fef2f2 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="action-bar">
        <a href="{{ route('laporan.index') }}" class="btn-back">← Kembali ke Laporan</a>
        <button class="btn-print" onclick="window.print()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Save as PDF
        </button>
    </div>

    <!-- Header -->
    <div class="print-header">
        <div class="logo-area">
            <div class="logo-box"><span>F</span></div>
            <div>
                <div class="org-name">{{ config('app.name', 'Forty Libs') }}</div>
                <div class="org-sub">SMKN 40 Jakarta — Sistem Perpustakaan Digital</div>
            </div>
        </div>
        <div>
            <div class="doc-title">Rekap Denda Peminjaman</div>
            <div class="doc-date">Dicetak: {{ now()->isoFormat('dddd, D MMMM YYYY') }} pukul {{ now()->format('H:i') }} WIB</div>
        </div>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <div>
            <div class="label">Total Denda Terkumpul</div>
            <div class="count">dari {{ $dendaList->count() }} transaksi yang memiliki denda</div>
        </div>
        <div class="amount">Rp{{ number_format($totalDenda, 0, ',', '.') }}</div>
    </div>

    <!-- Tabel Denda -->
    <table>
        <thead>
            <tr>
                <th style="width:28px">#</th>
                <th>Buku</th>
                <th>Anggota</th>
                <th>Tgl. Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tgl. Kembali</th>
                <th>Jumlah Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dendaList as $i => $d)
                <tr>
                    <td style="color:#94a3b8;text-align:center;">{{ $i + 1 }}</td>
                    <td>
                        <div class="buku-title">{{ $d->buku->judul ?? 'Buku Dihapus' }}</div>
                        <div class="buku-penulis">{{ $d->buku->penulis ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="anggota-nama">{{ $d->anggota->nama ?? 'Anggota Dihapus' }}</div>
                        <div class="anggota-nis">NIS: {{ $d->anggota->nis ?? '-' }}</div>
                    </td>
                    <td class="tgl">{{ \Carbon\Carbon::parse($d->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td class="tgl">{{ \Carbon\Carbon::parse($d->tgl_kembali_rencana)->format('d/m/Y') }}</td>
                    <td class="tgl">{{ $d->tgl_kembali_aktual ? \Carbon\Carbon::parse($d->tgl_kembali_aktual)->format('d/m/Y') : '— Belum' }}</td>
                    <td><span class="denda-amount">Rp{{ number_format($d->denda, 0, ',', '.') }}</span></td>
                    <td>
                        @if($d->status === 'dipinjam')
                            <span class="badge-status badge-terlambat">Belum Lunas</span>
                        @else
                            <span class="badge-status badge-kembali">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;padding:24px;color:#94a3b8;">Tidak ada denda tercatat.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="print-footer">
        <p>{{ config('app.name') }} &copy; {{ date('Y') }}</p>
        <p>Total: <strong>Rp{{ number_format($totalDenda, 0, ',', '.') }}</strong> dari <strong>{{ $dendaList->count() }} catatan</strong></p>
    </div>
</div>
</body>
</html>
