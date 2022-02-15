@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Tambah Modal
@stop
@section('head')
    <link href="{!! asset('css/bootstrap-chosen.css') !!}" rel="stylesheet">
@stop
@section('page-title') 
 <h2>Tambah Modal</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Tambah Modal</strong>
      </li>
</ol>
@stop
@section('content') 
@if(Session::has('print'))
    <div id="print">
    </div>
@endif
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Form Tambah Modal</div>
            </div>
            <div class="panel-body">
               {!! Form::open(['url'=>'pengeluarans/rc', 'method'=> 'post']) !!} 
			   <div class="form-group @if($errors->has('kas_masuk'))has-error @endif">
					 {!! Form::label('kas_masuk', 'Kas Masuk', ['class' => 'control-label']) !!}
					 {!! Form::text('kas_masuk' , null, ['class' => 'form-control rq uangInput']) !!}
			     @if($errors->has('kas_masuk'))<code>{{ $errors->first('kas_masuk') }}</code>@endif
			   </div>
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Petugas Penginput', ['class' => 'control-label']) !!}
                 {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' =>'true']) !!}
				  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('keterangan'))has-error @endif">
				  {!! Form::label('keterangan', 'Keterangan', ['class' => 'control-label']) !!}
				 {!! Form::textarea('keterangan', null, ['class' => 'form-control textareacustom', 'placeholder' => 'Harus diisi kalau RC - PD, pemasukan dan pengeluaran, karena di bayar oleh pak yoga.. Ini pengeluarannya buat apa?']) !!}
				  @if($errors->has('keterangan'))<code>{{ $errors->first('keterangan') }}</code>@endif
				</div>
               <div class="form-group">
                   <button class="btn btn-success" onclick="dummySubmit();return false;" type="button">Submit</button>
                   {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
               </div>
               {!! Form::close() !!}
              
           </div>
       </div>
    </div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Daftar Masuk Modal</div>
            </div>
            <div class="panel-body">
                <?php echo $modals->appends(Input::except('page'))->links(); ?>
                <div class-"table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Uang Masuk</th>
                                <th>coa</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modals as $modal)
                            <tr>
                                <td>{{  $modal->created_at->format('d-m-Y')  }}</td>
                                <td class="uang">{{  $modal->modal  }}</td>
                                <td>{{  $modal->coa->coa  }}</td>
                                <td> <a class="btn btn-info btn-xs" href="{{ url('pdfs/rc/' . $modal->id) }}" target="_blank">Struk</a> </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <?php echo $modals->appends(Input::except('page'))->links(); ?>
            </div>
        </div>
	</div>
</div>
@stop
@section('footer') 
{!! HTML::script("js/chosen.jquery.js")!!}
<script type="text/javascript" charset="utf-8">
    $(function () {
          if( $('#print').length > 0 ){
            window.open("{{ url('pdfs/rc/' . Session::get('print')) }}", '_blank');
          }
    });
</script>    
<script type="text/javascript" charset="utf-8">
function dummySubmit(){
     if(validatePass()){
         $('#submit').click();
     }
}
</script>
@stop



