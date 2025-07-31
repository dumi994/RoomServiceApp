<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="assets/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="assets/admin/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <x-sidebar />
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
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
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
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
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">

                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">

                    <div id="order-container" class="row">


                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.4
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script src="assets/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="assets/admin/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="assets/admin/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="assets/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="assets/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="assets/admin/plugins/moment/moment.min.js"></script>
    <script src="assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="assets/admin/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/admin/dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="assets/admin/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/admin/dist/js/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        html += `
                        <div class="col-4" id="order-${order.id}">
                            <div class="order-card">
                                <div class="order-header">
                                    <h2>Ordine #${order.id}</h2>
                                    <span class="update-status status ${badgeClass}" data-id="${order.id}" data-status="${order.status}">${orderStatus[order.status]}</span>
                                </div>
                                <div class="order-body">
                                    <p><strong>Cliente:</strong> ${order.first_name} ${order.last_name}</p>
                                    <p><strong>Camera:</strong> ${order.room_number}</p>

                                    <p><strong>Ordine:</strong> ${order.order_details}</p>
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
                    title: 'Questo ordine è gia stato completato',

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
</body>

</html>
