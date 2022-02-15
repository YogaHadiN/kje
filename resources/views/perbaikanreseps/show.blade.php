@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Perbaikan Resep

@stop
@section('page-title') 
 <h2>List Perbaikan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>List Perbaikan Resep</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Perbaikan Resep</h3>
                </div>
                <div class="panelRight">
                    <h3>Total : {!! $perbaikans->total() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <?php echo $perbaikans->appends(Input::except('page'))->links(); ?>

			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Informasi</th>
							<th>sebelum</th>
							<th>sesudah</th>
						</tr>
					</thead>
					<tbody>
						@foreach($perbaikans as $perbaikan)
							<tr>
								<td>{!!App\Models\Classes\Yoga::updateDatePrep($perbaikan->periksa->tanggal)!!}
									<br><br>
									{!!$perbaikan->periksa->pasien->nama!!}
									<br><br>
									{!!$perbaikan->periksa->asuransi->nama!!} <br>
									{!! $perbaikan->periksa->staf->nama!!}
									{!! $perbaikan->created_at !!}
								</td>
								<td>
									{!! $perbaikan->terapihtml1 !!}
								</td>
								<td>
									{!! $perbaikan->terapihtml2 !!}
								</td>
					   @endforeach
						</tr>
					</tbody>
				</table>
			</div>
            <?php echo $perbaikans->appends(Input::except('page'))->links(); ?>

      </div>
</div>
@stop
@section('footer') 


@stop

