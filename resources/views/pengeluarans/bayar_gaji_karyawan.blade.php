@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pembayaran Gaji Karyawan
@stop
@section('page-title') 
 <h2>Pembayaran Gaji Karyawan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Pembayaran Gaji Karyawan</strong>
      </li>
</ol>
@stop
@section('content') 
@if ( Session::has('print') )
    <div id="print" class="hide">
        {{ Session::get('print') }}
    </div>
@endif

{!! Form::open(['url' => 'pengeluarans/bayar_gaji_karyawan', 'method' => 'post']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Pembayaran Gaji Karyawan</h1>
            <hr>
				<div class="form-group @if($errors->has('coa_id'))has-error @endif">
				  {!! Form::label('coa_id', 'Sumber Dana', ['class' => 'control-label']) !!}
                  {!! Form::select('coa_id', $sumber_kas_lists, null , ['class' => 'form-control']) !!}
				  @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Nama Staf Yang Dibayarkan Gajinya', ['class' => 'control-label']) !!}
                  {!! Form::select('staf_id',App\Classes\Yoga::stafList(), null , ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
				  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('bulan'))has-error @endif">
				  {!! Form::label('bulan', 'Periode Bulan', ['class' => 'control-label']) !!}
                  {!! Form::text('bulan', null, ['class' => 'form-control rq bulanTahun']) !!}
				  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('tanggal_dibayar'))has-error @endif">
				  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar', ['class' => 'control-label']) !!}
                  {!! Form::text('tanggal_dibayar', null, ['class' => 'form-control rq tanggal']) !!}
				  @if($errors->has('tanggal_dibayar'))<code>{{ $errors->first('tanggal_dibayar') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('gaji_pokok'))has-error @endif">
				  {!! Form::label('gaji_pokok', 'Gaji Pokok', ['class' => 'control-label']) !!}
                  <div class="input-group">
                      <span class="input-group-addon">Rp. </span>
                      {!! Form::text('gaji_pokok', null, ['class' => 'form-control rq']) !!}
                  </div>
				  @if($errors->has('gaji_pokok'))<code>{{ $errors->first('gaji_pokok') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('bonus'))has-error @endif">
				  {!! Form::label('bonus', 'Bonus', ['class' => 'control-label']) !!}
                  <div class="input-group">
                      <span class="input-group-addon">Rp. </span>
                      {!! Form::text('bonus', null, ['class' => 'form-control rq']) !!}
                  </div>
				  @if($errors->has('bonus'))<code>{{ $errors->first('bonus') }}</code>@endif
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
                <div class="panel-title">List Semua Pembayaran Gaji Karyawan</div>
            </div>
            <div class="panel-body">
                <div class-"table-responsive">
                    <?php echo $pembayarans->appends(Input::except('page'))->links(); ?>
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nama Staf</th>
                                <th>Periode</th>
                                <th>Total Gaji</th>
                                <th>Sumber Kas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayarans as $pemb)
                            <tr>
                                <td>{{  $pemb->id }}</td>
                                <td>{{  $pemb->staf->nama  }}</td>
                                <td>{{  $pemb->mulai->format('d-m-Y') }} s/d {{ $pemb->akhir->format('d-m-Y')  }}</td>
                                <td class="uang">{{  $pemb->gaji_pokok + $pemb->bonus }}</td>
                                <td>{{  $pemb->coa->coa }}</td>
								<td> <a class="btn btn-success btn-sm" href="{{ url('pdfs/bayar_gaji_karyawan/' . $pemb->id) }}" target="_blank">Struk</a> </td>
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
        window.open("{{ url('pdfs/bayar_gaji_karyawan/' . Session::get('print')) }}", '_blank');
      }
    });
      function dummySubmit(){
        if (validatePass()) {
          $('#submit').click();
        }
      }
</script>

@stop



