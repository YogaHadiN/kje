@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Belanja Bukan Obat

@stop
@section('page-title') 
<h2>Laporan Belanja Bukan Obat</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Belanja Bukan Obat</strong>
	  </li>
</ol>

@stop
@section('head')
<style type="text/css" media="all">
	table td:first-child{
		width:1%;
	}
	.table tbody tr > td.success {
	  background-color: #dff0d8 !important;
	}

	.table tbody tr > td.error {
	  background-color: #f2dede !important;
	}

	.table tbody tr > td.warning {
	  background-color: #fcf8e3 !important;
	}

	.table tbody tr > td.info {
	  background-color: #d9edf7 !important;
	}

	.table-hover tbody tr:hover > td.success {
	  background-color: #d0e9c6 !important;
	}

	.table-hover tbody tr:hover > td.error {
	  background-color: #ebcccc !important;
	}

	.table-hover tbody tr:hover > td.warning {
	  background-color: #faf2cc !important;
	}

	.table-hover tbody tr:hover > td.info {
	  background-color: #c4e3f3 !important;
	}
</style>
@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Laporan Belanja Bukan Obat</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<div class="row">
					<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
						Ditemukan <span id="rows_found"></span> data
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						{!! Form::select('name', App\Models\Classes\Yoga::manyRows(), 15, [
							'class'    => 'form-control',
							'id'       => 'displayed_rows',
							'onchange' => 'clearAndView();return false;'
						]) !!}
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Keterangan</th>
								<th>Supplier</th>
								<th>Nilai</th>
								<th>Action</th>
							</tr>
							<tr>
								<th>  {!! Form::text('tanggal', null, [
											'class'   => 'form-control',
											'onkeyup' => 'clearAndView();return false;',
											'id'      => 'tanggal'
										]) !!} 
								</th>
								<th>  {!! Form::text('keterangan', null, [
											'class' => 'form-control',
											'onkeyup' => 'clearAndView();return false;',
											'id'    => 'keterangan'
										]) !!} 
								</th>
								<th>  {!! Form::text('supplier', null, [
											'class' => 'form-control', 
											'onkeyup' => 'clearAndView();return false;',
											'id' => 'supplier'
										]) !!} 
								</th>
								<th></th>
								<th> <button class="btn btn-danger btn-sm" type="button" onclick="clear();return false;">Clear</button> </th>
							</tr>
						</thead>
						<tbody id="content"></tbody>
					</table>
				</div>
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
	<script type="text/javascript" charset="utf-8">
		view();
		function view(key = 0){
			var base = "{{ url('/') }}";
			var nilai = $('#nilai').val();
			var keterangan = $('#keterangan').val();
			var tanggal = $('#tanggal').val();
			var supplier = $('#supplier').val();

			var displayed_rows = $('#displayed_rows').val();
			var param = { 
				'nilai':          nilai,
				'keterangan':     keterangan,
				'tanggal':        tanggal,
				'supplier':        supplier,
				'displayed_rows': displayed_rows,
				'key':            key
			};
			$.post(base + '/pengeluarans/data/ajax', param, function(hasil) {
                if( hasil.data.length ){
                    var data    = hasil.data;
                    var pages   = hasil.pages;
                    var key     = hasil.key;
                    var rows     = hasil.rows;
                    var temp    = '';
                     for (var i = 0; i < data.length; i++) {
                         temp += '<tr>';
                         temp += '<td nowrap>' + data[i].tanggal +  '</td>';
                         temp += '<td>' + data[i].keterangan +  '</td>';
                         temp += '<td> <a class="" href="{{ url('suppliers') }}/' + data[i].supplier_id + '" target="_blank"> ' + data[i].supplier +  '</a></td>';
                         temp += '<td nowrap class="text-right">' + uang( data[i].nilai ) +  '</td>';
                         temp += '<td nowrap>';
                         temp += '<a class="btn btn-info btn-xs" href="{{ url('pengeluarans/show') }}/' + data[i].pg_id + '">Detail</a>';
                         temp += ' <a class="btn btn-primary btn-xs" href="{{ url('pdfs/pengeluarans') }}/' + data[i].pg_id + '" target="_blank">Struk</a>';
                         temp += '</td>';
                         temp += '</tr>';
                     }
                    $('#content').html(temp);
                    if( data.length ){
                        $('#paging').twbsPagination({
                            startPage: parseInt(key) +1,
                            totalPages: pages,
                            visiblePages: 7,
                            onPageClick: function (event, page) {
                                view(parseInt( page ) -1);
                            }
                        });
                    }
                    $('#rows_found').html(numeral( rows ).format('0,0'));
                } else {
                    $('#content').html( '<tr class="alert-warning"><td class="text-center" colspan="5">Tidak ada data ditemukan</td></tr>');
                }
			});

		}
		function clearAndView(key = 0){
			if($('#paging').data("twbs-pagination")){
				$('#paging').twbsPagination('destroy');
			}
			view(key);
		}
		
	</script>
	
@stop

