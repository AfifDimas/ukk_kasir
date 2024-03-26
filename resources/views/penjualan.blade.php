@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Pesanan') }}</h1>

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <div class="btn-group mb-2">
                        <button onclick="addProduk()" class="btn btn-xs btn-primary btn-flat">+</button>
                        <a href="{{ route('penjualan.baru') }}" class="btn btn-xs btn-info btn-flat">Transaksi Baru</a>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableProduk">
                                <thead>
                                    <tr>
                                        <th width="5%" scope="col">No.</th>
                                        <th scope="col">Nama barang</th>
                                        <th scope="col" width="10%">Kode Barang</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col" width="20%">Jumlah</th>
                                        <th scope="col">Subtotal</th>
                                        <th width="10%" scope="col">*</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('penjualan.simpan') }}" class="form-penjualan" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="total" id="total" value="">
                        <input type="hidden" name="kembalian" id="kembalian" value="">
                        <input type="hidden" name="dbDiterima" id="dbDiterima" value="">
                        <input type="hidden" name="dbKembali" id="dbKembali">

                        <div class="form-group row">
                            <label for="totalrp" class="col-lg-3 control-label">Total</label>
                            <div class="col-lg-9">
                                <input type="text" id="totalrp" class="form-control" value="Rp. 0" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diskon" class="col-lg-3 control-label">Diskon</label>
                            <div class="col-lg-9">
                                <input type="number" name="diskon" id="diskon" class="form-control" value="0"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bayar" class="col-lg-3 control-label">Bayar</label>
                            <div class="col-lg-9">
                                <input type="text" id="bayarrp" class="form-control fw-bold" value="Rp. 0" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diterima" class="col-lg-3 control-label">Diterima</label>
                            <div class="col-lg-9">
                                <input type="text" id="diterima" class="form-control" name="diterima" value="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kembali" class="col-lg-3 control-label">Kembali</label>
                            <div class="col-lg-9">
                                <input type="text" id="kembali" name="kembali" class="form-control" value="Rp. 0"
                                    readonly>
                            </div>
                        </div>
                        <div class="btn-group mb-3">
                            <button type="submit" class="btn btn-xs btn-primary btn-flat">Konfirmasi</button>
                            <button class="btn btn-xs btn-danger btn-flat" onclick="batal()">batal</button>
                            {{-- <a href="{{ route('penjualan.batal') }}" class="btn btn-xs btn-danger btn-flat">Batal</a> --}}

                        </div>


                    </form>
                    @if (session('success'))
                        <button class="btn btn-info"
                            onclick="cetakNota('{{ route('cetakNota') }}')">Cetak Nota</button>
                        @elseif ($total_item > 0)
                            <button class="btn btn-info"
                                onclick="cetakNota('{{ route('cetakNota') }}')">Cetak Nota</button>

                        @endif


                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="addProdukModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Pilih Produk') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableAllProduks">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">No.</th>
                                    <th scope="col">Nama Produk</th>
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
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        let table, table1;

        $(function() {
            // loadForm($('#subtotal').val(), $('#diterima').val());
            table = $('#tableAllProduks').DataTable({
                searching: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('penjualan.dataProduk') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'stok',
                        searchable: false,
                        sortable: false
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

            table1 = $('#tableProduk').DataTable({
                searching: true,
                autoWidth: false,
                bSort: false,
                dom: 'Brt',
                ajax: {
                    url: '{{ route('penjualan.data') }}',
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
                        data: 'harga'
                    },
                    {
                        data: 'jumlah_barang'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $(document).on('input', '#quantity', function() {
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());

                if (jumlah < 1) {
                    $(this).val(1);
                    alert('Jumlah Tidak Boleh Kurang Dari Satu');
                    return;
                }

                $.post(`{{ url('penjualan/tambahJmlProduk') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'jumlah': jumlah
                    })
                    .done(response => {
                        $(this).on('mouseout', function() {
                            table1.ajax.reload(() => loadForm($('#subtotal').val()));

                        });
                    })
                    .fail(errors => {
                        // alert('tidak dapat memperbarui data');
                    });

            });

            $('#diterima').on('change', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }
                loadForm($('#subtotal').val(), $(this).val())

            })

        });




        function addProduk() {
            $('#addProdukModal').modal('show')
        }

        function tambahProduk(id) {
            var id = id;


            $.post(`{{ url('penjualan/tambahProduk') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'get',
                    'id': id
                })
                .done(response => {
                    $('#addProdukModal').modal('hide')
                    table1.ajax.reload(() => loadForm($('#diskon').val(), $('#diterima').val()));

                })
                .fail(errors => {
                    alert('tidak dapat menambah data');
                });
        }

        function batal() {
            $.post(`{{ url('/penjualan/batal') }}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'get',
                })
                .done(response => {
                    table1.ajax.reload();
                })
                .fail(errors => {
                    alert('tidak dapat menghapus data');
                });
        }

        function hapusData(id) {
            var id = id;
            if (confirm("Yakin Ingin Menghapus data!!")) {
                $.post(`{{ url('/penjualan/hapusData') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete',
                        'id': id
                    })
                    .done(response => {
                        // table1.ajax.reload(loadForm();
                        table1.ajax.reload(() => loadForm($('#diskon').val(), $('#diterima').val()));

                    })
                    .fail(errors => {
                        alert('tidak dapat menghapus data');
                    });
            }
        }

        function loadForm(diskon = 0, diterima) {
            var subtotal = ($('#subtotal').val());
            $('#totalrp').val('Rp. ' + subtotal);
            $('#bayarrp').val('Rp. ' + subtotal);

            if (diterima == 'undifined') {
                diterima == 0;
            }

            $.post(`{{ url('/penjualanDetail/loadForm') }}/0/${$('#subtotal').val()}/${diterima}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'get',
                })
                .done(response => {
                    $('#kembali').val('Rp. ' + response.kembali);
                    $('#diskon').val(response.diskon);
                    $('#totalrp').val('Rp. ' + response.subtotal);
                    $('#bayarrp').val('Rp. ' + response.subtotal);
                    $('#total').val(response.db_subtotal);
                    $('#diterima').val('Rp. ' + response.diterima);
                    $('#kembalian').val(response.kembali);
                    $('#dbKembali').val(response.db_kembali);
                    $('#dbDiterima').val(response.db_diterima);
                })
                .fail(errors => {
                    // alert('tidak dapat menampilkan data');
                });
        }


        function cetakNota(url) {
            popupCenter(url, 'NOTA PEMBELIAN', 720, 675);
        }

        function popupCenter(url, title, w, h) {

            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
      scrollbars=yes,
      width=${w / systemZoom}, 
      height=${h / systemZoom}, 
      top=${top}, 
      left=${left}
      `
            )

            if (window.focus) newWindow.focus();
        }
    </script>
@endsection
