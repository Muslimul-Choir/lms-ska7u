<?php

namespace App\Traits;

use Carbon\Carbon;

trait GeneratesPasswordFromBirthDate
{
    /**
     * Generate password dari tanggal lahir dalam format DDMMYYYY.
     * 
     * @param Carbon|string $tanggalLahir Tanggal lahir
     * @return string Password dalam format DDMMYYYY (contoh: 21041990)
     */
    protected function generatePasswordFromBirthDate($tanggalLahir): string
    {
        // Konversi ke Carbon jika string
        if (is_string($tanggalLahir)) {
            $tanggalLahir = Carbon::parse($tanggalLahir);
        }

        return $tanggalLahir->format('dmY');
    }
}
