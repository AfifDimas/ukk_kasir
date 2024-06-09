@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Produk') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
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
                    <div class="btn-group mb-3">
                        <button onclick="addProduk()" class="btn btn-xs btn-info btn-flat">+</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">No.</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Kode Produk</th>
                                    <th width="15%" scope="col">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- modal membuat produk baru --}}
        <div class="modal fade" id="addProdukModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Produk Baru') }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('produk.tambah') }}" method="head">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">harga Barang</label>
                                <input type="number" class="form-control" id="harga" name="harga" value="">
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="">
                            </div>
                            <div class="mb-3">
                                <label for="kode_produk" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="kode_produk" name="kode_produk"
                                    value="">
                            </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal edit produk --}}
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Produk') }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('produk.update') }}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" id="nama_edit" name="nama_edit"
                                    value="">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">harga Barang</label>
                                <input type="number" class="form-control" id="harga_edit" name="harga_edit"
                                    value="">
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah_edit" name="jumlah_edit"
                                    value="">
                            </div>
                            <div class="mb-3">
                                <label for="kode_produk" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="kode_produk_edit" name="kode_produk_edit"
                                    value="">
                            </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                    </div>
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
                    url: '{{ route('produk.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'hargaFormat'
                    },
                    {
                        data: 'stok'
                    },
                    {
                        data: 'kode_produk'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function addProduk() {
            $('#addProdukModal').modal('show')
        }

        function handleEdit(id) {
            $.post(`{{ url('produk/selectProduk') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'get',
                })
                .done(response => {
                    console.log(id);

                    $('#id_produk').val(id)
                    $('#nama_edit').val(response.nama)
                    $('#harga_edit').val(response.harga)
                    $('#jumlah_edit').val(response.jumlah)
                    $('#kode_produk_edit').val(response.kode_produk)

                    $('#modalEdit').modal('show')
                })
                .fail(erros => {
                    alert('yahahaha gagal');
                })
        }

        function handleHapus(id) {
            confirm('Apakah Anda Yakin Ingin Menghapus Data Ini!!!')

            $.post(`{{ url('produk/delete') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete',
                })
                .done(response => {
                    alert(response)
                    table.ajax.reload();
                })
                .fail(erros => {
                    alert('yahahaha gagal');
                })
        }
    </script>
@endsection
