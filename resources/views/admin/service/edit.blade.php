<x-admin-layout>
    <div class="container mt-5" style="max-width: 720px;">
        <h2 class="mb-4 fw-semibold text-dark text-center">Modifica {{ $service->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="my-4">
            <h5 class="mt-5">Carica immagini</h5>
            <form action="{{ route('services.upload.images', $service->id) }}" method="POST" enctype="multipart/form-data"
                class="dropzone" id="dropzone-form">
                @csrf
            </form>
            <div class="row mt-2">
                @if (!empty($service->images) && is_iterable($service->images))
                    @foreach ($service->images as $index => $image)
                        <div class=" col-6">
                            <div class="edit-service-img shadow rounded"
                                style="background-image: url('{{ isset($image) ? asset($image) : asset('images/default1.jpg') }}')">

                                <span data-index="{{ $index }}" data-image="{{ $image }}"
                                    class="material-symbols-outlined delete-icon">
                                    delete
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div id="uploaded-images" class="row"></div>

        </div>
        <form action="{{ route('services.update', $service->id) }}" method="POST"
            class="p-4 border rounded shadow-sm bg-white">
            @csrf
            @method('PUT') {{-- aggiungi questo se è una route di update --}}

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" id="name" value="{{ old('name', $service->name) }}" name="name"
                    class="form-control form-control-lg" placeholder="Es. Room Service" required>
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icona (classe Font Awesome)</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon', $service->icon) }}"
                    class="form-control form-control-lg" placeholder="Es. fa-solid fa-bell">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea id="description" name="description" rows="4" class="form-control form-control-lg"
                    placeholder="Scrivi una descrizione del servizio...">{{ old('description', $service->description) }}</textarea>
            </div>



            {{-- Checkbox disponibile --}}
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="available" id="available" value="1"
                    {{ old('available', $service->available) ? 'checked' : '' }}>
                <label class="form-check-label" for="available">Disponibile</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('services.index') }}" class="text-secondary text-decoration-none">
                    ← Torna ai servizi
                </a>
                <button type="submit" class="btn btn-dark px-4 py-2">Salva</button>
            </div>
        </form>

    </div>
    @section('scripts')
        <script>
            Dropzone.options.dropzoneForm = {
                paramName: 'file',
                maxFilesize: 5, // MB
                maxFiles: 2,
                uploadMultiple: false,
                parallelUploads: 1,
                acceptedFiles: 'image/*',
                dictDefaultMessage: 'Trascina qui le immagini o clicca per caricarle',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },

                success: function(file, response) {
                    console.log("Immagine caricata con successo");
                },
                error: function(file, response) {
                    console.log("Errore nel caricamento");
                },
                queuecomplete: function() {
                    fetch(`/dashboard/services/{{ $service->id }}/images`)
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.json();
                        })
                        .then(data => {
                            const container = document.getElementById("uploaded-images");
                            container.innerHTML = "";
                            data.images.forEach((image, index) => {
                                container.innerHTML += `
                                <div class="col-6">
                                    <div class="edit-service-img shadow rounded" 
                                        style="background-image: url('${image ? '/' + image : '/images/default1.jpg'}')">
                                        
                                        
                                    </div>
                                </div>
                            `;
                            });
                        })
                        .catch(err => console.error("Errore fetch immagini:", err));
                }
            };


            /* ELIMINA MMAGINE */
            $(document).ready(function() {
                $('.delete-icon').on('click', function() {
                    const image = $(this).data('image'); // prendi l'immagine dall'attributo data-image
                    const serviceId = @json($service->id); // passa id del servizio
                    const $imgContainer = $(this).closest('.col-6');

                    if (!confirm('Sei sicuro di voler eliminare questa immagine?')) return;

                    $.ajax({
                        url: `/dashboard/services/${serviceId}/delete-images`,
                        type: 'DELETE',
                        data: JSON.stringify({
                            image: image
                        }),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                $imgContainer.remove();
                            } else {
                                alert('Errore nell\'eliminazione dell\'immagine');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Errore nella chiamata AJAX: ' + error);
                        }
                    });
                });
            });

            /* ELIMINA IMMAGINE APPENA CARICATA */
            $('#uploaded-images').on('click', '.delete-icon', function() {

                // 'this' è la X cliccata
                // Prendo l'attributo data-image per sapere quale immagine eliminare
                const image = $(this).data('image');

                // Faccio la chiamata ajax al server per eliminare l'immagine
                $.ajax({
                    url: `/dashboard/services/{{ $service->id }}/delete-images`, // URL di eliminazione (modificalo secondo la tua rotta)
                    type: 'DELETE', // metodo HTTP DELETE
                    data: {
                        image: image
                    }, // passo il nome o percorso immagine da eliminare
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }, // token CSRF per sicurezza

                    success: () => {
                        // Se va tutto bene, rimuovo dal DOM la colonna che contiene l'immagine e la X
                        $(this).closest('.col-6').remove();
                        console.log('Immagine eliminata dal server e rimossa dalla pagina');
                    },
                    error: () => {
                        console.log('Errore nell’eliminazione');
                    }
                });
            });
        </script>
    @endsection

</x-admin-layout>
