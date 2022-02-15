@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Users

@stop
@section('page-title') 
 <h2>List User</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List User</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $users->count() !!}</h3>
                </div>
                <div class="panelRight">
                    <a href="{!! url('users/create') !!}" class="btn btn-success"><span><i class="fa fa-plus"></i></span> User Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover DT">
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>email</th>
							<th>role</th>
							<th>aktif</th>
							<th>action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{!!$user->id!!}</td>
								<td>{!!$user->username!!}</td>
								<td>{!!$user->email!!}</td>
								<td>{!!$user->peran!!}</td>
								<td>{!!$user->keaktifan!!}</td>
							<td><a href="users/{!!$user->id!!}/edit" class="btn btn-info btn-block ">EDIT</a>
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


@stop
