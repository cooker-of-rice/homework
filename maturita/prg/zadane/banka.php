<?php

class BankovniUcet {
    private float $zustatek;
    private array $historie = [];
    private string $majitel;

    public function __construct(string $majitel, float $pocatecniVklad) {
        $this->majitel = $majitel;
        $this->zustatek = $pocatecniVklad;
        $this->zaznamenejTransakci("Počáteční vklad", $pocatecniVklad);
    }

    // vklad
    public function vlozit(float $castka): void {
        if ($castka > 0) {
            $this->zustatek += $castka;
            $this->zaznamenejTransakci("Vklad", $castka);
            echo "Vloženo: $castka Kč. Aktuální zůstatek: {$this->zustatek} Kč.<br>";
        }
    }

    // výběr + validace
    public function vybrat(float $castka): bool {
        if ($castka <= 0) {
            echo "Chyba: Částka musí být kladná.<br>";
            return false;
        }

        if ($castka > $this->zustatek) {
            echo "Chyba: Nedostatek prostředků pro výběr $castka Kč (Zůstatek: {$this->zustatek} Kč).<br>";
            return false;
        }

        $this->zustatek -= $castka;
        $this->zaznamenejTransakci("Výběr", -$castka);
        echo "Vybráno: $castka Kč. Zbývá: {$this->zustatek} Kč.<br>";
        return true;
    }

    // historie
    private function zaznamenejTransakci(string $typ, float $castka): void {
        $this->historie[] = [
            'datum' => date("Y-m-d H:i:s"),
            'typ' => $typ,
            'castka' => $castka,
            'zustatek_po' => $this->zustatek
        ];
    }

    public function vypisHistorii(): void {
        echo "<br>--- Historie transakcí účtu (Majitel: {$this->majitel}) ---<br>";
        foreach ($this->historie as $polozka) {
            printf("[%s] %-15s | Částka: %10.2f Kč | Zůstatek: %10.2f Kč<br>",
                $polozka['datum'],
                $polozka['typ'],
                $polozka['castka'],
                $polozka['zustatek_po']
            );
        }
    }
}

//volání

$mujUcet = new BankovniUcet("Jan Novák", 1000);

$mujUcet->vlozit(500);
$mujUcet->vybrat(200);
$mujUcet->vybrat(2000); // naschvál pro test validace
$mujUcet->vlozit(1200.50);

$mujUcet->vypisHistorii();