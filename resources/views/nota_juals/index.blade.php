@extends('layout.master')

@section('title') 
Klinik Jati Elok | Antrian Beli Obat

@stop
@section('page-title') 
<h2>Antrian Faktur Obat</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Antrian Faktur</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $faktur_belis->count() !!}</h3>
                </div>
                <div class="panelRight">
                   <a href="#" type="button" class="btn btn-success" data-toggle="modal" data-target="#faktur_insert"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Daftarkan Faktur</a>

                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover" id="tabel_faktur_beli">
                  <thead>
                    <tr>
                    	<th>id</th>
          						<th>tanggal</th>
          						<th>Nama Supplier</th>
          						<th>Nomor Faktur</th>
                    	<th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach ($faktur_belis as $faktur_beli)
              		<tr>
                      <td><div>{!!$faktur_beli->id!!}</div></td>
                      <td><div>{!!$faktur_beli->tanggal!!}</div></td>
                      <td><div>{!!$faktur_beli->supplier->nama!!}</div></td>
                      <td><div>{!!$faktur_beli->nomor_faktur!!}</div></td>
                      <td><div><a href="pembelians/{!! $faktur_beli->id !!}" class="btn-sm btn btn-primary btn-xs">Proses</a>
	                        {!! HTML::link('#','hapus', ['class' => 'btn btn-danger btn-xs', 'onclick' => 'rowDel(this); return false;'])!!}
                      </div></td>
                	</tr>
                	@endforeach
                </tbody>
            </table>
      </div>
</div>
<div class="modal fade bs-example-modal-md" id="faktur_insert" tabindex="-1" role="dialog" aria-labelledby="kriteriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="panel-title">
                      <div class="panelLeft">
                        <h4 class="modal-title" id="kriteriaLabel">Daftarkan Faktur</h4>
                      </div>
                      <div class="panelRight">
                      </div>
                    </div>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            {!! Form::open(['url' => 'pasiens', 'id' => 'faktur_insertForm', 'method' => 'post', 'autocomplete' => 'off'])!!}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                         <div class="form-group">
                                            {!! Form::label('supplier_id', 'Nama Supplier')!!}
                                            {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control selectpick'])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('tanggal')!!}
                                            {!! Form::text('tanggal', null, ['class' => 'form-control tanggal'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('nomor_faktur', 'Nomor Faktur')!!}
                                            {!! Form::text('nomor_faktur', null, ['class' => 'form-control'])!!}
                                        </div>
                                    </div>
                                </div>	
                                <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      {!! HTML::link('suppliers/create', 'Supplier Tidak Ada?', ['class' => ''])!!}
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success displayNone" id="dummySubmit">Submit</button>
                            <button type="button" class="btn btn-success" id="submitFaktur">Submit</button>
                            <button type="button" class="btn btn-danger" id="closeModal" data-dismiss="modal">Cancel</button>
                 {!! Form::close() !!}
            </div>
        </div>
        </div>
    </div>
@stop
@section('footer') 

<script>
	$(document).ready(function() {

    $('select[name="merek_id"]').closest('tr').find('.btn-white').focus();


		$('#dummySubmit').click(function(){

			if (
				$('input[name="tanggal"]').val() == '' ||
				$('input[name="nomor_faktur"]').val() == '' ||
				$('select[name="supplier_id"]').val() == ''
			) {

				if ($('input[name="tanggal"]').val() == '') {
					validasi('input[name="tanggal"]', 'Harus Diisi!!');
				}
				if ($('input[name="nomor_faktur"]').val() == '') {
					validasi('input[name="nomor_faktur"]', 'Harus Diisi!!');
				}
				if ($('select[name="supplier_id"]').val() == '') {
					validasi('select[name="supplier_id"]', 'Harus Diisi!!');
				}
			} else{
				$('#submitFaktur').click();
			}

		});



		$('#submitFaktur').click(function(e) {
			var tanggal = $('input[name="tanggal"]').val();
			var nomor_faktur = $('input[name="nomor_faktur"]').val();
			var supplier_id = $('select[name="supplier_id"]').val();

			$.post('faktur_belis', {'tanggal' : tanggal, 'nomor_faktur' : nomor_faktur, 'supplier_id' : supplier_id, '_token' :'{{ Session::token() }}'}, function(data) {
        data = $.trim(data);
				if(data){
					MyArray = JSON.parse(data);

					var temp = '';

					temp += '<tr>';
					temp += '<td class="yellow"><div>' + MyArray.id + '</div></td>';
					temp += '<td class="yellow"><div>' + MyArray.tanggal + '</div></td>';
					temp += '<td class="yellow"><div>' + MyArray.supplier + '</div></td>';
					temp += '<td class="yellow"><div>' + MyArray.nomor_faktur + '</div></td>';
					temp += '<td class="yellow"><div><a class="btn-sm btn btn-primary btn-xs" href="{{ url("pembelians/' + MyArray.id + '") }}">Proses</a> <a href="#" class="btn btn-danger btn-xs" onclick="rowDel(this);return false;">hapus</a><div></td>'
					temp += '</tr>';

					console.log(temp);

          $('#faktur_insert').modal('hide');
          $('select [name="supplier_id"]').val('').selectpicker('refresh');
          $('input [name="tanggal"]').val('');
          $('input [name="nomor_faktur"]').val('');

					$('#tabel_faktur_beli tbody').append(temp);
					$('#tabel_faktur_beli tbody tr:last-child td div').hide().slideDown('500', function() {
						$(this).closest('td').addClass('loaded');
					});
				} else {
					alert('Input Gagal!!');
				}
			});
		});

    
	});

function rowDel(control){

  var id = $(control).closest('tr').find('td:first-child div').html();
  var rowIndex = $(control).closest('tr').index() + 1;
  var r = confirm('Anda yakin mau menghapus faktur beli ' + id);
  if(r){
    $.post('delete/faktur_belis', {'id': id, '_token' : '{{ Session::token() }}'}, function(data) {
      data = $.trim(data);
      if(data == '1'){
          $('#tabel_faktur_beli tbody tr:nth-child(' + rowIndex + ')').find('div').slideUp('500', function() {
            $('#tabel_faktur_beli tbody tr:nth-child(' + rowIndex + ')').hide();
          });
      } else {
        alert('gagal menghapus');
      }
      /*optional stuff to do after success */
    });
  }
}
</script>
	
@stop
