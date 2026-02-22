<?php

class Sedadlo {
    private int $cislo;
    private bool $jeObsazeno = false;

    public function __construct(int $cislo) {
        $this->cislo = $cislo;
    }

    public function getCislo(): int {
        return $this->cislo;
    }

    public function jeVolne(): bool {
        return !$this->jeObsazeno;
    }

    public function rezervovat(): bool {
        if ($this->jeObsazeno) {
            return false; // obsazeno
        }
        $this->jeObsazeno = true;
        return true;
    }
}

class Kino {
    private array $sedadla = [];

    public function __construct(int $kapacita) {
        // kino s určitým počtem sedadel
        for ($i = 1; $i <= $kapacita; $i++) {
            $this->sedadla[$i] = new Sedadlo($i);
        }
    }

    public function provedRezervaci(int $cisloSedadla): void {
        // existuje sedadlo
        if (!isset($this->sedadla[$cisloSedadla])) {
            echo "Chyba: Sedadlo č. $cisloSedadla v tomto sále neexistuje.<br>";
            return;
        }

        // rezervovat či nerezervovat
        if ($this->sedadla[$cisloSedadla]->rezervovat()) {
            echo "Rezervace sedadla č. $cisloSedadla byla úspěšná.<br>";
        } else {
            echo "Sedadlo č. $cisloSedadla je již obsazeno!<br>";
        }
    }

    public function vypisVolnaMista(): void {
        echo "<br>Seznam volných míst: ";
        $volna = [];
        foreach ($this->sedadla as $sedadlo) {
            if ($sedadlo->jeVolne()) {
                $volna[] = $sedadlo->getCislo();
            }
        }
        echo implode(", ", $volna) . "<br>";
    }
}

//volání

$mojeKino = new Kino(10); // kino

$mojeKino->vypisVolnaMista();

$mojeKino->provedRezervaci(5);  // úspěch
$mojeKino->provedRezervaci(5);  // neseď mi na klíně
$mojeKino->provedRezervaci(11); // židle není
$mojeKino->provedRezervaci(1);  // úspěch

$mojeKino->vypisVolnaMista();