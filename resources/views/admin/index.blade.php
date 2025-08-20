<x-admin-layout>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info" style="cursor: pointer;" onclick="filterOrders('sent')">
                        <div class="inner">
                            <h3 id="new-orders-count">0</h3>
                            <p>Nuovi Ordini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">Clicca per filtrare <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success" style="cursor: pointer;" onclick="filterOrders('all')">
                        <div class="inner">
                            <h3 id="all-orders-count">0</h3>
                            <p>Tutti gli Ordini</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-window-restore"></i>
                        </div>
                        <a href="#" class="small-box-footer">Clicca per filtrare <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning" style="cursor: pointer;" onclick="filterOrders('pending')">
                        <div class="inner">
                            <h3 id="pending-orders-count">0</h3>
                            <p>Ordini in Corso</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hourglass"></i>
                        </div>
                        <a href="#" class="small-box-footer">Clicca per filtrare <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger" style="cursor: pointer;" onclick="filterOrders('delivered')">
                        <div class="inner">
                            <h3 id="delivered-orders-count">0</h3>
                            <p>Ordini Completati</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <a href="#" class="small-box-footer">Clicca per filtrare <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Titolo della sezione filtrata -->
            <div class="row mt-4">
                <div class="col-12">
                    <h3 id="filter-title">Tutti gli Ordini</h3>
                </div>
            </div>

            <!-- Main row -->
            <div class="row" id="order-container">
                <!-- Gli ordini verranno inseriti qui -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    @section('scripts')
        <script>
            // Variabili globali
            let allOrders = [];
            let currentFilter = 'all';

            // Funzione principale per recuperare gli ordini
            function getOrders() {
                $.ajax({
                    url: '/api/orders',
                    method: 'GET',
                    success: function(data) {
                        // Salva tutti gli ordini e ordina per ID decrescente
                        allOrders = data.sort((a, b) => b.id - a.id);
                        console.log('Dati ricevuti:', allOrders);

                        // Aggiorna i contatori
                        updateCounters();

                        // Mostra gli ordini con il filtro corrente
                        displayOrders(currentFilter);
                    },
                    error: function(xhr, status, error) {
                        console.error('Errore nella richiesta:', error);
                    }
                });
            }

            // Funzione per aggiornare i contatori nelle card
            function updateCounters() {
                const newOrders = allOrders.filter(order => order.status === 'sent').length;
                const pendingOrders = allOrders.filter(order => order.status === 'pending').length;
                const deliveredOrders = allOrders.filter(order => order.status === 'delivered').length;

                $('#new-orders-count').text(newOrders);
                $('#pending-orders-count').text(pendingOrders);
                $('#delivered-orders-count').text(deliveredOrders);
                $('#all-orders-count').text(allOrders.length);
            }

            // Funzione per visualizzare gli ordini filtrati
            function displayOrders(filterType) {
                let filteredOrders = [];
                let title = '';

                // Applica il filtro
                switch (filterType) {
                    case 'sent':
                        filteredOrders = allOrders.filter(order => order.status === 'sent');
                        title = 'Nuovi Ordini';
                        break;
                    case 'pending':
                        filteredOrders = allOrders.filter(order => order.status === 'pending');
                        title = 'Ordini in Preparazione';
                        break;
                    case 'delivered':
                        filteredOrders = allOrders.filter(order => order.status === 'delivered');
                        title = 'Ordini Completati';
                        break;
                    case 'all':
                    default:
                        filteredOrders = allOrders;
                        title = 'Tutti gli Ordini';
                        break;
                }

                // Aggiorna il titolo
                $('#filter-title').text(title);

                // Costanti per lo stile
                const statusBadgeClass = {
                    sent: 'bg-info', // Nuovi Ordini
                    pending: 'bg-warning', // Ordini in corso / in preparazione
                    delivered: 'bg-danger', // Ordini completati
                };
                const orderStatus = {
                    delivered: 'Ordine completato',
                    pending: 'In Preparazione',
                    sent: 'Ordine Ricevuto',
                };

                // Genera HTML
                let html = '';

                if (filteredOrders.length === 0) {
                    html = '<div class="col-12"><p class="text-center">Nessun ordine trovato per questo filtro.</p></div>';
                } else {
                    filteredOrders.forEach(order => {
                        const badgeClass = statusBadgeClass[order.status] || 'bg-secondary';
                        const serviceType = /[a-zA-Z]/.test(order.room_number) ? 'Pool Service' : 'Room Service';

                        html += `
                <div class="col-4" id="order-${order.id}">
                    <div class="order-card">
                        <div class="order-header">
                            <h2>Ordine #${order.id}</h2>
                            <span class="update-status status ${badgeClass}" data-id="${order.id}" data-status="${order.status}">${orderStatus[order.status]}</span>
                        </div>
                        <div class="order-body pr-3">
                            <div class="row">
                                <div class="col-12">
                                    <p><strong>Ospite: <br></strong> ${order.first_name} ${order.last_name}</p>
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-9">
                                    <p><strong>Servizio: <br></strong> ${serviceType}</p>
                                </div>
                                <div class="col-3">
                                    <p><strong>Camera: <br></strong> ${order.room_number}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p><strong>Ordine: <br></strong>${order.order_details}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                    });
                }

                $('#order-container').html(html);
            }

            // Document ready
            $(document).ready(function() {
                // Aggiungi i click handler alle card
                $('.small-box').css('cursor', 'pointer');

                // Click sulla card Nuovi Ordini
                $('.small-box.bg-info').on('click', function(e) {
                    e.preventDefault();
                    currentFilter = 'sent';
                    displayOrders('sent');
                });

                // Click sulla card Tutti gli Ordini
                $('.small-box.bg-success').on('click', function(e) {
                    e.preventDefault();
                    currentFilter = 'all';
                    displayOrders('all');
                });

                // Click sulla card Ordini in Corso
                $('.small-box.bg-warning').on('click', function(e) {
                    e.preventDefault();
                    currentFilter = 'pending';
                    displayOrders('pending');
                });

                // Click sulla card Ordini Completati
                $('.small-box.bg-danger').on('click', function(e) {
                    e.preventDefault();
                    currentFilter = 'delivered';
                    displayOrders('delivered');
                });

                // Carica gli ordini inizialmente
                getOrders();

                // Aggiorna ogni 5 secondi
                setInterval(getOrders, 5000);
            });

            // Event handler per l'update dello status (usa event delegation)
            $(document).on('click', '.update-status', function(e) {
                e.preventDefault();

                const btn = $(this);
                const orderId = btn.data('id');
                const currentStatus = btn.data('status');

                if (currentStatus === 'delivered') {
                    Swal.fire({
                        title: 'Questo ordine è stato completato',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok',
                    });
                    return;
                }

                let newStatus;
                if (currentStatus === 'sent') newStatus = 'pending';
                else if (currentStatus === 'pending') newStatus = 'delivered';
                else newStatus = 'sent';

                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Vuoi davvero cambiare lo stato?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, cambia stato!',
                    cancelButtonText: 'Annulla'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/orders/${orderId}/update-status`,
                            method: 'POST',
                            data: {
                                status: newStatus,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                Swal.fire(
                                    'Fatto!',
                                    'Lo stato è stato aggiornato.',
                                    'success'
                                );

                                // Aggiorna l'ordine nell'array locale
                                const orderIndex = allOrders.findIndex(order => order.id ===
                                    orderId);
                                if (orderIndex !== -1) {
                                    allOrders[orderIndex].status = newStatus;
                                }

                                // Aggiorna i contatori
                                updateCounters();

                                // Ri-visualizza con il filtro corrente
                                displayOrders(currentFilter);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Errore!',
                                    'Errore durante l\'aggiornamento dello stato: ' + error,
                                    'error'
                                );
                            }
                        });

                    }
                });
            });
        </script>
    @endsection
</x-admin-layout>
