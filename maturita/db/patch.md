
### Upravený Create


```sql
CREATE TABLE services_running_on_servers (
    servers_id INT UNSIGNED NOT NULL,
    services_id INT UNSIGNED NOT NULL,
    domain VARCHAR(255) NULL,
    IPv4 VARCHAR(15) NULL,
    port INT NULL,
    -- Tady jsou ty chybějící kousky:
    deployed_at DATE NOT NULL DEFAULT (CURRENT_DATE),
    status ENUM('Installed', 'Started', 'Running', 'Stopped', 'Failed') NOT NULL DEFAULT 'Installed',

    PRIMARY KEY (servers_id, services_id),
    CONSTRAINT fk_sros_server FOREIGN KEY (servers_id) REFERENCES servers(id) ON DELETE CASCADE,
    CONSTRAINT fk_sros_service FOREIGN KEY (services_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB;

```

---

### Data pro insert
```sql
-- Ukázka pro srv-web-01 a Nginx
INSERT INTO services_running_on_servers 
(servers_id, services_id, deployed_at, status) 
VALUES 
(@srv_web_01, @svc_nginx, '2024-05-20', 'Running');

```

### Složitější dotazy


```sql
SELECT s.name AS server, svc.name AS sluzba, sros.status
FROM services_running_on_servers sros
JOIN servers s ON s.id = sros.servers_id
JOIN services svc ON svc.id = sros.services_id
WHERE sros.status = 'Failed';

```

### Upravený diagram

| `servers` |  | `services_running_on_servers` |  | `services` |
| --- | --- | --- | --- | --- |
| **id** (PK) | --||--o< | **servers_id** (FK, PK) |  | **id** (PK) |
| name |  | **services_id** (FK, PK) | >o--||-- | name |
| os |  | domain |  | s_type |
| os_ver |  | IPv4 / IPv6 |  | s_ver |
|  |  | port / protocol |  |  |
|  |  | **deployed_at** (Date) |  |  |
|  |  | **status** (Enum) |  |  |

**Vysvětlivky k diagramu:**

* **servers_id, services_id:** PK+FK
* **deployed_at:** Datum nasazení na uzel.
* **status:** Aktuální provozní režim .
* **Vazby:** Kardinalita 1:N z obou stran směrem k prostřední tabulce vytváří vztah M:N.
