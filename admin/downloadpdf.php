<?php

require 'header_admin.php';
require '../models/admin.php';
require_once __DIR__ . '../../vendor/autoload.php';

$admin = new admin();
$catalogueDay = $admin->getCatalogueDetails($_GET["id"]);
$catalogueItems = $admin->getCatalogueItems($_GET["id"]);

$products = [];

foreach ($catalogueItems as $item) {
    $products[] = $admin->getAnAuction($item['item_id']);
}

// ob_start();

$data = '
<div class="container py-5">
  <header class="text-center">
    <h1 class="display-4">';
    $data .= $catalogueDay['name'];
    $data .= '</h1>
    <p class="font-italic mb-0">Starting on ';
    $data .= $catalogueDay['start_date'];
    $data .= '</p>
    </header>

    <div class="row">
    <div class="col-lg-11 mx-auto">
    <div class="row py-5">

        ';
            for($i = 0; $i < count($products); $i++){
            $data .='
                <div class="col-lg-4">
                <figure class="rounded p-3 bg-white shadow-sm">
                    <img src="../assets/uploads/';
            $data .= $admin->getPictureOfAuction($products[$i][0]["auction_id"]);
            $data .= '" alt="';
            $data .= $products[$i][0]["product_name"];
            $data .= '" class="w-100 card-img-top">
                    <figcaption class="p-4 card-img-bottom">
                    <h2 class="h5 font-weight-bold mb-2 font-italic">';
            $data .= $products[$i][0]['product_name'];
            $data .= '</h2>
                    <h2 class="h5 font-weight-bold mb-2 font-italic">Price: £';
            $data .= $products[$i][0]['price'];
            $data .= '</h2>
                    <p class="mb-0 text-small text-muted font-italic">';
            $data .= $products[$i][0]['description'];
            $data .= '</p>
                    </figcaption>
                </figure>
                </div>
                ';
                    }
                $data .= '

        </div>
    </div>
    </div>
    </div>
</div>';


// ob_end_flush();

ini_set("pcre.backtrack_limit", "1000000");
// if (isset($_POST['download'])) {

    // echo 'downloading';

    try{
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->debug = true;

        $stylesheet = file_get_contents('vendor/bootstrap-4.1/bootstrap.min.css');

        // $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($data,\Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output();
    } catch (\Mpdf\MpdfException $e) {
        echo $e->getMessage();
    }

// }

?>