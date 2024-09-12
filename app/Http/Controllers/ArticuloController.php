<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ArticuloController extends Controller
{
    public function buscarArticuloScrapper(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_url_articulo' => 'required',
        ], [
            'input_url_articulo.required' => 'El campo es obligatorio.',
        ]);

        if ($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $articulo = [];

        $url = $request->input('input_url_articulo');

        if (preg_match('/(https?:\/\/[^\s]+)/', $url, $matches)):
            $url = $matches[0];
        endif;


        $url = filter_var($url, FILTER_SANITIZE_URL);

        $urlParsed = parse_url($url);

        $host = $urlParsed['host'] ?? '';

        $hostsRegistrados = [
            '.shein.com' => 'shein.com.co',
            '.shein.com.co' => 'shein.com.co',
        ];

        $url = preg_replace('/\w+\.shein\.com/', 'shein.com.co', $url);
        $url = preg_replace('/\w+\.shein\.com\.co/', 'shein.com.co', $url);

        $host = parse_url($url, PHP_URL_HOST);

        if (array_key_exists($host, $hostsRegistrados)):
            $newHost = $hostsRegistrados[$host];
            $url = str_replace($host, $newHost, $url);
        endif;


        $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $url = addslashes($url);

        $endpointCrawlbase = env('ENDPOINT_URL_SCRAPER_CRAWLBASE');
        $endpointScraperApi = env('ENDPOINT_URL_SCRAPER_SCRAPERAPI');

        $urlCompleta = $endpointCrawlbase . $url;
        $tipoUrl = "web";

        if (str_contains($url, 'api-shein.shein.com')):
            $tipoUrl = "api";
        endif;


        if (!str_contains($host, 'shein.com')):
            return back()->withErrors(['input_url_articulo' => 'El enlace debe ser de shein.com.'])->withInput();
        endif;


        if($tipoUrl == "api"):

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            if(preg_match('/var shareInfo = (\{.*?\});/s', $response, $matches)):

                $json = $matches[1];
                $data = json_decode($json, true);
                $tituloArticulo = str_replace(' ', '', $data['shareTitle']);
                $idArticulo = $data['shareId'];
                $catIdArticulo = $data['cat_id'];

                $urlFinal = 'https://shein.com.co/'.$tituloArticulo . '-p-' . $idArticulo . '-cat-' . $catIdArticulo . '.html';
                $urlCompleta = $endpointCrawlbase . $urlFinal;

            endif;
        endif;

        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlCompleta);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);
            $crawler = new Crawler($data);
            $articulo['nombre'] = $crawler->filter('.product-intro__head-name.fsp-element')->text();
            $articulo['sku'] = $crawler->filter('.product-intro__head-sku')->text();
            $articulo['sku'] = trim(str_replace('SKU:','',$articulo['sku']));
            $articulo['precio_actual'] = $crawler->filter('.ProductIntroHeadPrice__head-mainprice > .original.from')->text();

            $articulo['imagenes'] = $crawler->filter('.crop-image-container > .crop-image-container__img')->each(function ($node) {
                if ($node->attr('data-src') != null && $node->attr('data-src') != ""):
                    return $node->attr('data-src');
                endif;
            });

            //quitar las imagenes vacias
            $articulo['imagenes'] = array_filter($articulo['imagenes']);
            $articulo['imagenes'] = array_values($articulo['imagenes']);

            $articulo['precio_original'] = 0;
            if($crawler->filter('.ProductIntroHeadPrice__head-mainprice > .del-price')->count()>0):
                $articulo['precio_original'] = $crawler->filter('.ProductIntroHeadPrice__head-mainprice > .del-price')->text();
            endif;

            $articulo['descuento'] = 0;
            if($crawler->filter('.ProductIntroHeadPrice__head-mainprice > .discount-label')->count()>0):
                $articulo['descuento'] = $crawler->filter('.ProductIntroHeadPrice__head-mainprice > .discount-label')->text();
            endif;

            $articulo['color'] = 0;

            if($crawler->filter('.color-block > .sub-title')->count()>0):
                $articulo['color'] = $crawler->filter('.color-block > .sub-title')->text();
                $articulo['color'] = str_replace(":","",$articulo['color']);
            endif;

            $articulo['iva'] = 0;

            if($crawler->filter('.product-intro__head-tax')->count()>0):
                $articulo['iva'] = $crawler->filter('.product-intro__head-tax')->text();
            endif;

            $articulo['titulo_talla'] = $crawler->filter('.product-intro__size > .product-intro__size-title')->text();

            $articulo['tallas'] = $crawler->filter('.product-intro__size-radio-inner.product-intro__sizes-item-text--one')->each(function ($node) {
                return $node->text();
            });

            $crawler->filter('script')->each(function ($node) use (&$scriptContent) {
                $scriptContent .= $node->text();
            });

            if (str_contains($scriptContent, "window.gbRawData")):
                if (preg_match('/window\.gbRawData\s*=\s*(\{.*\});/s', $scriptContent, $matches)):
                    $jsonCleaned = strstr($matches[1], 'document.dispatchEvent', true);
                    $jsonCleaned = rtrim($jsonCleaned, ',');
                    $jsonCleaned = preg_replace('/<[^>]*>/', '', $jsonCleaned);
                    $jsonDecoded = json_decode($jsonCleaned, true);

                    $productIntroData = $jsonDecoded['productIntroData'];

                    $articulo['imagen_principal'] = $productIntroData['goods_imgs']['main_image']['origin_image'];

                    array_unshift($articulo['imagenes'],$articulo['imagen_principal']);


                    $detail = $productIntroData['detail'];
                    $productDetails = $detail['productDetails'];

                    foreach ($productDetails as $indice => $valor):
                        $articulo['descripcion'][$indice]['indice'] = $valor['attr_name'];
                        $articulo['descripcion'][$indice]['valor'] = $valor['attr_value'];

                        if($valor['attr_name'] == "Color"):
                            if($articulo['color']===0):
                                $articulo['color'] = $valor['attr_value'];
                            endif;
                        endif;

                    endforeach;

                    $storeInfo = $productIntroData['storeInfo'];

                    $articulo['tienda'] = [
                        'nombre' => $storeInfo['title'],
                        'logo' => $storeInfo['logo'],
                        'descripciones' => $storeInfo['descriptions'],

                    ];

                    $articulo['colores'] = [];

                    if ($articulo['color'] !== 0):

                        if(count($productIntroData['colorData']['colorList'])>0):

                            $colorList = $productIntroData['colorData']['colorList'];

                            foreach ($colorList as $indice => $valor):
                                $articulo['colores'][$indice] = [
                                    'color_imagen' => $valor['goods_color_image'] ?? '',
                                    'color_titulo' => $valor['goods_title'],
                                    'articulo_sku' => $valor['goods_sn']
                                ];
                            endforeach;

                        endif;

                        if(count($productIntroData['relation_color'])>0):

                            $relationColors = $productIntroData['relation_color'];

                            foreach ($relationColors as $relationColor):
                                foreach ($articulo['colores'] as &$color):
                                    if (trim($color['articulo_sku']) == trim($relationColor['goods_sn'])):
                                        $color['articulo_nombre'] = $relationColor['goods_name'];
                                        $color['articulo_imagen'] = $relationColor['original_img'];
                                        $color['articulo_precio_original'] = $relationColor['retailPrice']['amountWithSymbol'];
                                        $color['articulo_precio_venta'] = $relationColor['salePrice']['amountWithSymbol'];
                                        $color['articulo_descuento'] = "-{$relationColor['unit_discount']}%";

                                        foreach ($relationColor['productDetails'] as $indice => $valor):
                                            $color['articulo_descripcion'][$indice]['indice'] = $valor['attr_name'];
                                            $color['articulo_descripcion'][$indice]['valor'] = $valor['attr_value'];
                                        endforeach;

                                    endif;
                                endforeach;
                            endforeach;


                            foreach ($articulo['colores'] as &$color):
                                if ($color['articulo_sku'] == $articulo['sku']):
                                        $color['articulo_nombre']  = $articulo['nombre'];
                                        $color['articulo_precio_original']  = $articulo['precio_original'];
                                        $color['articulo_precio_venta']  = $articulo['precio_actual'];
                                        $color['articulo_descuento'] = $articulo['descuento'];
                                        $color['articulo_descripcion']  = $articulo['descripcion'];
                                        $color['articulo_imagen'] = $articulo['imagen_principal'];
                                endif;
                            endforeach;

                        endif;

                    endif;


                    foreach ($articulo['colores'] as &$color):
                        $color['encriptado'] = base64_encode(json_encode($color));
                    endforeach;

                endif;
            endif;
        }catch (\Exception $e) {
            $errorDetails = $e->getMessage();
//            //TODO guardar error en la base de datos
            return back()->withInput()->with(['error' => 'Hubo un problema al buscar el artículo. Por favor, inténtalo de nuevo o contacta con el administrador.', "detalle" => $errorDetails]);
        }


        //No se pueden obtener
//        $articulo['valoracion'] = $crawler->filter('.rate-num')->text();
//        $articulo['comentarios_comunes'] = $crawler->filter('.fit-item')->each(function ($node) {
//            $fitName = $node->filter('.fit-name')->text();
//            $fitValue = $node->filter('.common-reviews__progress+span')->text();
//            return ['fitName' => $fitName, 'fitValue' => $fitValue];
//        });

        $articulo["tipo_url"] = $tipoUrl;

        return view('principal.mostrar_articulo', ['articulo' => $articulo]);
    }

    public function generarPedido(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'articulos_pagar' => 'required',
        ], [
            'articulos_pagar.required' => 'Debe seleccionar al menos un artículo para pagar.',
        ]);

        if ($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $articulos_pagar = $request->input('articulos_pagar');
        session(['carrito' => $articulos_pagar]);

        session(['total' => $request->input('total')]);
        session(['descuento' => $request->input('descuento')]);

        if (!Auth::check()) {
            return response()->json([
                'estado' => 'error',
                'mensaje' => 'Por favor, inicie sesión para continuar.',
                'detalle' => 'nosesion',
                'url_redirect' => route('login') . '?frompage=carrito'
            ], 401);
        }

        $usuario = Auth::user();

        $persona = Persona::where('id_usuario', $usuario->id)->first();

        if (!$persona) {

            return response()->json([
                'estado' => 'error',
                'mensaje' => 'Debe registrarse como persona para continuar.',
                'detalle' => 'noregistrado',
                'url_redirect' => route('pagar') . '?frompage=carrito'
            ]);
        }

        return response()->json([
            'estado' => 'ok',
            'mensaje' => 'Proceda a ingresar el pago.',
            'detalle' => 'pagar',
            'url_redirect' => route('pagar')
        ]);
    }

}

//productIntroData-> relation_color[{number}] =>
// -> goods_sn es el sku
// -> retailPrice -> amount es el precio original
// -> salePrice -> amount es el precio actual de venta
// -> goods_name es el nombre del articulo
// -> productDetails -> attr_name es el nombre del atributo, attr_value es el valor del atributo
// -> relatedColor: al parecer es un arreglo que tiene todos los colores, buscamos el color que tenga el mismo sku
// -> relatedColor: se busca por goods_sn que es el sku
// -> relatedColor -> original_img es la imagen de la prenda en ese color
