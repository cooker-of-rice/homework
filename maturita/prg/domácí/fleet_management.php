    <?php
    class car{
        public int $id;
        public string $model;
        public int $purchase_price;
        public int $kilometers;
        public string $last_service;

        public function __construct(int $id, string $model, int $purchase_price, int $kilometers, string $last_service){
            $this->id=$id;
            $this->model=$model;
            $this->purchase_price=$purchase_price;
            $this->kilometers=$kilometers;
            $this->last_service=$last_service;
        }
        public function needsService():bool{
            $service_date = new DateTime($this->last_service);
            $today = new DateTime();
            $daySinceService= $service_date->diff($today);
            if ($this->kilometers > 150000 || $daySinceService->days>360){
                return true;
            }else{
                return false;
            }
        }

        public function getCurrentValue():int{
            $deficit= $this->kilometers * 2;
            $currentPrice= $this->purchase_price - $deficit;
            return $currentPrice;
        }
    }
    $jsonData= json_decode($jsonString, true);
    $fleet = [];
    foreach($jsonData as $car){
        $fleet[]=new car(
            $car['id'],
            $car['model'],
            $car['purchase_price'],
            $car['kilometers'],
            $car['last_service']
        );
    }
    
    foreach($fleet as $car){
        $service = $car->needsService() ? "ANO" : "NE";
        echo "MODEL: " . $car->model . "|". "AKTUÁLNÍ CENA: " . $car->getCurrentValue() . "Kč"  . "|".  "SERVIS: " . $service;
    }

    ?>