<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 1cm 1.5cm; font-size: 12pt; line-height: 1.3; }
        .header { text-align: center; margin-bottom: 5px; }
        .header h2 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .header h3 { margin: 0; font-size: 14pt; }
        .header p { margin: 0; font-size: 9pt; }
        hr { border: 0; border-top: 2px solid black; margin-top: 10px; }
        
        .meta-table { width: 100%; margin-top: 20px; }
        .date { text-align: right; }
        
        .recipient { margin-top: 30px; }
        .content { margin-top: 20px; text-align: justify; }
        
        .signature { margin-top: 50px; float: right; text-align: center; width: 300px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <h2>UNIVERSITAS KOLEKSI BUKU</h2>
        <h3>FAKULTAS ILMU KOMPUTER</h3>
        <p>Kampus Alam Sutera, Jl. Jalur Sutera Barat No. 9, Tangerang 15143</p>
        <p>Laman: https://koleksibuku.ac.id, e-mail: info@koleksibuku.ac.id</p>
    </div>
    <hr>

    <table class="meta-table">
        <tr>
            <td width="15%">Nomor</td>
            <td width="45%">: {{ $nomor }}</td>
            <td class="date">{{ $tanggal }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>: Satu Lembar</td>
            <td></td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>: {{ $judul }}</td>
            <td></td>
        </tr>
    </table>

    <div class="recipient">
        Yth.<br>
        1. Para Wakil Dekan<br>
        2. Seluruh Mahasiswa HIMTI<br>
        Fakultas Ilmu Komputer
    </div>

    <div class="content">
        <p>Dalam rangka mempererat tali silaturahmi serta mengawali kegiatan tahun 2026, Fakultas Ilmu Komputer akan menyelenggarakan kegiatan <strong>{{ $judul }}</strong>. Sehubungan dengan hal tersebut, kami mengundang Saudara/i untuk hadir pada kegiatan yang akan dilaksanakan pada:</p>
        
        <table style="margin-left: 20px;">
            <tr><td>Hari, Tanggal</td><td>: Selasa, 24 Februari 2026</td></tr>
            <tr><td>Waktu</td><td>: 10.00 – 13.00 WIB</td></tr>
            <tr><td>Tempat</td><td>: Aula Lantai 3, Kampus Alam Sutera</td></tr>
        </table>

        <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Saudara/i, kami ucapkan terima kasih.</p>
    </div>

    <div class="signature">
        Dekan,<br>
        <br><br><br>
        <strong>Prof. Dian Yulie Reindrawati, Ph.D</strong><br>
        NIP. 197607071999032001
    </div>
</body>
</html>