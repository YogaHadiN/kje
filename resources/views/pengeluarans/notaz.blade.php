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
                                    <th>Jam</th>
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
                                    <td>{{ $checkout->created_at->format('H:i:s') }}</td>
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
      </div>
  </div>
   <div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
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
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($table as $trx)
                                @if ($trx['coa'] != 'Kas di tangan')
                                    <tr>
                                        <td>{!! $trx['coa'] !!}</td>        
                                        <td class="text-right">{!! $trx['jumlah'] !!}</td>        
                                        <td class="uang">{!! $trx['nilai'] !!}</td>        
                                        <td> <a href='{!! url("pengeluarans/nota_z/detail/" . json_encode($trx["jurnalable_id"])) !!}' class="btn btn-info btn-sm">Detail</a> </td>
                                         
                                    </tr>
                               @endif
                            @endforeach
                            <tr>
                                <td colspan="3">Semua Transaksi Kasir</td>        
                                <td> <a href='{!! url("pengeluarans/nota_z/detail/" . json_encode( $all_id )) !!}' class="btn btn-info btn-sm">Detail</a> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    
    
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    function validate(){
        var r = confirm('Anda akan melakukan Checkout yang hanya bisa dilakukan oleh Admin. Klik tombol OK hanya jika anda yakin apa yang anda lakukan');
        if(r){
            if(validatePass()){
             $('#submit').click();
            }
        }
        
    }
</script>
@stop


