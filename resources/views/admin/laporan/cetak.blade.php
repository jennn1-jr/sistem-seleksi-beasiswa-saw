<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Seleksi Beasiswa — SPK Beasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #1f2937;
            background: #fff;
            padding: 32px;
        }

        /* ── Header ─────────────────────────────────── */
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 3px solid #7c3aed;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: #fff;
        }
        .logo-text h1 { font-size: 16px; font-weight: 700; color: #1f2937; }
        .logo-text p  { font-size: 11px; color: #6b7280; margin-top: 2px; }
        .header-info { text-align: right; }
        .header-info p { font-size: 11px; color: #6b7280; line-height: 1.8; }

        /* ── Kop Surat / Judul ─────────────────────── */
        .title-section {
            text-align: center;
            margin-bottom: 24px;
            padding: 16px;
            background: linear-gradient(135deg, #ede9fe, #f5f3ff);
            border-radius: 10px;
            border: 1px solid #c4b5fd;
        }
        .title-section h2 { font-size: 18px; font-weight: 800; color: #5b21b6; }
        .title-section p  { font-size: 12px; color: #6b7280; margin-top: 4px; }

        /* ── Ringkasan ─────────────────────────────── */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .summary-card {
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
        }
        .summary-value { font-size: 22px; font-weight: 800; color: #7c3aed; }
        .summary-label { font-size: 10px; color: #6b7280; margin-top: 2px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ── Section Title ─────────────────────────── */
        .section-title {
            font-size: 12px; font-weight: 700;
            color: #fff; padding: 7px 14px;
            border-radius: 6px; margin-bottom: 8px;
            display: inline-block;
        }
        .section-title.lolos    { background: #10b981; }
        .section-title.tdk-lolos { background: #6b7280; }

        /* ── Table ─────────────────────────────────── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 11.5px;
        }
        thead th {
            background: #f3f4f6;
            padding: 7px 10px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 2px solid #e5e7eb;
        }
        thead th.center { text-align: center; }
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        tbody td.center { text-align: center; }
        tbody tr.lolos-row { background: #f0fdf4; }
        .nilai-vi { font-weight: 700; color: #7c3aed; }
        .peringkat { font-weight: 800; font-size: 13px; text-align: center; }

        /* ── Footer ────────────────────────────────── */
        .footer {
            margin-top: 32px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .ttd-box {
            text-align: center;
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        .ttd-box p { font-size: 11px; color: #374151; margin-bottom: 60px; }
        .ttd-line { border-top: 1px solid #374151; padding-top: 6px; font-size: 11px; font-weight: 600; }

        /* ── Tombol Print (tidak tampil saat cetak) ── */
        .print-btn {
            position: fixed; bottom: 24px; right: 24px;
            background: #7c3aed; color: #fff;
            border: none; border-radius: 10px;
            padding: 12px 20px; font-size: 13px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; gap: 8px;
            font-family: inherit;
            box-shadow: 0 4px 12px rgba(124,58,237,0.4);
        }
        .print-btn:hover { background: #5b21b6; }

        @media print {
            .print-btn { display: none !important; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>

    {{-- ── Header ───────────────────────────────────────── --}}
    <div class="header">
        <div class="header-logo">
            <div class="logo-icon">🎓</div>
            <div class="logo-text">
                <h1>SPK Beasiswa PPA</h1>
                <p>Sistem Pendukung Keputusan — Metode SAW</p>
            </div>
        </div>
        <div class="header-info">
            <p>Dicetak oleh: <strong>{{ Auth::user()->name }}</strong></p>
            <p>Tanggal cetak: <strong>{{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</strong></p>
            @if($hasil->isNotEmpty())
                <p>Tgl. perhitungan: <strong>{{ $hasil->first()->dieksekusi_at?->format('d F Y') }}</strong></p>
            @endif
        </div>
    </div>

    {{-- ── Judul ─────────────────────────────────────────── --}}
    <div class="title-section">
        <h2>LAPORAN HASIL SELEKSI {{ strtoupper($namaBeasiswa) }}</h2>
        <p>Periode Tahun Akademik {{ $periodeAktif }}/{{ (int)$periodeAktif + 1 }} &nbsp;|&nbsp; Metode Simple Additive Weighting (SAW)</p>
    </div>

    {{-- ── Ringkasan ─────────────────────────────────────── --}}
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-value">{{ $hasil->count() }}</div>
            <div class="summary-label">Total Diseleksi</div>
        </div>
        <div class="summary-card">
            <div class="summary-value" style="color: #10b981;">{{ $hasil->where('lolos', true)->count() }}</div>
            <div class="summary-label">Penerima Beasiswa</div>
        </div>
        <div class="summary-card">
            <div class="summary-value" style="color: #6b7280;">{{ $hasil->where('lolos', false)->count() }}</div>
            <div class="summary-label">Tidak Lolos</div>
        </div>
        <div class="summary-card">
            <div class="summary-value">{{ $kuota }}</div>
            <div class="summary-label">Kuota Beasiswa</div>
        </div>
    </div>

    {{-- ── Tabel Penerima Beasiswa ───────────────────────── --}}
    <div class="section-title lolos">✓ Daftar Penerima Beasiswa</div>
    <table>
        <thead>
            <tr>
                <th class="center" style="width:40px;">No.</th>
                <th class="center" style="width:50px;">Rank</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th class="center">Nilai Vi</th>
                <th class="center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil->where('lolos', true) as $i => $h)
            <tr class="lolos-row">
                <td class="center" style="color:#9ca3af;">{{ $i + 1 }}</td>
                <td class="peringkat">
                    @if($h->peringkat == 1) 🥇
                    @elseif($h->peringkat == 2) 🥈
                    @elseif($h->peringkat == 3) 🥉
                    @else #{{ $h->peringkat }}
                    @endif
                </td>
                <td><strong>{{ $h->pendaftar->nim }}</strong></td>
                <td>{{ $h->pendaftar->nama }}</td>
                <td style="color:#6b7280;">{{ $h->pendaftar->program_studi }}</td>
                <td class="center nilai-vi">{{ number_format($h->nilai_preferensi, 4) }}</td>
                <td class="center" style="color:#065f46; font-weight:600;">✓ LOLOS</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#9ca3af; padding:20px;">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Tabel Tidak Lolos ────────────────────────────── --}}
    @if($hasil->where('lolos', false)->isNotEmpty())
    <div class="section-title tdk-lolos">✗ Daftar Tidak Lolos Seleksi</div>
    <table>
        <thead>
            <tr>
                <th class="center" style="width:40px;">No.</th>
                <th class="center" style="width:50px;">Rank</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th class="center">Nilai Vi</th>
                <th class="center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil->where('lolos', false) as $i => $h)
            <tr>
                <td class="center" style="color:#9ca3af;">{{ $i + 1 }}</td>
                <td class="center" style="color:#9ca3af; font-weight:700;">#{{ $h->peringkat }}</td>
                <td style="color:#6b7280;">{{ $h->pendaftar->nim }}</td>
                <td style="color:#6b7280;">{{ $h->pendaftar->nama }}</td>
                <td style="color:#9ca3af;">{{ $h->pendaftar->program_studi }}</td>
                <td class="center" style="color:#9ca3af; font-weight:600;">{{ number_format($h->nilai_preferensi, 4) }}</td>
                <td class="center" style="color:#991b1b; font-weight:600;">✗ Tidak Lolos</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── Tanda Tangan ─────────────────────────────────── --}}
    <div class="footer">
        <div class="ttd-box">
            <p>Mengetahui,<br><strong>Kepala Bagian Kemahasiswaan</strong></p>
            <div class="ttd-line">NIP. ____________________________</div>
        </div>
        <div class="ttd-box">
            <p>Ditetapkan di ________________<br>Pada tanggal <strong>{{ now()->format('d F Y') }}</strong></p>
            <div class="ttd-line">Admin SPK Beasiswa</div>
        </div>
    </div>

    {{-- ── Tombol Print ─────────────────────────────────── --}}
    <button class="print-btn" onclick="window.print()">
        🖨️ Cetak Halaman Ini
    </button>

</body>
</html>
