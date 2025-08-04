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
                <h2 class="title mb-4 text-center m-auto"
                    style="    position: relative;
    left: 50%;
    transform: translate(-50%);">
                    Grazie per il tuo ordine!</h2>

                <div class="tracking-progress">
                    <div class="tracking-step" data-step="1" id="step-1">
                        <div class="step-circle">📋</div>
                        <div class="step-label">Ordine Inviato</div>
                    </div>

                    <div class="tracking-line" id="line-1"></div>

                    <div class="tracking-step" data-step="2" id="step-2">
                        <div class="step-circle">👨‍🍳</div>
                        <div class="step-label">In Preparazione</div>
                    </div>

                    <div class="tracking-line" id="line-2"></div>

                    <div class="tracking-step" data-step="3" id="step-3">
                        <div class="step-circle">🚚</div>
                        <div class="step-label">Consegnato</div>
                    </div>
                </div>

                <!-- Status message -->
                <div class="text-center mt-3">
                    <div class="alert alert-info" id="status-message">
                        <strong id="status-text">Controllo stato dell'ordine...</strong>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
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

                                <a href="/services" class="btn btn-primary" id="new-order-btn"
                                    id="back-to-services">Torna ai
                                    servizi</a>
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

    <!-- CSS per progress bar -->
    <style>
        .tracking-progress {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin: 40px 0;
            padding: 0 20px;
        }

        .tracking-step {
            text-align: center;
            z-index: 2;
            position: relative;
            flex: 1;
            max-width: 150px;
        }

        .step-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 10px;
            transition: all 0.3s ease;
            border: 3px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .tracking-step.pending .step-circle {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .tracking-step.active .step-circle {
            background-color: #007bff;
            border-color: #007bff;
            animation: pulse 2s infinite;
            transform: scale(1.1);
        }

        .tracking-step.completed .step-circle {
            background-color: #28a745;
            border-color: #28a745;
        }

        .tracking-line {
            flex: 1;
            height: 3px;
            background-color: #dee2e6;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }

        .tracking-line.completed {
            background-color: #28a745;
        }

        .step-label {
            font-weight: bold;
            color: #6c757d;
            font-size: 14px;
        }

        .tracking-step.active .step-label {
            color: #007bff;
        }

        .tracking-step.completed .step-label {
            color: #28a745;
        }

        @keyframes pulse {
            0% {
                transform: scale(1.1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1.1);
            }
        }
    </style>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let orderId = {{ $order->id ?? 'null' }};
        let pollingInterval = null;
        let lastKnownStatus = null;

        function startOrderPolling() {
            if (!orderId) {
                console.log('Nessun orderId disponibile');
                updateStatusMessage('Errore: ID ordine non disponibile', 'danger');
                return;
            }

            console.log('Avvio polling per ordine:', orderId);

            // Prima chiamata immediata
            checkOrderStatus();

            // Poi polling ogni 5 secondi
            pollingInterval = setInterval(function() {
                checkOrderStatus();
            }, 5000);
        }

        function checkOrderStatus() {
            $.ajax({
                url: '/orders/' + orderId + '/status',
                type: 'GET',
                data: {
                    timestamp: Date.now()
                },
                success: function(response) {
                    console.log('Status dal database:', response);

                    // Usa lo status REALE dal database
                    let currentStatus = response.status;

                    // Aggiorna solo se lo status è cambiato
                    if (currentStatus !== lastKnownStatus) {
                        console.log('Status cambiato da', lastKnownStatus, 'a', currentStatus);
                        updateOrderStatus(currentStatus);
                        lastKnownStatus = currentStatus;
                    }

                    // Ferma il polling se completato
                    if (currentStatus === 'completed' || currentStatus === 'delivered') {
                        clearInterval(pollingInterval);
                        showCompletionMessage();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Errore controllo ordine:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });

                    updateStatusMessage('Errore nel controllo dello stato', 'warning');

                    if (xhr.status === 404) {
                        console.log('Ordine non trovato, fermo il polling');
                        clearInterval(pollingInterval);
                        updateStatusMessage('Ordine non trovato', 'danger');
                    }
                },
                dataType: 'json',
                timeout: 10000
            });
        }

        function updateOrderStatus(dbStatus) {
            console.log('Aggiornamento con status reale dal DB:', dbStatus);

            // Reset di tutti gli step
            $('.tracking-step').removeClass('active completed pending');
            $('.tracking-line').removeClass('completed');

            // MAPPA GLI STATUS REALI DEL DATABASE
            let currentStep = 1;
            let statusText = '';
            let statusClass = 'info';

            switch (dbStatus) {
                case 'sent':
                case 'received':
                    currentStep = 1;
                    statusText = 'Il tuo ordine è stato ricevuto dal nostro staff';
                    statusClass = 'info';
                    break;

                case 'pending': // spostato qui
                case 'processing':
                case 'in_preparation':
                case 'preparing':
                    currentStep = 2;
                    statusText = 'Il nostro chef sta preparando il tuo ordine';
                    statusClass = 'warning';
                    break;

                case 'completed':
                case 'delivered':
                case 'ready':
                    currentStep = 3;
                    statusText = 'Il tuo ordine è pronto ed è stato consegnato!';
                    statusClass = 'success';
                    break;

                default:
                    currentStep = 1;
                    statusText = 'Status: ' + dbStatus;
                    statusClass = 'info';
            }

            console.log('Step calcolato:', currentStep);

            // Aggiorna gli step in base al valore REALE
            $('.tracking-step').each(function(index) {
                const stepNumber = index + 1;
                const stepElement = $(this);

                if (stepNumber < currentStep) {
                    stepElement.addClass('completed');
                } else if (stepNumber === currentStep) {
                    stepElement.addClass('active');
                } else {
                    stepElement.addClass('pending');
                }
            });

            // Aggiorna le linee
            $('.tracking-line').each(function(index) {
                if (index + 1 < currentStep) {
                    $(this).addClass('completed');
                }
            });

            // Aggiorna il messaggio di stato
            updateStatusMessage(statusText, statusClass);
        }

        function updateStatusMessage(message, alertClass) {
            const statusMessage = $('#status-message');
            const statusText = $('#status-text');

            statusMessage.removeClass('alert-info alert-warning alert-danger alert-success');
            statusMessage.addClass('alert-' + alertClass);
            statusText.text(message);
        }

        function showCompletionMessage() {
            console.log('Ordine completato dal database!');

            $('.tracking-step').removeClass('active pending').addClass('completed');
            $('.tracking-line').addClass('completed');

            updateStatusMessage('  Il tuo ordine è stato completato e verrà consegnato in pochi minuti!', 'success');

            setTimeout(function() {
                alert('  Il tuo ordine è stato completato e verrà consegnato in pochi minuti!');
            }, 1000);
        }

        function stopPolling() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
                console.log('Polling fermato');
            }
        }

        // Gestione pulsanti
        $('#new-order-btn').click(function() {
            stopPolling();
            window.location.href = '/services';
        });

        $('#back-to-services').click(function() {
            stopPolling();
            window.location.href = '/services';
        });

        $(window).on('beforeunload', function() {
            stopPolling();
        });

        // Avvia il polling quando la pagina è pronta
        $(document).ready(function() {
            console.log('Pagina pronta, controllo status dal database...');
            startOrderPolling();
        });
    </script>
</x-layout>
