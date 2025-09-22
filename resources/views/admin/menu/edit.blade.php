<x-admin-layout>
    <div class="container mt-5" style="max-width: 720px;">
        <h2 class="mb-4 fw-semibold text-dark">
            Modifica voce del menu di <span class="text-primary">{{ $menu->name }}</span>
        </h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('dashboard.menu.update', [$menu->id, $menu->id]) }}" method="POST"
            class="p-4 border rounded shadow-sm bg-white">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nome voce menu</label>
                    <input type="text" id="name" name="name" class="form-control form-control-lg"
                        value="{{ old('name', $menu->name) }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Prezzo</label>
                    <input type="number" step="0.01" id="price" name="price"
                        class="form-control form-control-lg" value="{{ old('price', $menu->price) }}" required>
                    @error('price')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Descrizione</label>
                <textarea id="description" name="description" rows="4" class="form-control form-control-lg">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard.menu.index') }}" class="text-secondary text-decoration-none">
                    ← Torna alle voci menu
                </a>

                <button type="submit" class="btn btn-dark px-4 py-2">
                    Salva modifiche
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
