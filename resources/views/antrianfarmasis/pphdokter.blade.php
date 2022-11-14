@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Pph21 Dokter

@stop
@section('page-title') 
<h2>Pph21 Dokter</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pph21 Dokter</strong>
	  </li>
</ol>
@stop
@section('content') 
<div class="alert alert-info">
	Pelaporan Pph21 akan dicetak setiap tanggal 2 bulan berikutnya
</div>
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panelLeft">
				<div class="panel-title">Pph21 Dokter</div>
			</div>
			<div class="panelRight">
				Pph21 Dokter
			</div>
		</div>
		<div class="panel-body">
            <?php echo $pphs->appends(Input::except('page'))->links(); ?>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Nama Dokter</th>
							<th>Menikah</th>
							<th>Npwp</th>
							<th>Ada Penghasilan Lain</th>
							<th>Cetak</th>
						</tr>
					</thead>
					<tbody>
						@if($pphs->count() > 0)
							@foreach( $pphs as $k=>$p )
								{!! Form::open(['url' => 'stafs/pph21/dokter/' . $p->id . '/' . $p->staf_id, 'method' => 'post']) !!}
								<tr>
								<td>{{ App\Models\Classes\Yoga::bulan( $p->bulan ) }} {{ $p->tahun }}</td>
									<td>{{ $p->staf->nama }}</td>
									<td>{{ $p->staf->status_pernikahan }}</td>
									<td>{{ $p->npwp }}</td>
									@if(isset(  $p->ada_penghasilan_lain  ))
									<td>{{ $p->penghasilan_lain }}</td>
									<td> 
										@if( isset( $p->ada_penghasilan_lain ) )
											<a class="btn btn-primary btn-xs" target="_blank" href="{{ url('pdfs/pph21dokter/' . $p->id) }}">Cetak Pph21</a> 
										@endif
									</td>
									@else
										<td colspan="2"> 
											{!! Form::select('ada_penghasilan_lain', App\Models\Classes\Yoga::adaPenghasilanLainList(), $p->ada_penghasilan_lain, [
												'class' => 'form-control',
												'onchange' => 'changeAdaPenghasilanLain(this); return false;',
											]) !!}
										</td>
									@endif
									<td class="hide">
										{!! Form::submit('Submit', ['class' => 'btn btn-success', 'class' => 'submit']) !!}
									</td>
								</tr>
							{!! Form::close() !!}
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="5">Tidak ada data untuk ditampilkan</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
            <?php echo $pphs->appends(Input::except('page'))->links(); ?>
		</div>
	</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	function changeAdaPenghasilanLain(control){
		$(control).closest('tr').find('.submit').click();
	}
</script>

@stop
