@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('detai Transaksi') }}</h1>

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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">nama Barang</th>
                                    <th scope="col">Kode Barang</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                        </table>
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
                url: '{{ route('penjualan.detail', $id) }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                },
                {
                    data: 'nama_barang'
                },
                {
                    data: 'kode_barang'
                },
                {
                    data: 'jumlah'
                },
                {
                    data: 'hargaRp'
                },
                {
                    data: 'totalRp'
                }
            ]
        });
    });

    // $(document).ready(function() {
    //     $('#datatable').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: '{{ url('/laporan/getdata') }}',
    //         columns: [{
    //                 render: function(data, type, row, meta) {
    //                     return meta.row + meta.settings._iDisplayStart + 1;
    //                 },
    //             },
    //             {
    //                 data: 'total_harga'
    //             },
    //             {
    //                 data: 'created_at'
    //             },
    //             {
    //                 "render": function(data, type, row) {
    //                     return '<button class="btn btn-primary btn-sm" onclick="terima(' + row
    //                         .id + ')">Lihat</button>'
    //                 }
    //             }
    //         ],
    //     });
    // });
</script>
@endsection