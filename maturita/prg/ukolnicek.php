<?php

class Ukol {
    public string $text;
    public bool $jeHotovo = false;

    public function __construct(string $text) {
        $this->text = $text;
    }

    public function oznacJakoSplneny(): void {
        $this->jeHotovo = true;
    }

    public function __toString(): string {
        $stav = $this->jeHotovo ? "[X]" : "[ ]";
        return "$stav {$this->text}";
    }
}

// pole  
$seznamUkolu = [];

// volání
$seznamUkolu[] = new Ukol("Koupit mléko");
$seznamUkolu[] = new Ukol("Naučit se PHP na maturitu");
$seznamUkolu[] = new Ukol("Vyvenčit psa");

// označení
if (isset($seznamUkolu[1])) {
    $seznamUkolu[1]->oznacJakoSplneny();
}

// výpis
echo "--- Můj TODO seznam ---<br>";
foreach ($seznamUkolu as $index => $ukol) {
    echo "$index. $ukol<br>";
}