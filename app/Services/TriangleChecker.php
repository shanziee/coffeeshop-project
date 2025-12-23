<?php

namespace App\Services;

class TriangleChecker
{
    public function check($a, $b, $c)
    {
        // Kasus 2: Penanganan angka pecahan (Float tolerance)
        // Sesuai instruksi: 2.99, 3.01, 3.00 dianggap sama sisi.
        // Kita bulatkan angkanya untuk mengakomodasi kasus ini.
        $a = round($a);
        $b = round($b);
        $c = round($c);

        // Urutkan bilangan agar mudah menentukan sisi terbesar (c) dan sisi kecil (a, b)
        $sides = [$a, $b, $c];
        sort($sides);
        $a = $sides[0];
        $b = $sides[1];
        $c = $sides[2]; // Ini bilangan terbesar

        // 1. Cek Validitas: Negatif atau 0
        if ($a <= 0 || $b <= 0 || $c <= 0) {
            return "TIDAK ADA SEGITIGA DAPAT DIBANGUN";
        }

        // 2. Cek Validitas: Pertidaksamaan Segitiga (Terbesar >= Jumlah dua terkecil)
        if ($c >= ($a + $b)) {
            return "TIDAK ADA SEGITIGA DAPAT DIBANGUN";
        }

        // 3. Cek Segitiga SAMA SISI (a=b dan b=c)
        if ($a == $b && $b == $c) {
            return "SEGITIGA SAMA SISI";
        }

        // 4. Cek Segitiga SAMA KAKI (Salah satu pasang sama, tapi tidak semua)
        // Karena sudah diurutkan, cek a=b atau b=c
        if ($a == $b || $b == $c) {
            return "SEGITIGA SAMA KAKI";
        }

        // 5. Cek Segitiga SIKU-SIKU (Pythagoras: c^2 = a^2 + b^2)
        // Gunakan pembulatan kecil untuk komparasi float jika perlu, tapi karena sudah di-round di awal, == aman.
        if (pow($c, 2) == (pow($a, 2) + pow($b, 2))) {
            return "SEGITIGA SIKU-SIKU";
        }

        // 6. Jika valid tapi bukan semua di atas
        return "SEGITIGA BEBAS";
    }
}
