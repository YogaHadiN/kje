@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Supplier
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
		  <div class="table-responsive">
            <table class="table table-bordered table-hover DT">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>nama</th>
						<th>alamat</th>
                        <th>telp</th>
						<th>pic</th>
						<th>created at</th>
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
							<td>{!!$user->created_at->format('d-m-Y')!!}</td>
                            <td nowrap>
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
			  <div class="form-group @if($errors->has('belanja_id'))has-error @endif">
			    {!! Form::label('belanja_id', 'Jenis Belanja', ['class' => 'control-label']) !!}
                {!! Form::select('belanja_id', $belanjaList, null, ['class' => 'form-control', 'id' => 'belanja_id_buy'])!!}
			    @if($errors->has('belanja_idnja_id'))<code>{{ $errors->first('belanja_id') }}</code>@endif
			  </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			  <div class="form-group @if($errors->has('nomor_faktur'))has-error @endif">
			    {!! Form::label('nomor_faktur', 'Nomor Faktur', ['class' => 'control-label']) !!}
                {!! Form::text('nomor_faktur', null, ['class' => 'form-control', 'id' => 'nomor_faktur_buy'])!!}
			    @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
			  </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			  <div class="form-group @if($errors->has('tanggal'))has-error @endif">
			    {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
                {!! Form::text('tanggal', null, ['class' => 'form-control tanggal'])!!}
			    @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
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
