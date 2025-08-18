// 1. Definisci le tabelle nel DB:
// - services: id, name, description, icon, available
// - service_menu_items: id, service_id (FK), name, description, price
// - orders: id, room_number, status, created_at, updated_at
// - order_items: id, order_id (FK), service_menu_item_id (FK), quantity, price

// 2. Crea i modelli con le relazioni:
// - Service ha molti ServiceMenuItems
// - Order ha molti OrderItems
// - OrderItem appartiene a Order e a ServiceMenuItem

<!--
Service → ServiceMenuItems: relazione One-to-Many (uno a molti)

Order → OrderItems: relazione One-to-Many (uno a molti)

OrderItem → Order: relazione Many-to-One (molti a uno)

OrderItem → ServiceMenuItem: relazione Many-to-One (molti a uno)
 -->

// 3. Crea controller API:
// - ServiceController: restituisce lista servizi + menu (GET /services)
// - OrderController: crea nuovi ordini (POST /orders), lista ordini (GET /orders), aggiorna stato

// 4. Definisci rotte API:
// - GET /api/services
// - GET /api/orders (per admin)
// - POST /api/orders (per guest)

// 5. Implementa front React:
// - Fetch servizi + menu e mostra lista dinamica
// - Form per selezionare prodotti e quantità
// - Invia POST ordine al backend
// - Visualizza stato ordine (polling o websocket)

// 6. Gestisci stato e UI dinamica senza ricaricare pagina:
// - Axios per chiamate API
// - Polling ogni pochi secondi o WebSocket per aggiornamenti in tempo reale

// 7. Auth (opzionale per admin):
// - Usa Laravel Breeze/Jetstream per login admin
// - Proteggi rotte admin e dashboard

// 8. Debug & test:
// - Scrivi test base con Pest o PHPUnit
// - Usa tinker per testare modelli e relazioni

// 9. Refactoring e miglioramenti:
// - Usa risorse API (Laravel Resource) per formattare JSON
// - Aggiungi notifiche email o Telegram per nuovi ordini (facoltativo)

// 10. Documenta tutto!
// - Commenti chiari
// - README con istruzioni base per setup e sviluppo

<!--  -->

// correggi bug invio ordine
// metti autenticazione
//correggi bug apertura menu frontend
// quando non selezioni elementi ti fa comunque andare avanti con ordine
//backend
//metti visualizzazione ordine in base a stato
//notifica nuovo ordine
//eventuali statistiche prodotti piu venduti
