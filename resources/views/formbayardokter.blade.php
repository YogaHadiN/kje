@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Gaji Dokter
@stop
@section('page-title') 
 <h2>List Laporan Gaji Dokter</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Laporan Gaji Dokter</strong>
      </li>
</ol>
@stop
@section('content') 
@if (Session::has('print'))
    <div id="print">
        
    </div>
@endif
    
{!! Form::open(['url' => 'pengeluarans/bayardokter/bayar', 'method' => 'get']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Bayar Gaji Dokter</h1>
            <hr>
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Nama Dokter Yang Dibayar', ['class' => 'control-label']) !!}
                  {!! Form::select('staf_id', App\Models\Classes\Yoga::dokterList(), null, ['class' => 'form-control rq selectpick', 'data-live-search' => 'true']) !!}
				  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
				</div>
                <div class="form-group @if($errors->has('tanggal_dibayar'))has-error @endif">
				  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar', ['class' => 'control-label']) !!}
                  {!! Form::text('tanggal_dibayar', date('d-m-Y'), ['class' => 'form-control rq']) !!}
				  @if($errors->has('tanggal_dibayar'))<code>{{ $errors->first('tanggal_dibayar') }}</code>@endif
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('mulai'))has-error @endif">
						  {!! Form::label('mulai', 'Mulai', ['class' => 'control-label']) !!}
						  {!! Form::text('mulai', null, ['class' => 'form-control rq tanggal']) !!}
						  @if($errors->has('mulai'))<code>{{ $errors->first('mulai') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('jam_mulai'))has-error @endif">
						  {!! Form::label('jam_mulai', 'Jam Mulai', ['class' => 'control-label']) !!}
						  {!! Form::text('jam_mulai', '13:00:00', ['class' => 'form-control rq jam']) !!}
						  @if($errors->has('jam_mulai'))<code>{{ $errors->first('jam_mulai') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('akhir'))has-error @endif">
						  {!! Form::label('akhir', 'Akhir', ['class' => 'control-label']) !!}
						  {!! Form::text('akhir', null, ['class' => 'form-control rq tanggal']) !!}
						  @if($errors->has('akhir'))<code>{{ $errors->first('akhir') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('jam_akhir'))has-error @endif">
						  {!! Form::label('jam_akhir', 'Jam Akhir', ['class' => 'control-label']) !!}
						  {!! Form::text('jam_akhir', '13:00:00', ['class' => 'form-control rq jam']) !!}
						  @if($errors->has('jam_akhir'))<code>{{ $errors->first('jam_akhir') }}</code>@endif
						</div>
					</div>
				</div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Submit</button>
                      <button class="btn btn-success btn-block btn-lg hide" id="submit" type="submit">Submit</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <a href="{{ url('laporan_laba_rugis') }}" class="btn btn-danger btn-block btn-lg">Cancel</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
  </div>
</div>
{!! Form::close() !!}
 @include('bayar_dokters.form')
  {{-- @include('pengeluarans.tabel_bayar_dokter', ['bayar' => $bayar_dokters]) --}}
@stop
@section('footer') 
<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
{!! HTML::script('js/bayar_dokters.js')!!}
<script>
    $(function () {
        if( $('#print-struk').length ){
            window.open("{{ url('pdfs/jasadokter/' . Session::get('print')) }}", '_blank');
        }
    });
  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>
@stop

