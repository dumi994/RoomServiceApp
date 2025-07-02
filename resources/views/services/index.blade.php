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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="order-form">
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="button" class="btn btn-primary" id="send-order" value="Invia ordine" />
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
                $('#exampleModal').modal('show');

                const testoOrdine = selectedItems
                    .map(item => `${item.quantity} ${item.name}`)
                    .join(', ');

                $('#order_details').val(testoOrdine);

            });

            //invia ordine
            $('#send-order').click(function() {
                $('#exampleModal').modal('hide');
            });


        });

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
    </script>
</x-layout>
