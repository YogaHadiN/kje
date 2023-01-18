@extends('layout.master')

@section('title') 
	{{ \Auth::user()->tenant->name }} | Rekening Bank {{ $rekening->akun }}
@stop
@section('head') 
    <link href="{!! asset('css/rekening.css') !!}" rel="stylesheet" media="screen">
@stop
@section('page-title') 
<h2>Rekening Bank {{ $rekening->akun }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Rekening Bank {{ $rekening->akun_bank->akun }}</strong>
	  </li>
</ol>
@stop
@section('content') 
	{!! Form::text('akun_bank_id', $rekening->akun_bank_id, ['class' => 'form-control hide', 'id' => 'akun_bank_id']) !!}
	{!! Form::text('auth_id', Auth::id(), ['class' => 'form-control hide', 'id' => 'auth_id']) !!}
	<div class="table-responsive">
        <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                Menampilkan <span id="rows"></span> hasil
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
                {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                    'class'    => 'form-control',
                    'onchange' => 'clearAndSelectPasien();return false;',
                    'id'       => 'displayed_rows'
                ]) !!}
            </div>
          </div>
		<table id="table_rekening" class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th nowrap class="kolom_1">
						ID
					</th>
					<th nowrap class="kolom_2">
						Tanggal
                        {!! Form::text('tanggal', null, [
							'class' => 'form-control-inline tgl form-control ajaxsearchrekening',
							'onkeyup' => 'clearAndSearch();return false;',
							'id'    => 'tanggal'
						])!!}
					</th>
					<th class="kolom_3">
						Deskripsi
                        {!! Form::text('deskripsi', null, [
							'class' => 'form-control-inline deskripsi form-control ajaxsearchrekening',
							'onkeyup' => 'clearAndSearch();return false;',
							'id' => 'deskripsi'
						])!!}
					</th>
					<th nowrap class="fit-column kolom_4">
						Kredit
                        {!! Form::text('nilai', null, [
							'class' => 'form-control-inline deskripsi form-control ajaxsearchrekening',
							'onkeyup' => 'clearAndSearch();return false;',
							'id' => 'nilai'
						])!!}
					</th>
					<th colspan="2" nowrap class="kolom_4">
						Action
						{!! Form::select('pembayaran_null',[
								0 => 'Semua' ,
								1 => 'Belum Dicek' ,
								2 => 'Sudah Dicek' 
							], 0, [
							'class'   => 'form-control-inline pembayaran_null form-control ajaxsearchrekening',
							'onchange' => 'clearAndSearch();return false;',
							'id'      => 'pembayaran_null'
						])!!}
					</th>
				</tr>
			</thead>
			<tbody id="rek_container">

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
@stop
@section('footer') 
	<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
	{!! HTML::script('js/rekening.js')!!}
@stop

