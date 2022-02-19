@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Poli {!! ucfirst($poli) !!}

@stop
@section('page-title') 
<h2>Antrian Periksa</h2>
    <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Poli {!! ucfirst($poli) !!} </strong>
      </li>
     </ol>
@stop
@section('content') 

<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Belum Diperiksa</h3>
                </div>
                <div class="panelRight">
                    <h3>Total : {!! $antrian_periksas->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">             
		  <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableAsuransi">
                  <thead>
                    <tr>
						<th>id</th>
						<th>Antrian</th>
                        <th>Tanggal</th>
                        <th>Poli</th>
                        <th>Pembayaran</th>
                        <th>Nama Pasien</th>
                        <th>Pemeriksa</th>
                        <th class="hide">pasien_id</th>
                        <th class="hide antrian_periksa_id">id</th>
                        <th style="width:5px" nowrap>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($antrian_periksas->count() > 0)
                        @foreach ($antrian_periksas as $periksa)
                            <tr>
                              <td>{{ $periksa->antrian->id }}</td>
								@if($periksa->poli == 'estetika' && $periksa->periksaEx != null)
								<td> <a class="btn btn-xs btn-info" href="{{ url('periksa/'.$periksa->periksaEx->id . '/images') }}">Gambar</a> </td>
								@else
									<td class="nomor_antrian">
										@if(isset($periksa->antrian))
											{!! $periksa->antrian->nomor_antrian !!}
										@endif
									</td>
								@endif
								<td>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!} </br>
									{!! $periksa->jam !!}
								</td>
                                <td>
                                    {!! Form::open(['url' => 'antrianperiksas/' . $periksa->id .'/editPoli', 'method' => 'put'])!!}
										{!! Form::select('poli', $poli_list, $periksa->poli, ['class' => 'form-control', 'onchange' => 'changePoli(this);return false;']) !!}
                                    {!! Form::close() !!}
								</td>
                                <td>{!! $periksa->asuransi->nama !!}</td>
                                <td class="nama_pasien">{!! $periksa->pasien_id !!} - {!! $periksa->pasien->nama !!}</td>
								<td>
								{!! Form::select('staf_id', $staf_list, $periksa->staf_id, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'onchange' => 'changeStaf(this);return false;']) !!}
								
								</td>
                                {{--<td>{!! $periksa->staf->nama !!}</td>--}}
                                <td class="hide pasien_id">{!! $periksa->pasien_id !!}</td>
                                <td class="hide antrian_periksa_id">{!! $periksa->id !!}</td>
                                <td nowrap>
                                    {!! Form::open(['url' => 'antrianperiksas/' . $periksa->id, 'method' => 'delete'])!!}
										<a href="{!! URL::to('poli/' . $periksa->id)!!}" class="btn btn-success btn-xs">
											<span class="glyphicon glyphicon-log-in " aria-hidden="true"></span>
										</a>
                                        {!! Form::hidden('pasien_id', $periksa->pasien_id, ['class' => 'pasien_id'])!!}
                                        {!! Form::hidden('alasan', null, ['class' => 'alasan', 'id' => 'alasan' . $periksa->id])!!}
                                        <button type="button" class="btn btn-danger btn-xs" onclick="alasas_hapus(this);return false;">
											<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
										</button>
                                        @if ( isset($periksa->antrian) )
                                          @include('fasilitas.call_button', ['antrian' => $periksa->antrian])
                                        @endif
                                        @include('antrianpolis.pengantar_button', [
                                            'antrianpoli'    => $periksa,
                                            'asuransi_id'    => $periksa->asuransi_id,
                                            'posisi_antrian' => 'antrianperiksas'
                                        ])
                                      {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">TIdak ada data untuk ditampilkan :p</td>
                        </tr>
                    @endif
                </tbody>
            </table>
		  </div>
      </div>
</div>
@if (
  $antrian_kasirs->count() > 0 ||
  $antrian_apoteks->count() > 0
  )
    <div class="panel panel-success">
          <div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					<h3>Sudah Diperiksa Pasien Belum Pulang</h3>
				</div>
				<div class="panelRight">
					<h3>Total : {!! $antrian_kasirs->count() + $antrian_apoteks->count()!!}</h3>
				</div>
			</div>
          </div>
          <div class="panel-body">             
			  <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tableAsuransi">
                      <thead>
                        <tr>
                            <th class="hide">periksa_id</th>
                            <th>Antrian</th>
                            <th>Nama Pasien</th>
                            <th>Pemeriksa</th>
                            <th>Pembayaran</th>
                            <th>Surat Sakit</th>
                            <th>Rujukan</th>
                            <th style="width:5px" nowrap>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @include('antrianperiksas.form_index', ['postperiksa' => $antrian_kasirs])
                      @include('antrianperiksas.form_index', ['postperiksa' => $antrian_apoteks])
                    </tbody>
                </table>
			  	
			  </div>
          </div>
    </div>
@endif
@include('antrianpolis.modalalasan', ['antrianperiksa' => 'fasilitas/antrianperiksa/destroy'])
@include('panggil')
@stop
@section('footer') 
  <script src="{!! asset('js/antrianperiksa.js') !!}"></script>
  <script src="{!! asset('js/panggil.js') !!}"></script>
@stop
