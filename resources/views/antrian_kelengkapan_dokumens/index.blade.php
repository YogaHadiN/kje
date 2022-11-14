@extends('layout.master')
@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Antrian Kelengkapan Dokumen
@stop
@section('page-title') 
<h2>Antrian Kelengkapan Dokumen</h2>
  <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Antrian Kelengkapan Dokumen</strong>
      </li>
  </ol>
@stop
@section('content') 
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $antrian->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover DTsWithI" id="tableAsuransi">
					  <thead>
						<tr>
							<th>id</th>
							<th>Nama Pasien</th>
							<th>Jam Terima Resep</th>
							<th>Tanggal</th>
							<th>Pembayaran</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if ($antrian->count() > 0)
						{{-- true expr --}}
								@foreach ($antrian as $ant)
							<tr>
								<td>{!! $ant->periksa_id !!}</td>
								<td>{!! $ant->periksa->pasien->nama!!}</td>
								<td>{!! $ant->jam!!}</td>
								<td>{!! $ant->tanggal!!}</td>
								<td>{!! $ant->periksa->asuransi->nama!!}</td>
							<td>
								@include('antriankasirs.form_hasil_rapid', ['antriankasir' => $ant])
								<a href="{{ url('antrian_kelengkapan_dokumens/' . $ant->id) }}" class="btn btn-success btn-xs">Proses</a>
							</td>
						</tr>
								@endforeach
					  @else
					  <tr>
						<td colspan="5" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
					  </tr>
					  @endif
					</tbody>
				</table>
		  </div>
      </div>
</div>
@include('tunggu')
@include('panggil')
@stop
@section('footer') 
	<script>
       $(function () {
		   @if(Session::has('kasir_submit'))
			   window.open("{!! url('pdfs/status/' . Session::get('kasir_submit') ) !!}", '_blank');
		   @endif
            if( $('#print-struk').length > 0 ){
                window.open("{{ url('pdfs/struk/' . Session::get('print')) }}", '_blank');
            }
       }); 
      function monitor_available(control){
        $('#pleaseWaitDialog').modal({backdrop: 'static', keyboard: false});
        $.post('{{ url("monitor/avail")}}', {}, function(data) {
          data = JSON.parse(data);
          var periksa_id = $(control).closest('tr').find('td:first-child').html();
          if (data['periksa_id'] == periksa_id || data['periksa_id'] == '0') {
            $(control).closest('td').find('.displayNone').get(0).click(); //sudah bisa
          }else{
			Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text:'monitor sedang digunakan oleh ' + data['periksa_id'] + ' - ' + data['nama']
			});
            $('#pleaseWaitDialog').modal('hide');
          }   
        });
      }
    </script>
    <script src="{!! asset('js/panggil.js') !!}"></script>
@stop
