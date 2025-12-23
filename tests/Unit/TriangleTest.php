<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TriangleChecker;

class TriangleTest extends TestCase
{
    protected $triangle;

    protected function setUp(): void
    {
        parent::setUp();
        $this->triangle = new TriangleChecker();
    }

    // SKENARIO 1: Input Negatif atau 0
    public function test_tidak_bisa_dibangun_jika_ada_nilai_nol_atau_negatif()
    {
        // Input: 0, 5, 5
        $this->assertEquals("TIDAK ADA SEGITIGA DAPAT DIBANGUN", $this->triangle->check(0, 5, 5));

        // Input: -1, 5, 5
        $this->assertEquals("TIDAK ADA SEGITIGA DAPAT DIBANGUN", $this->triangle->check(-1, 5, 5));
    }

    // SKENARIO 2: Sisi Terbesar >= Penjumlahan dua sisi lain
    public function test_tidak_bisa_dibangun_jika_sisi_terbesar_terlalu_panjang()
    {
        // Input: 1, 2, 10 (1+2 < 10)
        $this->assertEquals("TIDAK ADA SEGITIGA DAPAT DIBANGUN", $this->triangle->check(1, 2, 10));

        // Input: 2, 3, 5 (2+3 = 5, harusnya lebih besar, bukan sama dengan)
        $this->assertEquals("TIDAK ADA SEGITIGA DAPAT DIBANGUN", $this->triangle->check(2, 3, 5));
    }

    // SKENARIO 3: Segitiga Sama Sisi
    public function test_segitiga_sama_sisi()
    {
        // Input: 5, 5, 5
        $this->assertEquals("SEGITIGA SAMA SISI", $this->triangle->check(5, 5, 5));
    }

    // SKENARIO 4: Segitiga Sama Kaki
    public function test_segitiga_sama_kaki()
    {
        // Input: 5, 5, 3 (a=b)
        $this->assertEquals("SEGITIGA SAMA KAKI", $this->triangle->check(5, 5, 3));

        // Input: 5, 8, 8 (b=c setelah sort)
        $this->assertEquals("SEGITIGA SAMA KAKI", $this->triangle->check(5, 8, 8));
    }

    // SKENARIO 5: Segitiga Siku-Siku
    public function test_segitiga_siku_siku()
    {
        // Input: 3, 4, 5 (3^2 + 4^2 = 5^2 -> 9+16 = 25)
        $this->assertEquals("SEGITIGA SIKU-SIKU", $this->triangle->check(3, 4, 5));
    }

    // SKENARIO 6: Segitiga Bebas
    public function test_segitiga_bebas()
    {
        // Input: 4, 5, 6 (Valid, tidak sama sisi/kaki, bukan siku-siku)
        $this->assertEquals("SEGITIGA BEBAS", $this->triangle->check(4, 5, 6));
    }

    // SKENARIO 7: Kasus Pecahan (Float Tolerance)
    public function test_segitiga_pecahan_dianggap_bulat()
    {
        // Input: 2.99, 3.01, 3.00 -> Dianggap 3, 3, 3 -> Sama Sisi
        $this->assertEquals("SEGITIGA SAMA SISI", $this->triangle->check(2.99, 3.01, 3.00));
    }
}
