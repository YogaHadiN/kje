@extends('layout.master')

@section('title') 
Klinik Jati Elok | Belanja Obat
@stop
@section('page-title') 
 <h2>Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Belanja Obat</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="panelLeft">
                        Belanja Obat
                    </div>
                    <div class="panelRight">
                        <button class="btn btn-success btn-block" type="submit" data-toggle="modal" data-target="#create_supplier">Supplier tidak ditemukan</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['url'=>'fakturbelanjas', 'method'=> 'post']) !!} 
                    {!! Form::text('belanja_id', 1, ['class' => 'hide']) !!} 
                    <div class="form-group">
                      {!! Form::label('supplier_id', 'Supplier') !!}
                      {!! Form::select('supplier_id', App\Classes\Yoga::supplierList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('nomor_faktur', 'Nomor Faktur') !!}
                      {!! Form::text('nomor_faktur' , null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('tanggal', 'Tanggal') !!}
                      {!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control tanggal']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::submit('Belanja Obat', ['class' => 'btn btn-primary btn-block btn-lg']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="alert alert-info">
            <ul>
                <li>Belanja obat Adalah untuk input pembelian obat yang masuk dalam daftar stok barang</li>
                <li>Untuk pembelian / pengeluaran uang yang tidak masuk dalam stok barang contoh : belanja sayur pilihannya masuk ke dalam <a href="{{ url('suppliers/belanja_bukan_obat') }}" class="btn btn-info">Belanja Bukan Obat</a> </li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Daftar Belanja Obat</div>
            </div>
            <div class="panel-body">
                <div class-"table-responsive">
                    <table class="table table-hover table-condensed DT">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Supplier</th>
                                <th>Nomor Faktur</th>
                                <th>Jenis Belanja</th>
                                <th>Jumlah Item</th>
                                <th>Total Biaya</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if($fakturbelanjas->count())
                            @foreach ($fakturbelanjas as $faktur_beli)
                                <tr>
                                <td><div>{!!App\Classes\Yoga::updateDatePrep($faktur_beli->tanggal)!!}</div></td>
                                <td><div>{!!$faktur_beli->supplier->nama!!}</div></td>
                                <td><div>{!!$faktur_beli->nomor_faktur!!}</div></td>
                                <td><div>{!!$faktur_beli->belanja->belanja!!}</div></td>
                                <td><div>{!!$faktur_beli->items!!} pcs</div></td>
                                <td><div class="uang">{!!$faktur_beli->totalbiaya!!}</div></td>
                                <td>
                                    @if ($faktur_beli->belanja->belanja == 'Belanja Obat')
                                        <a href="{{ url('pembelians/show/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail</a>
                                    @else
                                        <a href="{{ url('pengeluarans/show/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail</a>
                                    @endif
                                        <a class="btn btn-info btn-xs" href="{{ url('pdfs/pembelian/' . $faktur_beli->id) }}" target="_blank">Print Struk</a>
                                </td>
                            </tr>
                            @endforeach
                          @else 
                            <td colspan="6" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="create_supplier">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buat Supplier Baru</h4>
      </div>
      <div class="modal-body">
          @include('suppliers.form', ['submit' => 'SUBMIT'])
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
@stop

@section('footer') 
<script type="text/javascript" charset="utf-8">
    var base = "{{ url('/') }}";
</script>
<script src="{{ url('js/supplier_ajax_create.js') }}"></script>

<script>
  jQuery(document).ready(function($) {
  });

  function buy(control){
    var supplier_id = $(control).closest('tr').find('td:first-child').html();
    var supplier_name = $(control).closest('tr').find('td:nth-child(2)').html();

    console.log($(control).attr('data-belanja-obat'));

    $('#tipe_belanja').html($(control).val());
    $('#supplier_id_buy').val(supplier_id);
    $('#supplier_name_buy').html(supplier_name);

    $('#btn_modal').click();
  }

  function dummySub(){

        if (
            $('input[name="tanggal"]').val() == '' ||
            $('input[name="nomor_faktur"]').val() == '' ||
            $('select[name="belanja_id"]').val() == '' ||
            $('input[name="supplier_id"]').val() == '' ||
            $('select[name="staf_id"]').val() == ''

          ) {

            if($('input[name="tanggal"]').val() == '' ) {
              validasi('input[name="tanggal"]', 'Harus Diisi!!');
            } 
            if($('input[name="nomor_faktur"]').val() == '' ) {
              validasi('input[name="nomor_faktur"]', 'Harus Diisi!!');
            } 
            if($('select[name="belanja_id"]').val() == '' ) {
              validasi('select[name="belanja_id"]', 'Harus Diisi!!');
            } 
            if($('input[name="supplier_id"]').val() == '' ) {
              validasi('input[name="supplier_id"]', 'Harus Diisi!!');
            } 
            if($('select[name="staf_id"]').val() == '' ) {
              validasi('select[name="staf_id"]', 'Harus Diisi!!');
            }
        } else {
          var supplier_id = $('#supplier_id_buy').val();
          var nomor_faktur = $('#nomor_faktur_buy').val();

          var param = {
            'supplier_id'  : supplier_id,
            'nomor_faktur' : nomor_faktur,
            '_token' : '{{ Session::token() }}'
          }; 

          $.post('{{ url("suppliers/ajax/ceknotalama") }}', param, function(data, textStatus, xhr) {
            data = $.trim(data);
            if (data == '1') {
              var r = confirm('Sudah ada nomor_faktur dengan supplier yang sama. Anda akan mengedit faktur yang sudah ada. Lanjutkan? Jika mau buat baru tekan Cancel dan ganti nomor_faktur nya');

              if (r) {
                $('#submit').click();
              }
            } else {
              $('#submit').click();
            }
          });
        }

  }
</script>

@stop

