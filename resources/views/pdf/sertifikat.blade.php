<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 0; } /* Menghilangkan margin otomatis agar tidak 2 halaman */
        body { margin: 0; padding: 0; font-family: 'Helvetica', sans-serif; background-color: #fff; }
        
        .certificate-page {
            width: 297mm; height: 210mm; /* Standar A4 Landscape */
            position: relative; overflow: hidden;
        }

        /* Ornamen Biru (Meniru SERTIFIKAT INISSS.jpg) */
        .shape-top-left { position: absolute; top: -50px; left: -50px; width: 250px; height: 250px; background: #003399; transform: rotate(45deg); }
        .shape-top-right { position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: #0055ff; transform: rotate(45deg); }
        .shape-bottom-left { position: absolute; bottom: -80px; left: -80px; width: 200px; height: 200px; background: #0055ff; transform: rotate(45deg); }
        .shape-bottom-right { position: absolute; bottom: -50px; right: -50px; width: 250px; height: 250px; background: #003399; transform: rotate(45deg); }

        .content {
            position: relative; z-index: 10; text-align: center; padding: 40mm 20mm;
        }

        .title { font-size: 54pt; font-weight: bold; color: #333; margin-bottom: 0; }
        .subtitle { font-size: 20pt; font-weight: bold; text-transform: uppercase; letter-spacing: 5px; margin-top: 0; }
        .given-to { font-size: 16pt; margin: 30px 0 10px 0; }
        .name { font-size: 40pt; font-family: 'Times New Roman', serif; font-style: italic; border-bottom: 2px solid #333; display: inline-block; padding: 0 50px; }
        .reason { font-size: 14pt; margin-top: 30px; line-height: 1.6; }

        .footer { position: absolute; bottom: 30mm; width: 100%; }
        .footer table { width: 100%; text-align: center; }
        .sig-name { font-weight: bold; text-decoration: underline; margin-top: 60px; display: block; }
    </style>
</head>
<body>
    <div class="certificate-page">
        <div class="shape-top-left"></div>
        <div class="shape-top-right"></div>
        <div class="shape-bottom-left"></div>
        <div class="shape-bottom-right"></div>

        <div class="content">
            <div class="title">SERTIFIKAT</div>
            <div class="subtitle">PENGHARGAAN</div>
            
            <p class="given-to">Diberikan kepada Kelompok:</p>
            <div class="name">{{ $nama }}</div>

            <p class="reason">
                Sebagai <strong>{{ $peran }}</strong><br>
                Dalam rangka kegiatan <strong>{{ $event }}</strong> yang diselenggarakan oleh<br>
                Himpunan Mahasiswa Teknik Informatika (HIMTI) pada tanggal {{ $tanggal }}
            </p>
        </div>

        <br>

        <div class="footer">
            <table>
                <tr>
                    <td width="50%">
                        Ketua Himpunan Mahasiswa,<br><br><br><br>
                        <span class="sig-name">MUHAMMAD ZAKY IRLY</span>
                    </td>
                    <td width="50%">
                        Ketua Pelaksana,<br><br><br><br>
                        <span class="sig-name">ANDHIKA MUHAMMAD IQBAL</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>