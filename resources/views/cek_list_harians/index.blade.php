@extends('layout.master')

@section('title') 
Klinik Jati Elok | Cek List Harian

@stop
@section('page-title') 
<h2>Cek List Harian</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek List Harian</strong>
            </li>
</ol>

@stop
@section('content') 
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Cek List</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ruang Periksa 1</td>
                        <td>Belum</td>
                        <td> <a href="{{ url('cek_list_harians/ruang_periksa_satu') }}" target="_blank" class="btn btn-info btn-xs"> Action</a> </td>
                    </tr>
                    <tr>
                        <td>Ruang Periksa 2</td>
                        <td>Belum</td>
                        <td> <a href="{{ url('cek_list_harians/ruang_periksa_dua') }}" target="_blank" class="btn btn-info btn-xs"> Action</a> </td>
                    </tr>
                    <tr>
                        <td>Ruang Periksa 3</td>
                        <td>Belum</td>
                        <td> <a href="{{ url('cek_list_harians/ruang_periksa_tiga') }}" target="_blank" class="btn btn-info btn-xs"> Action</a> </td>
                    </tr>
                    <tr>
                        <td>Ruang Periksa Gigi</td>
                        <td>Belum</td>
                        <td> <a href="{{ url('cek_list_harians/ruang_periksa_gigi') }}" target="_blank" class="btn btn-info btn-xs"> Action</a> </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    
@stop
@section('footer') 
    
@stop
