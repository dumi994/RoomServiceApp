<x-layout>
    <!-- menu overlay close -->
    <div id="app"></div>

    <div id="background" data-bgimage="url({{ asset('images/background/2.jpg') }}) fixed"></div>
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



        <section id="order-confirmation" class="no-bg no-top" style="min-height: 400px;">
            <div class="m-4">
                <h2 class="title mb-4 text-center">Grazie per il tuo ordine!</h2>

                <div class="tracking-progress">
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
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                    </div>
                    <div class="col-lg-8 text-center">
                        <div class="py-5">


                            <div class="order-summary mt-4">
                                <h5>Riepilogo ordine:</h5>
                                <div id="order-summary-content" class="bg-light p-3 rounded mt-3">
                                    <div class="mb-4">
                                        <img src="{{ asset('images/logo-andana.webp') }}" alt="Logo Andana"
                                            style="max-width: 200px;" />
                                    </div>
                                    @php
                                        $orderItems = array_filter(
                                            array_map('trim', explode(',', $order->order_details ?? '')),
                                        );
                                    @endphp

                                    @if (count($orderItems) > 0)
                                        <h6 class="mb-3">Il tuo ordine include:</h6>
                                        <div class="row">
                                            @foreach ($orderItems as $index => $item)
                                                <div class="col-12 mb-2">
                                                    <div class="d-flex align-items-center p-2 border rounded">

                                                        <div class="flex-grow-1">
                                                            <strong class="text-dark">{{ $item }}</strong>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">Nessun dettaglio ordine disponibile.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary" id="new-order-btn">Fai un nuovo ordine</button>
                                <button class="btn btn-secondary ms-2" id="back-to-services">Torna ai servizi</button>
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
        let orderId = {{ $order->id ?? 'null' }};
        let pollingInterval = null;

        function startOrderPolling() {
            if (!orderId) return;

            pollingInterval = setInterval(function() {
                $.ajax({
                    url: `/orders/${orderId}`,
                    type: 'GET',
                    success: function(response) {
                        console.log('Order status:', response);

                        // Aggiorna lo stato dell'ordine
                        updateOrderStatus(response.status);

                        // Ferma il polling se completato
                        if (response.status === 'completed') {
                            clearInterval(pollingInterval);
                            showCompletionMessage();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Errore controllo ordine:', error);
                    },
                    dataType: 'json'
                });
            }, 5000);
        }

        function updateOrderStatus(status) {
            const statusMap = {
                'pending': 'In attesa',
                'processing': 'In elaborazione',
                'completed': 'Completato',
                'cancelled': 'Annullato'
            };

            $('#order-status').text(statusMap[status] || status);
        }

        function showCompletionMessage() {
            $('#completion-alert').show();
            // Altre azioni quando l'ordine è completato
        }

        // Avvia il polling
        $(document).ready(function() {
            startOrderPolling();
        });
    </script>
</x-layout>
