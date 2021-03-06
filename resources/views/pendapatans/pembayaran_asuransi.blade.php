@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pembayaran Asuransi
@stop
@section('page-title') 
 <h2>Pembayaran Asuransi</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Pembayaran Asuransi</strong>
      </li>
</ol>
@stop
@section('content') 
@if ( Session::has('print') )
    <div id="print">
    </div>
@endif

{!! Form::open(['url' => 'pengeluarans/pembayaran_asuransi/show', 'method' => 'get']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Pembayaran Asuransi</h1>
            <hr>
				<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
				  {!! Form::label('asuransi_id', 'Asuransi', ['class' => 'control-label']) !!}
				  {!! Form::select('asuransi_id', $asuransi_list , null , ['class' => 'selectpick form-control rq', 'data-live-search' => 'true']) !!}
				  @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('mulai'))has-error @endif">
				  {!! Form::label('mulai', 'Mulai', ['class' => 'control-label']) !!}
                  {!! Form::text('mulai', null, ['class' => 'form-control rq tanggal']) !!}
				  @if($errors->has('mulai'))<code>{{ $errors->first('mulai') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('akhir'))has-error @endif">
				  {!! Form::label('akhir', 'Akhir', ['class' => 'control-label']) !!}
                  {!! Form::text('akhir', null, ['class' => 'form-control rq tanggal']) !!}
				  @if($errors->has('akhir'))<code>{{ $errors->first('akhir') }}</code>@endif
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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">List Semua Pembayaran Asuransi</div>
            </div>
            <div class="panel-body">
                <div class-"table-responsive">
                    <?php echo $pembayarans->appends(Input::except('page'))->links(); ?>
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th>Nama Asuransi</th>
                                <th>Periode</th>
                                <th>Pembayaran</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Tujuan Kas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayarans as $pemb)
                            <tr>
                                <td>{{  $pemb->created_at  }}</td>
                                <td>{{  $pemb->asuransi->nama  }}</td>
                                <td>{{  $pemb->mulai->format('d-m-Y')  }} s/d {{  $pemb->akhir->format('d-m-Y')  }}</td>
                                <td class="uang">{{  $pemb->pembayaran }}</td>
                                <td>{{  $pemb->tanggal_dibayar->format('d-m-Y')  }}</td>
                                <td>{{ $pemb->kas_coa_id }}-{{  $pemb->coa->coa }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <?php echo $pembayarans->appends(Input::except('page'))->links(); ?>
                </div>
                
                
            </div>
        </div>
        
    </div>
    
</div>

@stop
@section('footer') 
<script>
    $(function () {
          if( $('#print').length > 0 ){
            window.open("{{ url('pdfs/pembayaran_asuransi/' . Session::get('print')) }}", '_blank');
          }
    });

  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>

@stop


