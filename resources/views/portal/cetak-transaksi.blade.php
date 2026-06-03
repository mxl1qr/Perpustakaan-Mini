<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi — {{ $user->name }}</title>
    <style>
        @page { size: A4; margin: 20mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #334155; line-height: 1.5; }
        
        .container { width: 100%; max-width: 800px; margin: 0 auto; }
        
        /* Header Table */
        .header-table { width: 100%; border-bottom: 2px solid #2563eb; margin-bottom: 25px; }
        .header-table td { padding-bottom: 15px; vertical-align: bottom; }
        .org-name { font-size: 18px; font-weight: bold; color: #1e293b; }
        .org-sub { font-size: 10px; color: #64748b; }
        .doc-title { text-align: right; font-size: 14px; font-weight: bold; color: #2563eb; }
        .doc-date { text-align: right; font-size: 9px; color: #94a3b8; }

        /* Info Boxes Table */
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 0; }
        .info-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; }
        .info-label { font-size: 9px; font-weight: bold; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
        .info-value { font-size: 12px; font-weight: bold; color: #1e293b; }

        /* Summary Table */
        .summary-table { width: 100%; margin-bottom: 25px; table-layout: fixed; }
        .summary-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; text-align: center; }
        .s-label { font-size: 8px; font-weight: bold; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px; }
        .s-value { font-size: 18px; font-weight: 800; color: #1e293b; }
        .s-denda { color: #dc2626; }

        /* Data Table */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th { background: #1e40af; color: #ffffff; padding: 8px 10px; font-size: 9px; font-weight: bold; text-align: left; text-transform: uppercase; border: 1px solid #1e40af; }
        .data-table td { padding: 8px 10px; border: 1px solid #e2e8f0; vertical-align: top; }
        .data-table tr:nth-child(even) { background: #f8fafc; }
        
        .buku-judul { font-weight: bold; color: #1e293b; font-size: 10px; }
        .buku-info { font-size: 9px; color: #64748b; }
        
        .status-badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .status-dipinjam { background: #dbeafe; color: #1e40af; }
        .status-kembali { background: #dcfce7; color: #15803d; }
        .status-terlambat { background: #fee2e2; color: #b91c1c; }

        .footer { border-top: 1px solid #e2e8f0; padding-top: 10px; font-size: 9px; color: #94a3b8; }
        .footer-right { text-align: right; }

        .btn-container { margin-bottom: 20px; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 12px; cursor: pointer; border: none; }
        .btn-print { background: #2563eb; color: #ffffff; }
        .btn-back { background: #ffffff; color: #64748b; border: 1px solid #e2e8f0; margin-right: 10px; }

        @media print {
            .btn-container { display: none; }
            body { background: #ffffff; }
            .container { max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Action Bar -->
        <div class="btn-container">
            <a href="{{ route('anggota.transaksi') }}" class="btn btn-back">← Kembali</a>
            <button class="btn btn-print" onclick="window.print()">Cetak / Save as PDF</button>
        </div>

        <!-- Header -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="org-name">{{ config('app.name', 'Forty Libs') }}</div>
                    <div class="org-sub">SMKN 40 Jakarta — Sistem Perpustakaan Digital</div>
                </td>
                <td>
                    <div class="doc-title">RIWAYAT TRANSAKSI PEMINJAMAN</div>
                    <div class="doc-date">Dicetak pada: {{ now()->isoFormat('D MMMM YYYY, HH:mm') }}</div>
                </td>
            </tr>
        </table>

        <!-- Member Info -->
        <table class="info-table">
            <tr>
                <td width="50%" style="padding-right: 10px;">
                    <div class="info-card">
                        <div class="info-label">Nama Anggota</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                </td>
                <td width="50%" style="padding-left: 10px;">
                    <div class="info-card">
                        <div class="info-label">NIS / NISN</div>
                        <div class="info-value">{{ $user->nisn ?? ($anggota->nis ?? '—') }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 10px;">
                    <div class="info-card">
                        <div class="info-label">Email & Kelas</div>
                        <div class="info-value">{{ $user->email }} &mdash; {{ $anggota->kelas ?? '—' }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Summary -->
        <table class="summary-table">
            <tr>
                <td style="padding-right: 8px;">
                    <div class="summary-box">
                        <div class="s-label">Total Transaksi</div>
                        <div class="s-value">{{ $riwayat->count() }}</div>
                    </div>
                </td>
                <td style="padding: 0 4px;">
                    <div class="summary-box">
                        <div class="s-label">Sedang Dipinjam</div>
                        <div class="s-value">{{ $riwayat->where('status','dipinjam')->count() }}</div>
                    </div>
                </td>
                <td style="padding: 0 4px;">
                    <div class="summary-box">
                        <div class="s-label">Selesai / Kembali</div>
                        <div class="s-value">{{ $riwayat->whereIn('status', ['dikembalikan', 'terlambat'])->count() }}</div>
                    </div>
                </td>
                <td style="padding-left: 8px;">
                    <div class="summary-box">
                        <div class="s-label">Total Denda</div>
                        <div class="s-value s-denda">Rp{{ number_format($totalDenda, 0, ',', '.') }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Data Table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th width="30">#</th>
                    <th>Informasi Buku</th>
                    <th width="80">Tgl Pinjam</th>
                    <th width="80">Batas Kembali</th>
                    <th width="80">Tgl Kembali</th>
                    <th width="90">Denda</th>
                    <th width="80">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $i => $p)
                    @php 
                        $isLateActive = $p->status === 'dipinjam' && \Carbon\Carbon::parse($p->tgl_kembali_rencana)->isPast();
                        $dendaValue = $p->denda;
                        if ($isLateActive) {
                            $dendaValue = \Carbon\Carbon::parse($p->tgl_kembali_rencana)->diffInDays(now()) * 1000;
                        }
                    @endphp
                    <tr>
                        <td align="center">{{ $i + 1 }}</td>
                        <td>
                            <div class="buku-judul">{{ $p->buku->judul ?? 'Buku Dihapus' }}</div>
                            <div class="buku-info">{{ $p->buku->penulis ?? '-' }}</div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td style="{{ $isLateActive ? 'color:#dc2626;font-weight:bold;' : '' }}">
                            {{ \Carbon\Carbon::parse($p->tgl_kembali_rencana)->format('d/m/Y') }}
                        </td>
                        <td>{{ $p->tgl_kembali_aktual ? \Carbon\Carbon::parse($p->tgl_kembali_aktual)->format('d/m/Y') : '—' }}</td>
                        <td align="right">
                            @if($dendaValue > 0)
                                <strong style="color:#dc2626;">Rp{{ number_format($dendaValue, 0, ',', '.') }}</strong>
                            @else
                                <span style="color:#cbd5e1;">Rp0</span>
                            @endif
                        </td>
                        <td>
                            @if($isLateActive)
                                <span class="status-badge status-terlambat">Terlambat</span>
                            @elseif($p->status === 'dipinjam')
                                <span class="status-badge status-dipinjam">Dipinjam</span>
                            @elseif($p->status === 'terlambat')
                                <span class="status-badge status-terlambat">Kembali Late</span>
                            @else
                                <span class="status-badge status-kembali">Kembali</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" align="center" style="padding: 30px; color: #94a3b8;">Belum ada data transaksi peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <table width="100%" class="footer">
            <tr>
                <td>{{ config('app.name') }} &copy; {{ date('Y') }} &mdash; Dokumen sah dihasilkan sistem.</td>
                <td class="footer-right">Dicetak oleh: <strong>{{ $user->name }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
