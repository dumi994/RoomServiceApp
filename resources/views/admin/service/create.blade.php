<x-admin-layout>
    <h2>Aggiungi voci servizi</h2>

    @if (session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Aggiungi un nuovo Servizio</h2>

        <form action="{{ route('services.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nome</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Es. Room Service">
            </div>

            <div class="mb-4">
                <label for="icon" class="block text-sm font-semibold text-gray-700 mb-1">Icona (classe Font Awesome
                    o nome)</label>
                <input type="text" id="icon" name="icon"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Es. fa-solid fa-bell">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Descrizione</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Scrivi una descrizione del servizio..."></textarea>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="available" value="1" class="form-checkbox text-blue-600">
                    <span class="ml-2 text-gray-700">Disponibile</span>
                </label>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('services.index') }}" class="mr-4 text-sm text-gray-500 hover:underline">Annulla</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Salva</button>
            </div>
        </form>
    </div>

    <a href="{{ route('services.index') }}">Torna ai servizi</a>

</x-admin-layout>
