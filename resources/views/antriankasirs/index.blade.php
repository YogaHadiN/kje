@extends('layout.master')
@section('title') 
Klinik Jati Elok | Antrian Kasir

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
            <table class="table table-bordered table-hover" id="tableAsuransi">
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
                  @if (count($antriankasirs) > 0)
                    {{-- true expr --}}
                        	@foreach ($antriankasirs as $antriankasir)
              		<tr>
        						<td>{!! $antriankasir->id !!}</td>
        						<td>{!! $antriankasir->pasien->nama!!}</td>
        						<td>{!! $antriankasir->jam!!}</td>
								<td>{!! $antriankasir->tanggal!!}</td>
        						<td>{!! $antriankasir->asuransi->nama!!}</td>
	                	<td>
                      @if ($antriankasir->lewat_kasir == '0')
                          {!! Form::open(['url' => 'update/kembali/' . $antriankasir->id, 'method' => 'post'])!!}
                            <a href="{{ url('kasir/' . $antriankasir->id) }}" class="btn btn-primary btn-xs">Prosesi</a>
						  <a href="{{ url('antriankasirs/pengantar/' . $antriankasir->id . '/edit') }}" class="btn btn-success btn-xs">{{ $antriankasir->antars->count() }} pengantar</a>
                            {!! Form::submit('Kembalikan', ['class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm("Anda Yakin mau mengembalikan ' . $antriankasir->pasien_id . ' - ' . $antriankasir->pasien->nama. ' ke ruang periksa?")']) !!}

                          {!! Form::close() !!}
                      @else 
                          {!! Form::open(['url' => 'update/kembali3/' . $antriankasir->id, 'method' => 'post'])!!}
                            <a href="#" class="btn btn-warning btn-xs"  onclick="monitor_available(this); return false;">Lanjut</a>
                             <a href="{{ url('update/surveys/' . $antriankasir->id) }}" class="btn btn-warning btn-xs displayNone">Lanjutlah</a>
                             <a href="{{ url('pdfs/status/a4/' . $antriankasir->id) }}" target="_blank" class="btn btn-info btn-xs">Print A4</a>

							  <a href="{{ url('antriankasirs/pengantar/' . $antriankasir->id . '/edit') }}" class="btn btn-success btn-xs">{{ $antriankasir->antars->count() }} pengantar</a>
                            {!! Form::submit('Kembalikan', ['class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm("Anda Yakin mau mengembalikan ' . $antriankasir->pasien_id . ' - ' . $antriankasir->pasien->nama. ' ke Apotek?")']) !!}
                          {!! Form::close() !!}
                      @endif
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
@include('tunggu')
@stop
@section('footer') 
	<script>
       $(function () {
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
            alert('monitor sedang digunakan oleh ' + data['periksa_id'] + ' - ' + data['nama']);
            $('#pleaseWaitDialog').modal('hide');
          }   
              
        });
      }
        
    </script>
@stop
