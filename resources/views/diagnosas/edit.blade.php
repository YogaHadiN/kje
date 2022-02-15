 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Diagnosa

 @stop
 @section('head')
  <style>
    th.rotate {
  /* Something you can count on */
  height: 100px;
  white-space: nowrap;
}

th.rotate > div {
  transform: 
    /* Magic Numbers */
    translate(25px, 51px)
    /* 45 is really 360 - 45 */
    rotate(270deg);
  width: 30px;
}
th.rotate > div > span {
  padding: 5px 10px;
  right:10px;
}
  </style>
 @stop
 @section('page-title') 
<h2>Edit Diagnosa</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('diagnosas')}}">Diagnosa</a>
      </li>
      <li class="active">
          <strong>Edit Diagnosa</strong>
      </li>
</ol>
 @stop
 @section('content') 
  {!! Form::open(array(
        "url"   => "diagnosas/". $diagnosa->id ,
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "put"
        ))!!}
<div class="row">
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
      <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Edit Diagnosa</h3>
          </div>
          <div class="panel-body">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="">Diagnosa</label>
                        <input type="text" class="form-control" id="" placeholder="Input field" value="{!! $diagnosa->diagnosa !!}">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="">ICD 10 Code</label>
                        <input type="text" class="form-control" id="" placeholder="Input field" disabled value="{!!$diagnosa->icd10_id!!}">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="">Diagnosa ICD</label>
                        <textarea class="form-control textareacustom" id="" placeholder="Input field" disabled>{!!$diagnosa->icd10->diagnosaICD!!}</textarea>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">

    </div>
</div>

<div>
<div class="panel panel-warning">
    <div class="panel-heading">
      <h3 class="panel-title">SOP TERAPI by ICD</h3>
    </div>
    <div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
			<thead>
			  <tr>
				<th>Asuransi</th>
				@foreach($berat_badans as $bb)
				  <th class="rotate"><div><span>{!! $bb->berat_badan !!} {!!$bb->id!!}</span></div></th>
				@endforeach
			  </tr>
			</thead>
			<tbody>
			  @foreach($asuransis as $asuransi)
			  <tr>
				<td>{!! $asuransi->nama !!} {!!$asuransi->id!!}</td>
				@foreach($berat_badans as $bb)
				<td> 
				   {!! $bb->id!!}
				</td>
			   @endforeach
			  </tr>
			  @endforeach
			</tbody>
		  </table>
		</div>

    </div>
</div>

</div>

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    {!! Form::submit('Submit', ['class' => 'btn btn-success btn-block btn-lg'])!!}
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    {!! HTML::link('diagnosas', 'Cancel', ['class' => 'btn btn-danger btn-block btn-lg'])!!}
  </div>
</div>

  
{!! Form::close()!!}

@stop
@section('footer') 

@stop
