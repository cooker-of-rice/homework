<?php
class klient{
    private string $jmeno;
    private string $typPredplceni;
    protected int $pocetPredplaceny;

    public function __construct(string $jmeno, string $typPredplceni, $pocetPredplaceny){
        $this->jmeno= $jmeno;
        $this->typPredplaceni=$typPredplceni;
        $this->pocetPredplaceni=$pocetPredplaceny;
    }

        public function odectiVstup(): string {
            if ($this->pocetPredplaceni>0){
                $this->pocetPredplaceny-=1;
                return  "Vstup přijat";
            }else{
                    return "Radši se neukazuj";
            }
    }
    
    public function getJmeno(string $jmeno): string{
        return $this->jmeno;

    }
    public function getPocetVstupu(): int {
    return $this->pocetPredplaceni;
}
}
    $evidence=[];

        $evidence[] = new klient("Petr", 1, Premium, 1);
        $evidence[] = new klient("Jana", 5, Basic, 5);

       foreach ($evidence as $klient) {
    if ($klient->getPocetVstupu() > 0) {
        echo "Klient " . $klient->getJmeno() . ": " . $klient->odectiVstup() . "<br>";
    } else {
        echo "Klient " . $klient->getJmeno() . " by se neměl ukázat! <br>";
    }
}

?>