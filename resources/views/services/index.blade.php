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

                            <p>Il servizio in camera e in piscina de L’Andana Resort offre un’esperienza esclusiva e
                                curata nei minimi dettagli, permettendo agli ospiti di gustare piatti e bevande di alta
                                qualità direttamente nel comfort della propria camera o a bordo piscina, in un’atmosfera
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

                <div class="row">
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
                                                        class="menu-item-price">€{{ number_format($item->price, 2, ',', '.') }}</span>
                                                </label>

                                                <input type="number" min="1" value="0"
                                                    class="form-control ms-2 quantity-input"
                                                    style="width: 80px; display:none"
                                                    data-item-id="{{ $item->id }}" disabled />
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-center mt-5">
                                        <button class="btn btn-primary" id="conferma-btn" data-toggle="modal"
                                            data-target="#exampleModal">Conferma selezione</button>
                                    </div>
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
                        <h5 class="modal-title" id="exampleModalLabel">Conferma Ordine</h5>
                        <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="order-form" action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Cognome</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="room_number" class="form-label">Numero Camera</label>
                                <input type="text" class="form-control" id="room_number" name="room_number"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="order_details" class="form-label">Dettagli Ordine</label>
                                <textarea class="form-control" id="order_details" name="order_details" rows="3" required></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close-modal"
                                    data-bs-dismiss="modal">Chiudi</button>
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
            const defaultImgs = [
                '/images/misc/1.jpg',
                '/images/misc/2.jpg'
            ];

            // Funzione per settare le immagini (usa tag img)
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
                    // Nascondi gli altri dettagli
                    $('.service-details').not(detailBox).slideUp(300, function() {
                        $(this).addClass('d-none');
                    });

                    // Mostra questo dettaglio
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
                    // Nascondi dettaglio corrente
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

                if (checkbox.is(':checked')) {
                    qtyInput.prop('disabled', false).val(1).show();
                } else {
                    qtyInput.prop('disabled', true).val(0).hide();
                }
            });

            // Gestione submit form: raccogli i dati selezionati
            $('#order-form').submit(function(e) {
                const selectedItems = [];

                $('.menu-checkbox:checked').each(function() {
                    const checkbox = $(this);
                    const itemId = checkbox.data('item-id');
                    const qtyInput = $('.quantity-input[data-item-id="' + itemId + '"]');
                    const quantity = parseInt(qtyInput.val());

                    if (quantity > 0) {
                        selectedItems.push({
                            id: itemId,
                            quantity: quantity
                        });
                    }
                });

                if (selectedItems.length === 0) {
                    e.preventDefault();
                    alert("Seleziona almeno un elemento e imposta una quantità valida.");
                    return false;
                }

                // Aggiungere dati al form nascosti
                $('#order-form').find('input[name="items"]').remove();
                selectedItems.forEach(function(item, index) {
                    $('#order-form').append(
                        $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', `items[${index}][id]`)
                        .val(item.id)
                    );
                    $('#order-form').append(
                        $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', `items[${index}][quantity]`)
                        .val(item.quantity)
                    );
                });

                return true;
            });
        });
    </script>

</x-layout>
