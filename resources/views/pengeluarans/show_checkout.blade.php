@extends('layout.master')

@section('title') 
Klinik Jati Elok | Checkout Detail
@stop
@section('page-title') 
 <h2>Cehckout Detail</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li>
          <a href="{!! url('pengeluarans/notaz')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Cehckout Detail</strong>
      </li>
</ol>
@stop
@section('content') 
  <div class="row">
      <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="panelLeft">
                            <h3>Ceckout Detail</h3>
                        </div> 
                        <div class="panelRight">
                            <h3>{{  $checkout->created_at->format('d-m-Y')  }}</h3>
                            
                        </div>
                    </div>
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
                                    <td>{{  $checkout->modal_awal  }}</td>
                                    <td>{{  $checkout->uang_keluar  }}</td>
                                    <td>{{  $checkout->uang_masuk  }}</td>
                                    <td>{{  $checkout->hasil_penjualan  }}</td>
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


