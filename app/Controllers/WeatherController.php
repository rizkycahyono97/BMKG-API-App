<?php
namespace App\Controllers;

use PDO;
use Database;
use App\Models\Weather;

class WeatherController {

    public function getWeather()
    {
        // Ambil parameter city dari query string
        $city = isset($_GET['city']) ? $_GET['city'] : '';

        if (empty($city)) {
            // Redirect pengguna ke halaman form
            view('dashboard', ['weather' => null, 'error' => 'Masukkan nama kota terlebih dahulu.']);
            return;
        }

        // Proses mencari idKota berdasarkan city
        $idKota = $this->getKotaIdFromCityName($city);
        if (empty($idKota)) {
            view('dashboard', ['weather' => null, 'error' => 'Kota tidak valid.']);
            return;
        }

        // URL API dengan idKota
        $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$idKota}";

        // Request ke API BMKG
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        // Cek apakah ada response
        if ($response) {
            $weatherData = json_decode($response, true);
        } else {
            $weatherData = null;
        }

        // Kirim data cuaca ke view
        view('dashboard', ['weather' => $weatherData, 'city' => $city, 'error' => null]);
    }
  

    private function getKotaIdFromCityName($city)
    {
        $kotaMapping = [
            // Jakarta
            'kepulauan seribu' => '31.01.01.1001',
            'jakarta pusat' => '31.71.01.1001', 
            'jakarta utara' => '31.72.01.1001',
            'jakarta barat' => '31.73.01.1001',
            'jakarta selatan' => '31.74.01.1001',
            'jakarta timur' => '31.75.01.1001',

            // Banten
            'kabupaten pandeglang' => '36.01.01.2001',
            'kabupaten lebak' => '36.02.01.2002',
            'kabupaten tangerang' => '36.03.01.1001',
            'kabupaten serang' => '36.04.05.2001',
            'kota tangerang' => '36.71.01.1001',
            'kota cilegon' => '36.72.01.1001',
            'kota serang' => '36.73.01.1001',
            'kota tangerang selatan' => '36.74.01.1001',

            // jawa barat
            'kabupaten bogor' => '32.01.01.1001',
            'kabupaten sukabumi' => '32.02.01.1001',
            'kabupaten cianjur' => '32.03.01.2001',
            'kabupaten bandung' => '32.04.05.2001',
            'kabupaten garut' => '32.05.01.1001',
            'kabupaten tasikmalaya' => '32.06.01.2001',
            'kabupaten ciamis' => '32.07.01.1001',
            'kabupaten kuningan' => '32.08.01.2001',
            'kabupaten cirebon' => '32.09.01.2008',
            'kabupaten majalengka' => '32.10.01.2001',
            'kabupaten sumedang' => '32.11.01.2001',
            'kabupaten indramayu' => '32.12.01.2007',
            'kabupaten subang' => '32.13.01.1001',
            'kabupaten purwakarta' => '32.14.01.1001',
            'kabupaten karawang' => '32.15.01.1001',
            'kabupaten bekasi' => '32.16.01.2001',
            'kabupaten bandung barat' => '32.17.01.2001',
            'kabupaten pangandaran' => '32.18.01.2001',
            'kota bogor' => '32.71.01.1001',
            'kota sukabumi' => '32.72.01.1001',
            'kota bandung' => '32.73.01.1001',
            'kota cirebon' => '32.74.01.1001',
            'kota bekasi' => '32.75.01.1001',
            'kota depok' => '32.76.01.1006',
            'kota cimahi' => '32.77.01.1001',
            'kota tasikmalaya' => '32.78.01.1001',
            'kota banjar' => '32.79.01.1001',

            // jawatengah
            'kabupaten cilacap' => '33.01.01.2001',
            'kabupaten banyumas' => '33.02.01.2001',
            'kabupaten purbalingga' => '33.03.01.2001',
            'kabupaten banjarnegara' => '33.04.01.2001',
            'kabupaten kebumen' => '33.05.01.2001',
            'kabupaten purworejo' => '33.06.01.2001',
            'kabupaten wonosobo' => '33.07.01.2001',
            'kabupaten magelang' => '33.08.01.2001',
            'kabupaten boyolali' => '33.09.01.2001',
            'kabupaten klaten' => '33.10.01.2001',
            'kabupaten sukoharjo' => '33.11.01.2001',
            'kabupaten wonogiri' => '33.12.01.2001',
            'kabupaten karanganyar' => '33.13.01.2001',
            'kabupaten sragen' => '33.14.01.2001',
            'kabupaten grobogan' => '33.15.01.2001',
            'kabupaten blora' => '33.16.01.2001',
            'kabupaten rembang' => '33.17.01.2001',
            'kabupaten pati' => '33.18.01.2001',
            'kabupaten kudus' => '33.19.01.2001',
            'kabupaten jepara' => '33.20.01.2001',
            'kabupaten demak' => '33.21.01.2001',
            'kabupaten semarang' => '33.22.01.2001',
            'kabupaten temanggung' => '33.23.01.2001',
            'kabupaten kendal' => '33.24.01.2001',
            'kabupaten batang' => '33.25.01.2001',
            'kabupaten pekalongan' => '33.26.01.2001',
            'kabupaten pemalang' => '33.27.01.2001',
            'kabupaten tegal' => '33.28.01.2001',
            'kabupaten brebes' => '33.29.01.2001',
            'kota magelang' => '33.71.01.2001',
            'kota surakarta' => '33.72.01.2001',
            'kota salatiga' => '33.73.01.2001',
            'kota semarang' => '33.74.01.2001',
            'kota pekalongan' => '33.75.01.2001',
            'kota tegal' => '33.76.01.2001',

            // Yogyakarta
            'kabupaten kulon progo' => '34.01.01.2001',
            'kabupaten bantul' => '34.02.01.2001',
            'kabupaten gunungkidul' => '34.03.01.2001',
            'kabupaten sleman' => '34.04.01.2001',
            'kota yogyakarta' => '34.71.01.1001',

            // jawa timur
            'kabupaten pacitan' => '35.01.01.2001',
            'kabupaten ponorogo' => '35.02.01.2001',
            'kabupaten trenggalek' => '35.03.01.2001',
            'kabupaten tulungagung' => '35.04.01.2001',
            'kabupaten blitar' => '35.05.01.2001',
            'kabupaten kediri' => '35.06.01.2001',
            'kabupaten malang' => '35.07.01.2001',
            'kabupaten lumajang' => '35.08.01.2001',
            'kabupaten jember' => '35.09.01.2001',
            'kabupaten banyuwangi' => '35.10.01.2001',
            'kabupaten bondowoso' => '35.11.01.2001',
            'kabupaten situbondo' => '35.12.01.2001',
            'kabupaten probolinggo' => '35.13.01.2001',
            'kabupaten pasuruan' => '35.14.01.2001',
            'kabupaten sidoarjo' => '35.15.01.2001',
            'kabupaten mojokerto' => '35.16.01.2001',
            'kabupaten jombang' => '35.17.01.2001',
            'kabupaten nganjuk' => '35.18.01.2001',
            'kabupaten madiun' => '35.19.01.2001',
            'kabupaten magetan' => '35.20.01.2001',
            'kabupaten ngawi' => '35.21.01.2001',
            'kabupaten bojonegoro' => '35.22.01.2001',
            'kabupaten tuban' => '35.23.01.2001',
            'kabupaten lamongan' => '35.24.01.2001',
            'kabupaten gresik' => '35.25.01.2001',
            'kabupaten bangkalan' => '35.26.01.2001',
            'kabupaten sampang' => '35.27.01.2001',
            'kabupaten pamekasan' => '35.28.01.2001',
            'kabupaten sumenep' => '35.29.01.2001',
            'kota kediri' => '35.71.01.2001',
            'kota blitar' => '35.72.01.2001',
            'kota malang' => '35.73.01.2001',
            'kota probolinggo' => '35.74.01.2001',
            'kota pasuruan' => '35.75.01.2001',
            'kota mojokerto' => '35.76.01.2001',
            'kota madiun' => '35.77.01.2001',
            'kota surabaya' => '35.78.01.2001',
            'kota batu' => '35.79.01.2001',
            // Tambahkan lebih banyak kota dan kode wilayahnya
        ];

        return isset($kotaMapping[$city]) ? $kotaMapping[$city] : null;
    }



}
