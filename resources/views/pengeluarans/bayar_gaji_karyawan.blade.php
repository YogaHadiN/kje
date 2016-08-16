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
                <div class="form-group">
                  {!! Form::label('coa_id', 'Sumber Dana') !!}
                  {!! Form::select('coa_id', $sumber_kas_lists, null , ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('staf_id', 'Nama Staf Yang Dibayarkan Gajiny') !!}
                  {!! Form::select('staf_id',App\Classes\Yoga::stafList(), null , ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('bulan', 'Periode') !!}
                  {!! Form::text('bulan', null, ['class' => 'form-control rq bulanTahun']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar') !!}
                  {!! Form::text('tanggal_dibayar', null, ['class' => 'form-control rq tanggal']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('gaji_pokok', 'Gaji Pokok') !!}
                  <div class="input-group">
                      <span class="input-group-addon">Rp. </span>
                      {!! Form::text('gaji_pokok', null, ['class' => 'form-control rq']) !!}
                  </div>
                </div>
                <div class="form-group">
                  {!! Form::label('bonus', 'Bonus') !!}
                  <div class="input-group">
                      <span class="input-group-addon">Rp. </span>
                      {!! Form::text('bonus', null, ['class' => 'form-control rq']) !!}
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
                                <th>Tanggal Pembayaran</th>
                                <th>Nama Staf</th>
                                <th>Periode</th>
                                <th>Gaji Pokok</th>
                                <th>Bonus</th>
                                <th>Total</th>
                                <th>Sumber Kas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayarans as $pemb)
                            <tr>
                                <td>{{  $pemb->tanggal_dibayar->format('d-m-Y') }}</td>
                                <td>{{  $pemb->staf->nama  }}</td>
                                <td>{{  $pemb->mulai->format('d-m-Y') }} s/d {{ $pemb->akhir->format('d-m-Y')  }}</td>
                                <td class="uang">{{  $pemb->gaji_pokok }}</td>
                                <td class="uang">{{  $pemb->bonus }}</td>
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



