@extends('layout.master')

@section('title') 
Klinik Jati Elok | Supplier
@stop
@section('page-title') 
 <h2>Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Supplier</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! App\Supplier::all()->count() !!}</h3>
                </div>
                <div class="panelRight">
                    <a href="{{ url('suppliers/create') }}" class="btn btn-success"><span><i class="fa fa-plus"></i></span> Supplier Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>nama</th>
						<th>alamat</th>
                        <th>telp</th>
						<th>pic</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                  @if (count($suppliers) > 0)
                    {{-- expr --}}
                    @foreach($suppliers as $user)
                        <tr>
                            <td>{!!$user->id!!}</td>
                            <td>{!!$user->nama!!}</td>
                            <td>{!!$user->alamat!!}</td>
                            <td>{!!$user->no_telp!!}</td>
                            <td>{!!$user->pic!!}</td>
                            <td nowrap>
                                  <button type="button" class="btn btn-info btn-sm" onclick="buy(this); return false;" data-belanja-obat="1" value="Obat"><i class="fa fa-shopping-cart fa-lg"></i> Belanja</button>
                                    <a href="suppliers/{!!$user->id!!}/edit" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="suppliers/{!!$user->id!!}" class="btn btn-primary btn-sm"><i class="fa fa-info"></i> Riwayat</a>
                            </td>

                        </tr>
                   @endforeach
                  @else
                    <tr>
                      
                      <td colspan="7" class="text-center">Tidak ada Data Untuk Ditampilkan :p</td>
                    </tr>
                  @endif
                    </tr>
                </tbody>
            </table>
      </div>
</div>

<button type="button" class="btn btn-primary hide" id="btn_modal" data-toggle="modal" data-target="#pre">Small modal</button>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="pre" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <span id="supplier_name_buy" style="color:red;"></span>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => 'fakturbelanjas', 'method' => 'post'])!!}
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide">
              <div class="form-group">
                <h3><label for="" ></label></h3>
              {!! Form::text('supplier_id', null, ['class' => 'form-control', 'id' => 'supplier_id_buy'])!!}
              </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              {!! Form::label('belanja_id', 'Jenis Belanja')!!}
              {!! Form::select('belanja_id', $belanjaList, null, ['class' => 'form-control', 'id' => 'belanja_id_buy'])!!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              {!! Form::label('nomor_faktur')!!}
              {!! Form::text('nomor_faktur', null, ['class' => 'form-control', 'id' => 'nomor_faktur_buy'])!!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                {!! Form::label('Tanggal')!!}
                {!! Form::text('tanggal', null, ['class' => 'form-control tanggal'])!!}
              </div>
          </div>
        </div>
        <div class="row">
          
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button type="button" class="btn btn-success btn-block" id="dummySubmit" onclick="dummySub();return false;">submit</button> 
            {!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit'])!!}
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            
            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" aria-label="Close">cancel</button>

          </div>
        </div>
        {!!Form::close()!!}
      </div>
    </div>
  </div>
</div>
@stop
@section('footer') 
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
            $('input[name="belanja_id"]').val() == '' ||
            $('input[name="supplier_id"]').val() == '' ||
            $('select[name="staf_id"]').val() == ''

          ) {

            if($('input[name="tanggal"]').val() == '' ) {
              validasi('input[name="tanggal"]', 'Harus Diisi!!');
            } 
            if($('input[name="nomor_faktur"]').val() == '' ) {
              validasi('input[name="nomor_faktur"]', 'Harus Diisi!!');
            } 
            if($('input[name="belanja_id"]').val() == '' ) {
              validasi('input[name="belanja_id"]', 'Harus Diisi!!');
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