<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Seleksi {{ $namaBeasiswa }}</title>
    <style>
        /* ── Reset ──────────────────────────────────── */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.5;
        }

        /* ── Header ─────────────────────────────────── */
        .header {
            border-bottom: 3px solid #5b21b6;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .header-title h1 {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
        }
        .header-title p {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }
        .header-info {
            text-align: right;
            font-size: 10px;
            color: #6b7280;
            line-height: 1.7;
        }

        /* ── Judul Laporan ──────────────────────────── */
        .title-box {
            background: #ede9fe;
            border: 1px solid #c4b5fd;
            border-radius: 6px;
            text-align: center;
            padding: 10px;
            margin-bottom: 14px;
        }
        .title-box h2 {
            font-size: 13px;
            font-weight: bold;
            color: #4c1d95;
            text-transform: uppercase;
        }
        .title-box p {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }

        /* ── Ringkasan ──────────────────────────────── */
        .summary-table {
            width: 100%;
            margin-bottom: 14px;
            border-collapse: collapse;
        }
        .summary-table td {
            width: 25%;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            text-align: center;
            border-radius: 4px;
        }
        .summary-val { font-size: 18px; font-weight: bold; color: #5b21b6; display: block; }
        .summary-lbl { font-size: 9px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .summary-val.green { color: #065f46; }
        .summary-val.gray  { color: #6b7280; }

        /* ── Section Title ──────────────────────────── */
        .section-head {
            padding: 5px 10px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 6px;
            border-radius: 4px;
        }
        .section-head.lolos     { background: #059669; }
        .section-head.tdk-lolos { background: #6b7280; }

        /* ── Table ──────────────────────────────────── */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10.5px;
        }
        table.data thead th {
            background: #f3f4f6;
            padding: 6px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
            letter-spacing: 0.3px;
        }
        table.data thead th.center { text-align: center; }
        table.data tbody td {
            padding: 7px 8px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            vertical-align: middle;
        }
        table.data tbody td.center { text-align: center; }
        table.data tbody tr.lolos-row { background: #f0fdf4; }
        .vi-val { font-weight: bold; color: #5b21b6; }
        .rank   { font-weight: bold; text-align: center; }

        /* ── Tanda Tangan ───────────────────────────── */
        .ttd-section {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
        }
        .ttd-box {
            width: 45%;
            text-align: center;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px;
        }
        .ttd-box p { font-size: 10px; color: #374151; margin-bottom: 50px; }
        .ttd-line  { border-top: 1px solid #374151; padding-top: 4px; font-size: 10px; font-weight: bold; }

        /* ── Footer ────────────────────────────────── */
        .page-footer {
            margin-top: 16px;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- ── Header ───────────────────────────────────── --}}
    <div class="header">
        <div class="header-top">
            <div class="header-title">
                <h1>SPK Beasiswa — Sistem Pendukung Keputusan</h1>
                <p>Metode Simple Additive Weighting (SAW)</p>
            </div>
            <div class="header-info">
                <span>Dicetak: {{ now()->format('d F Y, H:i') }} WIB</span><br>
                @if($hasil->isNotEmpty())
                    <span>Tgl. Perhitungan: {{ $hasil->first()->dieksekusi_at?->format('d F Y') }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Judul Laporan ─────────────────────────────── --}}
    <div class="title-box">
        <h2>Laporan Hasil Seleksi {{ $namaBeasiswa }}</h2>
        <p>Tahun Akademik {{ $periodeAktif }}/{{ (int)$periodeAktif + 1 }} &nbsp;|&nbsp; Metode SAW</p>
    </div>

    {{-- ── Ringkasan ─────────────────────────────────── --}}
    <table class="summary-table">
        <tr>
            <td>
                <span class="summary-val">{{ $hasil->count() }}</span>
                <span class="summary-lbl">Total Diseleksi</span>
            </td>
            <td>
                <span class="summary-val green">{{ $hasil->where('lolos', true)->count() }}</span>
                <span class="summary-lbl">Penerima Beasiswa</span>
            </td>
            <td>
                <span class="summary-val gray">{{ $hasil->where('lolos', false)->count() }}</span>
                <span class="summary-lbl">Tidak Lolos</span>
            </td>
            <td>
                <span class="summary-val">{{ $kuota }}</span>
                <span class="summary-lbl">Kuota Beasiswa</span>
            </td>
        </tr>
    </table>

    {{-- ── Tabel Penerima Beasiswa ───────────────────── --}}
    <div class="section-head lolos">&#10003; Daftar Penerima Beasiswa</div>
    <table class="data">
        <thead>
            <tr>
                <th class="center" style="width:30px;">No.</th>
                <th class="center" style="width:40px;">Rank</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th class="center">Nilai Vi</th>
                <th class="center">Ket.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil->where('lolos', true) as $i => $h)
            <tr class="lolos-row">
                <td class="center" style="color:#9ca3af;">{{ $i + 1 }}</td>
                <td class="rank">#{{ $h->peringkat }}</td>
                <td><strong>{{ $h->pendaftar->nim }}</strong></td>
                <td>{{ $h->pendaftar->nama }}</td>
                <td style="color:#6b7280; font-size:10px;">{{ $h->pendaftar->program_studi }}</td>
                <td class="center vi-val">{{ number_format($h->nilai_preferensi, 4) }}</td>
                <td class="center" style="color:#065f46; font-weight:bold; font-size:10px;">LOLOS</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#9ca3af; padding:16px;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Tabel Tidak Lolos ────────────────────────── --}}
    @if($hasil->where('lolos', false)->isNotEmpty())
    <div class="section-head tdk-lolos">&#10007; Tidak Lolos Seleksi</div>
    <table class="data">
        <thead>
            <tr>
                <th class="center" style="width:30px;">No.</th>
                <th class="center" style="width:40px;">Rank</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th class="center">Nilai Vi</th>
                <th class="center">Ket.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil->where('lolos', false) as $i => $h)
            <tr>
                <td class="center" style="color:#9ca3af;">{{ $i + 1 }}</td>
                <td class="rank" style="color:#9ca3af;">#{{ $h->peringkat }}</td>
                <td style="color:#6b7280;">{{ $h->pendaftar->nim }}</td>
                <td style="color:#6b7280;">{{ $h->pendaftar->nama }}</td>
                <td style="color:#9ca3af; font-size:10px;">{{ $h->pendaftar->program_studi }}</td>
                <td class="center" style="color:#9ca3af;">{{ number_format($h->nilai_preferensi, 4) }}</td>
                <td class="center" style="color:#991b1b; font-weight:bold; font-size:10px;">TDK LOLOS</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── Tanda Tangan ─────────────────────────────── --}}
    <div class="ttd-section">
        <div class="ttd-box">
            <p>Mengetahui,<br><strong>Kepala Bagian Kemahasiswaan</strong></p>
            <div class="ttd-line">NIP. ____________________________</div>
        </div>
        <div class="ttd-box">
            <p>Ditetapkan pada tanggal<br><strong>{{ now()->format('d F Y') }}</strong></p>
            <div class="ttd-line">Admin SPK Beasiswa</div>
        </div>
    </div>

    <div class="page-footer">
        Dokumen ini digenerate otomatis oleh Sistem Pendukung Keputusan Beasiswa &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
