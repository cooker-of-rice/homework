# Zadání úlohy: Operace "Blackout"

## Kontext
Jsi expertní datový analytik (nebo hacker, záleží na úhlu pohledu). Podařilo se ti proniknout do zabezpečeného serveru korporace, která tají důležité důkazy. Tvůj čas je ale omezený. Bezpečnostní systém "Cerberus" tě detekoval a začal trasovat tvé připojení. Máš přesně **300 sekund** (5 minut) do odpojení a smazání stop.

Na serveru je mnoho souborů s různou důležitostí (hodnotou pro tvého klienta) a velikostí. Tvůj přenosový kanál má omezenou rychlost. Nemůžeš stahovat soubory paraleleně, musíš je brát jeden po druhém.

## Cíl
Tvým úkolem je napsat skript, který zanalyzuje seznam dostupných souborů a vybere přesně ty, které ti přinesou **největší celkovou hodnotu** (kredity), a přitom se stihnou stáhnout v časovém limitu.

## Vstupní data
Server ti vrátil výpis souborů v textovém formátu (logu). Každý řádek reprezentuje jeden soubor.

**Formát řádku:**
`[FILE] <náz_souboru> | Size: <velikost> MB | Val: <hodnota> Credits`

**Parametry spojení:**
*   Rychlost stahování: **20 MB/s** (megabytů za sekundu)
*   Časový limit: **300 sekund**

### Ukázka dat (data.txt)
```text
[FILE] evidence_01.dat | Size: 450 MB | Val: 2500 Credits
[FILE] photo_ceo_vacation.jpg | Size: 12 MB | Val: 10 Credits
[FILE] blueprint_omega.cad | Size: 1200 MB | Val: 8500 Credits
[FILE] email_backup.zip | Size: 300 MB | Val: 1200 Credits
[FILE] financial_report_2024.xls | Size: 40 MB | Val: 600 Credits
[FILE] security_logs.txt | Size: 150 MB | Val: 50 Credits
[FILE] project_x_source_code.tar | Size: 800 MB | Val: 5000 Credits
[FILE] meeting_minutes.doc | Size: 5 MB | Val: 20 Credits
```

*(Poznámka pro studenta: V reálném zadání může být souborů mnohem více, např. 50-100. Tvůj program musí být univerzální.)*

## Úkoly pro studenta

1.  **Analýza problému:**
    *   Zamysli se, co vlastně řešíš. Jaké jsou proměnné? Co je omezující podmínka? Co optimalizuješ?
    *   Převeď si "velikost souboru" a "rychlost" na společnou jednotku, která tě zajímá – **čas**. (Kolik sekund trvá stažení každého souboru?)

2.  **Návrh řešení:**
    *   Jaký algoritmus použiješ?
    *   Bude stačit brát soubory "jak přijdou"? (Zkus si to na papíře).
    *   Bude stačit brát ty nejhodnotnější? Co když je nejhodnotnější soubor tak velký, že zablokuje stažení pěti menších, které by dohromady měly větší cenu?
    *   Bude stačit brát ty nejmenší?

3.  **Implementace:**
    *   Napiš program (v JS, PHP, Pythonu nebo C), který:
        1.  Načte textový vstup (ze souboru nebo stringu).
        2.  Rozparsuje data (získá název, velikost, hodnotu).
        3.  Vypočítá dobu stahování pro každý soubor.
        4.  Najde nejlepší kombinaci souborů.
    *   Výstupem programu musí být:
        *   Seznam vybraných souborů.
        *   Celková hodnota (Credits).
        *   Celkový spotřebovaný čas.


