@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Staf
@stop
@section('page-title') 
 <h2>List Of All Staf</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Staf</strong>
      </li>
</ol>
@stop
@section('content') 
@if (Session::has('print'))
<div class="hide" id="print-struk">
    
</div>
@endif

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                </div>
                <div class="panelRight">
                    <a href="{{ url('stafs/create') }}" class="btn btn-success"><span><i class="fa fa-plus"></i></span> Staf Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered DT">
					<thead>
						<tr>
							<th class="hide">id</th>
							<th>nama</th>
							<th>email</th>
							<th>alamat</th>
							<th>telp</th>
							<th> Jasa Dokter </th>
							<th>action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($stafs as $user)
							<tr>
								<td class="hide">{!!$user->id!!}</td>
								<td>{!!$user->nama!!}</td>
								<td>{!!$user->email!!}</td>
								<td>{!!$user->alamat_domisili!!}</td>
								<td>{!!$user->no_telp!!}</td>
								<td>
									@if ($user->titel == 'dr' )
										<a href="{{ url('pengeluarans/bayardoker/'. $user->id) }}" class="btn btn-primary block btn-sm">Jasa Dokter</a>
									@endif
								</td>
								<td nowrap>
									@if( \Auth::id() == '28' )
									<a href="stafs/{!!$user->id!!}/gaji" class="btn btn-info btn-sm">Daftar Gaji</a>
									@endif
									<a href="stafs/{!!$user->id!!}/edit" class="btn btn-success btn-sm">Edit</a>
								</td>
							</tr>
					   @endforeach
						</tr>
					</tbody>
				</table>
		  </div>
      </div>
</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    $(function () {
        if( $('#print-struk').length ){
            window.open("{{ url('pdfs/jasadokter/' . Session::get('print')) }}", '_blank');
        }
    });
</script>


@stop
