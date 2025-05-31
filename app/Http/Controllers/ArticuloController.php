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

//        $hostsRegistrados = [
//            '.shein.com' => 'shein.com.co',
//            '.shein.com.co' => 'shein.com.co',
//        ];
//
//        $host = parse_url($url, PHP_URL_HOST);
//
//        if (array_key_exists($host, $hostsRegistrados)):
//            $newHost = $hostsRegistrados[$host];
//            $url = str_replace($host, $newHost, $url);
//        endif;



        $scheme = $urlParsed['scheme'] ?? 'https';
        $path = $urlParsed['path'] ?? '';
        $query = isset($urlParsed['query']) ? '?' . $urlParsed['query'] : '';

        $url = $scheme . '://' . $host . $path . $query;

        $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $url = addslashes($url);

        $endpointCrawlbase = env('ENDPOINT_URL_SCRAPER_CRAWLBASE');
        $endpointScraperApi = env('ENDPOINT_URL_SCRAPER_SCRAPERAPI');

        $servicio = $endpointCrawlbase;
        $urlCompleta = $servicio . $url;
        $tipoUrl = "web";

        if (str_contains($url, 'api-shein.shein.com')):
            $tipoUrl = "api";
        endif;

        if (str_contains($host, 'shein.com')):
            $host = 'www.shein.com.co';
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
                $urlCompleta = $servicio . $urlFinal;

            endif;
        endif;



//        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlCompleta);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);
            $crawler = new Crawler($data);

            $crawler->filter('script')->each(function ($node) use (&$scriptContent) {
                $scriptContent .= $node->text();
            });
            if (str_contains($scriptContent, "window.gbRawData")):
                if (preg_match('/window\.gbRawData\s*=\s*(\{.*)/s', $scriptContent, $matches)):
                    $jsonCleaned = strstr($matches[1], 'document.dispatchEvent', true);
                    $jsonCleaned = rtrim($jsonCleaned, ',');
                    $jsonCleaned = preg_replace('/<[^>]*>/', '', $jsonCleaned);
                    $jsonDecoded = json_decode($jsonCleaned, true);



                    $modules = $jsonDecoded['modules'] ?? null;

                    $productInfo = $modules['productInfo'] ?? null;
                    $priceInfo = $modules['priceInfo'] ?? null;
                    $storeInfo = $modules['storeInfo'] ?? null;
                    $saleAttr = $modules['saleAttr'] ?? null;


                    $articulo['nombre'] = $productInfo['goods_name'] ?? '';

                    $articulo['imagen_principal'] = $productInfo['goods_img'] ?? '';

                    $articulo['sku'] = $productInfo['goods_sn'] ?? '';

                    $articulo['goods_id'] = $productInfo['goods_id'] ?? '';

                    $articulo['precio_original'] = $priceInfo['retailPrice']['amountWithSymbol'] ?? '';

                    $articulo['precio_actual'] = $priceInfo['salePrice']['amountWithSymbol'] ?? '';

                    if($articulo['precio_original'] == $articulo['precio_actual']) $articulo['precio_original'] = '';

                    $articulo['descuento'] = $priceInfo['unitDiscount'] == 0 ? '' : "-{$priceInfo['unitDiscount']}%";

                    foreach ($productInfo['currentSkcImgInfo']['skcImages'] as $indice => $valor):
                        $articulo['imagenes'][$indice] = $valor;
                    endforeach;

                    foreach ($saleAttr['mainSaleAttribute']['info'] as $indice => $valor):
                        if ($valor['goods_id'] == $articulo['goods_id']):
                            $articulo['color'] = $valor['attr_value'];
                        endif;
                        $articulo['colores'][$indice] = [
                            'articulo_sku' => $valor['goods_sn'],
                            'articulo_goods_id' => $valor['goods_id'],
                            'color_imagen' => $valor['goods_color_image'] ?? '',
                            'color_titulo' => $valor['attr_value'],
                            'articulo_nombre' => $valor['goods_url_name']
                        ];
                    endforeach;

                    $i = 0;

                    foreach ($productInfo['allColorDetailImages'] as $indice => $valor):
                        //si $indice es diferente a $articulo['goods_id'] eso significa que es otro color, por lo tanto
                        //hay que guardar todas las imagenes que contenga dentro del indice
                        if ($indice != $articulo['goods_id']):
                            foreach ($valor as $indice2 => $valor2):
                                $articulo['colores'][$i]['imagenes'][$indice2] = $valor2;
                            endforeach;
                            $i++;
                        endif;
                    endforeach;

                    //tallas

                    foreach ($saleAttr['sizeInfo']['sizeInfo'] as $indice => $valor):
                        $articulo['tallas'][$indice] = $valor['attr_value_name'];
                    endforeach;


                    //descripción del artículo

                    foreach ($productInfo['productDescriptionInfo']['productDetails'] as $indice => $valor):
                        $articulo['descripcion'][$indice]['indice'] = $valor['attr_name'];
                        $articulo['descripcion'][$indice]['valor'] = $valor['attr_value'];
                    endforeach;

                    foreach($articulo['descripcion'] as $descripcion):
                        endforeach;

                    $articulo['tienda'] = [
                        'nombre' => $storeInfo['title'],
                        'logo' => $storeInfo['logo'],
                    ];


                    foreach ($articulo['colores'] as &$color):
                        $color['encriptado'] = base64_encode(json_encode($color));
                    endforeach;

                endif;
            endif;
//        }catch (\Exception $e) {
//            $errorDetails = $e->getMessage();
////            //TODO guardar error en la base de datos
//            return back()->withInput()->with(['error' => 'Hubo un problema al buscar el artículo. Por favor, inténtalo de nuevo o contacta con el administrador.', "detalle" => $errorDetails]);
//        }

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
        session(['precioMitadTotal' => $request->input('precioMitadTotal')]);

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
