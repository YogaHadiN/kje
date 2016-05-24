@extends('layout.master')

@section('title') 
Klinik Jati Elok | Staf
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
            <table class="table table-bordered DT">
                <thead>
                    <tr>
                        <th class="hide">id</th>
                        <th>nama</th>
            						<th>email</th>
            						{{-- <th>tanggal_lahir</th> --}}
            						<th>alamat</th>
            						<th>telp</th>
            						{{-- <th>no_ktp</th> --}}
                        {{-- <th>terapi</th> --}}
                        @if(\Auth::user()->role == '6')
                          <th>action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($stafs as $user)
                        <tr>
                            <td class="hide">{!!$user->id!!}</td>
                            <td>{!!$user->nama!!}</td>
                            <td>{!!$user->email!!}</td>
                            {{-- <td>{!!$user->tanggal_lahir!!}</td> --}}
                            <td>{!!$user->alamat_domisili!!}</td>
                            {{-- <td>{!!$user->no_telp!!}</td> --}}
                            <td>{!!$user->ktp!!}</td>
                     {{--        <td>
                              <a href="stafs/{!!$user->id!!}/terapi" class="btn btn-info block btn-sm">10 terapi</a>
                            </td> --}}
                          @if(\Auth::user()->role == '6')
                              <td>
                                <a href="stafs/{!!$user->id!!}/edit" class="btn btn-success block btn-sm">Edit</a>
                              </td>
                          @endif
                        </tr>
                   @endforeach
                    </tr>
                </tbody>
            </table>
      </div>
</div>
@stop
@section('footer') 



@stop