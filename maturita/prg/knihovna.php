<?php

class Kniha {
    public string $nazev;
    public int $pocetStran;

    public function __construct(string $nazev, int $pocetStran) {
        $this->nazev = $nazev;
        $this->pocetStran = $pocetStran;
    }

    // zjistí typ knihy
    public function typKnihy(): string {
        return $this->pocetStran > 100 ? "dlouhá" : "krátká";
    }

    // formátování 
    public function vypisInfo(): string {
        return sprintf("Kniha: %-20s | Stran: %4d | Typ: %s", 
            $this->nazev, 
            $this->pocetStran, 
            $this->typKnihy()
        );
    }
}

// referenční pole
$knihovna = [];

// volání
$knihovna[] = new Kniha("Babička", 250);
$knihovna[] = new Kniha("Malý princ", 96);
$knihovna[] = new Kniha("Stopařův průvodce", 160);
$knihovna[] = new Kniha("Haiku", 15);

// výpis 
echo "--- Seznam knih v knihovně ---<br>";
foreach ($knihovna as $kniha) {
    echo $kniha->vypisInfo() . "<br>";
}

// nejdelší kniha
$nejdelsiKniha = $knihovna[0]; 

foreach ($knihovna as $kniha) {
    if ($kniha->pocetStran > $nejdelsiKniha->pocetStran) {
        $nejdelsiKniha = $kniha;
    }
}

echo "<br>Nejdelší knihou v knihovně je: " . $nejdelsiKniha->nazev . " (" . $nejdelsiKniha->pocetStran . " stran).<br>";