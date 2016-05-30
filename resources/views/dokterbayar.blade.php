@extends('layout.master')

@section('title') 
Klinik Jati Elok | Gaji Dokter

@stop
@section('head') 
    <link href="{!! asset('css/pembelian.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 
<h2>Bayar Dokter</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
        <li>
          <a href="{{ url('stafs')}}">Staf</a>
      </li>
      <li class="active">
          <strong>Gaji Dokter</strong>
      </li>
</ol>

@stop
@section('content') 
    <div class="row">
      <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Pembayaran</div>
            </div>
            <div class="panel-body">
                <h1>Dokter {{ $nama_staf }}</h1>
                {!! Form::open(['url'=>'pengeluarans/bayardokter/bayar', 'method'=> 'post']) !!} 
                <div class="form-group hide">
                  {!! Form::label('staf_id', 'Staf') !!}
                  {!! Form::text('staf_id' , $id, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('hutang', 'Jasa Dokter') !!}
                    {!! Form::text('hutang' , $total, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>  
                <div class="form-group">
                    {!! Form::label('dibayar', 'Pembayaran') !!}
                    {!! Form::text('dibayar', null, ['class' => 'form-control', 'id' => 'pembayaran']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="button" onclick="submitPage();return false;">Submit</button>
                    {!! Form::submit('Bayar', ['class' => 'btn btn-success hide', 'id'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
      </div>
    </div>
    <button class="btn btn-info" type="button" onclick="testPrint();return false;">Print</button>
<div id="content-print">
    <h1>
        Pembayaran Jasa Dokter 
    </h1>
<hr>
    <div class="box">
        <table>
            <tbody>
                <tr>
                    <td>Tanggal Mulai</td>
                    <td>{{ $mulai }}</td>
                </tr>
                <tr>
                    <td>Tanggal Akhir</td>
                    <td>{{ $akhir }}</td>
                </tr>
                <tr>
                    <td>Nama Dokter</td>
                    <td>{{ $nama_staf }}</td>
                </tr>
                <tr class="border-top">
                    <td>Total</td>
                    <td>
                        <h2 id="pembayaranDokter">
                                <!--pembayaran goes here-->
                        </h2>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        Diserahkan pada <span id="tanggal"></span> jam <span id="jam"></span>
        <table class="table-center">
            <tbody>
                <tr class="border-top">
                    <td>Diserahkan Oleh</td>
                    <td>Diterima Oleh</td>
                </tr>
                <tr class="tanda-tangan">
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>( ............. )</td>
                    <td>{{ $nama_staf }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="small-padding">
        
    </div>
</div>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>
                        Dokter : {{ $nama_staf }}
                    </h3>
                </div>
                <div class="panelRight">
                    <h3>
                        Tanggal : {{ $mulai }} s/d {{ $akhir }} 
                    </h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-striped table-bordered table-hover " id="tableAsuransi">
                  <thead>
                    <tr>
                    	<th>ID</th>
                    	<th>Tanggal</th>
                    	<th>Nama Pasien</th>
                    	<th>Asuransi</th>
                    	<th>Tunai</th>
                        <th>Piutang</th>
                        <th>Jasa Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hutangs as $hutang)
                        <tr>
                            <td>{!! $hutang->pasien_id !!}</td>
                            <td>{!! App\Classes\Yoga::updateDatePrep( $hutang->tanggal  )!!}</td>
                            <td>{!! $hutang->nama !!}</td>
                            <td>{!! $hutang->nama_asuransi !!}</td>
                            <td class="uang">{!! $hutang->tunai !!}</td>
                            <td class="uang">{!! $hutang->piutang !!}</td>
                            <td class="uang">{!! $hutang->nilai !!}</td>
                        </tr>
                    @endforeach
                </tbody>
               <tfoot>
                   <tr>
                       <td colspan="4" class="text-right"><h2>Total</h2></td>
                       <td colspan="3" class="bold"><h2 class="uang">{{ $total }}</h2></td>
                   </tr>
               </tfoot> 
            </table>
      </div>
</div>

@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    function testPrint(){
       var pembayaran = $('#pembayaran').val(); 
       $('#pembayaranDokter').html(uang( pembayaran ));
       $('#tanggal').html(date()); 
       $('#jam').html(time()); 
        print_tanpa_dialog();
    }
    
    function submitPage(){
        if(validatePass()){
         $('#submit').click();
         testPrint();
        }
    }
    
    
</script>

@stop


