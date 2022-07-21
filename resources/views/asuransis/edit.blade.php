 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Edit Asuransi

 @stop
 @section('page-title') 
<h2>Edit Asuransi</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('asuransis')}}">Asuransi</a>
      </li>
      <li class="active">
          <strong>Edit Asuransi</strong>
      </li>
</ol>
 @stop
 @section('content') 
  {!! Form::model($asuransi, array(
        "url"   => "asuransis/". $asuransi->id ,
        "class" => "m-t", 
        "role"  => "form",
		"files"=> "true",
        "method"=> "put"
        ))!!}
		@include('asuransis/form', [
		  'tanggal'         => App\Models\Classes\Yoga::updateDatePrep($asuransi->tanggal_berakhir),
		  'submit'          => 'Update',
		  'tarifs'          => json_encode($tarifs),
		  'umumstring'      => $asuransi->umumstring,
		  'gigistring'      => $asuransi->gigistring,
		  'rujukanstring'   => $asuransi->rujukanstring,
		  'hapus'           => true,
		  'penagihanstring' => $asuransi->penagihanstring
		])
{!! Form::close()!!}
@if(\Auth::user()->role_id == '6')
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {!!Form::open(['url' => 'asuransis/' . $asuransi->id, 'method' => 'delete'])!!}
            {!! Form::submit('Delete', ['class' => 'btn btn-lg btn-block btn-warning', 'onclick' => 'return confirm("Anda yakin mau menghapus asuransi ' . $asuransi->nama. ' ?");'])!!}
        {!! Form::close()!!}
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <a href="{{ url('asuransis/riwayat/' . $asuransi->id) }}" class="btn btn-lg btn-block btn-success">Riwayat Pemeriksaan</a>
    </div>
</div>
@endif
@stop
@section('footer') 
	@include('asuransis/footer', ['tarifs' => $tarifs])
	{!! HTML::script('js/asuransi_upload.js')!!}
@stop
