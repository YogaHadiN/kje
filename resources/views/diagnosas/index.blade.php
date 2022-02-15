 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Diagnosa

 @stop
 @section('page-title') 
<h2>Diagnosa</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Diagnosa</strong>
      </li>
</ol>
 @stop
 @section('content') 
  <div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!!$diagnosas->count()!!}</h3>
                </div>
                <div class="panelRight">

                </div>
            </div>
      </div>
      <div class="panel-body">
        <div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#GroupByDiagnosa" aria-controls="GroupByDiagnosa" role="tab" data-toggle="tab">Group By Diagnosa</a></li>
    <li role="presentation"><a href="#GroupByICD" aria-controls="GroupByICD" role="tab" data-toggle="tab">Group By ICD</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="GroupByDiagnosa">
      <br>
	  <div class="table-responsive">
		<table class="table table-striped table-bordered table-hover DT" id="tableAsuransi">
			  <thead>
				<tr>
					<th>ID</th>
					<th>Diagnosa</th>
					<th>Kode ICD</th>
					<th>Diagnosa ICD</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				 @foreach ($diagnosas as $diagnosa)
				 <tr>
				   <td>
					 {!! $diagnosa->id !!}
				   </td>
				   <td>
					 {!! $diagnosa->diagnosa !!}
				   </td>
				   <td>
					 {!! $diagnosa->icd10_id !!}
				   </td>
				   <td>
					 {!! $diagnosa->icd10->diagnosaICD !!}
				   </td>
				   <td>
					  {!! HTML::link('diagnosas/' . $diagnosa->id . '/edit', 'Edit', ['class' => 'btn btn-sm btn-info'])!!}
				   </td>
				 </tr>
			   @endforeach
			</tbody>
		</table>
	  </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="GroupByICD">
      <br>
	  <div class="table-responsive">
			<table class="table table-striped table-bordered table-hover DT" id="tableAsuransi">
				  <thead>
					<tr>
						<th>ID</th>
						<th>Diagnosa</th>
						<th>Kode ICD</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($icds as $k => $icd)
					 <tr>
					   <td>
						 {!! $k !!}
					   </td>
					   <td>
						@foreach($icd['diagnosa'] as $diag)
						 {!! $diag !!} <br>
						 @endforeach
					   </td>
					   <td>
						 {!! $icd['diagnosa_icd'] !!}
					   </td>
					   <td>
						  {!! HTML::link('diagnosas/' . $icd['diagnosa_id'] . '/edit', 'Edit', ['class' => 'btn btn-sm btn-info'])!!}
					   </td>
					 </tr>
				   @endforeach
				</tbody>
			</table>
	  </div>
    </div>
  </div>

</div>
         
      </div>
</div>

    @stop
    @section('footer') 


    @stop
