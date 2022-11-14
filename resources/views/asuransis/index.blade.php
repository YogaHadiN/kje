@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Asuransi

@stop
@section('page-title') 
<h2>List Semua Asuransi</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Asuransi</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
                <div class="panelRight">
                   <a href='{{ url("asuransis/create") }}' type="button" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ASURANSI Baru</a>

                </div>
            </div>
      </div>
      <div class="panel-body">
            <div class="row">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    Menampilkan <span id="rows"></span> hasil
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
                    {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                        'class'    => 'form-control',
                        'onchange' => 'clearAndSearch();return false;',
                        'id'       => 'displayed_rows'
                    ]) !!}
                </div>
            </div>
            <br></br>
		  <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="tableAsuransi">
				  <thead>
					<tr>
                        <th>
                           ID<br>
                           {!! Form::text('id', null, [
                               'class'       => 'form-control-inline form-control selectpick',
                               'id'          => 'id',
                               'onkeyup'    => 'clearAndSearch(); return false;'
                           ])!!}
                        </th>
                        <th>
                            Nama<br>
                            {!! Form::text('nama', null, [
                                'class'       => 'form-control-inline form-control selectpick',
                                'id'          => 'nama',
                                'onkeyup'    => 'clearAndSearch(); return false;'
                           ])!!}
                        </th>
						<th>
                            Alamat<br>
                            {!! Form::text('alamat', null, [
                                'class'       => 'form-control-inline form-control selectpick',
                                'id'          => 'alamat',
                                'onkeyup'    => 'clearAndSearch(); return false;'
                           ])!!}
                        </th>
						<th colspan="3">Action</th>
					</tr>
				</thead>
				<tbody id="asuransi_container">

                </tbody>
			</table>
            <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div id="page-box">
						<nav class="text-right" aria-label="Page navigation" id="paging">
						
						</nav>
					</div>
				</div>
			</div>
		  </div>
      </div>
</div>
@stop
@section('footer') 
	
{!! HTML::script('js/asuransi.js')!!}
@stop
