<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StorylineController extends Controller
{
    //

    public function index()
    {
        $title = "Storyline";
        
        $currentPhase = 1;

        // $maxUnlockedPhase = 4;

        $maxUnlockedPhase = DB::table('phases')
        ->where('status', 1)
        ->max('phase');

        
    $storylines =[
        1 =>"Pada tahun 2024, India berada di tengah krisis lingkungan, terutama dengan keberadaan kondisi iklim El Nino. 
        Polusi udara telah menjadi salah satu isu paling mendesak, dengan wilayah metropolitan seperti New Delhi mengalami tingkat polusi 
        yang melampaui ambang batas berbahaya. Musim dingin memperburuk keadaan, menciptakan kabut asap tebal akibat pembakaran jerami di wilayah pertanian sekitar. 
        Polusi udara ini tidak hanya merugikan kesehatan masyarakat tetapi juga menurunkan produktivitas pekerja. Terlebih lagi, krisis air bersih semakin memperburuk situasi. 
        Sungai-sungai utama seperti Yamuna dan Ganges menjadi simbol dari kerusakan lingkungan akibat limbah domestik, sisa-sisa pertanian. 
        Sektor agribisnis, yang menjadi tulang punggung masyarakat pedesaan India, terhambat oleh ketergantungan pada air tanah yang semakin menipis dan penurunan kualitas tanah akibat penggunaan pestisida berlebihan.",

        2 =>"Perubahan iklim mempengaruhi industri perikanan Norwegia secara signifikan, terutama dengan menurunnya populasi spesies ikan boreal seperti ikan kod Atlantik, 
        halibut Greenland, kakap merah, dan tombak. Jumlah ikan salmon juga diperkirakan akan terpengaruh, karena suhu air yang lebih hangat meningkatkan risiko serangan 
        parasit dan penyakit pada ikan. Di sisi lain, perubahan iklim menyebabkan sebagian wilayah selatan Norwegia menjadi semakin tidak cocok bagi sebagian spesies yang 
        kini cenderung bermigrasi ke wilayah utara. Spesies lain seperti kepiting salju Norwegia juga sensitif terhadap perubahan suhu sehingga jumlah yang bisa ditangkap 
        untuk perikanan komersial semakin berkurang.  Selain itu, perairan yang lebih hangat berdampak pada berkurangnya populasi makanan ikan yang lebih kecil, seperti plankton.",
                
        3=>"Industri otomotif Jerman, yang dikenal sebagai salah satu pilar ekonomi negara, menghadapi tekanan besar untuk mengurangi emisi karbon sejalan dengan target 
        Uni Eropa untuk mencapai netralitas karbon pada tahun 2050. Target Uni Eropa adalah setidaknya 29% pangsa energi terbarukan pada 2030 atau pengurangan gas rumah 
        kaca sebesar 14,5% dibandingkan dengan emisi yang dihasilkan oleh penggunaan bahan bakar fosil. Produsen besar seperti Volkswagen, BMW, dan Mercedes-Benz pun harus 
        menyesuaikan dengan beralih dari kendaraan bermesin pembakaran internal (ICE) ke kendaraan listrik (EV) dalam skala besar. Salah satu dampak utama perubahan iklim pada 
        sektor ini adalah meningkatnya biaya produksi dan inovasi. Transisi menuju kendaraan listrik membutuhkan investasi besar dalam pengembangan teknologi baterai, infrastruktur pengisian daya, 
        dan rantai pasokan bahan baku seperti lithium dan kobalt, yang diperlukan untuk produksi baterai.",

        4=>"Tiongkok menghadapi berbagai masalah lingkungan serius yang semakin diperparah oleh perubahan iklim. 
        Sebagai negara dengan ekonomi manufaktur dan eksportir barang terkemuka di dunia, Tiongkok juga merupakan 
        salah satu produsen plastik terbesar di dunia dengan produksi plastik bulanan berkisar antara enam hingga 12 juta metrik ton. 
        Selain itu, Tiongkok menempati posisi teratas sebagai penyumbang emisi karbon terbesar di dunia, dengan emisi sebanyak 11.397 juta metrik ton pada 2022. 
        Berbagai faktor yang menyumbang buruknya kondisi lingkungan di Tiongkok menyebabkan hampir separuh dari seluruh kota-kota besarnya tenggelam. 
        Faktor-faktor lain ialah pengambilan air tanah berlebihan dan peningkatan beban ekspansi kota yang pesat. 
        Data menunjukkan satu dari enam kota di China mengalami penurunan tanah melebihi 10 mm per tahun."
         ];


        return view('storyline.storyline', compact('title','currentPhase', 'maxUnlockedPhase', 'storylines'));
    }

}

