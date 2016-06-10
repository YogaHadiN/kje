@extends('layout.master')

@section('title') 
Klinik Jati Elok | Test

@stop
@section('head') 
    <link href="{!! asset('css/icon.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/easyui.css') !!}" rel="stylesheet">
    <style type="text/css" media="all">
.textbox-text {
  background-color: #FFFFFF;
  background-image: none;
  border: 1px solid #e5e6e7 !important;
  border-radius: 1px !important;
  color: inherit;
  display: block;
  padding: 6px 12px !important;
  transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
  width: 100%;
  font-size: 14px !important;
}

.datagrid-wrap.panel-body{
  padding:0;
  margin:0;
}
.combo-panel.panel-body{
  padding:0;
  margin:0;
}
ul
{
list-style-type: none;
}
    </style>
@stop
@section('page-title') 
<h2>Test</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Test</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
          <div class="panel-title">
              test
          </div>
      </div>
      <div class="panel-body">
      <div class="form-group">
        <input id="cg" style="width:150px" class="form-control"></input>
      </div>
      
      
    {!! Form::open(['url'=>'test/test', 'method'=> 'post']) !!} 
    <div class="form-group">
        <button class="btn btn-info" type="submit">Submit</button>
    </div>
    
    
    {!! Form::close() !!}
      </div>
</div>


@stop
@section('footer') 
    <script src="{!! url('js/jquery.easyui.min.js') !!}"></script>
	<script type="text/javascript" charset="utf-8">
	    $(function () {
            $('#cg').combogrid({
				panelWidth:800,
				url: '{{ url("test/getmereks") }}',
				idField:'id',
				textField:'merek',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'merek',title:'Merek',width:100},
					{field:'stok',title:'Stok',width:20},
					{field:'komposisi',title:'Komposisi',align:'left',width:80},
					{field:'aturan_minum',title:'Aturan Minum',align:'left',width:80},
					{field:'fornas',title:'Fornas',align:'left',width:60}
				]]
			});
        });
	</script>
@stop

