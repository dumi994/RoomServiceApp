<x-layout>

    <!-- menu overlay close -->
    <div id="app"></div>

    <div id="background" data-bgimage="url(/images/background/2.jpg) fixed"></div>
    <div id="content-absolute">

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
                    <div class="col-lg-3 col-6">
                        <div class="spacer-double sm-hide"></div>
                        <img src="/images/misc/1.jpg" alt="" id="service-image-1"
                            class="img-responsive wow fadeInUp" data-wow-duration="1s">
                    </div>

                    <div class="col-lg-3 col-6">
                        <img src="/images/misc/2.jpg" alt=""
                            id="service-image-2"class="img-responsive wow fadeInUp" data-wow-duration="1.5s">
                    </div>

                    <div class="col-lg-6 wow fadeIn">
                        <div class="padding20">
                            <h2 class="title mb10">L'esperienza di lusso
                                <br>Tutta da ricordare
                                <span class="small-border"></span>
                            </h2>

                            <p>Il servizio in camera e in piscina de L’Andana Resort offre un’esperienza esclusiva e
                                curata nei minimi dettagli, permettendo agli ospiti di gustare piatti e bevande di alta
                                qualità direttamente nel comfort della propria camera o a bordo piscina, in un’atmosfera
                                rilassante e raffinata.
                            </p>

                            {{-- <a href="room-2-cols.html" class="btn-line"><span>Choose Room</span>s</a> --}}
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

                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-md-4 mb-3 d-flex justify-content-center" id="service-id-{{ $service->id }}">
                            <div class="card-bg d-flex justify-content-center flex-column align-items-center"
                                style="cursor:pointer;">
                                <span class="custom-icona d-flex align-items-center justify-content-center"
                                    style="">{!! $service->icon !!}</span>

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
                                                        class="menu-item-price">€{{ number_format($item->price, 2, ',', '.') }}</span>
                                                </label>

                                                <input type="number" min="1" value="0"
                                                    class="form-control ms-2 quantity-input "
                                                    style="width: 80px; display:none"
                                                    data-item-id="{{ $item->id }}" disabled />
                                            </li>
                                        @endforeach
                                        <div class="text-center mt-5">
                                            <button class="btn btn-primary" id="conferma-btn" data-toggle="modal"
                                                data-target="#exampleModal">Conferma selezione</button>

                                        </div>
                                        <!-- Modal -->

                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <input type="button" class="btn btn-secondary close-modal" data-dismiss="modal"
                            aria-label="Close" value="X" />


                    </div>

                    <div class="modal-body">

                        <form id="order-form" action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="room_number" class="form-label">Room Number</label>
                                <input type="text" class="form-control" id="room_number" name="room_number"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="order_details" class="form-label">Order Details</label>
                                <textarea class="form-control" id="order_details" name="order_details" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-secondary close-modal" data-dismiss="modal"
                                    value="Chiudi" />
                                {{-- <input type="button" class="btn btn-primary text-white" id="send-order"
                                    value="Invia ordine" /> --}}
                                <input type="submit" class="btn btn-primary text-white" id="send-order"
                                    value="Invia ordine" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer begin -->
        <x-footer />
        <!-- footer close -->

    </div>

    <script>
        var services = @json($services);
        $(document).ready(function() {
            $(".card-bg").click(function() {
                const card = $(this);
                const parentCol = card.closest(".col-md-4");
                const id = parentCol.attr("id").replace("service-id-", "");
                const detailBox = $("#details-" + id);

                // Nasconde tutti gli altri dettagli
                $(".service-details").not(detailBox).slideUp().addClass("d-none");

                // Toggle del box corrente
                detailBox.slideToggle().toggleClass("d-none");
            });

            // Quando un checkbox viene selezionato/deselezionato
            $('.menu-checkbox').change(function() {
                const itemId = $(this).data('item-id'); // Prendi l'ID dell'elemento selezionato
                const qtyInput = $('.quantity-input[data-item-id="' + itemId +
                    '"]'); //  Seleziona il campo quantità corrispondente

                if ($(this).is(':checked')) {
                    qtyInput.prop('disabled', false); // Abilita il campo quantità
                    $(this).closest('li').addClass(
                        'active-menu-item'); // Aggiunge la classe active per evidenziare la voce
                    qtyInput.val('1'); // Imposta quantità iniziale a 1

                    qtyInput.show() // Mostra il campo quantità
                } else {
                    qtyInput.prop('disabled', true); // Disabilita il campo quantità
                    qtyInput.val('0'); // Reimposta a 0
                    qtyInput.hide(); // Nasconde il campo quantità
                    $(this).closest('li').removeClass('active-menu-item'); // Rimuove classe active
                }
            });
            // Quando clicchi sul bottone "Conferma selezione"
            // Recupera i dati selezionati
            $('#conferma-btn').click(function() {
                const selectedItems = [];
                // Cicla su tutti i checkbox selezionati
                $('.menu-checkbox:checked').each(function() {
                    const itemId = $(this).data('item-id');
                    const qty = $('.quantity-input[data-item-id="' + itemId + '"]')
                        .val(); // controlla la quantità selezionata
                    const name = getMenuItemName(itemId); // Recupera il nome del menu

                    selectedItems.push({
                        id: itemId,
                        name: name,
                        quantity: qty
                    });
                });

                console.clear();
                console.log("Selezionati:", selectedItems);
                /*  */
                $('#exampleModal').modal('toggle'); // Mostra la modale del form ordine
                // Costruisce una stringa riepilogativa dell’ordine
                const testoOrdine = selectedItems
                    .map(item => `${item.quantity} ${item.name}`) // esempio: "2 Panino Club"
                    .join(', ');

                $('#order_details').val(
                    testoOrdine); // Inserisci la stringa dentro il campo "Order Details" del form


            });


        });
        //CHIUDI modale
        $('.close-modal').click(function() {
            $('#exampleModal').modal('hide');

        })

        function getMenuItemName(itemId) {
            for (const service of services) {
                if (service.menu_items) {
                    for (const item of service.menu_items) {
                        if (item.id == itemId) {
                            return item.name; // Restituisce il nome dell’item
                        }
                    }
                }
            }
            return null; // Se non trova nulla, ritorna null
        }


        /* CAMBIA IMMAGINE IN BASE AL SERVIZIO */
        $(document).ready(function() {
            //immagini di default
            const defaultImgs = [
                '/images/misc/1.jpg',
                '/images/misc/2.jpg'
            ]

            function setImages(imgs) {
                //prendi due immagini disponibili, se disponibili, altrimenti default
                const img1 = imgs && imgs.length > 0 ? images[0] : defaultImgs[0];
                const img2 = imgs && imgs.length > 0 ? images[1] : defaultImgs[1];

            }
            // All'avvio pagina carica immagini default
            setImages(defaultImgs)

            $('.card-bg').click(function() {
                const card = $(this)
                const parentCol = card.closest(".col-md-4")
                const id = parentCol.attr("id").replace("service-id-", "")
                const detailBox = $("#details-" + id);

                //nascondi altri dettagli
                $('.service-details').not(detailBox).slideUp().addClass('d-none')

                //toggle box corrente

                const isVisible = !detailBox.hasClass('d-none')
                detailBox.slideToggle().toggleClass('d-none')

                if (!isVisible) {
                    //se aperto servizio, cambia immagini con quelle del servizio
                    const service = service.find(s => s.id = id)
                    if (service && service.images && service.images.length > 0) {
                        setImages(service.images)
                    } else {
                        setImages(defaultImgs)
                    }
                }
            })

        })
    </script>
</x-layout>
