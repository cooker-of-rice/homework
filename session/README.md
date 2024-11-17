

## Způsoby přenosu

1. **GET metoda**:
   - Hodnota je přenesena jako součást URL adresy.
   - Příklad: `b.php?method=get&number=42`
   - Použití: Kliknutí na odkaz.
   - Výhoda: Snadná implementace a použití pro odkazy.
   - Nevýhoda: Hodnota je viditelná v URL, což může představovat bezpečnostní riziko.

2. **POST metoda**:
   - Hodnota je přenesena pomocí HTTP POST požadavku přes formulář.
   - Použití: Odeslání formuláře na server.
   - Výhoda: Hodnota není viditelná v URL, což zvyšuje bezpečnost.
   - Nevýhoda: Nelze použít jako odkaz, je nutné použít formulář.

3. **Session**:
   - Hodnota je uložena na straně serveru a lze ji získat z libovolné stránky během aktivní session.
   - Použití: Hodnota se ukládá pomocí `$_SESSION` proměnných.
   - Výhoda: Bezpečný způsob uložení dat na straně serveru, uživatel hodnotu nevidí ani nemůže změnit.
   - Nevýhoda: Hodnota je dostupná pouze během trvání session.

4. **Cookies**:
   - Hodnota je uložena v cookies na straně klienta a je automaticky odesílána se všemi požadavky na server.
   - Použití: Hodnota se ukládá pomocí `setcookie()` funkce.
   - Výhoda: Hodnota je dostupná i po zavření prohlížeče (dokud nevyprší platnost cookie).
   - Nevýhoda: Uživatelsky modifikovatelné, nelze použít pro citlivá data.

5. **HTTP přesměrování (GET)**:
   - Hodnota je přenesena při přesměrování stránky jako parametr URL.
   - Použití: Odeslání formuláře nebo přesměrování na stránku pomocí `header("Location: b.php?number=42")`.
   - Výhoda: Snadná implementace, ideální pro přesměrování uživatele po odeslání formuláře.
   - Nevýhoda: Hodnota je viditelná v URL.
