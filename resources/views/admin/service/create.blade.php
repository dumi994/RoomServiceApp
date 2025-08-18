<x-admin-layout>
    <div class="container mt-5" style="max-width: 720px;">
        <h2 class="mb-4 fw-semibold text-dark text-center">Aggiungi un nuovo Servizio</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" id="service-form"
            class="p-4 border rounded shadow-sm bg-white">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" id="name" name="name" class="form-control form-control-lg"
                    placeholder="Es. Room Service" required>
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icona (classe Font Awesome)</label>
                <input type="text" id="icon" name="icon" class="form-control form-control-lg"
                    placeholder="Es. fa-solid fa-bell">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea id="description" name="description" rows="4" class="form-control form-control-lg"
                    placeholder="Scrivi una descrizione del servizio..."></textarea>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="available" id="available" value="1">
                <label class="form-check-label" for="available">Disponibile</label>
            </div>

            <div class="mb-4">
                <label for="images" class="form-label">Carica immagini (max 2)</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*" />
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard.services.index') }}" class="text-secondary text-decoration-none">← Torna ai
                    servizi</a>
                <button type="submit" class="btn btn-dark px-4 py-2">Salva</button>
            </div>
        </form>
    </div>
</x-admin-layout>
