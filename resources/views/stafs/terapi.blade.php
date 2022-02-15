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

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panelLeft">
               <h3> Variasi terapi : {!! count($periksas)!!} </h3>
            </div>
            <div class="panelRight">
                <h3>{!! $periksas[0]->staf !!} </h3>
            </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>terapi</th>
                        <th>jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periksas as $periksa)
                        <tr>
                            <td>{!! App\Periksa::find($periksa->id)->terapi_html !!}</td>
                            <td>{!! $periksa->jumlah !!}</td>
                        </tr>
                   @endforeach
                    </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
</div>
@stop
@section('footer') 


@stop