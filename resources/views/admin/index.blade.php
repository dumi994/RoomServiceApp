<x-admin-layout>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                     <div class="small-box bg-info" style="cursor: pointer;" onclick="filterOrders('sent')">
                        <span id="new-order-badge" class="new-order-badge">0</span>
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
    <style>
      /* Mostra un badge rosso in alto a destra sulla small-box "Nuovi Ordini" */
      .new-order-badge{
        position: absolute;
        top: 8px;
        right: 10px;
        background: #dc3545;
        color: #fff;
        border-radius: 9999px;
        padding: 2px 8px;
        font-weight: 700;
        font-size: 12px;
        display: none;
        line-height: 1.4;
      }
      .small-box.has-badge .new-order-badge{ display: inline-block; }
    </style>

   @section('scripts')
<script>
    // Variabili globali
    let allOrders = [];
    let currentFilter = 'all';

    // 🔔 Tracciamento nuovi ordini
    let seenOrderIds = new Set();
    let unseenNewOrdersCount = 0;

    // Inietta badge rosso sulla card "Nuovi Ordini"
    function ensureNewOrderBadge() {
        if (!document.getElementById('new-order-badge-style')) {
            const css = `
                .new-order-badge {
                    position: absolute;
                    top: 8px;
                    right: 10px;
                    background: #dc3545;
                    color: #fff;
                    border-radius: 9999px;
                    padding: 2px 8px;
                    font-weight: 700;
                    font-size: 12px;
                    display: none;
                    line-height: 1.4;
                    z-index: 2;
                }
                .small-box.has-badge .new-order-badge { display: inline-block; }
                .small-box.bg-info { position: relative; }
            `;
            const style = document.createElement('style');
            style.id = 'new-order-badge-style';
            style.appendChild(document.createTextNode(css));
            document.head.appendChild(style);
        }
        const box = document.querySelector('.small-box.bg-info');
        if (box && !box.querySelector('#new-order-badge')) {
            const span = document.createElement('span');
            span.id = 'new-order-badge';
            span.className = 'new-order-badge';
            span.textContent = '0';
            box.prepend(span);
        }
    }

    // Determina tipo di servizio
    function getServiceType(order) {
        return /[a-zA-Z]/.test(String(order.room_number || ''))
            ? 'Pool Service'
            : 'Room Service';
    }

    // Aggiorna il badge
    function updateNewOrderBadge() {
        const $badge = $('#new-order-badge');
        const $box = $('.small-box.bg-info');
        if (!$badge.length) return;

        if (unseenNewOrdersCount > 0) {
            $badge.text(unseenNewOrdersCount);
            $box.addClass('has-badge');
        } else {
            $badge.text('0');
            $box.removeClass('has-badge');
        }
    }

    // Mostra notifica toast
    function notifyNewOrder(order) {
        const serviceType = getServiceType(order);
        const room = order.room_number ? ` (${order.room_number})` : '';

        Swal.fire({
            title: 'Nuovo ordine',
            text: `${order.first_name} ${order.last_name} — ${serviceType}${room}`,
            icon: 'info',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    }

    // Recupera ordini
    function getOrders() {
        $.ajax({
            url: '/api/orders',
            method: 'GET',
            success: function(data) {
                const prevHadSeen = seenOrderIds.size > 0;
                const previousAllOrders = allOrders;

                allOrders = (data || []).sort((a, b) => b.id - a.id);

                if (!prevHadSeen && previousAllOrders.length === 0) {
                    // Primo load → segna tutti come già visti
                    for (const o of allOrders) seenOrderIds.add(o.id);
                } else {
                    // Solo nuovi ID
                    const newOnes = allOrders.filter(o => !seenOrderIds.has(o.id));
                    for (const o of newOnes) {
                        seenOrderIds.add(o.id);
                        if (o.status === 'sent') {
                            notifyNewOrder(o);
                            unseenNewOrdersCount += 1;
                        }
                    }
                    updateNewOrderBadge();
                }

                updateCounters();
                displayOrders(currentFilter);
            },
            error: function(xhr, status, error) {
                console.error('Errore nella richiesta:', error);
            }
        });
    }

    // Aggiorna i contatori
    function updateCounters() {
        const newOrders = allOrders.filter(o => o.status === 'sent').length;
        const pendingOrders = allOrders.filter(o => o.status === 'pending').length;
        const deliveredOrders = allOrders.filter(o => o.status === 'delivered').length;

        $('#new-orders-count').text(newOrders);
        $('#pending-orders-count').text(pendingOrders);
        $('#delivered-orders-count').text(deliveredOrders);
        $('#all-orders-count').text(allOrders.length);
    }

    // Mostra ordini filtrati
    function displayOrders(filterType) {
        let filteredOrders = [];
        let title = '';

        switch (filterType) {
            case 'sent':
                filteredOrders = allOrders.filter(o => o.status === 'sent');
                title = 'Nuovi Ordini';
                break;
            case 'pending':
                filteredOrders = allOrders.filter(o => o.status === 'pending');
                title = 'Ordini in Preparazione';
                break;
            case 'delivered':
                filteredOrders = allOrders.filter(o => o.status === 'delivered');
                title = 'Ordini Completati';
                break;
            case 'all':
            default:
                filteredOrders = allOrders;
                title = 'Tutti gli Ordini';
                break;
        }

        $('#filter-title').text(title);

        const statusBadgeClass = {
            sent: 'bg-info',
            pending: 'bg-warning',
            delivered: 'bg-danger',
        };
        const orderStatus = {
            delivered: 'Ordine completato',
            pending: 'In Preparazione',
            sent: 'Ordine Ricevuto',
        };

        let html = '';

        if (filteredOrders.length === 0) {
            html = '<div class="col-12"><p class="text-center">Nessun ordine trovato per questo filtro.</p></div>';
        } else {
            filteredOrders.forEach(order => {
                const badgeClass = statusBadgeClass[order.status] || 'bg-secondary';
                const serviceType = getServiceType(order);

                html += `
                    <div class="col-md-4 col-sm-12" id="order-${order.id}">
                        <div class="order-card">
                            <div class="order-header">
                                <h2>Ordine #${order.id}</h2>
                                <span class="update-status status ${badgeClass}"
                                      data-id="${order.id}"
                                      data-status="${order.status}">
                                      ${orderStatus[order.status]}
                                </span>
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
                                        <p><strong>Camera: <br></strong> ${order.room_number ?? ''}</p>
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

    // Ready
    $(document).ready(function() {
        ensureNewOrderBadge();

        // Click handler card Nuovi Ordini
        $('.small-box.bg-info').on('click', function(e) {
            e.preventDefault();
            currentFilter = 'sent';
            displayOrders('sent');
            unseenNewOrdersCount = 0;
            updateNewOrderBadge();
        });

        // Card Tutti gli Ordini
        $('.small-box.bg-success').on('click', function(e) {
            e.preventDefault();
            currentFilter = 'all';
            displayOrders('all');
        });

        // Card Ordini in Corso
        $('.small-box.bg-warning').on('click', function(e) {
            e.preventDefault();
            currentFilter = 'pending';
            displayOrders('pending');
        });

        // Card Ordini Completati
        $('.small-box.bg-danger').on('click', function(e) {
            e.preventDefault();
            currentFilter = 'delivered';
            displayOrders('delivered');
        });

        // Carica iniziale + polling
        getOrders();
        setInterval(getOrders, 5000);
    });

    // Update stato ordine
    $(document).on('click', '.update-status', function(e) {
        e.preventDefault();

        const btn = $(this);
        const orderId = btn.data('id');
        const currentStatus = btn.data('status');

        if (currentStatus === 'delivered') {
            Swal.fire({
                title: 'Questo ordine è stato completato',
                icon: 'warning',
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
                    success: function() {
                        Swal.fire('Fatto!', 'Lo stato è stato aggiornato.', 'success');

                        const orderIndex = allOrders.findIndex(o => o.id === orderId);
                        if (orderIndex !== -1) {
                            allOrders[orderIndex].status = newStatus;
                        }

                        updateCounters();
                        displayOrders(currentFilter);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Errore!', 'Errore durante aggiornamento: ' + error, 'error');
                    }
                });
            }
        });
    });
</script>
@endsection

</x-admin-layout>
