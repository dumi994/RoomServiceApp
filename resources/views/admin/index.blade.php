<x-admin-layout>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            {{--  <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div> --}}
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">

            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>

    @section('scripts')
        <script>
            function getOrders() {
                fetch('/api/orders')
                    .then(response => {
                        if (!response.ok) throw new Error('Errore HTTP: ' + response.status);
                        return response.json();
                    })
                    .then(data => {
                        // Ordina decrescente per id
                        data.sort((a, b) => b.id - a.id);
                        console.log('Dati ricevuti:', data);

                        const container = document.getElementById('order-container');
                        let html = '';
                        const statusBadgeClass = {
                            delivered: 'bg-success', // verde
                            pending: 'bg-warning', // giallo
                            sent: 'bg-danger', // rosso
                        };
                        const orderStatus = {
                            delivered: 'Ordine completato',
                            pending: 'In Preparazione',
                            sent: 'Ordine Ricevuto',
                        };
                        data.forEach(order => {
                            const badgeClass = statusBadgeClass[order.status] || 'bg-secondary';
                            // Controllo per determinare il tipo di servizio
                            const serviceType = /[a-zA-Z]/.test(order.room_number) ? 'Pool Service' :
                                'Room Service';
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

                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Errore nella richiesta:', error);
                    });
            }
            getOrders()
            setInterval(getOrders, 5000)


            /*  */

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

                    })
                    return; // blocca click
                }
                let newStatus;
                if (currentStatus === 'sent') newStatus = 'pending';
                else if (currentStatus === 'pending') newStatus = 'delivered';
                else if (currentStatus === 'delivered') newStatus = 'sent';
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

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: `/orders/${orderId}/update-status`,
                            method: 'POST',
                            data: {
                                status: newStatus
                            },
                            dataType: "json",
                            success: function(data) {
                                Swal.fire(
                                    'Fatto!',
                                    'Lo stato è stato aggiornato.',
                                    'success'
                                );

                                // Aggiorna il badge con nuovo status
                                const badge = $(`#order-${orderId} .status`);

                                // Rimuove tutte le classi di background
                                badge.removeClass('bg-success bg-danger bg-secondary');

                                if (newStatus === 'delivered') {
                                    badge.addClass('bg-success').text('Ordine completato');
                                } else if (newStatus === 'sent') {
                                    badge.addClass('bg-danger').text('Ordine ricevuto');
                                }
                                // Aggiorna il data-status con il nuovo stato
                                badge.data('status', newStatus);
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
