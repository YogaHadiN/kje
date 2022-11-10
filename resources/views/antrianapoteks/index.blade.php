@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Antrian Apotek

@stop
@section('page-title') 
<h2>Antrian Apotek</h2>
  <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Antrian Apotek</strong>
      </li>
  </ol>
@stop
@section('content') 
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $antrianapoteks->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tableAsuransi">
					  <thead>
						<tr>
							<th>id</th>
							<th>periksa id</th>
                            @if( \Auth::user()->tenant->nursestation_availability )
                                <th>Antrian</th>
                            @endif
							<th>Nama Pasien</th>
							<th>Jam Terima Resep</th>
							<th>Tanggal</th>
							<th>Pembayaran</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if ($antrianapoteks->count() > 0)
								@foreach ($antrianapoteks as $antrianapotek)
							<tr>
									<td>{!! $antrianapotek->id !!}</td>
									<td>{!! $antrianapotek->periksa_id !!}</td>
                                    @if( \Auth::user()->tenant->nursestation_availability )
                                        <td>
                                            @if(isset( $antrianapotek->antrian  ))
                                                {!! $antrianapotek->antrian->nomor_antrian !!}
                                            @endif
                                        </td>
                                    @endif
									<td>{!! $antrianapotek->periksa->pasien->nama!!}</td>
									<td>{!! $antrianapotek->jam!!}</td>
									<td>{!! $antrianapotek->tanggal!!}</td>
									<td>{!! $antrianapotek->periksa->asuransi->nama!!}</td>
							<td>
							  {!! Form::open(['url' => 'antrianapoteks/kembali/' . $antrianapotek->id, 'method' => 'post'])!!}
								<a href="{{ url('kasir/' . $antrianapotek->periksa_id) }}" class="btn btn-primary btn-xs">Proses</a>
								@include('antrianpolis.pengantar_button', [
									'antrianpoli'    => $antrianapotek,
                                    'tipe_asuransi_id'    => $antrianapotek->periksa->asuransi->tipe_asuransi_id,
									'posisi_antrian' => 'antrianapoteks'
								])
								@include('antriankasirs.form_hasil_rapid', ['antriankasir' => $antrianapotek])
								 {!! Form::submit('Kembalikan', ['class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm("Anda Yakin mau mengembalikan ' . $antrianapotek->periksa->pasien_id . ' - ' . $antrianapotek->periksa->pasien->nama. ' ke ruang periksa?")']) !!}
							  {!! Form::close() !!}
						</td>
						</tr>
                            @endforeach
					  @else
					  <tr>
						<td colspan="5" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
					  </tr>
						{{-- false expr --}}
					  @endif
					</tbody>
				</table>
		  </div>
      </div>
</div>
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
