<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan baris ini ada untuk memanggil DomPDF

class PdfController extends Controller
{
    /**
     * Poin a: Generate Sertifikat Format Landscape A4
     */
    public function generateSertifikat()
    {
        $data = [
            'nama' => auth()->user()->nama,
            'peran' => 'Peserta Workshop',
            'event' => 'Laravel PDF Masterclass',
            'tanggal' => date('d F Y')
        ];
        $pdf = Pdf::loadView('pdf.sertifikat', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('Sertifikat_Alisya.pdf');
    }

    public function generatePengumuman()
    {
        $data = [
            'nomor' => '556/B/DST/UN3.FV/TU.01.00/2026',
            'judul' => 'Undangan Silaturahmi Awal Tahun',
            'isi' => 'Silaturahmi Keluarga Besar Fakultas Ilmu Komputer',
            'tanggal' => date('d F Y')
        ];
        $pdf = Pdf::loadView('pdf.pengumuman', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('Surat_Undangan.pdf');
    }
}