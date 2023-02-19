@extends('layout.master')

@section('title') 
Klinik Jati Elok | Cek List By Cek List Ruangan

@stop
@section('page-title') 
<h2>Cek List By Cek List Ruangan</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek List By Cek List Ruangan</strong>
            </li>
</ol>

@stop
@section('content') 
    <h1>{{ ucwords(  $ceks->first()->cekListRuangan->cekList->cek_list  ) }} {{ $ceks->first()->cekListRuangan->ruangan->nama }}</h1>
    <?php echo $ceks->appends(Input::except('page'))->links(); ?>
    <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th nowrap>Tanggal</th>
                    <th nowrap>jumlah</th>
                    <th class="w-30-percent">Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $ceks as $c )
                    <tr>
                        <td nowrap>{{ $c->created_at->format( 'Y-m-d' ) }}</td>
                        <td>{{ $c->jumlah }}</td>
                        <td>
                            <a href="{{ \Storage::disk('s3')->url($c->image) }}" target="_blank"> 
                                <img src="{{ \Storage::disk('s3')->url($c->image) }}" alt="" class="img-rounded upload"> 
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <?php echo $ceks->appends(Input::except('page'))->links(); ?>
@stop
@section('footer') 
    
@stop
