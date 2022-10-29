<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>
    {!! HTML::style('css/bootstrap.min.css')!!}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
    {{-- {!! HTML::style('css/animate.css')!!} --}}
    {!! HTML::style('css/style.css')!!}
	<style type="text/css" media="all">
		.text-center {
			text-align: center;
		}
		.fit-width{
			width: 100%;
		}
        .btn-whatsapp {
            padding:20px 40px;
            font-size: 40px;
            border-radius: 20px;
        }
        .vertical-center {
          margin: 0;
          position: absolute;
          top: 50%;
          -ms-transform: translateY(-50%);
          transform: translateY(-50%);
        }
        .modal-ku {
          width: 430px;
          margin: auto;
        }
        tbody {
            width: 100%;
        }

		h2{
			font-size : 20px;
		}
		h3{
			font-size : 40px;
		}
		.margin-top {
			margin-top: 10px;
		}
		.bold {
			font-weight: bold;
		}
		table {
			font-size: 13px;
			text-align: left !important;
		}
		.box-border{
			border: 1px solid black;
		}
		.underline{
			text-decoration: underline;
		}
		.paddingTop{
			margin-top: 20px;
		}
		.welcome_title {
			font-size: 30px;
		}
		.alamat_klinik {
			font-size: 20px;
		}

		@media screen {
			#section-to-print {
				visibility: hidden;
			}
		} 
		@media print {
		  body * {
			visibility: hidden;
		  }
		.receipt { 
			width: 80mm 
		} 
		@media print { body.receipt { width: 80mm } } /* this line is needed for fixing Chrome's bug */
			html body.receipt .sheet { 
				width: 80mm; 
			} 
			html, body {
			  height:100vh; 
			  margin: 0 !important; 
			  padding: 0 !important;
			  overflow: hidden;
			}
		  #section-to-print, #section-to-print * {
			visibility: visible;
		  }
		  #section-to-print {
			position: absolute;
			left: 0;
			top: 0;
		  }
		}
		.imgKonfirmasi {
			width : 300px;
			height : 300px;
		}
		.superbig{
			font-size:50px;
		}

		.superbig-button{
			padding : 50px;
			font-size : 50px;
			border-radius : 20px;
		}
		.content-secondary{
			padding : 0px 150px;
		}
		h1{
			font-size: 100px !important;
			margin-bottom : 50px;
		}
		h2{
			font-size: 75px !important;
			margin-bottom : 30px;
		}

        .small{
			font-size: 25px !important;
        }
	</style>

</head>

<body class="receipt gray-bg A5" onclick="returnFocus();return false;">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@if (Session::has('pesan'))
				{!! Session::get('pesan')!!}
			@endif
		</div>
	</div>
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="content-secondary">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<h1>Klinik Jati Elok</h1>
					{{-- <h1>{{ \Auth::user()->tenant->name }}</h1> --}}
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<h2>Pilih Antrian</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="showWhatsaappForm(1)" class="btn btn-lg btn-block btn-success superbig-button">Dokter Umum</button>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="showWhatsaappForm(3)" class="btn btn-lg btn-block btn-info superbig-button">Bidan</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="showWhatsaappForm(7)" class="btn btn-lg btn-block btn-primary superbig-button">Rapid Test</button>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button type="button" onclick="showWhatsaappForm(8)" class="btn btn-lg btn-block btn-success superbig-button">Medical Checkup</button>
				</div>
			</div>
                <!-- Modal -->
                <div class="modal fade" id="noWhatsapp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog modal-ku" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title text-center" id="myModalLabel">Masukkan Nomor Handphone Anda</h3>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                  <h3 id="no_wa">

                                  </h3>
                              </div>
                              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" id="backspace">
                                  {{-- <button type="button" onclick="backspace(this);return false;" id="backspace_button"> --}}
                                        <svg onclick="backspace(this);return false;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M576 128c0-35.3-28.7-64-64-64H205.3c-17 0-33.3 6.7-45.3 18.7L9.4 233.4c-6 6-9.4 14.1-9.4 22.6s3.4 16.6 9.4 22.6L160 429.3c12 12 28.3 18.7 45.3 18.7H512c35.3 0 64-28.7 64-64V128zM271 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                                  {{-- </button> --}}
                              </div>
                          </div>
                          <div class="table-responsive">
                              <table class="table table-hover table-condensed table-bordered">
                                  <tbody>
                                      <tr>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">1</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">2</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">3</button>
                                            </td>
                                      </tr>
                                        <tr>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">4</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">5</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">6</button>
                                            </td>
                                      </tr>
                                        <tr>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">7</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">8</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">9</button>
                                            </td>
                                      </tr>
                                <tr>
                                    <td>
                                        <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">*</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">0</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-whatsapp" onclick="waBtn(this);return false">#</button>
                                    </td>
                              </tr>
                          </tbody>
                          </table>
                      </div>
                      </div>
                      <div class="modal-footer">
                          <div class="row">
                              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <button type="button" onclick="lewati(this);return false;" class="btn btn-danger btn-block btn-lg" data-dismiss="modal">Lewati</button>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <button type="button" onclick="lanjutkan(this);return false;" class="btn btn-primary btn-block btn-lg">Lanjutkan</button>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
			<br>
			<hr>
			<div class="row text-center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-info">
						<h3>
							Peserta BPJS <small>yang berobat ke </small>Dokter Umum <small>silahkan Scan Kartu / Barcode Aplikasi untuk mendapatkan Nomor Antrian</small>
						</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<br />
				</div>
			</div>
            {!! Form::text('jenis_antrian_id', null, ['class' => 'form-control hide', 'id' => 'jenis_antrian_id']) !!}
		</div>
		{!! Form::text('nomor_bpjs', null, ['class' => 'form-control hide', 'id' => 'nomor_bpjs']) !!}
	</div>
	<div id="section-to-print">
	  <section class="sheet">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center">
                    <div class="text-center border-top welcome_title">
						Selamat Datang di
						<br />Klinik Jati Elok
						{{-- <br />{{ \Auth::user()->tenant->name }} --}}
					</div>
                    <div class="text-center border-bottom border-top alamat_klinik">
					</div>
                </div>
				<div class="text-center alamat_klinik">Nomor Antrian </div>
                <div class="text-center superbig strong" id="nomor_antrian">
							A50
               </div>
				<div class="text-center welcome_title" id="jenis_antrian">Poli Umum</div>
                {{-- <div class="alamat_klinik text-center bold">Kode Unik : <span  id="kode_unik"></span></div> --}}
                {{-- <div class="text-center"> --}}
                {{--     <img src="" id="qr_code" alt=""> --}}
                {{-- </div> --}}
				{{-- <div class="text-center alamat_klinik">Scan QR Code di atas, anda akan dialihkan menuju whatsapp</div> --}}
				<br />
	  </section>
	</div>
    <!-- Mainly scripts -->
	<script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
	</script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/antrian.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}
</body>

</html>
