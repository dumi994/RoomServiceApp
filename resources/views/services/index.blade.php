<x-layout>

    <!-- menu overlay close -->
    <div id="app"></div>

    <div id="background" data-bgimage="url(images/background/2.jpg) fixed"></div>
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
                        <img src="images/misc/1.jpg" alt="" class="img-responsive wow fadeInUp"
                            data-wow-duration="1s">
                    </div>

                    <div class="col-lg-3 col-6">
                        <img src="images/misc/2.jpg" alt="" class="img-responsive wow fadeInUp"
                            data-wow-duration="1.5s">
                    </div>

                    <div class="col-lg-6 wow fadeIn">
                        <div class="padding20">
                            <h2 class="title mb10">The Luxury Experience<br>You'll Remember
                                <span class="small-border"></span>
                            </h2>

                            <p>Welcome to our luxurious hotel, where sophistication, impeccable service, and
                                unparalleled comfort await you. From the moment you step into our grand lobby, you'll be
                                immersed in an atmosphere of opulence and refined elegance. As you enter our elegant
                                establishment, you will be greeted by a captivating ambiance that exudes sophistication
                                and tranquility.</p>

                            <a href="room-2-cols.html" class="btn-line"><span>Choose Room</span>s</a>
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
                                <span class="icon"><img src="{{ $service->icon }}" alt=""></span>
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
                                <img src="images/logo-andana.webp" alt="Logo Andana" />
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
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    required>
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
        {{-- CONFIRMATION MODAL --}}
        <section id="order-confirmation" class="no-bg no-top  " style="min-height: 400px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="order-tracking mt-4">
                            <h5 class="text-center mb-4">Stato del tuo ordine</h5>
                            {{--  <div class="tracking-progress">
                                <div class="tracking-step completed" data-step="1">
                                    <div class="step-circle">📋</div> 

                                    <div class="step-label">Ordine Inviato</div>
                                </div>

                                <div class="tracking-line"></div>

                                <div class="tracking-step active" data-step="2">
                                    <div class="step-circle">👨‍🍳</div> 
                                    <div class="step-label">In Preparazione</div>
                                </div>

                                <div class="tracking-line"></div>

                                <div class="tracking-step pending" data-step="3">
                                    <div class="step-circle">🚚</div> 
                                    <div class="step-label">Consegnato</div>
                                </div>
                            </div> --}}
                            <div class="steps">
                                <div id="step1" class="step">Ordine Inviato</div>
                                <div id="step2" class="step">In Preparazione</div>
                                <div id="step3" class="step">Consegnato</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 text-center">
                        <div class="py-5">
                            <div class="mb-4">
                                <img src="images/logo-andana.webp" alt="Logo Andana" style="max-width: 200px;" />
                            </div>
                            <h2 class="title mb-4">Grazie per il tuo ordine!</h2>
                            <div class="alert alert-success">
                                <h4>✅ Ordine ricevuto con successo</h4>
                                <p>Il tuo ordine è stato inviato al nostro staff. Riceverai conferma a breve.</p>
                            </div>
                            <div class="order-summary mt-4">
                                <h5>Riepilogo ordine:</h5>
                                <div id="order-summary-content" class="bg-light p-3 rounded mt-3">
                                    <!-- Qui verranno inseriti i dettagli -->

                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary" id="new-order-btn">Fai un nuovo ordine</button>
                                <button class="btn btn-secondary ms-2" id="back-to-services">Torna ai
                                    servizi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                const itemId = $(this).data('item-id');
                const qtyInput = $('.quantity-input[data-item-id="' + itemId + '"]');

                if ($(this).is(':checked')) {
                    qtyInput.prop('disabled', false);
                    $(this).closest('li').addClass('active-menu-item');
                    qtyInput.val('1');

                    qtyInput.show()

                } else {
                    qtyInput.prop('disabled', true);
                    qtyInput.val('0');
                    qtyInput.hide()
                    $(this).closest('li').removeClass('active-menu-item');
                }
            });

            // Recupera i dati selezionati
            $('#conferma-btn').click(function() {
                const selectedItems = [];

                $('.menu-checkbox:checked').each(function() {
                    const itemId = $(this).data('item-id');
                    const qty = $('.quantity-input[data-item-id="' + itemId + '"]').val();
                    const name = getMenuItemName(itemId);

                    selectedItems.push({
                        id: itemId,
                        name: name,
                        quantity: qty
                    });
                });

                console.clear();
                console.log("Selezionati:", selectedItems);
                /*  */
                $('#exampleModal').modal('toggle');

                const testoOrdine = selectedItems
                    .map(item => `${item.quantity} ${item.name}`)
                    .join(', ');

                $('#order_details').val(testoOrdine);

            });

            //invia ordine
            $('#send-order').click(function(e) {
                e.preventDefault();

                // 1. VALIDAZIONE PRIMA DI INVIARE
                const firstName = $('#first_name').val().trim();
                const lastName = $('#last_name').val().trim();
                const roomNumber = $('#room_number').val().trim();
                const orderDetails = $('#order_details').val().trim();

                // Rimuovi eventuali errori precedenti
                $('.form-control').removeClass('is-invalid');

                // Verifica se i campi sono vuoti
                let hasErrors = false;

                if (!firstName) {
                    $('#first_name').addClass('is-invalid');
                    hasErrors = true;
                }
                if (!lastName) {
                    $('#last_name').addClass('is-invalid');
                    hasErrors = true;
                }
                if (!roomNumber) {
                    $('#room_number').addClass('is-invalid');
                    hasErrors = true;
                }
                if (!orderDetails) {
                    $('#order_details').addClass('is-invalid');
                    hasErrors = true;
                }

                // Se ci sono errori, non inviare
                if (hasErrors) {
                    alert('Tutti i campi sono obbligatori!');
                    return;
                }

                // 2. INVIA SOLO SE TUTTO È VALIDO
                $.ajax({
                    url: '{{ route('orders.store') }}',
                    method: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),

                        first_name: firstName,
                        last_name: lastName,
                        room_number: roomNumber,
                        order_details: orderDetails
                    },
                    success: function(risposta) {
                        // 3. SE TUTTO È ANDATO BENE, MOSTRA CONFERMA
                        $('#exampleModal').modal('hide');
                        $('.service-details').slideUp().addClass('d-none');
                        $('#section-main').slideUp();
                        $('#order-confirmation').removeClass('d-none').slideDown();

                        $('#order-summary-content').html(`
                            <p class="text-black"><strong>Nome:</strong> ${firstName} ${lastName}</p>
                            <p class="text-black"><strong>Camera:</strong> ${roomNumber}</p>
                            <p class="text-black"><strong>Ordine:</strong> ${orderDetails}</p>
                        `);

                        $('#order-form')[0].reset();
                        console.log("id: " + id);

                        // Simula progressione automatica

                        $('.menu-checkbox:checked').prop('checked', false).trigger('change');

                    },
                    error: function(errore) {
                        console.log('Errore:', errore);
                        alert('Errore durante invio');
                    }
                });
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
                            return item.name;
                        }
                    }
                }
            }
            return null;
        }


        /* POLLING */
        $('#startTracking').on('click', function() {
            var orderId = $(this).data('order-id'); // prende l'ID dal bottone
            startPolling(orderId); // lo passa alla funzione
        });
    </script>
</x-layout>
