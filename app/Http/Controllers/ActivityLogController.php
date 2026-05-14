<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $filter_aksi = $request->input('filter_aksi', 'semua');
        
        $query = ActivityLog::with('user');

        if ($q) {
            $query->where(function($b) use ($q) {
                $b->where('deskripsi', 'like', "%$q%")
                  ->orWhere('modul', 'like', "%$q%")
                  ->orWhere('ip_address', 'like', "%$q%")
                  ->orWhereHas('user', function($u) use ($q) {
                      $u->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%");
                  });
            });
        }

        if ($filter_aksi && $filter_aksi !== 'semua') {
            $query->where('aksi', $filter_aksi);
        }

        // Handle Export CSV
        if ($request->has('export')) {
            $logs = $query->latest()->get();
            return $this->exportCsv($logs);
        }

        $logs = $query->latest()->paginate(15)->withQueryString();
        return view('activity_log.index', compact('logs', 'q', 'filter_aksi'));
    }

    private function exportCsv($logs)
    {
        $fileName = 'activity_log_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['Waktu', 'Pengguna', 'Email', 'Aksi', 'Modul', 'Tabel', 'ID Target', 'IP Address', 'User Agent', 'Deskripsi'];

        $callback = function() use($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user ? $log->user->name : 'Sistem / Guest',
                    $log->user ? $log->user->email : '-',
                    $log->aksi,
                    $log->modul,
                    $log->tabel_target,
                    $log->id_target,
                    $log->ip_address,
                    $log->user_agent,
                    $log->deskripsi
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}