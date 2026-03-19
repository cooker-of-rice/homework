<?php
class player{
    public string $name;
    public int $goalCount;
    public bool $isCaptain;

   public function __construct(string $name, int $goalCount, bool $isCaptain) {
        $this->name = $name;
        $this->goalCount = $goalCount;
        $this->isCaptain = $isCaptain;
    }
}

$team=[
    new player("Bican", 15, false),
    new player("Novak", 9, true),
    new player("Müller", 4, false),
];

foreach ($team as $player){
    if ($player->goalCount>10){
    echo $player->name . "má více než 10 goalů". "(".$player->goalCount . ")<br>";
    }
}

$mvp= $team[0];
foreach ($team as $player){
    if ($player->goalCount>$mvp->goalCount){
        $mvp = $player;
    }
}

echo $name . "má nejvíce goalů". "(".$player->goalCount. ")<br>";

$json = json_encode($team,JSON_PRETTY_PRINT);
file_put_contents("team.json", $json); 

?>