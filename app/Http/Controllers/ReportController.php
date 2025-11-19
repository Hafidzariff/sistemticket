<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Mail\ReportCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // 🟢 Form laporan untuk user
    public function create()
    {
        return view('reports.create');
    }

    // 🟢 Simpan laporan baru + kirim email notifikasi ke admin
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required',
            'departemen' => 'required',
            'jenis_masalah' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filename = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/laporan'), $filename);
        }

        $report = Report::create([
            'nama_pelapor' => $request->nama_pelapor,
            'departemen' => $request->departemen,
            'tanggal_laporan' => now(),
            'jenis_masalah' => $request->jenis_masalah,
            'deskripsi' => $request->deskripsi,
            'status' => 'Baru',
            'foto' => $filename,
        ]);

        Mail::to(env('ADMIN_EMAIL', 'admin@surabraja.co.id'))
            ->queue(new ReportCreatedMail($report));

        return redirect()->back()->with('success', '✅ Laporan berhasil dikirim dan notifikasi telah dikirim ke admin!');
    }

    // 🟢 Tampilkan daftar laporan + FILTER + SEARCH
    public function index(Request $request)
    {
        $query = Report::orderBy('created_at', 'desc');

        // 🔍 Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 🔍 Filter tanggal dari
        if ($request->filled('from')) {
            $query->whereDate('tanggal_laporan', '>=', $request->from);
        }

        // 🔍 Filter tanggal sampai
        if ($request->filled('to')) {
            $query->whereDate('tanggal_laporan', '<=', $request->to);
        }

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('nama_pelapor', 'LIKE', "%$keyword%")
                  ->orWhere('departemen', 'LIKE', "%$keyword%")
                  ->orWhere('jenis_masalah', 'LIKE', "%$keyword%")
                  ->orWhere('deskripsi', 'LIKE', "%$keyword%");
            });
        }

        $reports = $query->get();

        return view('reports.index', compact('reports'));
    }

    // 🟢 Update status laporan
    public function update(Request $request, Report $report)
    {
        $report->update([
            'status' => $request->status,
            'catatan_teknisi' => $request->catatan_teknisi,
            'tanggal_selesai' => $request->status === 'Selesai' ? now() : null,
        ]);

        return redirect()->route('reports.index')->with('success', '✅ Status laporan berhasil diperbarui.');
    }

    // 🟢 Hapus laporan
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', '🗑️ Laporan berhasil dihapus.');
    }

    // 🟢 Hapus semua laporan
    public function destroyAll()
    {
        Report::truncate();
        return redirect()->route('reports.index')->with('success', '🗑️ Semua laporan berhasil dihapus.');
    }

    // 🟢 Export laporan ke Excel + ikut filter
    public function export(Request $request)
    {
        return Excel::download(
            new ReportsExport(
                $request->from,
                $request->to,
                $request->status,
                $request->search
            ),
            'laporan_masuk.xlsx'
        );
    }

    // 🟢 Dashboard admin
    public function dashboard()
    {
        $total   = Report::count();
        $selesai = Report::where('status', 'Selesai')->count();
        $proses  = Report::where('status', 'Sedang Dikerjakan')->count();
        $baru    = Report::where('status', 'Baru')->count();

        $laporanBaru = Report::where('status', 'Baru')->latest()->take(3)->get();

        return view('reports.dashboard', compact('total', 'selesai', 'proses', 'baru', 'laporanBaru'));
    }
}
