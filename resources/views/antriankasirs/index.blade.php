@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Antrian Kasir

@stop
@section('page-title') 
<h2>Antrian Kasir</h2>
  <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Antrian Kasir</strong>
      </li>
  </ol>
@stop
@section('content') 
@if (Session::has('print'))
<div id="print-struk" class="hide">
    <a target="_blank" id="print_button" class="btn btn-primary" href="{{ url('pdfs/struk/' . Session::get('print')) }}">Print Struk</a>
</div>
@endif
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $antriankasirs->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tableAsuransi">
					  <thead>
						<tr>
							<th>id</th>
							<th>periksa_id</th>
							<th>Antrian</th>
							<th>Nama Pasien</th>
							<th>Jam Terima Resep</th>
							<th>Tanggal</th>
							<th>Pembayaran</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if ($antriankasirs->count() > 0)
						{{-- true expr --}}
								@foreach ($antriankasirs as $antriankasir)
							<tr>
									<td>{!! $antriankasir->id !!}</td>
									<td>{!! $antriankasir->periksa_id !!}</td>
									<td>
										@if(isset( $antriankasir->antrian  ))
											{!! $antriankasir->antrian->nomor_antrian !!}
										@endif
									</td>
									<td>{!! !is_null($antriankasir->periksa) ? $antriankasir->periksa->pasien->nama : ''!!}</td>
									<td>{!! $antriankasir->jam!!}</td>
									<td>{!! $antriankasir->tanggal!!}</td>
									<td>{!! !is_null($antriankasir->periksa) ? $antriankasir->periksa->asuransi->nama : ''!!}</td>
							<td>
								  {!! Form::open(['url' => 'antriankasirs/kembali/' . $antriankasir->id, 'method' => 'post'])!!}
									<a href="#" class="btn btn-warning btn-xs"  onclick="monitor_available(this); return false;">Lanjut</a>
									 <a href="{{ url('update/surveys/' . $antriankasir->periksa_id) }}" class="btn btn-warning btn-xs displayNone">Lanjutlah</a>
									 <a href="{{ url('pdfs/status/' . $antriankasir->periksa_id) }}" target="_blank" class="btn btn-info btn-xs">Print Status</a>
									 <a href="{{ url('pdfs/label_obat/' . $antriankasir->periksa_id) }}" target="_blank" class="btn btn-success btn-xs">Sticker</a>
									 {{ $adaRapidAntigen = false }}
									 {{ $adaRapidAntibodi = false }}
									 @include('antriankasirs.form_hasil_rapid', ['antriankasir' => $antriankasir->periksa])
									@include('antrianpolis.pengantar_button', [
										'antrianpoli'    => $antriankasir,
                                        'tipe_asuransi_id'    => $antriankasir->periksa->asuransi->tipe_asuransi_id,
										'posisi_antrian' => 'antriankasirs'
									])
									  {!! Form::submit('Kembalikan', ['class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm("Anda Yakin mau mengembalikan ' . $antriankasir->periksa->pasien_id . ' - ' . $antriankasir->periksa->pasien->nama. ' ke Apotek?")']) !!}
									@if ( isset($antriankasir->antrian) )
                                          @include('fasilitas.call_button', ['antrian' => $antriankasir->antrian])
									@endif
								  {!! Form::close() !!}
							</td>
						</tr>
								@endforeach
					  @else
					  <tr>
						<td colspan="8" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
					  </tr>
					  @endif

						
					</tbody>
				</table>
		  </div>
      </div>
</div>
@include('panggil')
@include('tunggu')
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
