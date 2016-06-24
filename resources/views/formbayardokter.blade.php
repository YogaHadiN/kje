@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Gaji Dokter
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
{!! Form::open(['url' => 'pengeluarans/bayardokter/bayar', 'method' => 'get']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Bayar Gaji Dokter</h1>
            <hr>
                <div class="form-group">
                  {!! Form::label('staf_id', 'Staf') !!}
                  {!! Form::select('staf_id', App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('mulai') !!}
                  {!! Form::text('mulai', null, ['class' => 'form-control rq tanggal']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('akhir') !!}
                  {!! Form::text('akhir', null, ['class' => 'form-control rq tanggal']) !!}
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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Pembayaran Dokter</div>
            </div>
            <div class="panel-body">
            <?php echo $bayar_dokters->appends(Input::except('page'))->links(); ?>
                <div class-"table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Nama Dokter</th>
                                <th>Periode</th>
                                <th>Nilai</th>
                                <th>Petugas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bayar_dokters as $b)
                            <tr>
                                <td>{{  $b->created_at->format('d-m-Y')  }}</td>
                                <td>{{  $b->created_at->format('H:i:s')  }}</td>
                                <td>{{  $b->staf->nama }}</td>
                                <td>{{  $b->mulai->format('d-m-Y') }} s/d {{ $b->akhir->format('d-m-Y') }}</td>
                                <td class="uang">{{  $b->bayar_dokter }}</td>
                                <td>{{  $b->petugas->nama }}</td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="{{ url("pdfs/jasadokter/" . $b->id) }}" target="_blank">Struk</a> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <?php echo $bayar_dokters->appends(Input::except('page'))->links(); ?>
                </div>
                
            </div>
        </div>
        
    </div>
    
</div>

{!! Form::close() !!}
@stop
@section('footer') 
<script>
  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>
@stop

