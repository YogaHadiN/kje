@extends('layout.master')

@section('title') 
Klinik Jati Elok | Antrian Beli Obat

@stop
@section('page-title') 
<h2>Antrian Belanja</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Cari Faktur Belanja Obat</strong>
      </li>
</ol>
@stop
@section('content') 
@if (Session::has('print'))
   <div id="print-struk">
       
   </div> 
@endif

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $fakturbelanjas->count() !!}</h3>
                </div>
                <div class="panelRight">
					<a href="{{ url('suppliers/belanja_obat') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	Belanja Persediaan Obat</a>
                  </div>
                </div>
               
            </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover DT" id="tabel_faktur_beli">
                  <thead>
                    <tr>
					  <th>tanggal</th>
                      <th>Nama Supplier</th>
                      <th>Nomor Faktur</th>
                      <th>Jenis Belanja</th>
                      <th>Sumber Uang</th>
				    	<th>Total Biaya</th>
                    	<th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if($fakturbelanjas->count())
                  	@foreach ($fakturbelanjas as $faktur_beli)
                		<tr>
                        <td><div>{!!App\Classes\Yoga::updateDatePrep($faktur_beli->tanggal)!!}</div></td>
                        <td><div>{!!$faktur_beli->supplier->nama!!}</div></td>
                        <td><div>{!!$faktur_beli->nomor_faktur!!}</div></td>
                        <td><div>{!!$faktur_beli->belanja->belanja!!}</div></td>
                        <td><div>{!!$faktur_beli->sumberUang->coa!!}</div></td>
                        <td><div class="uang">{!!$faktur_beli->totalbiaya!!}</div></td>
                        <td>
                            @if ($faktur_beli->belanja->belanja == 'Belanja Obat')
                                <a href="{{ url('pembelians/show/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail / Edit</a>
                            @endif
                                <a class="btn btn-info btn-xs" href="{{ url('pdfs/pembelian/' . $faktur_beli->id) }}" target="_blank">Print Struk</a>
                        </td>
                  	</tr>
                  	@endforeach
                  @else 
                    <td colspan="6" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
                  @endif
                </tbody>
            </table>
      </div>
</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    $(function () {
        if( $('#print-struk').length ){
            window.open("{{ url('pdfs/pembelian/' . Session::get('print')) }}", '_blank');
        }
    });
</script>

@stop
