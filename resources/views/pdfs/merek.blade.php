<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pendapatan</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

    </head>
    <body>
        <div class="row" id="content-print">
            <div class="box title-print text-center border-bottom">

				<h1>{{ env("NAMA_KLINIK") }}</h1>
				<h5>
					{{ env("ALAMAT_KLINIK") }} <br>
					Telp : {{ env("TELPON_KLINIK") }}  
				</h5>
				<h2 class="text-center border-top"></h2>
        
            </div>
            <div class="box border-bottom">
                    <table class="table table-bordered DT actionAutoWidth" id="tableAsuransi">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Merek</th>
                          <th>Komposisi</th>
                          <th>Rak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mereks as $merek)
                        <tr>
                             <td>{!! $merek->id !!}</td>
                             <td>{!! $merek->merek !!}</td>
                             <td>
                              @foreach($merek->rak->formula->komposisi as $komp)
                                {!! $komp->generik->generik !!} {!!$komp->bobot!!} <br> 
                              @endforeach
                              </td>
                              <td nowrap>
                                  {!! $merek->rak->id !!}
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </body>
</html>
