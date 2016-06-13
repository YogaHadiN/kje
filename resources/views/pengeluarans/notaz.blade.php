@extends('layout.master')

@section('title') 
Klinik Jati Elok | Checkout Kasir
@stop
@section('page-title') 
 <h2>Cehckout Kasir (Nota Z)</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Cehckout Kasir (Nota Z)</strong>
      </li>
</ol>
@stop
@section('content') 


  <div class="row">
      <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Entri Nota Z</div>
                </div>
                <div class="panel-body">
                    <button class="btn btn-primary btn-lg btn-block" type="button" onclick="validate();return false;"> Checkout </button>
                   {!! Form::open(['url'=>'pengeluarans/nota_z', 'method'=> 'post']) !!} 
                       <div class="form-group">
                           {!! Form::submit('Submit', ['class' => 'hide', 'id'=>'submit']) !!}
                       </div>
                   {!! Form::close() !!}
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">List Checkout (Nota Z)</div>
                </div>
                <div class="panel-body">
                    <?php echo $checkouts->appends(Input::except('page'))->links(); ?>
                    <div class-"table-responsive">
                        <table class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Modal Awal</th>
                                    <th>Uang Keluar</th>
                                    <th>Uang Masuk</th>
                                    <th>Hasil Penjualan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkouts as $checkout)
                                <tr>
                                    <td>{{  $checkout->created_at->format('d-m-Y')  }}</td>
                                    <td class="uang">{{  $checkout->modal_awal  }}</td>
                                    <td class="uang">{{  $checkout->uang_keluar  }}</td>
                                    <td class="uang">{{  $checkout->uang_masuk  }}</td>
                                    <td class="uang">{{  $checkout->hasil_penjualan  }}</td>
                                    <td> <a href="{{ url('pengelurans/checkout/' . $checkout->id) }}" class="btn btn-primary btn-xs">details</a> </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <?php echo $checkouts->appends(Input::except('page'))->links(); ?>
                </div>
            </div>
      </div>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <div class="panel panel-success">
              <div class="panel-heading">
                  <div class="panel-title">Informasi Kasir</div>
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed">
                          <thead>
                              <tr>
                                  <td>Modal Awal</td>
                                  <td class="uang">{{ $modal_awal }}</td>
                              </tr>
                              <tr>
                                  <td>Uang di Kasir</td>
                                  <td class="uang">{{ $uang_di_kasir }}</td>
                              </tr>
                              <tr>
                                  <td>Uang Masuk</td>
                                  <td class="uang">{{ $total_uang_masuk }}</td>
                              </tr>
                              <tr>
                                  <td>Uang Keluar</td>
                                  <td class="uang">{{ $total_uang_keluar }}</td>
                              </tr>
                          </thead>
                      </table>

                  </div>
              </div>
          </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Panel Oke</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Jenis Tarif</th> 
                                <th>Jumlah</th> 
                                <th>Nilai</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($table as $trx)
                            <tr>
                                <td>{!! $trx['coa'] !!}</td>        
                                <td>{!! $trx['jumlah'] !!}</td>        
                                <td class="uang">{!! $trx['nilai'] !!}</td>        
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
  </div>
   <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      </div>
</div>
    
    
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    function validate(){
        if(validatePass()){
         $('#submit').click();
        }
    }
</script>
@stop


