<x-admin-layout>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!-- (i tuoi small box esistenti...) -->
            </div>
            <!-- /.row -->

            <!-- Bottone aggiungi nuovo item -->
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('dashboard.menu.create') }}" class="btn btn-primary">
                        + Aggiungi nuovo piatto
                    </a>
                </div>
            </div>

            <!-- Main row -->
            <div class="row d-block">
                <table id="example" class="display w-100">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrizione</th>
                            <th>Prezzo</th>
                            <th>Fa parte di</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menuItems as $i)
                            <tr>
                                <td>{{ $i->name }}</td>
                                <td>{{ $i->description }}</td>
                                <td>{{ $i->price }} €</td>
                                <td>{{ $i->service->name }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="menu/{{ $i->id }}/edit">
                                                <span style="color:rgb(60, 60, 222)" class="material-symbols-outlined">
                                                    edit_square
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <form action="{{ route('dashboard.menu.destroy', $i->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-no-style">
                                                    <span style="color:red"
                                                        class="material-symbols-outlined delete-icon">
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
                            <th>Prezzo</th>
                            <th>Attivo</th>
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

            $('.delete-form').on('submit', function(e) {
                e.preventDefault(); // blocca il submit per mostrare conferma
                const form = this;

                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Questa azione non può essere annullata!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sì, elimina!',
                    cancelButtonText: 'Annulla'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // invia form se confermato
                    }
                });
            });
        </script>
    @endsection
</x-admin-layout>
