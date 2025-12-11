<?php
class Zamestnanec{
    public string $jmeno;
    public int $pozice;
    public int  $pobocka;    

    public function __construct($jmeno, $pozice, $pobocka) {
        $this ->jmeno = $jmeno;
        $this->pozice= $pozice;
        $this->pobocka= $pobocka;
        
    }
}
class Firma {
    public array $zamestnanci;
    public array $vetve;
    public array $pozice;

    public function __construct() {
        $this->zamestnanci = [];
        $this->vetve = [];
        $this->pozice = [];
    }
    
    public function pridatPobocku($pobockaId) {
    $this->vetve[$pobockaId] = [];
}
    public function pridatPozici($poziceId){
        $this->pozice[$poziceId] = [];

    }
    public function pridatZamestnance($jmeno, $poziceId, $pobockaId){
        $novyZamestnanec = new Zamestnanec($jmeno, $poziceId, $pobockaId);
        $this->zamestnanci[]=$novyZamestnanec;
        $this->vetve[$pobockaId][] = $novyZamestnanec;
        $this->pozice[$poziceId][] = $novyZamestnanec;

    }


}

?>