@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Daftar Petugas') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <button class="btn btn-primary" onclick="TambahPetugas()">Tambah Petugas</button>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Petugas</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- modal generate laporan -->
    <div class="modal fade" id="modalGenerateLaporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Petugas Baru') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('petugas.create') }}" class="user">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @method('post')
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="last_name" placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <select name="level" id="level" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2" selected>Petugas</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary" type="submit">{{ __('Simpan') }}</button>
                    </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal Update -->
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('update') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('petugas.update') }}" class="user">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id">
                        @method('put')
                        <div class="form-group">
                            <label for="name">Nama Depan</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Nama Belakang</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"  value="{{ old('last_name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email"  value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select name="level_update" id="level_update" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">Petugas</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password"  >
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary" type="submit">{{ __('Simpan') }}</button>
                    </form>
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('petugas.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function TambahPetugas() {
            $('#modalGenerateLaporan').modal('show')
        }

        function handleUpdate(id) {
            $.post(`{{ url('petugas/getUser') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'get',
                    'id': id
                })
                .done(response => {
                    $('#id').val(id);
                    $('#name').val(response.name);
                    $('#last_name').val(response.last_name);
                    $('#email').val(response.email);
                    $('#level').val(response.level);
                    $('#modalUpdate').modal('show')
                })
                .fail(errors => {
                    alert('tidak dapat menampilkan data');
                });
        }

    

    </script>
@endsection
