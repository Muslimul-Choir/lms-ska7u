<?php

namespace App\Http\Middleware;

use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Kuis;
use App\Services\AttendanceGatewayService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceGateMiddleware
{
    protected $attendanceService;

    public function __construct(AttendanceGatewayService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Handle an incoming request.
     * NEW LOGIC: Check attendance per pertemuan, not per content
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Only apply to students
        if (!$user || !$user->siswa) {
            return $next($request);
        }

        $siswa = $user->siswa;

        // Extract content type and ID from route
        $tipeKonten = $this->getContentTypeFromRoute($request);
        $idKonten = $this->getContentIdFromRoute($request);

        if (!$tipeKonten || !$idKonten) {
            return $next($request); // Cannot determine content, proceed
        }

        // Load content
        $content = $this->loadContent($tipeKonten, $idKonten);
        
        if (!$content) {
            return $next($request); // Content not found, let controller handle
        }

        // Get pertemuan from content
        $pertemuanId = $content->id_pertemuan;
        
        if (!$pertemuanId) {
            return $next($request); // No pertemuan, proceed (shouldn't happen)
        }

        // Check if content requires attendance
        if (!$this->attendanceService->requiresAttendance($content)) {
            return $next($request); // No attendance required for this content
        }

        // NEW: Check if exempted for this PERTEMUAN
        if ($this->attendanceService->isExemptedFromPertemuan($siswa->id, $pertemuanId)) {
            return $next($request); // Exempted from whole pertemuan, allow access
        }

        // NEW: Check if already marked attendance for this PERTEMUAN
        if ($this->attendanceService->hasMarkedAttendanceForPertemuan($siswa->id, $pertemuanId)) {
            return $next($request); // Already marked for pertemuan, allow access to all content
        }

        // Attendance not marked for pertemuan - redirect to attendance modal
        return redirect()->route('siswa.attendance.modal', [
            'pertemuan' => $pertemuanId,
            'tipe_konten' => $tipeKonten,
            'id_konten' => $idKonten,
            'redirect_to' => $request->fullUrl()
        ])->with('info', 'Silakan absen terlebih dahulu untuk mengakses konten pada pertemuan ini.');
    }

    /**
     * Get content type from route
     */
    protected function getContentTypeFromRoute(Request $request): ?string
    {
        $routeName = $request->route()->getName();

        if (str_contains($routeName, 'materi')) {
            return 'materi';
        } elseif (str_contains($routeName, 'tugas')) {
            return 'tugas';
        } elseif (str_contains($routeName, 'kuis')) {
            return 'kuis';
        }

        return null;
    }

    /**
     * Get content ID from route
     */
    protected function getContentIdFromRoute(Request $request): ?int
    {
        // Try to get from route parameter
        $param = $request->route('id') 
              ?? $request->route('materi') 
              ?? $request->route('tugas') 
              ?? $request->route('kuis')
              ?? $request->route('tuga'); // Laravel singular form

        // If param is an object (from route model binding), get its ID
        if (is_object($param)) {
            return $param->id ?? null;
        }

        return $param ? (int) $param : null;
    }

    /**
     * Load content model
     */
    protected function loadContent(string $tipeKonten, int $idKonten)
    {
        return match($tipeKonten) {
            'materi' => Materi::find($idKonten),
            'tugas' => Tugas::find($idKonten),
            'kuis' => Kuis::find($idKonten),
            default => null
        };
    }
}
