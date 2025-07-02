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
                        <div class="col-md-4 mb-3 d-flex justify-content-center" id="service-id-{{ $service['id'] }}">
                            <div class="card-bg d-flex justify-content-center flex-column align-items-center">
                                <span class="icon  "><img src="{{ $service['icon'] }}" alt=""></span>
                                <div class="text mt-4">
                                    <h3 class="text-center">{{ $service['name'] }}</h3>
                                </div>
                                <p>{{ $service['description'] ?? 'Detailed information about the service.' }}</p>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-12 mt-2 service-details d-none" id="details-{{ $service['id'] }}">
                            <div class="d-flex justify-content-center py-5">
                                <img src="images/logo-andana.webp" />
                            </div>
                            <div class=" p-3">
                                <h3 class="text-center text-dark">{{ $service['name'] }}</h3>
                                @if (isset($service['menu']))
                                    <h5 class="mt-3 text-dark text-center">Il nostro menu</h5>
                                    <ul class="list-group">
                                        @foreach ($service['menu'] as $item)
                                            <li class="list-group-item d-flex align-items-center text-center">
                                                <input type="checkbox" id="menu_item_{{ $loop->index }}"
                                                    class="me-2 menu-checkbox" />
                                                <label for="menu_item_{{ $loop->index }}" class="mb-0 flex-grow-1">
                                                    <strong>{{ $item['name'] }}</strong><br>
                                                    <small>{{ $item['description'] }}</small><br>
                                                    <span
                                                        class="menu-item-price">€{{ number_format($item['price'], 2, ',', '.') }}</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- footer begin -->
        <x-footer />
        <!-- footer close -->

    </div>
    <script>
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
            $('.menu-checkbox').change(function() {
                if ($(this).is(':checked')) {
                    $(this).closest('li').addClass('active-menu-item');
                } else {
                    $(this).closest('li').removeClass('active-menu-item');
                }

                const checkedItems = [];
                $('.menu-checkbox:checked').each(function() {
                    const labelText = $(this).next('label').text().trim();
                    checkedItems.push(labelText);
                });

                console.clear();
                console.log('Elementi selezionati:', checkedItems);
            });

        });
    </script>
</x-layout>
