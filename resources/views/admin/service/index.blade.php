<x-admin-layout>
    <section class="content">
        {{-- <div class="container-fluid">
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
        <div class="row d-block">
            <table id="example" class="display w-100">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrizione</th>
                        <th>Icona</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->description }}</td>
                            <td>{{ $s->icon }}</td>
                            <td>
                                <div class="">
                                    <label class="switch">
                                        <input type="checkbox" class="toggle-available" data-id="{{ $s->id }}"
                                            {{ $s->available ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('dashboard.services.edit', $s->id) }}">
                                            <span style="color:rgb(60, 60, 222)" class="material-symbols-outlined">
                                                edit_square
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <form action="{{ route('dashboard.services.destroy', $s->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-no-style">
                                                <span style="color:red" class="material-symbols-outlined delete-icon">
                                                    delete
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>Nome</th>
                        <th>Descrizione</th>
                        <th>Icona</th>
                        <th>Stato</th>
                        <th>Azioni</th>

                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>

    @section('scripts')
        <script>
            new DataTable('#example', {
                order: [
                    [3, 'desc']
                ]
            });


            $(document).ready(function() {
                $('.delete-form').on('submit', function(e) {
                    e.preventDefault(); // blocca il submit

                    const form = this;

                    Swal.fire({
                        title: 'Sei sicuro?',
                        text: "Non potrai tornare indietro!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sì, elimina!',
                        cancelButtonText: 'Annulla'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // invia il form se confermato
                        }
                    });
                });
            });
            /* SWITCH BUTTON */
            $(document).on("change", ".toggle-available", function() {
                let serviceId = $(this).data("id");
                let checked = $(this).is(":checked");

                $.ajax({
                    url: "/api/services/" + serviceId,
                    type: "PUT",
                    data: {
                        available: checked ? 1 : 0
                    },
                    success: function(response) {
                        console.log("Servizio aggiornato:", response.service.available);
                    },
                    error: function(xhr) {
                        console.error("Errore aggiornamento servizio");
                    }
                });
            });
        </script>
    @endsection
</x-admin-layout>
