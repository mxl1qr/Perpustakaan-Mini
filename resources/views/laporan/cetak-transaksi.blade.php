<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Transaksi Peminjaman — {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 11px; color: #1e293b; background: #fff; }

        /* ── Screen Preview Styles ── */
        .page-wrapper { max-width: 960px; margin: 0 auto; padding: 32px 24px; }

        .print-header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #1e293b; padding-bottom: 16px; margin-bottom: 20px; }
        .print-header .logo-area { display: flex; align-items: center; gap: 12px; }
        .print-header .logo-box { width: 44px; height: 44px; background: #2563eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .print-header .logo-box span { color: white; font-weight: 900; font-size: 18px; }
        .print-header .org-name { font-size: 16px; font-weight: 800; color: #0f172a; line-height: 1.2; }
        .print-header .org-sub  { font-size: 10px; color: #64748b; margin-top: 2px; }
        .print-header .doc-info { text-align: right; }
        .print-header .doc-title { font-size: 14px; font-weight: 700; color: #1e40af; }
        .print-header .doc-date  { font-size: 10px; color: #94a3b8; margin-top: 3px; }

        /* Stats Bar */
        .stats-bar { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-bottom: 20px; }
        .stat-box { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; }
        .stat-box .stat-label { font-size: 9px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-box .stat-value { font-size: 22px; font-weight: 800; margin-top: 4px; }
        .stat-box.total    .stat-value { color: #1e293b; }
        .stat-box.dipinjam .stat-value { color: #2563eb; }
        .stat-box.kembali  .stat-value { color: #16a34a; }
        .stat-box.terlambat .stat-value { color: #dc2626; }
        .stat-box.denda    .stat-value { color: #d97706; font-size: 16px; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        thead tr { background: #1e293b; color: white; }
        thead th { padding: 9px 12px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:hover { background: #eff6ff; }
        tbody td { padding: 8px 12px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .buku-title { font-weight: 600; color: #0f172a; }
        .buku-penulis { font-size: 10px; color: #94a3b8; margin-top: 1px; }
        .anggota-nama { font-weight: 600; color: #1e293b; }
        .anggota-nis  { font-size: 10px; color: #94a3b8; margin-top: 1px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: 700; }
        .badge-dipinjam   { background: #dbeafe; color: #1d4ed8; }
        .badge-kembali    { background: #dcfce7; color: #166534; }
        .badge-terlambat  { background: #fee2e2; color: #991b1b; }
        .denda-amount { font-weight: 700; color: #dc2626; }
        .denda-nil    { color: #cbd5e1; }
        .tgl { color: #475569; white-space: nowrap; }
        .late-marker { color: #dc2626; font-size: 9px; font-weight: 700; }

        /* Action bar (screen only) */
        .action-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
        .btn-print { display: flex; align-items: center; gap: 8px; background: #2563eb; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-back  { display: flex; align-items: center; gap: 8px; background: white; color: #475569; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; }
        .btn-print:hover { background: #1d4ed8; }
        .btn-back:hover  { background: #f8fafc; }

        /* Footer */
        .print-footer { margin-top: 24px; padding-top: 12px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .print-footer p { font-size: 10px; color: #94a3b8; }

        /* Print Styles */
        @media print {
            .action-bar { display: none !important; }
            .page-wrapper { padding: 0; max-width: 100%; }
            body { font-size: 10px; }
            thead tr { background: #1e293b !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            tbody tr:nth-child(even) { background: #f8fafc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .badge { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <!-- Action Bar (hanya muncul di layar) -->
    <div class="action-bar">
        <a href="{{ route('laporan.index') }}" class="btn-back">
            ← Kembali
        </a>
        <button class="btn-print" onclick="window.print()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Save as PDF
        </button>
        <a href="{{ route('laporan.cetak-denda') }}" target="_blank" class="btn-back">
            Cetak Rekap Denda →
        </a>
    </div>

    <!-- Header Dokumen -->
    <div class="print-header">
        <div class="logo-area">
            <div class="logo-box"><span>F</span></div>
            <div>
                <div class="org-name">{{ config('app.name', 'Forty Libs') }}</div>
                <div class="org-sub">SMKN 40 Jakarta — Sistem Perpustakaan Digital</div>
            </div>
        </div>
        <div class="doc-info">
            <div class="doc-title">Rekap Transaksi Peminjaman</div>
            <div class="doc-date">Dicetak: {{ now()->isoFormat('dddd, D MMMM YYYY') }} pukul {{ now()->format('H:i') }} WIB</div>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-box total">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-box dipinjam">
            <div class="stat-label">Sedang Dipinjam</div>
            <div class="stat-value">{{ $stats['dipinjam'] }}</div>
        </div>
        <div class="stat-box kembali">
            <div class="stat-label">Dikembalikan</div>
            <div class="stat-value">{{ $stats['dikembalikan'] }}</div>
        </div>
        <div class="stat-box terlambat">
            <div class="stat-label">Terlambat</div>
            <div class="stat-value">{{ $stats['terlambat'] }}</div>
        </div>
        <div class="stat-box denda">
            <div class="stat-label">Total Denda</div>
            <div class="stat-value">Rp{{ number_format($stats['total_denda'], 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <table>
        <thead>
            <tr>
                <th style="width:32px">#</th>
                <th>Buku</th>
                <th>Anggota</th>
                <th>Tgl. Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tgl. Kembali</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $i => $p)
                @php
                    $isLate = $p->status === 'dipinjam' && \Carbon\Carbon::parse($p->tgl_kembali_rencana)->isPast();
                @endphp
                <tr>
                    <td style="color:#94a3b8;text-align:center;">{{ $i + 1 }}</td>
                    <td>
                        <div class="buku-title">{{ $p->buku->judul ?? 'Buku Dihapus' }}</div>
                        <div class="buku-penulis">{{ $p->buku->penulis ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="anggota-nama">{{ $p->anggota->nama ?? 'Anggota Dihapus' }}</div>
                        <div class="anggota-nis">NIS: {{ $p->anggota->nis ?? '-' }}</div>
                    </td>
                    <td class="tgl">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td class="tgl">
                        {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d/m/Y') }}
                        @if($isLate)<br><span class="late-marker">⚠ Terlambat {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->diffInDays(now()) }}h</span>@endif
                    </td>
                    <td class="tgl">
                        {{ $p->tgl_kembali_aktual ? \Carbon\Carbon::parse($p->tgl_kembali_aktual)->format('d/m/Y') : '—' }}
                    </td>
                    <td>
                        @if($p->denda > 0)
                            <span class="denda-amount">Rp{{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="denda-nil">—</span>
                        @endif
                    </td>
                    <td>
                        @if($isLate)
                            <span class="badge badge-terlambat">Terlambat</span>
                        @elseif($p->status === 'dipinjam')
                            <span class="badge badge-dipinjam">Dipinjam</span>
                        @else
                            <span class="badge badge-kembali">Kembali</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;padding:24px;color:#94a3b8;">Belum ada data transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="print-footer">
        <p>{{ config('app.name') }} — SMKN 40 Jakarta &copy; {{ date('Y') }}</p>
        <p>Dokumen ini digenerate secara otomatis oleh sistem. Total: <strong>{{ $stats['total'] }} transaksi</strong></p>
    </div>
</div>
</body>
</html>
