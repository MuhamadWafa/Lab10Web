<?php
class Mobil
{
    private $warna;
    private $merk;
    private $harga;

    public function __construct() 
    {
        $this->warna = "Biru";
        $this->merk = "BMW";
        $this->harga = "10000000";
    }

    public function gantiwarna ($warnaBaru)
    {
        $this->warna = $warnaBaru; 
    }

    public function tampilWarna ()
    {
        echo "Warna mobilnya: ";
        echo $this->warna;
    }
}

$a = new Mobil();
$b = new Mobil();

echo "<b>Mobil pertama</b><br>";
$a->tampilWarna(); 
echo "<br>Mobil pertama ganti warna<br>";
$a->gantiwarna ("Merah");
$a->tampilWarna(); 

echo "<br><b>Mobil kedua</b><br>";
$b->gantiwarna("Hijau");
$b->tampilWarna(); 