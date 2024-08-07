@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Pesanan') }}</h1>

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

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <div class="btn-group mb-2">
                        <button onclick="addProduk()" class="btn btn-xs btn-primary btn-flat">+</button>
                        <button onclick="pelangganBaru()" class="btn btn-xs btn-info btn-flat">Transaksi Baru</button>
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
                        <input type="hidden" name="subtotal1" id="subtotal1" value="">
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
                                <select name="diskon" id="diskon" class="form-control">
                                    <option value="0">0%</option>
                                    <option value="1">1%</option>
                                    <option value="3">3%</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                </select>
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
                        </div>


                    </form>
                    @if (session('success'))
                        <button class="btn btn-info" onclick="cetakNota('{{ route('cetakNota') }}')">Cetak Nota</button>
                    @endif


                </div>
            </div>
        </div>

    </div>

    {{-- modal transaksi baru --}}
    <div class="modal fade" id="modalTransaksiBaru" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('Transaksi Baru') }}</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pelanggan.new') }}">
                        <div class="form-group">
                            <label for="nama_pelanggan">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input class="form-control" name="nomor_telepon" id="nomor_telepon"  type="number" min="0" max="99999999999"
                            onKeyUp="if(this.value>0899999999999){this.value='0815381513721';}else if(this.value<0){this.value='0';}">
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

    {{-- modal Tambah Produk --}}
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


    {{-- modal nota --}}
    <div class="modal fade" id="modalNota" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h5 class="modal-title" id="staticBackdropLabel">{{ __('Silahkan Print Nota Pembayaran') }}</h5>

                    </center>
                </div>
                <div class="modal-body">
                    <center>
                        <button class="btn btn-info" onclick="cetakNota('{{ route('cetakNota') }}')">Cetak Nota</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            $('#modalNota').modal('show')
        </script>
    @endif

    <script type="text/javascript">
        let table, table1;

        $(function() {
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
                        alert('Maaf Data yang anda minta melebihi stok');

                    });

            });

            $('#diterima').on('change', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }
                loadForm($('#subtotal').val(), $(this).val())

            })

        });

        function pelangganBaru() {
            $('#modalTransaksiBaru').modal('show')
        }

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
            var alert = confirm("Yakin Ingin Menghapus data!!");
            if (alert) {
                $.post(`{{ url('/penjualan/hapusData') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete',
                        'id': id
                    })
                    .done(response => {
                        table1.ajax.reload(() => loadForm($('#diskon').val(), $('#diterima').val()));

                    })
                    .fail(errors => {
                        alert('tidak dapat menghapus data');
                    });
            }
        }

        function loadForm(diskon, diterima) {
            var subtotal = ($('#subtotal').val());
            $('#totalrp').val('Rp. ' + subtotal);
            $('#bayarrp').val('Rp. ' + subtotal);

            if (diterima == 'undifined') {
                diterima == 0;
            }

            $.post(`{{ url('/penjualanDetail/loadForm') }}/${$('#diskon').val()}/${$('#subtotal').val()}/${diterima}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'get',
                })
                .done(response => {
                    $('#kembali').val('Rp. ' + response.kembali);
                    $('#diskon').val(response.diskon);
                    $('#totalrp').val('Rp. ' + response.total);
                    $('#bayarrp').val('Rp. ' + response.subtotal);
                    $('#total').val(response.db_total);
                    $('#subtotal1').val(response.db_subtotal);
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
