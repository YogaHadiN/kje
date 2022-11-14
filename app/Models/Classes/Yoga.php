<?php

namespace App\Models\Classes;

use Input;
use DB;
use Log;
use DateTime;
use App\Models\Rak;
use App\Models\Poli;
use App\Models\SmsKirim;
use App\Models\Role;
use App\Models\JurnalUmum;
use App\Models\Pasien;
use App\Models\Signa;
use App\Models\Coa;
use App\Models\Perujuk;
use App\Models\AturanMinum;
use App\Models\Supplier;
use App\Models\Tarif;
use App\Models\GolonganPeralatan;
use App\Models\Merek;
use App\Models\Periksa;
use App\Models\JenisTarif;
use App\Models\Confirm;
use App\Models\AntrianPeriksa;
use App\Models\AntrianPoli;
use App\Models\RefleksPatela;
use App\Models\KepalaTerhadapPap;
use App\Models\Presentasi;
use App\Models\Buku;
use App\Models\PengantarPasien;
use App\Models\Staf;
use App\Models\Asuransi;
use App\Models\JenisRumahSakit;
use App\Models\RegisterHamil;
use App\Models\JenisPengeluaran;
use App\Http\Controllers\PdfsController;
use App\Models\Terapi;
use App\Models\TujuanRujuk;





class Yoga {
			public static function redirect_to($new_location) {
			  header("Location: " . $new_location);
			  exit;
			}

			public static function mysql_prep($string) {
				global $connection;
				
				$escaped_string = mysqli_real_escape_string($connection, $string);
				return $escaped_string;
			}
			
			public static function confirm_query($result_set) {
				if (!$result_set) {
					die("Database query failed.");
				}
			}

			public static function form_errors($errors=array()) {
				$output = "";
				if (!empty($errors)) {
				  $output .= "<div class=\"error\">";
				  $output .= "Please fix the following errors:";
				  $output .= "<ul>";
				  foreach ($errors as $key => $error) {
				    $output .= "<li>";
						$output .= htmlentities($error);
						$output .= "</li>";
				  }
				  $output .= "</ul>";
				  $output .= "</div>";
				}
				return $output;
			}
			
			public static function ddlAsuransi() {
				global $connection;
				
				$query  = "SELECT * ";
				$query .= "FROM asuransi ";
				$asuransi = mysqli_query($connection, $query);
				confirm_query($asuransi);
				return $asuransi;
			}
			
				
			public static function find_all_admins() {
				global $connection;
				
				$query  = "SELECT * ";
				$query .= "FROM admins ";
				$query .= "ORDER BY username ASC";
				$admin_set = mysqli_query($connection, $query);
				confirm_query($admin_set);
				return $admin_set;
			}
			
			public static function find_subject_by_id($subject_id, $public=true) {
				global $connection;
				
				$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
				
				$query  = "SELECT * ";
				$query .= "FROM subjects ";
				$query .= "WHERE id = {$safe_subject_id} ";
				if ($public) {
					$query .= "AND visible = 1 ";
				}
				$query .= "LIMIT 1";
				$subject_set = mysqli_query($connection, $query);
				confirm_query($subject_set);
				if($subject = mysqli_fetch_assoc($subject_set)) {
					return $subject;
				} else {
					return null;
				}
			}

			public static function find_page_by_id($page_id, $public=true) {
				global $connection;
				
				$safe_page_id = mysqli_real_escape_string($connection, $page_id);
				
				$query  = "SELECT * ";
				$query .= "FROM pages ";
				$query .= "WHERE id = {$safe_page_id} ";
				if ($public) {
					$query .= "AND visible = 1 ";
				}
				$query .= "LIMIT 1";
				$page_set = mysqli_query($connection, $query);
				confirm_query($page_set);
				if($page = mysqli_fetch_assoc($page_set)) {
					return $page;
				} else {
					return null;
				}
			}
			
			public static function find_admin_by_id($admin_id) {
				global $connection;
				
				$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
				
				$query  = "SELECT * ";
				$query .= "FROM admins ";
				$query .= "WHERE id = {$safe_admin_id} ";
				$query .= "LIMIT 1";
				$admin_set = mysqli_query($connection, $query);
				confirm_query($admin_set);
				if($admin = mysqli_fetch_assoc($admin_set)) {
					return $admin;
				} else {
					return null;
				}
			}

			public static function find_admin_by_username($username) {
				global $connection;
				
				$safe_username = mysqli_real_escape_string($connection, $username);
				
				$query  = "SELECT * ";
				$query .= "FROM admins ";
				$query .= "WHERE username = '{$safe_username}' ";
				$query .= "LIMIT 1";
				$admin_set = mysqli_query($connection, $query);
				confirm_query($admin_set);
				if($admin = mysqli_fetch_assoc($admin_set)) {
					return $admin;
				} else {
					return null;
				}
			}

			public static function find_default_page_for_subject($subject_id) {
				$page_set = find_pages_for_subject($subject_id);
				if($first_page = mysqli_fetch_assoc($page_set)) {
					return $first_page;
				} else {
					return null;
				}
			}
			
			public static function find_selected_page($public=false) {
				global $current_subject;
				global $current_page;
				
				if (isset($_GET["subject"])) {
					$current_subject = find_subject_by_id($_GET["subject"], $public);
					if ($current_subject && $public) {
						$current_page = find_default_page_for_subject($current_subject["id"]);
					} else {
						$current_page = null;
					}
				} elseif (isset($_GET["page"])) {
					$current_subject = null;
					$current_page = find_page_by_id($_GET["page"], $public);
				} else {
					$current_subject = null;
					$current_page = null;
				}
			}

			public static function navigation($subject_array, $page_array) {
				$output = "<ul class=\"subjects\">";
				$subject_set = find_all_subjects(false);
				while($subject = mysqli_fetch_assoc($subject_set)) {
					$output .= "<li";
					if ($subject_array && $subject["id"] == $subject_array["id"]) {
						$output .= " class=\"selected\"";
					}
					$output .= ">";
					$output .= "<a href=\"manage_content.php?subject=";
					$output .= urlencode($subject["id"]);
					$output .= "\">";
					$output .= htmlentities($subject["menu_name"]);
					$output .= "</a>";
					
					$page_set = find_pages_for_subject($subject["id"], false);
					$output .= "<ul class=\"pages\">";
					while($page = mysqli_fetch_assoc($page_set)) {
						$output .= "<li";
						if ($page_array && $page["id"] == $page_array["id"]) {
							$output .= " class=\"selected\"";
						}
						$output .= ">";
						$output .= "<a href=\"manage_content.php?page=";
						$output .= urlencode($page["id"]);
						$output .= "\">";
						$output .= htmlentities($page["menu_name"]);
						$output .= "</a></li>";
					}
					mysqli_free_result($page_set);
					$output .= "</ul></li>";
				}
				mysqli_free_result($subject_set);
				$output .= "</ul>";
				return $output;
			}

			public static function public_navigation($subject_array, $page_array) {
				$output = "<ul class=\"subjects\">";
				$subject_set = find_all_subjects();
				while($subject = mysqli_fetch_assoc($subject_set)) {
					$output .= "<li";
					if ($subject_array && $subject["id"] == $subject_array["id"]) {
						$output .= " class=\"selected\"";
					}
					$output .= ">";
					$output .= "<a href=\"index.php?subject=";
					$output .= urlencode($subject["id"]);
					$output .= "\">";
					$output .= htmlentities($subject["menu_name"]);
					$output .= "</a>";
					
					if ($subject_array["id"] == $subject["id"] || 
							$page_array["subject_id"] == $subject["id"]) {
						$page_set = find_pages_for_subject($subject["id"]);
						$output .= "<ul class=\"pages\">";
						while($page = mysqli_fetch_assoc($page_set)) {
							$output .= "<li";
							if ($page_array && $page["id"] == $page_array["id"]) {
								$output .= " class=\"selected\"";
							}
							$output .= ">";
							$output .= "<a href=\"index.php?page=";
							$output .= urlencode($page["id"]);
							$output .= "\">";
							$output .= htmlentities($page["menu_name"]);
							$output .= "</a></li>";
						}
						$output .= "</ul>";
						mysqli_free_result($page_set);
					}

					$output .= "</li>"; // end of the subject li
				}
				mysqli_free_result($subject_set);
				$output .= "</ul>";
				return $output;
			}

			public static function password_encrypt($password) {
		  	  $hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
			  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
			  $salt = generate_salt($salt_length);
			  $format_and_salt = $hash_format . $salt;
			  $hash = crypt($password, $format_and_salt);
				return $hash;
			}
			
			public static function generate_salt($length) {
			  // Not 100% unique, not 100% random, but good enough for a salt
			  // MD5 returns 32 characters
			  $unique_random_string = md5(uniqid(mt_rand(), true));
			  
				// Valid characters for a salt are [a-zA-Z0-9./]
			  $base64_string = base64_encode($unique_random_string);
			  
				// But not '+' which is valid in base64 encoding
			  $modified_base64_string = str_replace('+', '.', $base64_string);
			  
				// Truncate string to the correct length
			  $salt = substr($modified_base64_string, 0, $length);
			  
				return $salt;
			}
			
			public static function password_check($password, $existing_hash) {
				// existing hash contains format and salt at start
			  $hash = crypt($password, $existing_hash);
			  if ($hash === $existing_hash) {
			    return true;
			  } else {
			    return false;
			  }
			}

			public static function attempt_login($username, $password) {
				$admin = find_admin_by_username($username);
				if ($admin) {
					// found admin, now check password
					if (password_check($password, $admin["hashed_password"])) {
						// password matches
						return $admin;
					} else {
						// password does not match
						return false;
					}
				} else {
					// admin not found
					return false;
				}
			}

			public static function logged_in() {
				return isset($_SESSION['admin_id']);
			}
			
			public static function confirm_logged_in() {
				if (!logged_in()) {
					redirect_to("login.php");
				}
			}

			public static function query($query) {
				global $connection;
				$resultID = mysqli_query($connection, $query);
				if (!$resultID) {
					die("query <br />$query<br /> failed.");
				}
				return $resultID;

			}

			public static function unikID($tableName){
				global $connection;
				$prefix = date("ymd"); 
				$queryID = "Select * from {$tableName} where prefix = '" . $prefix . "'";
				$resultID = mysqli_query($connection, $queryID);
				confirm_query($resultID);
				$numRows = mysqli_num_rows($resultID);
				if($numRows > 0) {
					if($rdr = mysqli_fetch_assoc($resultID)) {
						(int) $next = $rdr["next"];
					}

					(int) $more = $next + 1;

					

					$query = "UPDATE {$tableName} SET last = {$next}, next = {$more} WHERE prefix = '{$prefix}'";
					$resultUpdate = query($query);
							

			
					
				} else {

					$next = 1;
					$more = 2;
					$insert = "INSERT INTO {$tableName} (prefix, last, next) VALUES ('{$prefix}', {$next}, {$more})";
					$resultInsert = query($insert);

						
				}

				if((int) $next < 10 ){
					$next = "00" . (string) $next;
				} else if((int) $next <100) {
					$next = "0" . (string) $next;
				} else{
					$next = (string) $next;
				}
				$ID_PASIEN = $prefix . $next;
				return $ID_PASIEN;
			}	

			public static function optionFromDatabase($tableName, $ID, $name){
				$myArray = "<option value=\"\"> -- pilih -- </option>";
		        while($rdr = mysqli_fetch_assoc($tableName)) {
		        $myArray .= "<option value=\"";
		        $myArray .= $rdr["{$ID}"] . "\">";
		        $myArray .= $rdr["{$name}"];
		        $myArray .= "</option>";
		     }
		     mysqli_free_result($tableName);
		     return $myArray;
			}

			public static function optionSelectedFromDatabase($tableName, $ID, $name, $selectedValue){
		        $myArray = "<option value=\"\"> -- pilih -- </option>";
		        while($rdr = mysqli_fetch_assoc($tableName)) {
		            $myArray .= "<option value=\"";
		            $myArray .= $rdr["$ID"] . "\" ";
		            if($rdr["$ID"] == $selectedValue){
		            	$myArray .= "selected";
		            }
		            $myArray .= ">" . $rdr["$name"] . "</option>";
		        }
		        mysqli_free_result($tableName);
		        return $myArray;
			}

			public static function optionSelectedFromDatabaseNoNull($tableName, $ID, $name, $selectedValue){
		        $myArray = "";
		        while($rdr = mysqli_fetch_assoc($tableName)) {
		            $myArray .= "<option value=\"";
		            $myArray .= $rdr["$ID"] . "\" ";
		            if($rdr["$ID"] == $selectedValue){
		            	$myArray .= "selected";
		            }
		            $myArray .= ">" . $rdr["$name"] . "</option>";
		        }
		        mysqli_free_result($tableName);
		        return $myArray;
			}


		 public static function datePrep($tanggal){
		 	if ($tanggal == null) {
		 		return null;
		 	} else {
			 	$date = substr($tanggal, 6, 4) . "-" . substr($tanggal, 3, 2). "-" . substr($tanggal, 0, 2);
			 	return $date;
		 	}
		 }


		 public static function updateDatePrep($tanggal){
		 	$date = substr($tanggal, 8, 2) . "-" . substr($tanggal, 5, 2). "-" . substr($tanggal, 0, 4);
		 	if ($tanggal != null) {
			 	return $date;
		 	} else {
		 		return null;
		 	}
		 }

		public static function terbilang($x){
			$unabsx = $x;
			$x      = abs($x);
		    $arr = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		    if ($x < 12)
		    return " " . $arr[$x];
		    elseif ($x < 20)
		    return Yoga::terbilang($x - 10) . " belas";
		    elseif ($x < 100)
		    return Yoga::terbilang($x / 10) . " puluh" . Yoga::terbilang($x % 10);
		    elseif ($x < 200)
		    return " seratus" . Yoga::terbilang($x - 100);
		    elseif ($x < 1000)
		    return Yoga::terbilang($x / 100) . " ratus" . Yoga::terbilang($x % 100);
		    elseif ($x < 2000)
		    return " seribu" . Yoga::terbilang($x - 1000);
		    elseif ($x < 1000000)
		    return Yoga::terbilang($x / 1000) . " ribu" . Yoga::terbilang($x % 1000);
		    elseif ($x < 1000000000)
		    return Yoga::terbilang($x / 1000000) . " juta" . Yoga::terbilang($x % 1000000);

		}



		public static function prepMerek($ID_FORMULA, $contohMerek){
			$komposisi = query("SELECT * FROM komposisi WHERE ID_FORMULA = '{$ID_FORMULA}'");
			$merek = '';
		    $getSediaan = query("SELECT * FROM formula AS f left outer join sediaan as s on s.ID_SEDIAAN = f.ID_SEDIAAN WHERE ID_FORMULA = '{$ID_FORMULA}'");

		    if($r = mysqli_fetch_assoc($getSediaan)){
		    	$sediaan = $r['sediaan'];
		    }
		    mysqli_free_result($getSediaan);
		    if(mysqli_num_rows($komposisi) > 1){
		        $merek = $contohMerek . ' ' . $sediaan;
		    } else if (mysqli_num_rows($komposisi) == 1){
			    if($rdr = mysqli_fetch_assoc($komposisi)){
			        $bobot = $rdr['bobot'];
			    }
		        $merek = $contohMerek . ' ' . $sediaan . ' ' . $bobot;
		    } else {
		    	$merek = $contohMerek;
		    }

		    // echo 'bobot = ' . $bobot . '<br />';
		    // echo 'sediaan = ' . $sediaan . '<br />';
		    mysqli_free_result($komposisi);

			return $merek;
		}

		public static function getValue($field, $query){

			if($rdr = mysqli_fetch_assoc($query)){
				$result = $rdr[$field];
			}
			mysqli_free_result($query);
			return $result;
		}


		public static function bulanTahun($blnThn){

			$bulanThn = explode("-", $blnThn)[1] . "-".explode("-", $blnThn)[0];
			return $bulanThn;
		}

		public static function rataAtas5000($n){
            if ($n) {
                return round(($n+5000/2)/5000)*5000;
            }
            return $n;
		}

		public static function alternatif_fornas(){
			return array('' => '- Pilih Merek -') + Merek::pluck('merek', 'id')->all();
		}
		public static function jenisPengeluaranList(){
			return array('' => '- Pilih Pengeluran -') + JenisPengeluaran::pluck('nama', 'id')->all();
		}

		public static function fornas(){
			return [
						 null        => '- Pilih -',
			            '0'         => 'Bukan Fornas',
			            '1'         => 'Fornas'
					];
		}

		public static function merekAsli($merek_lama, $formula, $bobot){
			if($formula->komposisi->count() == 1) {
				$end = $formula->sediaan->sediaan . ' ' . $bobot;
				$merek = str_replace($end, '', $merek_lama);
			} else {
				$merek = str_replace($formula->sediaan, '', $merek_lama);
			}

			return $merek;
		}

		public static function asuransiList(){
			return Asuransi::where('aktif', 1)->pluck('nama', 'id');
		}

		public static function stafList(){
			$data = array(null => '- Pilih Staf -') + Staf::pluck('nama', 'id')->all();
            return $data;
		}

		public static function blnPrep($param){

			$myArray = explode('-', $param);
			$date = $myArray[1] . '-' . $myArray[0];
			return $date;
		}

		public static function poliList(){
			$data = [null => '-Pilih Poli-'] + Poli::pluck('poli', 'id')->all();;

			return $data;
		}

		public static function roleList() {
			$roles = Role::all();
			$result[null] = '- Pilih Peran -' ;
			foreach ($roles as $role) {
				if ( $role->id < 5 ) {
					$result[ $role->id ] = $role->role;
				}
			}
			return $result;
		}
		public static function rakList() {
			$rakList['%'] = ['Semua Rak'];
			$query  = "SELECT ";
			$query .= "rk.id as rak_id, ";
			$query .= "mr.id as merek_id, ";
			$query .= "mr.merek as merek ";
			$query .= "FROM raks as rk ";
			$query .= "JOIN mereks as mr on mr.rak_id = rk.id ";
			$query .= "WHERE rk.tenant_id = " . session()->get('tenant_id') . " ";
			$raks = DB::select($query);

			foreach ($raks as $rak) {
				if (isset( $rakList[$rak->rak_id] )) {
					$rakList[$rak->rak_id] = $rakList[$rak->rak_id] . ', '  . $rak->merek;
				} else {
					$rakList[$rak->rak_id] = $rak->merek;
				}
			}
			return  $rakList;
		}

		public static function customId($model){
			if($model::where('id', 'like', date('ymd') . '%')->get()->count() == 0) {
    			$idCustom = date('ymd').sprintf("%03d", 1);
    		} else {
    			$last_id = $model::where('id', 'like', date('ymd') . '%')->orderBy('id', 'desc')->first()->id;
    			$substr_id = substr($last_id, -3);
    			$insert_id = "$substr_id" + 1;
    			$idCustom = date('ymd').sprintf("%03d", $insert_id);
    		}

    		return $idCustom; // id ke 100, tanggal 01-01-2016 mereturn 1601010100
		}

		public static function customIdPasien(){
			
			if(Pasien::where('id', 'like', date('ymd') . '%')->get()->count() == 0) {
    			$idCustom = date('ymd').sprintf("%03d", 1);
    		} else {
    			$last_id = Pasien::where('id', 'like', date('ymd') . '%')->orderBy('id', 'desc')->first()->id;
    			$substr_id = substr($last_id, -3);
    			$insert_id = "$substr_id" + 1;
    			$idCustom = date('ymd').sprintf("%03d", $insert_id);
    		}

    		return $idCustom;
		}

		public static function clean($str){
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

		public static function sesuaikanResep($json, $order){
			$terapis = json_decode($json, true);
			foreach ($terapis as $key => $terapi) {
				$formula_id                  = $terapi['formula_id'];
				$rak                         = Rak::with('merek')->where('formula_id', $formula_id)->orderBy('kelas_obat_id', $order)->first();
                if (is_null($rak)) {
                    Log::info("formula_id");
                    Log::info("===============================================");
                    Log::info($formula_id);
                    Log::info("===============================================");
                }
				$terapis[$key]['merek_id']   = $rak->merek->first()->id;
				$terapis[$key]['rak_id']     = $rak->id;
				$terapis[$key]['merek_obat'] = $rak->merek->first()->merek;
			}
			return json_encode($terapis);
		}
		public static function sesuaikanResepPasienUmum($json){
			$terapis = json_decode($json, true);
			foreach ($terapis as $key => $terapi) {
				$formula_id                  = $terapi['formula_id'];
				$rak                         = Rak::where('formula_id', $formula_id)->where('kelas_obat_id', '2')->first();
				if ($rak != null) {
					$terapis[$key]['merek_id']   = $rak->merek->first()->id;
					$terapis[$key]['rak_id']     = $rak->id;
					$terapis[$key]['merek_obat'] = $rak->merek->first()->merek;
				}
			}
			return json_encode($terapis);
		}

		public static function signa_list(){

			return array(null => '- Pilih Signa -') + Signa::pluck('signa', 'id')->all();

		}
		public static function aturan_minum_list(){

			return array(null => '- Pilih Aturan Minum -') + AturanMinum::pluck('aturan_minum', 'id')->all();

		}
		public static function beratBadanId($bb){

			$berat_badan_id = '0';

			if ($bb >= 6 && $bb <= 7) {	
				$berat_badan_id = '1';
			}
			else if ($bb > 7 && $bb <= 9) {	
				$berat_badan_id = '2';
			}
			else if ($bb > 9 && $bb <= 13) {	
				$berat_badan_id = '3';
			}
			else if ($bb > 13 && $bb <= 15) {	
				$berat_badan_id = '4';
			}
			else if ($bb > 15 && $bb <= 19) {	
				$berat_badan_id = '5';
			}
			else if ($bb > 19 && $bb <= 23) {	
				$berat_badan_id = '6';
			}
			else if ($bb > 23 && $bb <= 26) {	
				$berat_badan_id = '7';
			}
			else if ($bb > 26 && $bb <= 33) {	
				$berat_badan_id = '8';
			}
			else if ($bb > 33 && $bb <= 37) {	
				$berat_badan_id = '9';
			}
			else if ($bb > 37 && $bb <= 45) {	
				$berat_badan_id = '10';
			}
			else if ($bb > 45 && $bb <= 50) {	
				$berat_badan_id = '11';
			}
			else if ($bb > 50 || $bb == '') {	
				$berat_badan_id = '12';
			} else {
				$berat_badan_id = '12';
			}

			return $berat_badan_id;


		}

		public static function returnNull($val){

			if ($val === '' || $val == 0) {
				return null;
			} else {
				return $val;
			}

		}

		public static function supplierList(){

			return [ null => '- pilih -'] + Supplier::pluck('nama', 'id')->all();

		}

		public static function umur($birthDate){

			$num = number_format(((int)strtotime(date('Y-m-d')) - (int)strtotime(date( 'Y-m-d', strtotime( $birthDate . ' -1 day' ) )))/31556952);

			if(empty($birthDate) || $birthDate == '0000-00-00'){
				return null;
			} else {
				return $num;
			}

		}

		public static function umurSaatPeriksa($birthDate, $checkDate){

			if(empty($birthDate) || $birthDate == '0000-00-00'){
				return ' -- ';
			} else {
				return date_diff(date_create($birthDate), date_create($checkDate))->y;
			}

		}

		public static function cleanArrayJson($param){

			$umums = explode("\r\n", $param);
			$umums = array_merge(array_diff($umums, array("")));
			$umums = json_encode($umums);

			return $umums;

		}


		public static function emptyIfNull($val){

			if ($val == null) {
				return '';
			} else {
				return $val;
			}

		}

		public static function datediff($tgl1, $tgl2){
			$tgl1 = is_object($tgl1) ? $tgl1->format('Y-m-d') : $tgl1;
			$tgl2 = is_object($tgl2) ? $tgl2->format('Y-m-d') : $tgl2;



			$tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
			$tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
			$diff_secs = abs($tgl1 - $tgl2);
			$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
			$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
			$umur =  array( "years" => date("Y", $diff) - $base_year,
			"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
			"months" => date("n", $diff) - 1,
			"days_total" => floor($diff_secs / (3600 * 24)),
			"days" => date("j", $diff) - 1,
			"hours_total" => floor($diff_secs / 3600),
			"hours" => date("G", $diff),
			"minutes_total" => floor($diff_secs / 60),
			"minutes" => (int) date("i", $diff),
			"seconds_total" => $diff_secs,
			"seconds" => (int) date("s", $diff) );

			return $umur['years'] . ' tahun ' . $umur['months'] . ' bulan ' . $umur['days'] . ' hari';

		}
		public static function umurKehamilan($tgl1, $tgl2){

				$tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
				$tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
				$diff_secs = abs($tgl1 - $tgl2);
				$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
				$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
				$umur =  array( "years" => date("Y", $diff) - $base_year,
				"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
				"months" => date("n", $diff) - 1,
				"days_total" => floor($diff_secs / (3600 * 24)),
				"days" => date("j", $diff) - 1,
				"hours_total" => floor($diff_secs / 3600),
				"hours" => date("G", $diff),
				"minutes_total" => floor($diff_secs / 60),
				"minutes" => (int) date("i", $diff),
				"seconds_total" => $diff_secs,
				"seconds" => (int) date("s", $diff) );

				return floor((int)$umur['days_total']/7) . ' minggu ' . (int)$umur['days_total'] % 7 . ' hari';

		}


		public static function biayaObatTotal($control){
	   		$transaksis = json_decode($control, true);
	   		foreach ($transaksis as $key => $transaksi) {
	   			if ($transaksi['jenis_tarif'] == 'Biaya Obat') {
	   				return $transaksi['biaya'];
	   			}
	   		}
		}

		public static function kaliObat2($transaksis, $terapis, $asuransi, $plafon){

			$transaksi_array = $transaksis;
			$non_paket = true;
			foreach ($transaksi_array as $k => $v) {
				$tarif_ini = Tarif::where('jenis_tarif_id', $v['jenis_tarif_id'])->where('asuransi_id', $asuransi->id)->first();
				if ($tarif_ini->tipe_tindakan_id == 2) {
					$non_paket = false;
					$tarif_ini = $v;
					break;	
				}
			}
			if ($non_paket) {
				if($terapis->count() > 0){
				//jenis tarif id = 9 adalah biaya obat
					$tarif = Tarif::queryTarif($asuransi->id, 3);
					$merek = Merek::all();
					$biaya = 0;

					foreach ($terapis as $terapi) {
						if ($asuransi->tipe_asuransi_id == 5) { //pembayaran BPJS
							if ($terapi->merek->rak->fornas == '0') { // jika obat tidak tergolong fornas
								$biaya += $terapi->merek->rak->harga_jual * $terapi->jumlah;
							} else {
								$biaya += 0;
							}
						} else {
							if ( $terapi->merek_id > 0 ) { // jika bukan kertas puyer dan add
								$biaya += $terapi->merek->rak->harga_jual * $terapi->jumlah * $asuransi->kali_obat;
							} else {
								$biaya += $terapi->merek->rak->harga_jual * $terapi->jumlah;
							}
						}
					}
					if ($asuransi->tipe_asuransi_id == 4) { //tipe asuransi pembayaran flat
						$selisihPlafon = $plafon - $biaya;
					}

					$biaya = Yoga::rataAtas5000($biaya);
					$plus = [
						'jenis_tarif_id' => $tarif->jenis_tarif_id,
						'jenis_tarif'    => $tarif->jenis_tarif,
						'biaya'          => $biaya
					];
					array_unshift($transaksis, $plus);
				} else {
					$plus = [
						'jenis_tarif_id' => $tarif->jenis_tarif_id,
						'jenis_tarif'    => $tarif->jenis_tarif,
						'biaya'          => 0
					];
					array_unshift($transaksis, $plus);
				}
			} else {
				$plus = [
                    'jenis_tarif_id' => $tarif->jenis_tarif_id,
                    'jenis_tarif'    => $tarif->jenis_tarif,
					'biaya'          => 0
				];
				array_unshift($transaksis, $plus);
			}
			return $transaksis;
		}
		public static function dispensingObatBulanIni($asuransi, $periksa = [] ,$edit = false,$kasir = false){

			if ($edit) {
				$edit = 0;
			} else {
				$edit = 1;
			}
			$dispensingObatBulanIni = 0;
			$totalDibayarTunai      = 0;
			$plafonFlat             = 0;
			$plafonObat             = 0;
			$plafonJasaDokter       = 0;

			//
			//Jika tipe_asuransi adalah 4 == flat, maka hitung plafon
			//
			
			if ($asuransi->tipe_asuransi_id == 4) {

				//
				//plafon sekali berobat
				//
				
				$plafonObatSekaliBerobat       = Tarif::queryTarif($asuransi->id,3)->biaya;
				$plafonJasaDokterSekaliBerobat = Tarif::queryTarif($asuransi->id,1)->biaya;
				$sisaPlafon = 0;

				//
				//di loop untuk pemeriksaan bulan ini
				// 
				
				$periksaFlatBulanIni  = Periksa::with('terapii')->where('asuransi_id', $asuransi->id)->where('tanggal', 'like', date('Y-m') . '%')->get();

				foreach ($periksaFlatBulanIni as $key => $pxBulanIni) {
					
					//
					//ambil terapi nya untuk periksa_id ini
					//
					
					$terapiArray = $pxBulanIni->terapii;
					$dispensingObat = 0;
					foreach($terapiArray as $terapi){
						//dispensing = harga_jual * jumlah * kali_obat;
						$dispensingObat         += $terapi->harga_jual_satuan * $terapi->jumlah;
					}

					$dispensingObatBulanIni += $dispensingObat;

						if ($pxBulanIni->piutang == 0 && $pxBulanIni->tunai == 0) {
							$sisaPlafon        += $plafonObatSekaliBerobat  - $dispensingObat;
						} else {
							$sisaPlafon        += $pxBulanIni->piutang - $dispensingObat - $plafonJasaDokterSekaliBerobat + $pxBulanIni->tunai;
						}
					
					$totalDibayarTunai += $pxBulanIni->tunai;
				}
				if ($kasir) {
					$plafonFlat = $sisaPlafon;
				} else {
					$plafonFlat = $sisaPlafon + ($plafonObatSekaliBerobat * $edit);
				}

				if ($edit == 0) {
					$terapis = $periksa->terapii;
					foreach ($terapis as $terapi) {
						$plafonFlat += $terapi->harga_jual_satuan * $terapi->jumlah;
					}
				}

				return [ 
					'plafon'    => $plafonFlat,
					'kunjungan' => $periksaFlatBulanIni->count(),
					'utilisasi' => $dispensingObatBulanIni,
					'tunai'     => $totalDibayarTunai
	 			];
			}

		}
		public static function kasirHargaJual($terapi, $periksa){
            if($terapi->merek_id > 0){
            	if ($terapi->merek->rak_id == 'D7' && $terapi->signa == 'Puyer') {
            		return '0';
            	} else {
	                return $harga_jual = $terapi->merek->rak->harga_jual * $periksa->asuransi->kali_obat;
            	}
            } else {
	            return $terapi->merek->rak->harga_jual;
            }
		}
		public static function kasirHargaJualItem($terapi, $periksa, $bool = true){
			if ($bool) {
	            if($terapi->merek_id > 0){
                    $asuransi_bpjs = Asuransi::Bpjs();
	            	if ($periksa->asuransi_id == $asuransi_bpjs->id) {
		            	if ($terapi->merek->rak_id == 'D7' && $terapi->signa == 'Puyer') {
		            		return '0';
		            	} else {
		            		$fornas = Merek::find($terapi->merek_id)->rak->fornas;
		            		if ($fornas == '1') {
		            			$harga_jual = 0;
		            		}else {
				                $harga_jual = $terapi->jumlah * $terapi->merek->rak->harga_jual;   
		            		}
		            	}
	            	} else {
		                $harga_jual = $terapi->jumlah * $terapi->merek->rak->harga_jual * $periksa->asuransi->kali_obat;              
	            	}
	            }else{
	                $harga_jual = $terapi->jumlah * $terapi->merek->rak->harga_jual;
		        }
			} else {
        		$merek = Merek::find($terapi['merek_id']);
                $asuransi_bpjs = Asuransi::Bpjs();
            	if ($periksa->asuransi_id == $asuransi_bpjs->id) {
            		$fornas = $terapi['fornas'];
            		if ($fornas == '1') {
            			$harga_jual = 0;
            		}else {
		                $harga_jual = $terapi['jumlah'] * $merek->rak->harga_jual;   
            		}
            	} else {
	                $harga_jual = $terapi['jumlah'] * $merek->rak->harga_jual * $periksa->asuransi->kali_obat;              
            	}

			}
            return $harga_jual;
		}
		public static function modalBulanIni($tanggal, $asuransi_id){
         	
     	   	$modalObat = 0;

			$query = "SELECT sum(tr.harga_beli_satuan * tr.jumlah) as modal_obat ";
			$query .= "FROM terapis as tr ";
			$query .= "join periksas as px on px.id = tr.periksa_id ";
			$query .= "where px.tanggal like '{$tanggal}%' ";
			$query .= "and tr.tenant_id = " . session()->get('tenant_id') . " ";
			$query .= "and px.asuransi_id like '{$asuransi_id}'";

     	    return DB::select($query)[0]->modal_obat;

		}
		public static function modalObat($periksa){
     	   	$modalObat = 0;
     	   	$mereks = Merek::all();
         	foreach ($periksa as $key => $px) {
         	   	foreach (json_decode($px->terapi, true) as $key => $trp) {
         	   		$modalObat += $mereks->find($trp['merek_id'])->rak->harga_beli * $trp['jumlah'];
         	   	}
     	    }   
     	    return $modalObat;
		}
		public static function tunaiBulanan($periksa){
			$tunai = 0;
			foreach ($periksa as $key => $prx) {
				$tunai += $prx->tunai;
			}
			return $tunai;
		}
		public static function piutangBulanan($periksa){
			$piutang = 0;
			foreach ($periksa as $key => $prx) {
				$piutang += $prx->piutang;
			}
			return $piutang;
		}
		public static function totalTunaiHarian($periksa){
			$total = 0;
			foreach ($periksa as $key => $px) {
				$total += $px->tunai;
			}
			return $total;
		}
		public static function totalPiutangHarian($periksa){
			$total = 0;
			foreach ($periksa as $key => $px) {
				$total += $px->piutang;
			}
			return $total;
		}

		public static function totalTunaiDetBulan($periksa){
			$total = 0;
			foreach ($periksa as $key => $px) {
				$total += $px->tunai;
			}
			return $total;
		}
		public static function totalPiutangDetBulan($periksa){
			$total = 0;
			foreach ($periksa as $key => $px) {
				$total += $px->piutang;
			}
			return $total;
		}
		public static function totalActionDetBulan($periksa){
			$total = 0;
			foreach ($periksa as $key => $px) {
				$total += $px->tunai;
				$total += $px->piutang;
			}
			return $total;
		}
		public static function totalPenyakit($periksa){
			$total = 0;
			foreach ($periksa as $key => $px) {
				$total += $px->jumlah;
			}
			return $total;
		}

		public static function hamil(){
			return [
				null => '-pilih-',
				'0' => 'tidak hamil',
				'1' => 'hamil'
			];
		}

		public static function dibantu(){
			return [
				null => '-pilih-',
				'0' => 'tidak dibantu',
				'1' => 'dibantu'
			];
		}

		public static function jumlahDisini($count){
			if ($count > 0) {
				return '<span class="label label-warning kecil">' .$count. '</span>';
			} else {
				return '';
			}
		}

		public static function jenisTarifs($periksa, $rincian){
			$temp = '';
			$transaksi = $periksa->transaksi;
			$transaksi = json_decode($transaksi, true);
			foreach ($rincian as $key => $rinci) {
				$biaya = 0;
				$sama = false;
				foreach ($transaksi as $k => $val) {
					if ($rinci == $val['jenis_tarif']) {
						$biaya += $val['biaya'];
						$sama = true;
					}
				}
				if ($sama) {
					$temp .= '<td class="uang">' . $biaya . '</td>';
				} else {
					$temp .= '<td></td>';
				}
			}

			return $temp;
		}

		public static function rincian($periksas){
			$rincian = [];
			$sama = false;
			foreach ($periksas as $key => $px) {
				$transaksi = $px->transaksi;
				$transaksi = json_decode($transaksi,true);
				foreach ($transaksi as $ky => $tr) {
					if (count($rincian) == 0) {
						$rincian[] = $tr['jenis_tarif'];
					} else {
						foreach ($rincian as $k => $rc) {
							if($rc == $tr['jenis_tarif']){
								$sama = true;
								break;
							}
						}
						if (!$sama) {
							$rincian[] = $tr['jenis_tarif'];
						}
						$sama = false;
					}
				}
			}
			return $rincian;
		}

		public static function laporanRinci($rincian, $periksa){
			$transaksi = json_decode($periksa->transaksi, true);
			$temp ='';
			$jenis_tarif = JenisTarif::all();
			foreach ($rincian as $key => $rinci) {
				$biaya = 0;
				$sama = false;
				$kb=false;
				$anc=false;
				// return $rinci->id;
				foreach ($transaksi as $k => $tr) {
					$tipe_laporan_admedika = $jenis_tarif->find($tr['jenis_tarif_id'])->tipe_laporan_admedika_id;
					if ($periksa->icd10 == 'Z308') {

						$kb = true;
						$biaya += $tr['biaya'];
						
					} elseif ($periksa->icd10 == 'Z36'){

						$anc = true;
						$biaya += $tr['biaya'];

					} elseif ($tipe_laporan_admedika == $rinci->id) {
						$sama = true;
						$biaya += $tr['biaya'];
					}
				}
				if ($sama) {
					$temp .= '<td>' .$biaya. '</td>';
				} elseif ($kb && $rinci->id == '3'){
					$temp .= '<td>' . $biaya . '</td>';
				} elseif ($anc && $rinci->id == '4'){
					$temp .= '<td>' . $biaya . '</td>';
				} else {
					$temp .= '<td></td>';
				}
			}
			return $temp;
		}
			
		public static function lapKasir($rincian, $periksa){
			$transaksi = json_decode($periksa->transaksi, true);
			$temp ='';
			$jenis_tarif = JenisTarif::all();
			foreach ($rincian as $key => $rinci) {
				$biaya = 0;
				$sama = false;
				foreach ($transaksi as $ky => $tr) {
					$tipe_laporan_kasir_id = $jenis_tarif->find($tr['jenis_tarif_id'])->tipe_laporan_kasir_id;
					if ($tipe_laporan_kasir_id == $rinci['id']) {
						$sama = true;
						$biaya += $tr['biaya'];
					}
				}
				if ($sama) {
					$temp .= '<td>' .$biaya. '</td>';
				} else {
					$temp .= '<td></td>';
				}
			}
			return $temp;
		}

		public static function suratSakit($periksa){
			return 'Surat keterangan sakit selama <strong>' . $periksa->suratSakit->hari . ' hari</strong> mulai tanggal <strong> ' . Yoga::updateDatePrep($periksa->suratSakit->tanggal_mulai) . ' </strong> s/d <strong>' . $periksa->suratSakit->akhir .'</strong>';
		}

		public static function  periksaAwal($tekanan_darah, $berat_badan, $suhu, $tinggi_badan){
			if($tekanan_darah != '' || $berat_badan != '' || $suhu != '' || $tinggi_badan != ''){
				$periksa_awal =
				[
					'tekanan_darah' => $tekanan_darah,
					'berat_badan'	=> $berat_badan,
					'suhu'			=> $suhu,
					'tinggi_badan'	=> $tinggi_badan
				];
			} else {
				$periksa_awal = [];
			}

			return json_encode($periksa_awal);
		}

		public static function nowIfEmpty($tanggal) {
				if ($tanggal == '') {
					$tanggal = date('Y-m-d');
				} else {
					$tanggal = Yoga::datePrep($tanggal);
				}

				return $tanggal;
		}
		public static function nowIfEmptyMulai($tanggal) {
				if ($tanggal == '') {
					$tanggal = date('Y-m-d')  . ' 00:00:00';
				} else {
					$tanggal = Yoga::datePrep($tanggal) . ' 00:00:00';
				}

				return $tanggal;
		}
		public static function nowIfEmptyAkhir($tanggal) {
				if ($tanggal == '') {
					$tanggal = date('Y-m-d'). ' 23:59:59';
				} else {
					$tanggal = Yoga::datePrep($tanggal) . ' 23:59:59';
				}

				return $tanggal;
		}
		public static function confirmList() {

			return \Cache::remember('confirmList', 60, function() {	
				return Confirm::pluck('confirm', 'id')->all();
			});

		}
		public static function refleksPatelasList() {

			return \Cache::remember('refleksPatelasList', 60, function() {	
				return RefleksPatela::pluck('refleks_patela', 'id')->all();
			});
		}
		public static function kepalaTerhadapPapsList() {

			return \Cache::remember('kepalaTerhadapPapsList', 60, function() {	
				return KepalaTerhadapPap::pluck('kepala_terhadap_pap', 'id')->all();
			});
		}
		public static function presentasisList() {

			return \Cache::remember('presentasisList', 60, function() {	
				return Presentasi::pluck('presentasi', 'id')->all();
			});
		}
		public static function bukusList() {
			return \Cache::remember('bukusList', 60, function() {	
				return Buku::pluck('buku', 'id')->all();
			});
		}
		public static function tipeRumahSakitList() {
			return \Cache::remember('tipeRumahSakitList', 60, function() {	
				return [ null => '- pilih -'] +  JenisRumahSakit::pluck('jenis_rumah_sakit', 'id')->all();
			});
		}
		public static function statusGizi($lila) {
			if (is_numeric($lila)) {
				$param = $lila/28.5;
				if ($param< 0.9) {
					return 'underweight';
				} elseif( $param >=0.9 and $param <=1.1){
					return 'normal';
				} elseif( $param > 1.1 and $param <= 1.2){
					return 'overweight';
				} elseif($param > 1.2){
					return 'obese';
				} else {
					return 'tidak tahu';
				}
			} else {
				return 'tidak tahu';
			}
		}

		public static function registerHamilList($pasien_id){

			return [ null => '- pilih -'] + RegisterHamil::where('pasien_id', $pasien_id)->get()->pluck('namagpa', 'id')->toArray();

		}

		public static function returnConfirm($key){

			if ($key == '1') {
				return 'Tidak Tau';
			} else if($key == '2'){
				return 'Pasien Tidak Bawa';
			} elseif($key == '3')
			{
				return 'Ya';
			}

		}

		public static function golonganDarahList(){

			$list = [
				'A' => 'A',
				'B' => 'B',
				'AB' => 'AB',
				'O' => 'O'
			];

			return [ null => '-pilih '] + $list;
		}

		public static function terapi($terapi){
			try {

			$puyer = false;
	        $add = false;
		        // return $terapi;

		        if($terapi != ""){
	                $MyArray = json_decode($terapi, true);
		            } else {
		                $MyArray = [];
		            }
		            $temp = '<table width="100%" class="tabelTerapi">';
		          if (count($MyArray) > 0){

		            for ($i = 0; $i < count($MyArray) - 1; $i++) {

		                $MyArray[$i]['rak_id'] = Merek::find($MyArray[$i]['merek_id'])->rak_id;

		                if (substr($MyArray[$i]['signa'], 0, 5) == "Puyer" && $puyer == false ) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px">R/</td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$i]['jumlah'] . '</td>';
		                    $temp .= '</tr>';

		                    if ($MyArray[$i]['signa'] == $MyArray[$i + 1]['signa']) {
		                       $puyer = true;
		                    } else {
		                       $puyer = false;
		                    }


		                } else if (substr($MyArray[$i]['signa'], 0, 5) == "Puyer" && $puyer == true) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$i]['jumlah'] . '</td>';
		                    $temp .= '</tr>';

		                    if ($MyArray[$i]['signa'] == $MyArray[$i + 1]['signa']) {
		                        $puyer = true;
		                    } else {
		                       $puyer = false;
		                    }

		                } else if ($MyArray[$i]['merek_id'] == -1 || $MyArray[$i]['merek_id'] == -3) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$i]['jumlah'] . ' puyer ' . $MyArray[$i]['signa'] . '</td>';
		                    $temp .= '<td style="border-bottom:1px solid #000;"  nowrap>' . $MyArray[$i]['aturan_minum'] . '</td>';
		                    $temp .= '</tr>';

		                   $puyer = false;

		                } else if (substr($MyArray[$i]['signa'], 0, 3) == "Add" && $add == false) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px">R/</td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> fls No : ' . $MyArray[$i]['jumlah'] . '</td>';
		                    $temp .= '</tr>';
		                    $temp .= '<tr>';
		                    $temp .= '<td style="text-align:center;" colspan="3">ADD</td>';
		                    $temp .= '</tr>';

		                    $add = true;


		                } else if (substr($MyArray[$i]['signa'], 0, 3) == "Add" && $add == true) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$i]['jumlah'] . '</td>';
		                    $temp .= '</tr>';

		                    if ($MyArray[$i]['signa'] == $MyArray[$i + 1]['signa']) {
		                        $add = true;
		                    } else {
		                        $add = false;
		                    }

		                } else if ($MyArray[$i]['merek_id'] == -2) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;">S Masukkan ke dalam sirup ' . $MyArray[$i]['signa'] . ' </td>';
		                    $temp .= '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
		                    $temp .= '</tr>';

		                   $puyer = false;

		                } else {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px">R/</td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$i]['jumlah'] . '</td>';
		                    $temp .= '</tr><tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;"> S ' . $MyArray[$i]['signa'] . '</td>';
		                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$i]['aturan_minum'] . '</td>';
		                    $temp .= '</tr>';
		                }
		            }

		          

		                $a = count($MyArray) - 1;
		                $MyArray[$a]['rak_id'] = Merek::find($MyArray[$a]['merek_id'])->rak_id;


		                if ($MyArray[$a]['merek_id'] == -1 || $MyArray[$a]['merek_id'] == -3) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' . $MyArray[$a]['jumlah'] . ' puyer ' . $MyArray[$a]['signa'] . '</td>';
		                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]['aturan_minum'] . '</td>';

		                   $puyer = false;

		                } else if ($MyArray[$a]['merek_id'] == -2) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;" >S Masukkan ke dalam sirup ' . $MyArray[$a]['signa'] . '</td>';
		                    $temp .= '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';

		                    $add = false;
		                } else if (substr($MyArray[$a]['signa'], 0, 3) == "Add" && $add == false) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px">R/</td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> fls No : ' . $MyArray[$a]['jumlah'] . '</td>';
		                    $temp .= '</tr>';
		                    $temp .= '<tr>';
		                    $temp .= '<td  style="text-align:center;" colspan="3">ADD</td>';

		                    $add = true;


		                } else if (substr($MyArray[$a]['signa'], 0, 3) == "Add" && $add == true) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$a]['jumlah'] . '</td>';


		                } else if (substr($MyArray[$a]['signa'], 0, 5) == "Puyer" && $puyer == false) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px">R/</td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$a]['jumlah'] . '</td>';

		                } else if (substr($MyArray[$a]['signa'], 0, 5) == "Puyer" && $puyer == true) {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$a]['jumlah'] . '</td>';

		                } else {

		                    $temp .= '<tr>';
		                    $temp .= '<td style="width:15px">R/</td>';
		                    $temp .= '<td nowrap style="text-align:left; width:150px" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' . $MyArray[$i]['merek_id'] . '" onclick="informasi(this); return false; " href="#" >' . $MyArray[$i]['merek'] . '</a></td>';
		                    $temp .= '<td> No : ' . $MyArray[$a]['jumlah'] . '</td>';
		                    $temp .= '</tr><tr>';
		                    $temp .= '<td style="width:15px"></td>';
		                    $temp .= '<td style="width:150px;border-bottom:1px solid #000;"> S ' . $MyArray[$a]['signa'] . '</td>';
		                    $temp .= '<td style="border-bottom:1px solid #000;" nowrap>' . $MyArray[$a]['aturan_minum'] . '</td>';
		                }
		             }
		            $temp .= '</tr></table>';

		            return $temp;
					
				} catch (\Exception $e) {
					return '';
				}
		}

		public static function soOption(){
			$date = date('Y-m');
			$query = "SELECT m.merek as merek, ";
			$query .= "r.id as rak_id, ";
			$query .= "m.id as merek_id, ";
			$query .= "r.stok as stok ";
			$query .= "from mereks as m ";
			$query .= "join raks as r on r.id = m.rak_id ";
			$query .= "where r.id not in (";
				$query .= "select rak_id ";
				$query .= "from stok_opnames ";
				$query .= "where created_at like '{$date}%'";
			$query .= ")";
			$query .= "and m.tenant_id = " . session()->get('tenant_id') . " ";
			$mereks = DB::select($query);

			return $mereks;
		}

		public static function cacheku($name, $data){
			if (!\Cache::has($name)) {
				\Cache::put($name, $data, 60);
			}
			return \Cache::get($name);

		}

		public static function masukLagi($terapi){
			$terapis = json_encode($terapi);
			$terapis = json_decode($terapi, true);
			//return $terapi;
			foreach ($terapi as $k => $v) {
				$signa = $v['signa'];
				$terapis[$k]['harga_jual_ini'] = $v->merek->rak->harga_jual;
				$terapis[$k]['merek_obat']     = $v->merek->merek;
				$terapis[$k]['rak_id']         = $v->merek->rak_id;
				$terapis[$k]['cunam_id']         = $v->merek->rak->formula->cunam_id;
				$terapis[$k]['harga_jual']     = $v->merek->rak->harga_jual;
				$terapis[$k]['formula_id']     = $v->merek->rak->formula_id;
				if ($signa == 'Puyer' && $v->merek->rak_id == 'D7') {
					$terapis[$k]['fornas']         = '1';
				} else {
					$terapis[$k]['fornas']         = (string)$v->merek->rak->fornas;
				}
			}
			return $terapis;
		}

		public static function inputImageIfNotEmpty($image, $id){
			return self::image($image, $id, 'pasien/img');
		}
		public static function inputKtpIfNotEmpty($image, $id){
			return self::image($image, $id, 'pasien/ktp');
		}
		public static function inputBPJSIfNotEmpty($image, $id){
			return self::image($image, $id, 'pasien/bpjs');
		}
		public static function inputStafImageIfNotEmpty($image, $id){
			return self::image($image, $id, 'staf/img');
		}
		public static function inputStafKtpIfNotEmpty($image, $id){
			return self::image($image, $id, 'staf/ktp');
		}
		public static function inputImageIRujukanfNotEmpty($image, $id){ //$id = $periksa_id
			return self::image($image, $id, 'pasien/rjk');
		}

		public static function totalBiayaTerapi($terapis){
			$biaya = 0;
			foreach ($terapis as $key => $terapi) {
				$biaya += $terapi->jumlah * $terapi->harga_beli_satuan;
			}

			return $biaya;
		}

		public static function totalBiaya($array){
			$biaya = 0;
			foreach ($array as $key => $arr) {
				$biaya += $arr['biaya'];
			}
			return $biaya;
		}
		public static function totalBiayaTerapiJual($array){
			$biaya = 0;
			foreach ($array as $key => $arr) {
				$biaya += $arr->harga_jual_satuan * $arr->jumlah;
			}
			return $biaya;
		}

		public static function sukses($text){
			$temp = '<p class="bg-padding bg-success">';
			$temp .= $text;
			$temp .= '</p>';
			return $temp;
		}
		public static function gagal($text){
			$temp = '<p class="bg-padding bg-danger">';
			$temp .= $text;
			$temp .= '</p>';
			return $temp;
		}
		public static function suksesFlash($text){
			$temp = '<div class="text-left alert alert-success">';
			$temp .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>SUKSES!!  </strong>';
			$temp .= $text;
			$temp .= '</div>';
			return $temp;
		}
		public static function infoFlash($text){
			$temp = '<div class="text-left alert alert-info">';
			$temp .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>PETUNJUK :  </strong>';
			$temp .= $text;
			$temp .= '</div>';
			return $temp;
		}

		public static function Flash($text){
			$temp = '<div class="text-left alert alert-success">';
			$temp .= $text;
			$temp .= '</div>';
			return $temp;
		}
		public static function gagalFlash($text){
			$temp = '<div class="text-left alert alert-danger">';
			$temp .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>GAGAL !! </strong>';
			$temp .= $text;
			$temp .= '</div>';
			return $temp;
		}

		public static function hargaJualSatuan($asuransi, $merek_id){
			$merek = Merek::with('rak')->where('id', $merek_id)->first();
			if ($asuransi->tipe_asuransi_id == 5) { //asuransi bpjs
				$fornas = $merek->rak->fornas;
				if ($fornas == '1') {
					$harga_jual_satuan = 0;
				} else {
					$harga_jual_satuan = $merek->rak->harga_jual * $asuransi->kali_obat;
				}
			} else {
				$harga_jual_satuan = $merek->rak->harga_jual * $asuransi->kali_obat;
			}

			return $harga_jual_satuan;
		}

		public static function bulanList(){
			return [
				null => '-pilih-',
				'01'    => 'Januari',
				'02'    => 'Februari',
				'03'    => 'Maret',
				'04'    => 'April',
				'05'    => 'Mei',
				'06'    => 'Juni',
				'07'    => 'Juli',
				'08'    => 'Agustus',
				'09'    => 'September',
				'10'   => 'Oktober',
				'11'   => 'November',
				'12'   => 'Desember'
			];
		}

		public static function bukuBesarDebit($jurnalumums, $k){
			$value = 0;
			for ($i=0; $i < $k + 1 ; $i++) { 
				$nilai1 = 0;
				if ($jurnalumums[$i]->debit == '1') {
					$value += $jurnalumums[$i]->nilai;					
				} else {
					$value -= $jurnalumums[$i]->nilai;
				}
			}
			if ($value > 0) {
				return $value;
			}
		}
		public static function bukuBesarKredit($jurnalumums, $k){
			$value = 0;
			for ($i=0; $i < $k + 1 ; $i++) { 
				$nilai1 = 0;
				if ($jurnalumums[$i]->debit == '1') {
					$value += $jurnalumums[$i]->nilai;					
				} else {
					$value -= $jurnalumums[$i]->nilai;
				}
			}
			if ($value < 0) {
				return abs($value);
			}
		}


		public static function neracaDebet($jus){
			$value = 0;
			foreach ($jus as $k => $ju) {
				if ($ju['nilai'] > 0) {
					$value += $ju['nilai'];
				}
			}
			return $value;
		}

		public static function neracaKredit($jus){
			$value = 0;
			foreach ($jus as $k => $ju) {
				if ($ju['nilai'] < 0) {
					$value += $ju['nilai'];
				}
			}
			return abs($value);
		}
		public static function neracaLabaRugi($jus){
			$value = 0;
			foreach ($jus as $k => $ju) {
				$value += $ju['nilai'];
			}
			return abs($value);
		}

	public static function getSumCoa($jurnalumums, $tahun, $bulan)
	{
        $jurnalumums = json_encode($jurnalumums);
        $jurnalumums = json_decode($jurnalumums, true);
        

        foreach ($jurnalumums as $k => $v) {

            $jurnals = JurnalUmum::where('coa_id', $v['coa_id'])
                    ->where('created_at', 'like', $tahun . '-' . $bulan . '%')->get();

            $value = 0;
            foreach ($jurnals as $key => $j) {
                if ($j->debit == '1') {
                    $value += $j->nilai;
                } else {
                    $value -= $j->nilai;
                }
            }

            $jurnalumums[$k]['nilai'] = $value;
        }

        return $jurnalumums;
	}


	public static function cekGDSBulanIni($pasien, $periksaIni){
		$sudahBulanIni   = false;
		$bayar           = false;
		$dikasihObatGula = false;
		$tanggal         = '';
		$created_at      = '';
		if ($periksaIni != null) {
			$periksas = Periksa::with('transaksii')
				->where('pasien_id', $pasien->id)
				->where('tanggal', 'like', date('Y-m') . '%')
				->where('id', '<', $periksaIni->id)
				->get();
		} else {
			$periksas = Periksa::with('transaksii')
				->where('pasien_id', $pasien->id)
				->where('tanggal', 'like', date('Y-m') . '%')
				->get();
		}
		foreach ($periksas as $k => $v) 
		{
			foreach ($v->transaksii as $key => $value) {
			 	if ($value->jenis_tarif_id ==  JenisTarif::where('jenis_tarif', 'Gula Darah')->first()->id && $value->biaya == '0') {
			 		$bayar = true;
			 		$sudahBulanIni = true;
			 		$tanggal = $v->tanggal;
			 		$created_at = $v->created_at;
			 		break;
			 	}
			 }
			 if ($sudahBulanIni) {
			 	return [
			 		'bayar' => true,
			 		'sudahGDS' => true,
			 		'tanggal' => $tanggal
			 	];
			 }
		}

		
		$pernahDiagnosaDM= false;

		$periksas = Periksa::with(
			'terapii.merek.rak.formula', 
			'diagnosa'
		)->where('pasien_id', $pasien->id)->get();
		foreach ($periksas as $key => $periksa) {
			if (isset( $periksa->diagnosa->diagnosa )) {
				if (strpos( $periksa->diagnosa->diagnosa, 'DM ' ) !== false || strpos( $periksa->keterangan_diagnosa, 'DM ' ) !== false) {
					$pernahDiagnosaDM = true;		
				}
			}

			//---------------------
			// coba
			//
			/* $ddd = []; */
			/* //--------------------- */

			/* dd($periksa); */
			/* foreach ($periksa->terapii as $k => $terapi) { */
			/* 	try { */
			/* 		$aturan_minum_id = $terapi->merek->rak->formula->aturan_minum_id; */
			/* 		if ($aturan_minum_id == '3' || $pernahDiagnosaDM) { */
			/* 			$dikasihObatGula = true; */
			/* 		} */

			/* 	} catch (\Exception $e) { */
			/* 		$ddd[] = $terapi->merek_id; */
					
			/* 	} */
			/* 	/1* $aturan_minum_id = $terapi->merek->rak->formula->aturan_minum_id; *1/ */
			/* 	/1* if ($aturan_minum_id == '3' || $pernahDiagnosaDM) { *1/ */
			/* 	/1* 	$dikasihObatGula = true; *1/ */
			/* 	/1* } *1/ */
			/* } */
		}
		$umur = Yoga::umur($pasien->tanggal_lahir);
		if ($dikasihObatGula || ($umur > 50)) {
		} else {
			$bayar = true;
		}
		return [
			'bayar'    => $bayar,
			'sudahGDS' => $sudahBulanIni,
			'tanggal'  => $tanggal
			];
	}

	public static function pakaiBayarPribadi($asuransi_id, $pasien_id, $pemeriksaanTerakhir = null){
		$pakai_bayar_pribadi = false;
        $asuransi_bpjs = Asuransi::Bpjs();
		if ($asuransi_id == $asuransi_bpjs->id)  {
			//cek pemeriksaan dalam 3 minggu terakhir yang memakai biaya pribadi
			$periksa3mingguTerakhirPakaiBiayaPribadi = Periksa::where('pasien_id', $pasien_id)
			->whereRaw("date(tanggal) between '" . date( 'Y-m-d', strtotime( date('Y-m-d') . ' -21 day' ) ) . "' and '" .date('Y-m-d'). "'")
			->where('asuransi_id', 0)
			->get();

			//Cek Pemeriksaan terakhir
			//
			if($pemeriksaanTerakhir != null){
				if ($pemeriksaanTerakhir->asuransi_id == $asuransi_bpjs->id) {
					$periksaTerakhirGakPakaiBPJS = false;
				} else {
					$periksaTerakhirGakPakaiBPJS = true;
				}
			} else {
				$periksaTerakhirGakPakaiBPJS = false;
			}
			if ($periksa3mingguTerakhirPakaiBiayaPribadi->count() > 0 || $periksaTerakhirGakPakaiBPJS) {
				$pakai_bayar_pribadi = true;
			}
			//jika pakai_bayar_pribadi = true
			//Peringatkan dokter kemungkinan adanya pasien kontrol pasca KLL atau Kecelakaan Kerja
		}
		return $pakai_bayar_pribadi;
	}

	public static function terapiSortBaru($periksa_id){
		$terapis_baru = [];
		$terapis = Terapi::where('periksa_id', $periksa_id)->get();
		foreach ($terapis as $k => $v) {
			$formula_id     = $v->merek->rak->formula_id;
			$signa          = $v->signa;
			$jumlah         = $v->jumlah;
			$terapis_baru[] = [
				'formula_id'    => $formula_id,
				'signa'         => $signa,
				'jumlah'        => $jumlah
			];
		}
		return json_encode($terapis_baru);
	}
    public static function TujuanRujukList(){
		return array('' => '- Pilih Dokter Spesialis -') + TujuanRujuk::pluck('tujuan_rujuk', 'id')->all();
    }
    public static function hitungTindakan($asuransi_id, $jenis_tarif_id, $tanggal){
		$query = "SELECT * ";
		$query .= "FROM transaksi_periksas as tp ";
		$query .= "join periksas as px on px.id = tp.periksa_id ";
		$query .= "join jenis_tarifs as jt on jt.id=tp.jenis_tarif_id ";
		$query .= "where tp.created_at >= '{$tanggal}' ";
		$query .= "and tp.jenis_tarif_id = {$jenis_tarif_id} ";
		$query .= "and px.asuransi_id = '{$asuransi_id}' ";
		$query .= "and tp.tenant_id = " . session()->get('tenant_id') . " ";
        $biaya = 0;
        foreach (DB::select($query) as $trx) {
            $biaya += $trx->biaya;
            
        }
        return count(DB::select($query)) . '<br />' . '( <span class="uang"> ' . $biaya . '</span> )';
    }
    public static function buatrp($angka){
        $jadi = "Rp. " . number_format($angka,0,',','.') . ',-';
        return $jadi;
    }
	public static function image($image, $id, $custom_url){
		$confirm = false;
		if (!empty($image)) {
			if (gethostname() == 'homestead') {
				$path = '/home/vagrant/Code/kje/public/img/'. $custom_url . $id . '.png';
			} else {
				$path = '/var/www/kje/public/img/' . $custom_url . $id . '.png';
				//$dropbox = '/home/kje/Dropbox/backup11/img/' . $custom_url . $id . '.png';
			}
			$urlImage = '/img/'. $custom_url . $id . '.png';
			$data     = $image;
			$data     = explode(',', $data);
			if (count($data) > 1) {
				$data     = base64_decode($data[1]);
			}
			$confirm  = file_put_contents($path, $data);
			if ($confirm) {
				if (isset( $dropbox )) {
					file_put_contents($dropbox, $data);
				}
				return $urlImage;
			} else {
				return null;
			}
		} 
	}
	public static function periksa_by_asuransi($tanggal, $asuransi_id, $poli){
		return Periksa::where('tanggal', $tanggal)
						->where('asuransi_id', $asuransi_id)
						->where('poli', $poli)
						->count();
	}
	public static function periksa_by_poli($tanggal, $poli){
		return Periksa::where('tanggal', $tanggal)->where('poli', $poli)->count();
	}
	
	    
	public static function perujukList(){
		return [ null => '-pilih-' ] + Perujuk::pluck('nama', 'id')->all();
	}
	
	public static function sumberCoaList(){
		return [ null => '-pilih-' ] + Coa::whereRaw('kode_coa between 110000 and 110004')->pluck('coa', 'id')->all();
	}
	public static function sumberuang(){
		$sumber_uang[null] = '-Pilih-';
		$sumber_uang[ Coa::where('kode_coa', 110000)->first()->id ] = 'Uang yang diambil dari kasir';
		$sumber_uang[ Coa::where('kode_coa', 110004)->first()->id ] = 'Uang punya dokter Yoga';

		return $sumber_uang;
	}
	
	public static function masaPakai(){
		$pluck = [ null => '-pilih-' ];
		$gol = GolonganPeralatan::all();
		foreach ($gol as $g) {
			$pluck[$g->masa_pakai] = $g->golongan_peralatan . ' (' . $g->masa_pakai . ' tahun)';
		}
		return $pluck;
	}
	public static function golonganProlanis($pasien){
		$sistolik  = 0;
		$diastolik = 0;
		if ($pasien->periksa->count() > 0) {
			foreach ($pasien->periksa as $p) {
				$sistolik  += $p->sistolik;
				$diastolik += $p->diastolik;
			}
		}
		if ( $pasien->periksa->count() ) {
			if(
				( ($sistolik / $pasien->periksa->count()) > 139 ||  //  jika rata2 sistolik 140 atau lebih
				( ($diastolik / $pasien->periksa->count()) > 89 ) ) && // atau jika diastolik 90 atau lebih 
				$pasien->periksa->count() > 5 && // dan jika pasien sudah berobat lebih dari 5 kali
				$pasien->usia > 49 // dan pasien berumur 50 tahun atau lebih tua
			){
				return $pasien->no_telp; // kembalikan nomor telepon pasien
			} else {
				return '0'; // kembalikan angka 0
			}
		} else {
			return '0';
		}
	}

	public static function prolanis(){
		
		// Dapatkan pasien hipertensi lebih dari 3 x pemerikssaan dengan usia diatas 49 tahun
		$query = "select ps.id as pasien_id, ";
		$query .= "count(*) as jumlah, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "count( px.id ) as jumlah_kali_periksa, ";
		$query .= "sum( px.sistolik ) / count( px.id ) as rata_tensi, ";
		$query .= "px.pemeriksaan_fisik as pf, ";
		$query .= "ps.alamat as alamat, ";
		$query .= "ps.no_telp as no_hp, ";
		$query .= "ps.id as pasien_id, ";
		$query .= "TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, ";
		$query .= "CURDATE()) as age, ";
		$query .= "px.pemeriksaan_penunjang as lab ";
		$query .= "from periksas as px ";
		$query .= "join asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, CURDATE()) > 49 ";
		$query .= "and asu.tipe_asuransi_id=5 ";
		$query .= "and px.sistolik not like '' ";
		$query .= "and px.sistolik is not null ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by ps.id ";
		$query .= "having sum( px.sistolik ) / count( px.id ) >139 ";

		$datas = DB::select($query);

		$pasien_ht = [];
		foreach ($datas as $data) {
			$pasien_ht[] = $data->pasien_id;
		}

		$query  = "select ps.id as pasien_id, ";
		$query .= "count(*) as jumlah, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "px.pemeriksaan_fisik as pf, ";
		$query .= "ps.alamat as alamat, ";
		$query .= "ps.no_telp as no_hp, ";
		$query .= "TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, CURDATE()) as age, ";
		$query .= "px.pemeriksaan_penunjang as lab ";
		$query .= "from periksas as px ";
		$query .= "join asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "join diagnosas as dg on dg.id = px.diagnosa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "join transaksi_periksas as trx on trx.periksa_id = px.id ";
		$query .= "join jenis_tarifs as jtf on jtf.id = trx.jenis_tarif_id ";
		$query .= "where asu.tipe_asuransi_id= 5 ";
		$query .= "and TIMESTAMPDIFF(YEAR, ps.tanggal_lahir, CURDATE()) > 49 ";
		$query .= "and jtf.jenis_tarif = 'Gula Darah' ";
		$query .= "and trx.keterangan_pemeriksaan not like '' ";
		$query .= "and trx.keterangan_pemeriksaan is not null ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by ps.id ";
		$query .= "having sum( cast(trx.keterangan_pemeriksaan as unsigned) ) / count( trx.id ) > 210 ";

		$dms = DB::select($query);
		$pasien_dm = [];
		foreach ($dms as $dm) {
			$pasien_dm[] = $dm->pasien_id;
		}
		$pasien_ht =  array_unique($pasien_ht);
		$pasien_dm =  array_unique($pasien_dm);

		return [
			'pasien_dm' => $pasien_dm,
			'pasien_ht' => $pasien_ht
		];
	}
	
	public static function imageBPJSFromBrowser($image, $id){
		$filename = null;
		if (!empty( $image )) {
			// Mengambil file yang di upload
			$upload_cover = $request->file('cover');

			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	'bpjs'. $id . '_' . time(). '.' . $extension;

			//menyimpan cover ke folder public/img
			$destination_path =  'img/pasien/';
			/* $upload_cover->move($destination_path, $filename); */
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));

			//mengisi field cover di book dengan filename yang baru dibuat
				
		}

		return $filename;
	}
	public static function imageKTPFromBrowser($image, $id){

		$filename = null;
		if (!empty( $image )) {
			// Mengambil file yang di upload
			$upload_cover = $request->file('cover');

			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	'ktp'. $id . '_' .  time().'.' . $extension;

			//menyimpan cover ke folder public/img
			$destination_path = 'img/pasien/';
			/* $upload_cover->move($destination_path, $filename); */

			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			//mengisi field cover di book dengan filename yang baru dibuat
				
		}
		return $filename;

	}
	public static function getDayFromFacebook($date){
		try {
			$MyArray = explode("/", $date);
			return $MyArray[1];
			
		} catch (\Exception $e) {
			return null;
		}
	}
	public static function getMonthFromFacebook($date){
		try {
			$MyArray = explode("/", $date);
			return $MyArray[0];
			
		} catch (\Exception $e) {
			return null;
		}
	}
	
	public static function getYearFromFacebook($date){
		try {
			$MyArray = explode("/", $date);
			return $MyArray[2];
			
		} catch (\Exception $e) {
			return null;
		}
	}
	
	
	public static function editYearFromFacebook($date){
		return self::editTanggal($date, 0);
	}
	
	public static function editMonthFromFacebook($date){
		return self::editTanggal($date, 1);
	}

	public static function editDayFromFacebook($date){
		return self::editTanggal($date, 2);
	}
	public static function editTanggal($tanggal, $i){
		try {
			$MyArray = explode("-", $tanggal);
			return $MyArray[$i];
			
		} catch (\Exception $e) {
			return null;
		}
	}
	public static function dokterList(){
        return [null => '- Pilih -'] + Staf::where('titel_id', 2)->get()->pluck('nama', 'id')->toArray();
	}
	
	public static function sms($telepon, $message){
		// Script http API SMS Reguler Zenziva

		$userkey=env('ZENZIVA_USERKEY'); // userkey lihat di zenziva

		$passkey=env('ZENZIVA_PASSKEY'); // set passkey di zenziva

		$url = 'https://reguler.zenziva.net/apps/smsapi.php';$curlHandle = curl_init();

		curl_setopt($curlHandle, CURLOPT_URL, $url);

		curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$telepon.'&pesan='.urlencode($message));

		curl_setopt($curlHandle, CURLOPT_HEADER, 0);

		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);

		curl_setopt($curlHandle, CURLOPT_POST, 1);

		$results = curl_exec($curlHandle);

		curl_close($curlHandle);
		return $results;
	}

	public static function pengantarBerobat($pasien_id, $bulanTahun){
	   return Periksa::where('pasien_id', $pasien_id)
			->where('tanggal', $bulanTahun)
			->get(['created_at']);
	}
	

	public static function pengantarMengantar($pasien_id, $bulanTahun){
	   return PengantarPasien::where('pengantar_id', $pasien_id)
			->where('created_at', 'like', $bulanTahun . '%')
			->where('pcare_submit', '1')
			->get(['created_at']);
	}
	
	public static function pengantarKunjunganSakit($pasien_id, $bulanTahun){
		$query = "SELECT ks.created_at FROM kunjungan_sakits as ks join periksas as px on px.id = ks.periksa_id ";
		$query .= "WHERE px.pasien_id = '{$pasien_id}' ";
		$query .= "AND ks.created_at like '{$bulanTahun}%' ";
		$query .= "AND ks.pcare_submit = 0 ";
		$query .= "and ks.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "ORDER BY ks.created_at desc ";
		return DB::select($query);
	}
	public static function even($number){
		if ($number % 2 == 0) {
		  return true;
		}
		return false;
	}
	public static function antrianTerakhir($tanggal){
		/* $periksa = Periksa::where('created_at', 'like', $tanggal. '%') */
		/* 	->orderBy('antrian', 'desc') */
		/* 	->first(); */
		/* $periksa = isset($periksa->antrian)? $periksa->antrian : 0; */
		/* $antrianperiksa = AntrianPeriksa::where('created_at', 'like', $tanggal. '%') */
		/* 	->orderBy('antrian', 'desc') */
		/* 	->first(); */
		/* $antrianperiksa = isset($antrianperiksa->antrian)? $antrianperiksa->antrian : 0; */
		/* $antrianpoli = AntrianPoli::where('created_at', 'like', $tanggal. '%') */
		/* 	->orderBy('antrian', 'desc') */
		/* 	->first(); */
		/* $antrianpoli = isset($antrianpoli->antrian)? $antrianpoli->antrian : 0; */

		/* return max( [ */
		/* 	$periksa, */
		/* 	$antrianperiksa, */
		/* 	$antrianpoli */
		/* ] ); */
	}
	public static function pasienSurvey(){
		 return [ 
			'0' => 'Pasien tidak keberatan menerima SMS survey',
			'1' => 'Pasien keberatan menerima SMS survey'
	   	];
		
	}
	public static function monthInterval($before, $after){
		$date1 = new DateTime($before);
		$date2 = new DateTime($after);
		$interval = date_diff($date1, $date2);
		return  $interval->m + ($interval->y * 12);
	}
	public static function monthLater($date, $n){
		$time = strtotime($date);
		$final = date("Y-m-d H:i:s", strtotime("+" . $n . " month", $time));
		return $final;
	}
	public static function bulan($num){
		if ($num == 1) {
			return 'Jan';
		} else if( $num == 2 ){
			return 'Feb';
		} else if( $num == 3 ){
			return 'Mar';
		} else if( $num == 4 ){
			return 'Apr';
		} else if( $num == 5 ){
			return 'Mei';
		} else if( $num == 6 ){
			return 'Jun';
		} else if( $num == 7 ){
			return 'Jul';
		} else if( $num == 8 ){
			return 'Ags';
		} else if( $num == 9 ){
			return 'Sep';
		} else if( $num == 10 ){
			return 'Okt';
		} else if( $num == 11 ){
			return 'Nov';
		} else if( $num == 12 ){
			return 'Des';
		} else {
			return '???';
		}
	}
	public static function statusMenikahList(){
		return [
			null => '- Pilih Merek -',
			'0' => 'Belum Menikah',
			'1' => 'Sudah Menikah'
		];
	}
	
	public static function adaPenghasilanLainList(){
		return [
			null => '- Pilih -',
			'0' => 'Tidak Ada',
			'1' => 'Ada'
		];
	}
	public static function pilihan($positif){
		return [
			null => '- Pilih -',
			'0' => 'Tidak',
			'1' => $positif
		];
	}
	public static function jenisKelaminList(){
		return [
			null => '- Pilih -',
			'1' => 'Laki-laki',
			'0' => 'Perempuan'
		];

	}
	public static function manyRows(){
		return [

			null => '- Pilih -',
			10 => '10 Baris',
			15 => '15 Baris',
			20 => '20 Baris',
			30 => '30 Baris',
			50 => '50 Baris'
		];
	}
	public static function konfirmasi(){
		return [

			null => '- Pilih -',
			0 => 'Belum Selesai',
			1 => 'Sudah Selesai'
		];
	}

	public static function bangunanPermanen(){
		return [
			null => '- Pilih -',
			0 => 'Tidak Permanen',
			1 => 'Permanen'
		];
	}
	public static function manyDays($tanggal1, $tanggal2){
		$tanggal1 = strtotime($tanggal1);
		$tanggal2 = strtotime($tanggal2);
		$datediff = $tanggal1 - $tanggal2;
		return floor($datediff / (60 * 60 * 24));
	}
	public static function diffMonth($date1, $date2) {
		 $date1 = strtotime($date1);
		$date2 = strtotime($date2);

		$months = 0;

		while (strtotime('+1 MONTH', $date1) < $date2) {
			$months++;
			$date1 = strtotime('+1 MONTH', $date1);
		}

		return $months;
	}
	public static function yesNo($n){

		if ($n) {
			return 'Yes';
		} else {
			return 'No';
		}
	}
	public static function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	public static function normalisasiNoHp($nohp) {
		if ( empty($nohp) ) {
			return null;
		}
		// kadang ada penulisan no hp 0811 239 345
		$nohp = str_replace(" ","",$nohp);
		// kadang ada penulisan no hp (0274) 778787
		$nohp = str_replace("(","",$nohp);
		// kadang ada penulisan no hp (0274) 778787
		$nohp = str_replace(")","",$nohp);
		// kadang ada penulisan no hp 0811.239.345
		$nohp = str_replace(".","",$nohp);

		// cek apakah no hp mengandung karakter + dan 0-9
		
		$hp = null;
		if(!preg_match('/[^+0-9]/',trim($nohp))){
			// cek apakah no hp karakter 1-3 adalah +62
			if(substr(trim($nohp), 0, 3)=='+62'){
				$hp = trim($nohp);
			}
			// cek apakah no hp karakter 1 adalah 0
			elseif(substr(trim($nohp), 0, 1)=='0'){
				$hp = '+62'.substr(trim($nohp), 1);
			}
		}
		return $hp;
	}
	public static function bulanKeRomawi($m){
                switch ($m){
                    case '01': 
                        return "I";
                        break;
                    case '02':
                        return "II";
                        break;
                    case '03':
                        return "III";
                        break;
                    case '04':
                        return "IV";
                        break;
                    case '05':
                        return "V";
                        break;
                    case '06':
                        return "VI";
                        break;
                    case '07':
                        return "VII";
                        break;
                    case '08':
                        return "VIII";
                        break;
                    case '09':
                        return "IX";
                        break;
                    case '10':
                        return "X";
                        break;
                    case '11':
                        return "XI";
                        break;
                    case '12':
                        return "XII";
                        break;
                }
	}
	public static function whatDay(){

		$h = date('H');
		if ( (int)$h > 17) {
			return 'malam';
		} else if( (int)$h > 14){
			return 'sore';
		} else if( (int)$h > 10){
			return 'siang';
		} else if( (int)$h > 4){
			return 'pagi';
		} else {
			return 'malam';
		}
	}
	public static function tahunList(){
	  $time = strtotime("-10 year", time());
	  $year = date("Y", $time);
	  $result = [];
		for ($i = date('Y'); $i > $year  ; $i--) {
			$result[$i] = (string)$i;
		}
	  return $result;
	}
	public static function dateDiffNow($date){

		$now = time(); // or your date as well
		$your_date = strtotime($date);
		$datediff = $your_date - $now;

		return round($datediff / (60 * 60 * 24));
	}
	public static function numberToRomanRepresentation($number) {
		$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		$returnValue = '';
		while ($number > 0) {
			foreach ($map as $roman => $int) {
				if($number >= $int) {
					$number -= $int;
					$returnValue .= $roman;
					break;
				}
			}
		}
		return $returnValue;
	}
	public static function htTerkendali($d){
		$pdf = new PdfsController;
		return $pdf->htTerkendali($d);
	}

	public function jarakHari($date1, $date2){
		$date1 = strtotime($date1);
		$date2 = strtotime($date);
		$datediff = $date2 - $date1;
		return round($datediff / (60 * 60 * 24));
	}
	
}
