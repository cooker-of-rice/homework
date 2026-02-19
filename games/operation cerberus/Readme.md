# Operace Cerberus

- spočívá vybrání dat podle toho kolik času zaberou na srovnání stažení (pod 300s) pomocáí rozděl a panuj

A.(D&C.PHP)

1. formátování

    rozbití textu na řádky, vytažení proměnných: název, čas (MB/20), kredity

2. rekurze

    štěpení:

    vzít: + kredity, - čas -> pokračuje na zbytek

    nechat: 0 kreditů, čas stejný -> pokračuje na zbytek

3. stopka (base case)

    pokud dojde čas (300 s) nebo soubory -> vrácení k porovnání

4. porovnání

    porovní hodnoty A vs B

    větší hodnota probublá nahoru

5. výstup

    tisk seznamu souborů z vítězné cesty + suma kreditů a času

## výsledek
Celková hodnota: 74167 Credits <br>
Spotřebovaný čas: 287.1 s <br>
*pzn: hladový jsem vzdal po zjištění, že největší soubor zabere přes minutu*


