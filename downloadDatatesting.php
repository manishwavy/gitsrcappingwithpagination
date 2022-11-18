<?php

require 'php_scraper/vendor/autoload.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="download-data.csv"');
fputcsv(
    fopen('php://output', 'w+'),
    array(
        'S.No.',
        'Title',
    )
);
$httpClient = new \GuzzleHttp\Client();


$j = 1;

for($j=0;$j<932;$j++)
{
$response = $httpClient->get('https://www.whtop.com/directory/category/shared-hosting/pageno/'.$j);
$htmlString = (string) $response->getBody();

libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);

$titles = $xpath->evaluate('//div[@class="company clearer"]//div[@class="company-title"]//b/a');

$i = 1;

if($titles->length != 0){
   
    foreach ($titles as $title) {
        $no = $i;
        $title = $title->textContent;
        fputcsv(
            fopen('php://output', 'w+'),
            array(
                $no,
                $title,
            )
        );
        $i++;
    }
}
else{
    echo "<div style='display:flex;height:100%;width:100%;justify-content:center;align-items-center'><h1>No Data Found...</h1></div>";
}
}


?>