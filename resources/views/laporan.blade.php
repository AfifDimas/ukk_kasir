@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Laporan') }}</h1>

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
                    <button class="btn btn-success" onclick="ModalGenerateLaporan()">generate laporan</button>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">No.</th>
                                    <th scope="col">Jumlah Barang</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">Diskon %</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Diterima</th>
                                    <th scope="col">Kembalian</th>
                                    <th scope="col">Tanggal</th>
                                    <th width="10%" scope="col">Aksi</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Pilih Periode Tanggal') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('laporan.cetakPDF') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <input class="form-control" type="date" name="tanggal1" required>
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
@endsection

@section('script')
    <script type="text/javascript">
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                    },
                    {
                        data: 'jumlah_barang'
                    },
                    {
                        data: 'harga_total'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'subTotal'
                    },
                    {
                        data: 'uang'
                    },
                    {
                        data: 'kembali'
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function ModalGenerateLaporan() {
            $('#modalGenerateLaporan').modal('show')
        }
    </script>
@endsection
