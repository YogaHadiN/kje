@extends('layout.master')

@section('title') 
Klinik Jati Elok | Formulas

@stop
@section('page-title') 

 <h2>List Semua Formula</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="#">Home</a>
      </li>
      <li class="active">
          <strong>List Semua Formula</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $formulas->count() !!}</h3>
                </div>
                <div class="panelRight">
                   <a href="formulas/create" type="button" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> FORMULA Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover DT" id="tableAsuransi">
                  <thead>
                    <tr>
                    	<th>ID</th>
                    	<th>Contoh Merek</th>
                    	<th>Komposisi</th>
                    	<th>Sediaan</th>
                        <th>Kontraindikasi</th>
                    	<th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach ($formulas as $asuransi)
            		<tr>

                        <td>{!! $asuransi->id !!}</td>
                        <td>{!! $asuransi->rak[0]->merek[0]->merek !!}</td>
                        <td>
                          @foreach($asuransi->komposisi as $komp)
                          {!! $komp->generik->generik !!} {!!$komp->bobot!!}, <br>
                          @endforeach
                        </td>
                        <td>{!! $asuransi->sediaan !!}</td>
                        <td>{!! $asuransi->kontraindikasi !!}</td>
	                	<td>
                            {!! HTML::link('formulas/'. $asuransi->id , "Show", ['class' => 'btn-sm btn btn-info btn-block'])!!}
                            {!! HTML::link('formulas/'. $asuransi->id . '/edit', "Edit", ['class' => 'btn-sm btn btn-default btn-block'])!!}
                        </td>
                	</tr>
                	@endforeach
                	
                </tbody>
            </table>
      </div>
</div>
@stop
@section('footer') 
	
@stop