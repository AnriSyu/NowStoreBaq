<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
class ArticuloController extends Controller
{
    public function buscarArticuloScrapper(Request $request)
    {
        $articulo = [];
        $url = $request->input('url_articulo');
        $api = env('API_URL_SHEIN_SCRAPPER');
        $urlCompleta = $api . $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlCompleta);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $crawler = new Crawler($data);
        $articulo['nombre'] = $crawler->filter('.product-intro__head-name.fsp-element')->text();
        $articulo['sku'] = $crawler->filter('.product-intro__head-sku')->text();
        $articulo['precio_original'] = $crawler->filter('.ProductIntroHeadPrice__head-mainprice > .original.from')->text();
        $articulo['imagenes'] = $crawler->filter('.crop-image-container > .crop-image-container__img')->each(function ($node) {
            if($node->attr('data-src') != null && $node->attr('data-src') != ""):
                return $node->attr('data-src');
            endif;
        });

        $articulo['color'] = $crawler->filter('.color-block > .sub-title')->text();
        //quitar las imagenes vacias
        $articulo['imagenes'] = array_filter($articulo['imagenes']);
        $articulo['imagenes'] = array_values($articulo['imagenes']);

        //imagen principal es 0 de imagenes
        $articulo['imagen_principal'] = $articulo['imagenes'][0];


        $articulo['tallas']  = $crawler->filter('.product-intro__size-radio-inner.product-intro__sizes-item-text--one')->each(function ($node) {
            return $node->text();
        });

        $crawler->filter('script')->each(function ($node) use (&$scriptContent) {
            $scriptContent .= $node->text();
        });
        if (str_contains($scriptContent, "window.gbRawData")):
            if (preg_match('/window\.gbRawData\s*=\s*(\{.*?\});/s', $scriptContent, $matches)):
                $jsonCleaned = strstr($matches[1], 'document.dispatchEvent', true);
                $jsonCleaned = rtrim($jsonCleaned, ',');
                $jsonCleaned = preg_replace('/<[^>]*>/', '', $jsonCleaned);
                $jsonDecoded = json_decode($jsonCleaned, true);
                $productIntroData = $jsonDecoded['productIntroData'];
                $relationColors = $productIntroData['relation_color'];
                $i = 0;
                foreach ($relationColors as $relationColor):
                    $articulo['colores'][$i]['sku'] = $relationColor['goods_sn'];
                    $articulo['colores'][$i]['nombreArticulo'] = $relationColor['goods_name'];
                    $articulo['colores'][$i]['imagen'] = $relationColor['original_img'];
                    $articulo['colores'][$i]['precio_original'] = $relationColor['retailPrice']['amount'];
                    $articulo['colores'][$i]['precio_venta'] = $relationColor['salePrice']['amount'];
                    foreach ($relationColor['productDetails'] as $productDetail):
                        if ($productDetail['attr_name'] == 'Color'):
                            $articulo['colores'][$i]['color'] = $productDetail['attr_value'];
                        endif;
                    endforeach;
                    $i++;
                endforeach;
            endif;
        endif;



        //No se pueden obtener
//        $articulo['valoracion'] = $crawler->filter('.rate-num')->text();
//        $articulo['comentarios_comunes'] = $crawler->filter('.fit-item')->each(function ($node) {
//            $fitName = $node->filter('.fit-name')->text();
//            $fitValue = $node->filter('.common-reviews__progress+span')->text();
//            return ['fitName' => $fitName, 'fitValue' => $fitValue];
//        });
        return view('mostrar_articulo', ['articulo' => $articulo]);
    }
}
//COLORES

//Guardar de esta forma
//articulo['colores'][0] = [
//"color" => "nombre del color",
//"sku" => "sku del color",
//"precio_original" => "precio original",
//"precio_venta" => "precio de venta",
//imagene => ["imagen1"]
//]

//productIntroData-> relation_color[{number}] =>
// -> goods_sn es el sku
// -> retailPrice -> amount es el precio original
// -> salePrice -> amount es el precio actual de venta
// -> goods_name es el nombre del articulo
// -> productDetails -> attr_name es el nombre del atributo, attr_value es el valor del atributo
// -> relatedColor: al parecer es un arreglo que tiene todos los colores, buscamos el color que tenga el mismo sku
// -> relatedColor: se busca por goods_sn que es el sku
// -> relatedColor -> original_img es la imagen de la prenda en ese color
