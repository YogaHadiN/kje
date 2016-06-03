@extends('layout.master')

@section('title') 
Klinik Jati Elok | Tambah Modal
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
<div class="row">
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Form Tambah Modal</div>
            </div>
            <div class="panel-body">
               {!! Form::open(['url'=>'pengeluarans/rc', 'method'=> 'post']) !!} 
               <div class="form-group">
                   {!! Form::label('kas_masuk', 'Kas Masuk') !!}
                     <div class="input-group">
                          <div class="input-group-addon">Rp. </div>
                           {!! Form::text('kas_masuk' , null, ['class' => 'form-control']) !!}
                     </div>
               </div>
               <div class="form-group">
                   {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
               </div>
               {!! Form::close() !!}
              
           </div>
       </div>
    </div>
</div>
@stop
@section('footer') 
    
            {!! HTML::script("js/chosen.jquery.js")!!}
<script type="text/javascript" charset="utf-8">
    $(function () {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
</script>    
@stop



