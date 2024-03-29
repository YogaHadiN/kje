<?php

if (!function_exists('flex_url')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function flex_url($url)
    {
        if (request()->secure()) {
            secure_url($url);
        } else {
            return url($url);
        }

    }

}
if (!function_exists('wamehp')) {
    function wamehp($nohp) {
        if (!empty( trim($nohp) )) {
            // kadang ada penulisan no hp 0811 239 345
            $nohp = str_replace(" ","",$nohp);
            // kadang ada penulisan no hp (0274) 778787
            $nohp = str_replace("(","",$nohp);
            // kadang ada penulisan no hp (0274) 778787
            $nohp = str_replace(")","",$nohp);
            // kadang ada penulisan no hp 0811.239.345
            $nohp = str_replace(".","",$nohp);

            // cek apakah no hp mengandung karakter + dan 0-9
            if(!preg_match('/[^+0-9]/',trim($nohp))){
                // cek apakah no hp karakter 1-3 adalah +62
                if(substr(trim($nohp), 0, 3)=='+62'){
                    $nohp = trim($nohp);
                }
                // cek apakah no hp karakter 1 adalah 0
                elseif(substr(trim($nohp), 0, 1)=='0'){
                    $nohp = '62'.substr(trim($nohp), 1);
                }
            }
            return 'https://wa.me/' . $nohp;
        }
    }
}

if (!function_exists('tekananDarahTerkendali')) {
    function tekananDarahTerkendali($umur, $sistolik, $diastolik) {
		return (( $umur >= 18  // usia lebih sama dengan 18 tahun
			&& $umur <= 64 // usia kurang sama dengan 64 tahun
			&& $sistolik >= 120 // sistolik lebih sama dengan 120
			&& $sistolik <= 130 // diastolik kurang sama dengan 130
		) ||
		(
			$umur > 64  // usia lebih 64 tahun
			&& $sistolik >= 130 // sistolik lebih sama dengan 120
			&& $sistolik <= 139 // diastolik kurang sama dengan 130
		))
		&& $diastolik >= 70 // diastolik lebih sama dengan 70
		&& $diastolik <= 79; // diastolik kurang sama dengan 79
    }
}

if (!function_exists('rpToNumber')) {
    function rpToNumber($rupiah) {
        // kecilkan semua
        $rupiah = strtolower($rupiah);
        $rupiah = trim($rupiah);
        $rupiah = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $rupiah);


        // hilangkan Rp
        $rupiah = str_replace("rp","",$rupiah); 
//
        // hilangkan ,00
        if(str_ends_with( $rupiah, ',00')){
            $rupiah = str_replace(",00","",$rupiah);
        }
//
        // hilangkan titik
        $rupiah = str_replace(".","",$rupiah); 

        // hilangkan koma
        $rupiah = str_replace(",","",$rupiah); 

        // hilangkan strip
        $rupiah =  str_replace("-","",$rupiah);

        $rupiah = (int) $rupiah;

        return $rupiah;


    }
}
if (!function_exists('excelToPhpDate')) {
    function excelToPhpDate($EXCEL_DATE) {
        $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
        return gmdate("Y-m-d", $UNIX_DATE);
    }
}
if (!function_exists('get_string_between')) {
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return trim(substr($string, $ini, $len));
    }
}

if (!function_exists('buatrp')) {
    function buatrp($angka){
        return "Rp. " . number_format($angka,0,',','.') . ',-';
    }
}
if (!function_exists('encrypt_string')) {
    function encrypt_string($simple_string){
        // Store the cipher method
        $ciphering = "AES-128-CTR";
          
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
          
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';
          
        // Store the encryption key
        $encryption_key = "GeeksforGeeks";
          
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($simple_string, $ciphering,
                    $encryption_key, $options, $encryption_iv);
        // return encrypt
        return $encryption ;
    }
}

if (!function_exists('decrypt_string')) {
    function decrypt_string($encryption){

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';
          
        $options = 0;
        $ciphering = "AES-128-CTR";
        // Store the decryption key
        $decryption_key = "GeeksforGeeks";
          
        // Use openssl_decrypt() function to decrypt the data
        $decryption=openssl_decrypt ($encryption, $ciphering, 
                $decryption_key, $options, $decryption_iv);
          
        // return decrypt
        return $decryption;
    }
}
if (!function_exists('day_diff')) {
    function day_diff($earlier, $later){
        $earlier = new DateTime($earlier);
        $later   = new DateTime($later);
        return abs($earlier->diff($later)->format("%r%a")); //3
    }
}

if (!function_exists('checkForUploadedFile')) {
    function checkForUploadedFile($file, $path){
        $exists = Storage::disk('s3')->exists($path);
        Storage::disk('s3')->assertExists($path);
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($pre, $field_name, $id, $destination_path){
        if ( Input::hasFile( $field_name ) ) {
            $upload_cover = Input::file($field_name);
            $extension = $upload_cover->getClientOriginalExtension();

            /* $upload_cover = Image::make($upload_cover); */
            /* $upload_cover->resize(1000, null, function ($constraint) { */
            /* 	$constraint->aspectRatio(); */
            /* 	$constraint->upsize(); */
            /* }); */

            //membuat nama file random + extension
            $filename =	 $pre . $id . '_' .  time() . '_' . generateRandomString() . '.' . $extension;

            //menyimpan bpjs_image ke folder public/img
            if (!str_ends_with('/', $destination_path)) {
                $destination_path =  $destination_path . '/';
            }

            //destinasi s3
            //
            \Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
            // Mengambil file yang di upload

            /* $upload_cover->save($destination_path . '/' . $filename); */
            
            //mengisi field bpjs_image di book dengan filename yang baru dibuat
            return $destination_path. $filename;
        } else {
            return null;
        }
        //mengambil extension
    }
}
if (!function_exists('rupiah')) {
    function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
}

if (!function_exists('getAsuransiIdFromDescription')) {
    function getAsuransiIdFromDescription($description)
    {
		$words = explode('/', $description);
		foreach ($words as $word) {
			if (substr($word, 0, 1) == 'P') {
				return preg_replace('~\D~', '', $word);;
                break;
			}
		}
		return '';
    }
}

if (!function_exists('convertToDatabaseFriendlyDateFormat')) {
    function convertToDatabaseFriendlyDateFormat($value) {
        if (!empty($value)) {
            return \Carbon\Carbon::CreateFromFormat('d-m-Y', $value)->format('Y-m-d');
        }
        return null;
    }
}

if (!function_exists('convertToDatabaseFriendlyDateFormatFromBulanTahun')) {
    function convertToDatabaseFriendlyDateFormatFromBulanTahun($value) {
        if (!empty($value)) {
            return $value. '-01';
        }
        return null;
    }
}


if (!function_exists('cleanUang')) {
    function cleanUang($str) {
        if ( is_numeric($str) ) {
            return $str;
        }
        $data = str_replace(".", "", substr( $str , 4));
        if ($data != '') {
            return trim( $data );
        }else {
            return '0';
        }
    }
}
if (!function_exists('convertToDatabaseFriendlyPhoneNumber')) {
    function convertToDatabaseFriendlyPhoneNumber($str) {
        $str = ltrim($str, "0");
        return '62' . $str;
    }
}

if (!function_exists('yesno_option')) {
    function yesno_option() {
        return [
            'tidak', 'ya'
        ];
    }
}
if (!function_exists('generateRandomString')) {
     function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('resetWhatsappRegistration')) {
     function resetWhatsappRegistration($no_telp) {
        \App\Models\WhatsappComplaint::where('no_telp', $no_telp)->delete();
        \App\Models\WhatsappRecoveryIndex::where('no_telp', $no_telp)->delete();
        \App\Models\WhatsappMainMenu::where('no_telp', $no_telp)->delete();
        \App\Models\WhatsappBot::where('no_telp', $no_telp)->delete();
        \App\Models\WhatsappSatisfactionSurvey::where('no_telp', $no_telp)->delete();
        \App\Models\FailedTherapy::where('no_telp', $no_telp)->delete();
        \App\Models\KuesionerMenungguObat::where('no_telp', $no_telp)->delete();
        \App\Models\WhatsappBpjsDentistRegistration::where('no_telp', $no_telp)->delete();
        \App\Models\WhatsappJadwalKonsultasiInquiry::where('no_telp', $no_telp)->delete();
    }
}



if (!function_exists('hitungUsia')) {
    function hitungUsia($birthDate, $checkDate){
        if(empty($birthDate) || $birthDate == '0000-00-00'){
            return ' -- ';
        } else {
            return date_diff(date_create($birthDate), date_create($checkDate))->y . ' th';
        }
    }
}
if (!function_exists('convertToWablasFriendlyFormat')) {
     function convertToWablasFriendlyFormat($no_telp) {
         if (
             !empty($no_telp) &&
              $no_telp[0] == 0
         ) {
             $no_telp = '62' . substr($no_telp, 1);
         }
         return $no_telp;
    }
}

if (!function_exists('tambahkanGelar')) {
     function tambahkanGelar($titel, $nama) {
        if (
            !str_contains( strtolower($nama), 'dr.' ) &&
            !str_contains( strtolower($nama), 'drg' ) &&
            !str_contains( strtolower($nama), 'dr ' )
        ) {
            return $titel.'. ' . $nama;
        } else {
            return $nama;
        }
    }
}

if (!function_exists('umur')) {
    function umur($birthDate){
        if ( !empty( $birthDate ) ) {
            $num = number_format(((int)strtotime(date('Y-m-d')) - (int)strtotime(date( 'Y-m-d', strtotime( $birthDate . ' -1 day' ) )))/31556952);
            if(empty($birthDate) || $birthDate == '0000-00-00'){
                return null;
            } else {
                return $num;
            }
        } else {
            return null;
        }
    }
}
if (!function_exists('pph21BulanIni')) {
    function pph21BulanIni($gaji_bulan_ini, $staf_id){

        $by = new \App\Http\Controllers\BayarGajiController;
        $by->staf = \App\Models\Staf::find( $staf_id );
        return round( $by->pph21($gaji_bulan_ini, 0, 4500000)['pph21'] );
    }
}

