<x-layout>

    <!-- menu overlay close -->
    <div id="app"></div>

    <div id="background" data-bgimage="url(/images/background/2.jpg) fixed"></div>
    <div id="content-absolute">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <input type="text" name="first_name" placeholder="Nome">
            <input type="text" name="last_name" placeholder="Cognome">
            <input type="text" name="room_number" placeholder="Numero stanza">
            <textarea name="order_details" placeholder="Dettagli ordine"></textarea>

            <button type="submit">Invia ordine</button>
        </form>
        <!-- subheader -->
        <section id="subheader" class="no-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4>Noi Siamo</h4>
                        <h1>L'Andana Resort</h1>
                    </div>
                </div>
            </div>
        </section>

        <section id="section-main" class="no-bg no-top" aria-label="section-menu">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-6 mt-5">
                        <img id="service-image-1" class="img-responsive wow fadeInUp" data-wow-duration="1s"
                            style="object-fit: cover; width: 100%; height:40vh;" alt="Service image 1">
                    </div>

                    <div class="col-lg-3 col-6">
                        <img id="service-image-2" class="img-responsive wow fadeInUp" data-wow-duration="1.5s"
                            style="object-fit: cover; width: 100%; height: 40vh" alt="Service image 2">
                    </div>

                    <div class="col-lg-6 wow fadeIn">
                        <div class="padding20">
                            <h2 class="title mb10">L'esperienza di lusso
                                <br>Tutta da ricordare
                                <span class="small-border"></span>
                            </h2>

                            <p>Il servizio in camera e in piscina de L'Andana Resort offre un'esperienza esclusiva e
                                curata nei minimi dettagli, permettendo agli ospiti di gustare piatti e bevande di alta
                                qualità direttamente nel comfort della propria camera o a bordo piscina, in un'atmosfera
                                rilassante e raffinata.
                            </p>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="spacer-double"></div>

                <div class="row gx-4">
                    <div class="col-lg-12 text-center">
                        <h2 class="title center">Hotel Facilities
                            <span class="small-border"></span>
                        </h2>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @foreach ($services as $service)
                        <div class="col-md-4 mb-3 d-flex justify-content-center" id="service-id-{{ $service->id }}">
                            <div class="card-bg d-flex justify-content-center flex-column align-items-center"
                                style="cursor:pointer;">
                                <span class="custom-icona d-flex align-items-center justify-content-center">
                                    {!! $service->icon !!}
                                </span>

                                <div class="text mt-4">
                                    <h3 class="text-center">{{ $service->name }}</h3>
                                </div>
                                <p>{{ $service->description ?? 'Detailed information about the service.' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-12 mt-2 service-details d-none" id="details-{{ $service->id }}">
                            <div class="d-flex justify-content-center py-5">
                                <img src="/images/logo-andana.webp" alt="Logo Andana" />
                            </div>
                            <div class="p-3">
                                <h3 class="text-center text-dark">{{ $service->name }}</h3>

                                @if ($service->menu_items && $service->menu_items->count())
                                    <h5 class="mt-3 text-dark text-center">Il nostro menu</h5>
                                    <ul class="list-group">
                                        @foreach ($service->menu_items as $item)
                                            <li class="list-group-item d-flex align-items-center text-center">
                                                <input type="checkbox"
                                                    id="menu_item_{{ $loop->index }}_service_{{ $service->id }}"
                                                    class="me-2 menu-checkbox" data-item-id="{{ $item->id }}" />

                                                <label for="menu_item_{{ $loop->index }}_service_{{ $service->id }}"
                                                    class="mb-0 flex-grow-1 text-start ms-2">
                                                    <strong>{{ $item->name }}</strong><br>
                                                    <small>{{ $item->description }}</small><br>
                                                    <span
                                                        class="menu-item-price text-black">€{{ number_format($item->price, 2, ',', '.') }}</span>
                                                </label>

                                                <input type="number" min="1" value="0"
                                                    class="form-control ms-2 quantity-input"
                                                    style="width: 80px; display:none"
                                                    data-item-id="{{ $item->id }}" disabled />
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center mt-5">
                                        <button type="button" class="btn btn-primary btn-conferma text-white"
                                            data-service-id="{{ $service->id }}" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Conferma selezione
                                        </button>
                                    </div>
                                @else
                                    <h2 class="text-center text-black my-4">Servizio momentaneamente non disponibile, ci
                                        scusiamo per il disagio.</h2>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- Modale per inviare ordine -->
        <!-- Modale -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Conferma Ordine</h5>
                            <button type="button" data-bs-dismiss="modal" class="btn-close" onclick="closeModal()"
                                aria-label="Chiudi"></button>

                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="Inserisci il nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Cognome</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Inserisci il cognome" required>
                            </div>

                            <div class="mb-3">
                                <label for="room_number" class="form-label">Numero Ombrellone/Stanza</label>
                                <input type="text" class="form-control" name="room_number" id="room_number"
                                    placeholder="Es. 101" required>
                            </div>

                            <div class="mb-3">
                                <label for="order_details" class="form-label">Dettagli Ordine</label>
                                <textarea class="form-control" id="order_details" name="order_details" rows="3"
                                    placeholder="Descrivi il tuo ordine..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <p id="orderTotal">

                                </p>
                            </div>
                            <!-- Hidden input dinamici -->
                            <div id="hidden-items-container"></div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Invia Ordine</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Modale per inviare ordine -->
        {{--   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> <!-- FORM CORRETTO -->
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Conferma Ordine</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Chiudi"></button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="Inserisci il nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Cognome</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Inserisci il cognome" required>
                            </div>
                            <div class="mb-3">
                                <label for="room_number" class="form-label">Numero Camera</label>
                                <input type="text" class="form-control" name="room_number" id="room_number"
                                    placeholder="Es. 101" required>
                            </div>
                            <div class="mb-3">
                                <label for="order_details" class="form-label">Dettagli Ordine</label>
                                <textarea class="form-control" id="order_details" name="order_details" rows="3"
                                    placeholder="Descrivi il tuo ordine..." required></textarea>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">

                            <button type="submit">Invia</button>

                        </div>
                    </form>
                </div>
            </div> --}}
    </div>

    <!-- footer begin -->
    <x-footer />
    <!-- footer close -->

    </div>

    <script>
        var services = @json($services);

        $(document).ready(function() {
            const defaultImgs = [
                '/images/misc/1.jpg',
                '/images/misc/2.jpg'
            ];
            //funzione per chiudere modale
            function closeModal() {
                $('#exampleModal').modal('hide');
            }
            // Funzione per settare le immagini
            function setImages(imgs) {
                const img1 = imgs && imgs.length > 0 ? imgs[0] : defaultImgs[0];
                const img2 = imgs && imgs.length > 1 ? imgs[1] : defaultImgs[1];
                $('#service-image-1').attr('src', img1);
                $('#service-image-2').attr('src', img2);
            }

            // Imposta immagini di default all'avvio
            setImages(defaultImgs);

            // Click sul card-bg per mostrare dettagli e cambiare immagini
            $('.card-bg').click(function() {
                const card = $(this);
                const parentCol = card.closest(".col-md-4");
                const id = parentCol.attr("id").replace("service-id-", "");
                const detailBox = $("#details-" + id);

                if (detailBox.hasClass('d-none')) {
                    $('.service-details').not(detailBox).slideUp(300, function() {
                        $(this).addClass('d-none');
                    });

                    detailBox.removeClass('d-none').hide().slideDown(300);

                    const service = services.find(s => s.id == id);
                    if (service && service.images && service.images.length > 0) {
                        $('#service-image-1, #service-image-2').fadeOut(300, function() {
                            setImages(service.images);
                            $('#service-image-1, #service-image-2').fadeIn(600);
                        });
                    } else {
                        $('#service-image-1, #service-image-2').fadeOut(300, function() {
                            setImages(defaultImgs);
                            $('#service-image-1, #service-image-2').fadeIn(600);
                        });
                    }
                } else {
                    detailBox.slideUp(300, function() {
                        detailBox.addClass('d-none');
                    });
                }
            });

            // Gestione checkboxes per abilitare/disabilitare input quantità
            $(document).on('change', '.menu-checkbox', function() {
                const checkbox = $(this);
                const itemId = checkbox.data('item-id');
                const qtyInput = $('.quantity-input[data-item-id="' + itemId + '"]');
                const listItem = checkbox.closest('li');
                const menuItemPrice = listItem.find('.menu-item-price');

                if (checkbox.is(':checked')) {
                    qtyInput.prop('disabled', false).val(1).show();
                    listItem.addClass('menu-item-selected');
                    menuItemPrice.addClass('text-white');
                } else {
                    qtyInput.prop('disabled', true).val(0).hide();
                    listItem.removeClass('menu-item-selected');
                    menuItemPrice.removeClass('text-white');
                }
            });

            // Inizializzazione del modal (UNA SOLA VOLTA)
            const orderModal = new bootstrap.Modal('#exampleModal');

            // UNICO handler per "Conferma selezione"
            $(document).on('click', '.btn-conferma', function(e) {
                e.preventDefault();
                console.log("Conferma cliccata!");

                const serviceId = $(this).data('service-id');
                const selectedItems = [];
                let orderDetails = "";
                let orderTotal = "";
                // **LOGICA PER CAMBIARE LA LABEL DEL FORM **
                // Trova il servizio corrente
                const currentService = services.find(s => s.id == serviceId);
                const serviceName = currentService ? currentService.name.toLowerCase() : '';

                // Cambia la label in base al servizio
                if (serviceName.includes('room') || serviceName.includes('camera')) {
                    $('.form-label[for="room_number"]').text('Numero Stanza');
                    $('#room_number').attr('placeholder', 'Es. 101');
                } else if (serviceName.includes('pool') || serviceName.includes('piscina') || serviceName
                    .includes('ombrellone')) {
                    $('.form-label[for="room_number"]').text('Numero Ombrellone');
                    $('#room_number').attr('placeholder', 'Es. A1');
                }
                // Seleziona solo item con checkbox spuntati
                $(`#details-${serviceId} .menu-checkbox:checked`).each(function() {
                    const checkbox = $(this);
                    const itemId = checkbox.data('item-id');
                    const qtyInput = $(
                        `#details-${serviceId} .quantity-input[data-item-id="${itemId}"]`);
                    const quantity = parseInt(qtyInput.val());
                    const itemName = checkbox.closest('li').find('strong').text();
                    const itemPrice = checkbox.closest('li').find('.menu-item-price').text();

                    if (quantity > 0) {
                        let parsedPrice = parseFloat(
                            itemPrice.replace('€', '').replace('.', '').replace(',', '.')
                        );

                        selectedItems.push({
                            id: itemId,
                            quantity: quantity,
                            name: itemName,
                            price: parsedPrice
                        });

                        orderDetails += `${quantity}x ${itemName} - ${itemPrice}\n`;
                    }
                });

                if (selectedItems.length === 0) {
                    alert("Seleziona almeno un elemento e imposta una quantità valida.");
                    return false;
                }

                // Calcola il totale
                const total = selectedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                orderTotal = `\nTOTALE: €${total.toFixed(2).toString().replace('.', ',')}`;


                // Popola campo order_details + hidden inputs
                $('#order_details').val(orderDetails);
                $('#orderTotal').append(orderTotal);

                $('#hidden-items-container').empty();

                selectedItems.forEach(function(item, index) {
                    $('#hidden-items-container').append(`
                <input type="hidden" name="items[${index}][id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
            `);
                });

                console.log("SelectedItems:", selectedItems);
                console.log("Hidden inputs pronti");

                // Mostra la modale
                orderModal.show();
            });

            // Handler per invio form - versione DEBUG
            $('#order-form').on('submit', function(e) {

                console.log("Tentativo di invio form...");
                console.log("Hidden inputs:", $('#hidden-items-container').html());

                // Stato di caricamento sul bottone
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html(`
             <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
             Invio in corso...
         `);

                console.log("Form inviato al server...");
                return true;
            });


            // Reset del form quando la modale viene chiusa
            $('#exampleModal').on('hidden.bs.modal', function() {
                $('#order-form')[0].reset();
                $('#hidden-items-container').empty();
                $('#order-form button[type="submit"]').prop('disabled', false).text('Invia ordine');
            });
        });

        /* checkbox disponibilità */
    </script>
</x-layout>
