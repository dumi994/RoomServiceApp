Passaggi in linea di massima (backend + frontend)

1. Backend - Laravel API (prima)

Definisci il modello Ordine con campi essenziali:
nome, camera, servizio, stato (es. “inviato”, “ricevuto”, “in lavorazione”)

Crea le migrazioni per il DB (SQLite o MySQL)

Crea il controller API OrdineController con metodi:

store() per salvare un nuovo ordine

index() per elencare gli ordini (per admin)

update() per aggiornare stato ordine (quando admin clicca "Ricevuto")

Definisci le rotte API nel routes/api.php

Testa le API con Postman o direttamente via tinker per verificare che tutto funzioni (es: inserire e leggere ordini)

2. Frontend - React app (dopo backend pronto)
   Crea progetto React con Vite (npm create vite@latest hotel-frontend --template react)

Installa TailwindCSS e Axios (npm install tailwindcss axios)

Crea componenti base:

ServiceSelector (per scegliere il servizio)

OrderForm (invia nome, camera e servizio)

OrderStatus (mostra stato attuale e barra di avanzamento fittizia)

AdminPanel (lista ordini, con bottone “Ricevuto”)

Implementa chiamate API con Axios per:

POST /api/ordini per inviare ordine

GET /api/ordini per caricare ordini admin

PUT /api/ordini/{id} per aggiornare stato ordine

Implementa polling con Axios ogni 5 secondi per aggiornare lo stato

3. Test e miglioramenti
   Prova il flusso completo (cliente invia ordine, admin aggiorna stato, cliente vede aggiornamento)

Aggiungi stile e UI/UX con TailwindCSS

Implementa test base con Pest su backend (es: test di creazione ordine)

Migliora progressivamente UI e funzionalità

Riassunto:
Fase Attività principali
Backend Modello, migrazione, API routes, controller, test
Frontend Setup React+Vite, Tailwind, Axios, componenti, API
Integrazione Polling, aggiornamenti in tempo reale, test completi
