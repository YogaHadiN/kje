@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Tidak Dirujuk

@stop
@section('page-title') 
<h2>List Semua Diagnosa Tidak Dirujuk</h2>
<ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Tidak Dirujuk</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $tidakdirujuks->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover DT" id="tableAsuransi">
					  <thead>
						<tr>
							<th>icd10</th>
							<th>Diagnosa Awam</th>
							<th>Diagnosa ICD</th>

						</tr>
					</thead>
					<tbody>
						 @foreach ($tidakdirujuks as $tidakdirujuk)
						 <tr>
						   <td>
							 {!! $tidakdirujuk->icd10_id !!}
						   </td>
						   <td>
							 {!! $tidakdirujuk->diagnosa !!}
						   </td>
						   <td>
							 {!! $tidakdirujuk->icd10['diagnosaICD'] !!}
						   </td>
						 </tr>
						 {{-- expr --}}
					   @endforeach
					</tbody>
				</table>
		  </div>
      </div>
</div>


@stop
@section('footer') 
	
@stop
