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
                    <h3>Total : {!! count($antrian_periksas) !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">             
		  <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableAsuransi">
                  <thead>
                    <tr>
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
                    @if (count($antrian_periksas) > 0)
                        @foreach ($antrian_periksas as $periksa)
                            <tr>
                                @if($periksa->poli == 'Poli Estetika' && $periksa->periksa_id != null)
								<td> <a class="btn btn-xs btn-info" href="{{ url('periksa/'.$periksa->periksa_id . '/images') }}">Gambar</a> </td>
								@else
									<td class="nomor_antrian">
										@if(isset($periksa->nomor_antrian))
											{!! $periksa->prefix !!}{!! $periksa->nomor_antrian !!}
										@endif
									</td>
								@endif
								<td>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!} </br>
									{!! $periksa->jam !!}
								</td>
                                <td>
                                    {!! Form::open(['url' => 'antrianperiksas/' . $periksa->id .'/editPoli', 'method' => 'put'])!!}
										{!! Form::select('poli', $poli_list, $periksa->poli_id, ['class' => 'form-control', 'onchange' => 'changePoli(this);return false;']) !!}
                                    {!! Form::close() !!}
								</td>
                                <td>{!! $periksa->nama_asuransi !!}</td>
                                <td class="nama_pasien">{!! $periksa->pasien_id !!} - {!! ucwords($periksa->nama_pasien) !!}</td>
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
                                        @if ( isset($periksa->nomor_antrian) )
                                            <style type="text/css" media="screen">
                                                .btn.disabled {
                                                    pointer-events: auto;
                                                }
                                            </style>
                                            <button type="button"
                                                class="btn btn-info btn-xs
                                                    @if(!str_contains( $periksa->created_at , date('Y-m-d')))
                                                        disabled		
                                                    @endif
                                                " 
                                                    @if(!str_contains( $periksa->created_at , date('Y-m-d')))
                                                         data-toggle="tooltip" data-placement="bottom" title="Bukan antrian hari ini"
                                                    @endif
                                                onclick="panggil('{{ $periksa->antrian_id }}', 'pendaftaran');return false;">
                                                  <span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span>
                                            </button>
                                        @endif
                                        @if(
                                            $periksa->tanggal <= date('Y-m-d 00:00:00') 
                                            && $periksa->asuransi_id == '32'
                                          )
                                              <a href="{{ url( 'antrianperiksas/pengantar/' . $periksa->id ) }}" class="btn btn-success btn-xs">{{ $periksa->jumlah_pengantar }} pengantar</a>		
                                        @endif
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
