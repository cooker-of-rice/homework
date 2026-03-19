<?php
/**
 * vypočítá průměr a dá ho do referenčího pole $evidence
 * @param string $jmeno
 * @param int $z1, $z2, $z3
 * @return array
 */
function zpracujStudenta(string $jmeno, int $z1, int $z2, int $z3): array {
    $prumer = ($z1 + $z2 + $z3) / 3;
    return [
        'jmeno' => $jmeno,
        'prumer' => $prumer
    ];
}

// referenční pole
$evidence = [];

// volání
$evidence[] = zpracujStudenta("Petr", 1, 2, 1);
$evidence[] = zpracujStudenta("Jana", 5, 4, 5);
$evidence[] = zpracujStudenta("Lukáš", 2, 3, 2);

// seřazení pole funkcí usort
usort($evidence, function($a, $b) {
    return $a['prumer'] <=> $b['prumer']; 
});

// výpis
echo "--- Seznam studentů podle průměru ---<br>";
foreach ($evidence as $student) {
    $prospel = $student['prumer'] <= 4.5 ? "Prospěl" : "Neprospěl";
    
    //formátování
    printf("Student: %-10s | Průměr: %5.2f | Stav: %s<br>", 
        $student['jmeno'], 
        $student['prumer'], 
        $prospel
    );
}
?>