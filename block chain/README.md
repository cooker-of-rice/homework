## Jak to otestovat?

1. **Zobrazení řetězce:**
Otevřete prohlížeč
*Uvidíte JSON s "Genesis Blockem".*
2. **Přidání transakce:**
tento příkaz do terminálu:
```bash
curl -X POST http://localhost/api.php \
-H "Content-Type: application/json" \
-d '{"data": {"sender": "Alice", "receiver": "Bob", "amount": 50}}'

```
