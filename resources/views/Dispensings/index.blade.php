@extends('layout.master')

@section('title') 
Klinik Jati Elok | Dispensing Obat

@stop
@section('page-title') 
<h2>Dispensing</h2>
<ol class="breadcrumb">
  <li>
      <a href="{{ url('laporans') }}">Home</a>
  </li>
  <li class="active">
      <strong>Dispensing Obat</strong>
  </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! count($dispensings) !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover DT" id="tableAsuransi">
                <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Rak</th>
                    	<th>Merek Terdaftar</th>
                    	<th>keluar</th>
                    	<th>masuk</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach ($dispensings as $dispensing)
                		<tr>
  	                	<td>{!! App\Classes\Yoga::updateDatePrep($dispensing->tanggal) !!}</td>
                      <td>{!! $dispensing->rak_id !!}</td>
  	                	<td>
                          @foreach($raks->find($dispensing->rak_id)->merek as $merek)
                            {!! $merek->merek !!}, <br>
                          @endforeach
                     </td>
  	                	<td>{!! $dispensing->keluar !!}</td>
  	                	<td>{!! $dispensing->masuk !!}</td>
                  	</tr>
                	@endforeach
                </tbody>
            </table>
      </div>
</div>
@stop
@section('footer') 
	
@stop