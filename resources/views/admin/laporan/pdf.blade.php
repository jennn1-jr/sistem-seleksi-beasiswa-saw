<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Hasil Seleksi {{ $namaBeasiswa }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.5;
        }

        /* ── Header layout via table ──────────────── */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #5b21b6;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header-table td { vertical-align: top; }
        .header-left h1  { font-size: 13px; font-weight: bold; color: #1f2937; }
        .header-left p   { font-size: 10px; color: #6b7280; margin-top: 2px; }
        .header-right    { text-align: right; font-size: 10px; color: #6b7280; line-height: 1.7; }

        /* ── Judul ────────────────────────────────── */
        .title-box {
            background: #ede9fe;
            border: 1px solid #c4b5fd;
            text-align: center;
            padding: 10px;
            margin-bottom: 14px;
        }
        .title-box h2 {
            font-size: 12px;
            font-weight: bold;
            color: #4c1d95;
            text-transform: uppercase;
        }
        .title-box p { font-size: 10px; color: #6b7280; margin-top: 3px; }

        /* ── Ringkasan ────────────────────────────── */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .summary-table td {
            width: 25%;
            padding: 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }
        .s-val       { font-size: 20px; font-weight: bold; color: #5b21b6; display: block; }
        .s-val.green { color: #065f46; }
        .s-val.gray  { color: #6b7280; }
        .s-lbl       { font-size: 9px; color: #6b7280; text-transform: uppercase; }

        /* ── Section Head ─────────────────────────── */
        .section-head {
            padding: 5px 10px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 6px;
        }
        .section-head.lolos     { background: #059669; }
        .section-head.tdk-lolos { background: #6b7280; }

        /* ── Data Table ───────────────────────────── */
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
        }
        table.data thead th.c { text-align: center; }
        table.data tbody td {
            padding: 7px 8px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            vertical-align: middle;
        }
        table.data tbody td.c { text-align: center; }
        table.data tbody tr.lolos-row { background: #f0fdf4; }
        .vi-val { font-weight: bold; color: #5b21b6; }

        /* ── TTD: layout via table ────────────────── */
        .ttd-table { width: 100%; margin-top: 24px; }
        .ttd-box {
            width: 45%;
            text-align: center;
            border: 1px solid #e5e7eb;
            padding: 10px;
        }
        .ttd-space { height: 50px; }
        .ttd-line  { border-top: 1px solid #374151; padding-top: 4px; font-size: 10px; font-weight: bold; }
        .ttd-sub   { font-size: 10px; color: #374151; }

        /* ── Footer ───────────────────────────────── */
        .footer {
            margin-top: 14px;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- ── Header ─────────────────────────────────── --}}
    <table class="header-table">
        <tr>
            <td style="width:52px; vertical-align:middle; padding-right:10px;">
                @if(!empty($logoPdf))
                    <img src="{{ $logoPdf }}" alt="Logo"
                         style="width:48px; height:48px; object-fit:contain;">
                @endif
            </td>
            <td class="header-left">
                <h1>SPK Beasiswa - Sistem Pendukung Keputusan</h1>
                <p>Metode Simple Additive Weighting (SAW)</p>
            </td>
            <td class="header-right">
                Dicetak: {{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB<br>
                @if($hasil->isNotEmpty())
                    Tgl. Perhitungan: {{ $hasil->first()->dieksekusi_at?->format('d F Y') }}
                @endif
            </td>
        </tr>
    </table>

    {{-- ── Judul ───────────────────────────────────── --}}
    <div class="title-box">
        <h2>Laporan Hasil Seleksi {{ $namaBeasiswa }}</h2>
        <p>Tahun Akademik {{ $periodeAktif }}/{{ (int)$periodeAktif + 1 }} | Metode SAW</p>
    </div>

    {{-- ── Ringkasan ───────────────────────────────── --}}
    <table class="summary-table">
        <tr>
            <td><span class="s-val">{{ $hasil->count() }}</span><span class="s-lbl">Total Diseleksi</span></td>
            <td><span class="s-val green">{{ $hasil->where('lolos', true)->count() }}</span><span class="s-lbl">Penerima Beasiswa</span></td>
            <td><span class="s-val gray">{{ $hasil->where('lolos', false)->count() }}</span><span class="s-lbl">Tidak Lolos</span></td>
            <td><span class="s-val">{{ $kuota }}</span><span class="s-lbl">Kuota Beasiswa</span></td>
        </tr>
    </table>

    {{-- ── Tabel Penerima ──────────────────────────── --}}
    <div class="section-head lolos">DAFTAR PENERIMA BEASISWA</div>
    <table class="data">
        <thead>
            <tr>
                <th class="c" style="width:28px;">No.</th>
                <th class="c" style="width:38px;">Rank</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th class="c">Nilai Vi</th>
                <th class="c">Ket.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil->where('lolos', true) as $i => $h)
            <tr class="lolos-row">
                <td class="c" style="color:#9ca3af;">{{ $i + 1 }}</td>
                <td class="c" style="font-weight:bold;">#{{ $h->peringkat }}</td>
                <td><strong>{{ $h->pendaftar->nim }}</strong></td>
                <td>{{ $h->pendaftar->nama }}</td>
                <td style="color:#6b7280; font-size:10px;">{{ $h->pendaftar->program_studi }}</td>
                <td class="c vi-val">{{ number_format($h->nilai_preferensi, 4) }}</td>
                <td class="c" style="color:#065f46; font-weight:bold; font-size:10px;">LOLOS</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#9ca3af; padding:16px;">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Tabel Tidak Lolos ───────────────────────── --}}
    @if($hasil->where('lolos', false)->isNotEmpty())
    <div class="section-head tdk-lolos">TIDAK LOLOS SELEKSI</div>
    <table class="data">
        <thead>
            <tr>
                <th class="c" style="width:28px;">No.</th>
                <th class="c" style="width:38px;">Rank</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th class="c">Nilai Vi</th>
                <th class="c">Ket.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil->where('lolos', false) as $i => $h)
            <tr>
                <td class="c" style="color:#9ca3af;">{{ $i + 1 }}</td>
                <td class="c" style="color:#9ca3af;">#{{ $h->peringkat }}</td>
                <td style="color:#6b7280;">{{ $h->pendaftar->nim }}</td>
                <td style="color:#6b7280;">{{ $h->pendaftar->nama }}</td>
                <td style="color:#9ca3af; font-size:10px;">{{ $h->pendaftar->program_studi }}</td>
                <td class="c" style="color:#9ca3af;">{{ number_format($h->nilai_preferensi, 4) }}</td>
                <td class="c" style="color:#991b1b; font-weight:bold; font-size:10px;">TDK LOLOS</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- ── Tanda Tangan ────────────────────────────── --}}
    <table class="ttd-table">
        <tr>
            <td class="ttd-box" style="width:45%;">
                <div class="ttd-sub">Mengetahui,<br><strong>Kepala Bagian Kemahasiswaan</strong></div>
                <div class="ttd-space"></div>
                <div class="ttd-line">NIP. ____________________________</div>
            </td>
            <td style="width:10%;"></td>
            <td class="ttd-box" style="width:45%;">
                <div class="ttd-sub">Ditetapkan,<br><strong>{{ now()->timezone('Asia/Jakarta')->format('d F Y') }}</strong></div>
                <div class="ttd-space"></div>
                <div class="ttd-line">Admin SPK Beasiswa</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen digenerate otomatis oleh Sistem Pendukung Keputusan Beasiswa &mdash;
        {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
    </div>

</body>
</html>
