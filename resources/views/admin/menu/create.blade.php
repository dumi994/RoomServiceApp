<x-admin-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Aggiungi voci menu per: <span class="text-blue-600">{{ $service->name }}</span>
        </h2>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('services.menu-items.store', $service->id) }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nome voce menu</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Es. Hamburger Deluxe">
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Descrizione</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Descrizione opzionale della voce..."></textarea>
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Prezzo (€)</label>
                <input type="number" id="price" name="price" step="0.01" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="0.00">
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('services.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">←
                    Torna ai servizi</a>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Aggiungi voce
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
