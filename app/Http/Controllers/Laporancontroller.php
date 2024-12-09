<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Dropbox\Client;
use App\Models\TransactionDetail;
use App\Exports\TransactionExport;
use App\Services\DropboxTokenProvider; // Tambahkan jika kelas ini berada di folder Services

class Laporancontroller extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client($this->getValidAccessToken());
    }

    /**
     * Mendapatkan token akses yang valid.
     */
    private function getValidAccessToken()
    {
        // Menggunakan DropboxTokenProvider untuk mengelola token
        $tokenProvider = new DropboxTokenProvider();
        return $tokenProvider->getToken();
    }

    // Menampilkan laporan dengan filter tanggal
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        $transactions = TransactionDetail::with('product')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalIncome = $transactions->sum('total_price');

        return view('pages.laporan.index', compact('transactions', 'totalIncome', 'startDate', 'endDate'));
    }

    // Mengekspor laporan ke Dropbox
    public function export(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $fileName = "laporan_transaksi_{$startDate}_to_{$endDate}.xlsx";
        $dropboxPath = "/LaporanKiosAnis/Laporan/{$fileName}";

        $excelFile = Excel::raw(new TransactionExport($startDate, $endDate), \Maatwebsite\Excel\Excel::XLSX);

        try {
            $this->client->upload($dropboxPath, $excelFile);
            return redirect()->route('pages.laporan.index')
                ->with('status', "Laporan berhasil diekspor ke Dropbox sebagai '{$fileName}'.");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengunggah file ke Dropbox: ' . $e->getMessage()]);
        }
    }

    // Menampilkan daftar file di Dropbox
    public function showDropboxFiles()
    {
        try {
            $files = $this->client->listFolder('/LaporanKiosAnis/Laporan')['entries'];
            return view('pages.dropbox.dropbox_files', compact('files'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mendapatkan daftar file dari Dropbox: ' . $e->getMessage()]);
        }
    }

    // Mengunduh file dari Dropbox
    public function downloadDropboxFile($fileName)
{
    $dropboxPath = "/LaporanKiosAnis/Laporan/{$fileName}";

    try {
        // Unduh file dari Dropbox
        $response = $this->client->download($dropboxPath);

// Jika response adalah resource
    $fileContent = stream_get_contents($response);

    return response($fileContent)
    ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal mengunduh file dari Dropbox: ' . $e->getMessage()]);
    }
}


    // Membuat folder di Dropbox
    public function createFolder($path)
    {
        try {
            $this->client->createFolder($path);
            return back()->with('status', 'Folder berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat folder di Dropbox: ' . $e->getMessage()]);
        }
    }

    // Mendapatkan tautan sementara untuk file
    public function getTemporaryLink($filePath)
    {
        try {
            // Dapatkan tautan sementara untuk file
            $link = $this->client->getTemporaryLink("/LaporanKiosAnis/Laporan/{$filePath}");

            return response()->json([
                'file' => $filePath,
                'temporary_link' => $link,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mendapatkan link sementara dari Dropbox: ' . $e->getMessage()]);
        }
    }

    // Menghapus file dari Dropbox
    public function deleteDropboxFile($fileName)
    {
        $dropboxPath = "/LaporanKiosAnis/Laporan/{$fileName}";

        try {
            // Hapus file dari Dropbox
            $this->client->delete($dropboxPath);
            return back()->with('status', "File '{$fileName}' berhasil dihapus dari Dropbox.");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus file dari Dropbox: ' . $e->getMessage()]);
        }
    }
}
