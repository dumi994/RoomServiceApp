# RoomService

Applicazione sviluppata in **Laravel** per la gestione di servizi, ordini e contenuti di un sito.  
Include autenticazione, API, pannello admin e gestione del menù servizi.

## Requisiti

- PHP >= 8.1
- Composer
- MySQL/MariaDB (o SQLite in locale)
- Node.js (>= 18) + npm
- Estensioni PHP comuni: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`

## Installazione

Clona il repository ed entra nella cartella del progetto:

```bash
git clone <repo-url>
cd roomservice
```

Installa le dipendenze PHP e JS:

```bash
composer install
npm install
```

Copia il file `.env` di esempio e genera la chiave applicativa:

```bash
cp .env.example .env
php artisan key:generate
```

Configura il database nel file `.env`.  
Puoi usare SQLite in locale (già incluso in `database/database.sqlite`) oppure MySQL/MariaDB.

Esegui le migrazioni e i seeders:

```bash
php artisan migrate --seed
```

Crea il link simbolico per la cartella `storage`:

```bash
php artisan storage:link
```

Avvia il server di sviluppo:

```bash
php artisan serve
```

Compila gli asset frontend (Vite):

```bash
npm run dev
```

## Struttura principale

- `app/Models` — Modelli Eloquent (`User`, `Order`, `Service`, `ServiceMenuItem`, ecc.)
- `app/Http/Controllers` — Controller per web, API e admin
- `database/migrations` — Migrazioni database (utenti, servizi, ordini, contenuti sito)
- `database/seeders` — Seeder per popolamento iniziale (servizi, menu, ordini demo)
- `config/` — Configurazioni Laravel (auth, mail, queue, filesystem, ecc.)
- `routes/` — Definizione delle rotte (web, api)

## Funzionalità

- Autenticazione (Laravel Breeze/Sanctum)
- CRUD servizi e voci di menu
- Gestione ordini e dettagli ordine
- Gestione contenuti del sito
- API REST per ordini e servizi
- Seeder per dati demo
- Middleware per email verification

## Comandi utili

```bash
# Migrazioni
php artisan migrate
php artisan migrate:refresh --seed

# Testing
php artisan test

# Queue
php artisan queue:work

# Cache
php artisan config:cache
php artisan route:cache
```

## Deploy

Per ambienti di produzione:

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
