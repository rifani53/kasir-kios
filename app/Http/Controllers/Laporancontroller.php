<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Spatie\Dropbox\Client;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\DropboxTokenProvider;

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
        $tokenProvider = new DropboxTokenProvider();
        return $tokenProvider->getToken();
    }

    // Menampilkan laporan transaksi berdasarkan filter tanggal
    public function index(Request $request)
{
    $startDate = Carbon::parse($request->get('start_date', now()->startOfMonth()))->startOfDay();
    $endDate = Carbon::parse($request->get('end_date', now()->endOfMonth()))->endOfDay();

    $details = TransactionDetail::whereBetween('created_at', [$startDate, $endDate])
        ->with(['transaction', 'product', 'pengguna']) // Tambahkan relasi 'pengguna' untuk memuat data kasir
        ->get();

    $totalIncome = $details->sum(function ($detail) {
        return $detail->quantity * ($detail->product->harga ?? 0);
    });
    try {
        $files = $this->client->listFolder('/Laporan')['entries'];
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal mendapatkan daftar file dari Dropbox: ' . $e->getMessage()]);
    }


    return view('pages.laporan.index', [
        'details' => $details,
        'startDate' => $startDate->format('Y-m-d'),
        'endDate' => $endDate->format('Y-m-d'),
        'totalIncome' => $totalIncome,
        'files' => $files
    ]);
}


    // Mengekspor laporan dan mengunggahnya ke Dropbox
    public function export(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $fileName = "laporan_transaksi_{$startDate}_to_{$endDate}.xlsx";
        $dropboxPath = "/Laporan/{$fileName}";

        try {
            // Generate Excel File
            $excelFile = Excel::raw(new TransactionExport($startDate, $endDate), \Maatwebsite\Excel\Excel::XLSX);

            // Upload ke Dropbox
            $this->client->upload($dropboxPath, $excelFile, 'add'); // Mode 'add'

            return redirect()->route('pages.laporan.index')
                ->with('status', "Laporan berhasil diekspor ke Dropbox: '{$fileName}'.");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengunggah file ke Dropbox: ' . $e->getMessage()]);
        }
    }

    // Menampilkan daftar file dari Dropbox


    // Mengunduh file dari Dropbox
    public function downloadDropboxFile($fileName)
    {
        $dropboxPath = "/Laporan/{$fileName}";

        try {
            // Unduh file dari Dropbox
            $response = $this->client->download($dropboxPath);
            $fileContent = stream_get_contents($response);

            return response($fileContent)
                ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengunduh file dari Dropbox: ' . $e->getMessage()]);
        }
    }

    // Membuat folder baru di Dropbox
    public function createFolder($folderName)
    {
        $dropboxPath = "/{$folderName}";

        try {
            $this->client->createFolder($dropboxPath);
            return back()->with('status', "Folder '{$folderName}' berhasil dibuat di Dropbox.");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membuat folder di Dropbox: ' . $e->getMessage()]);
        }
    }

    // Mendapatkan tautan sementara file
    public function getTemporaryLink($fileName)
{
    $dropboxPath = "/Laporan/{$fileName}";

    try {
        $link = $this->client->getTemporaryLink($dropboxPath);

        return response()->json([
            'file' => $fileName,
            'temporary_link' => $link,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Gagal mendapatkan link sementara dari Dropbox.',
            'message' => $e->getMessage(),
        ], 500);
    }
}


    // Menghapus file dari Dropbox
    public function deleteDropboxFile($fileName)
    {
        $dropboxPath = "/Laporan/{$fileName}";

        try {
            $this->client->delete($dropboxPath);
            return back()->with('status', "File '{$fileName}' berhasil dihapus dari Dropbox.");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus file dari Dropbox: ' . $e->getMessage()]);
        }
    }
}
