<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ProductRepository{

    public function __construct(){
        $this-> unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    }

    public function getProducts($nivel2){
        $datos = DB::table('productos')
            ->join("XML", function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->join("productosCategoriasNivel3", function ($join){
                $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                    ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                    ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
            })
            ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
            ->leftJoin('producto_caracteristica as pc', function ($join){
                $join->on("pc.producto",
                    DB::raw("CONCAT(productos.productType,' ',productos.brand,' ',productos.mpn)"));
            })
            ->leftJoin("inventario",function($join){
                $join->on("productos.productType","=","inventario.productType")
                    ->on("productos.brand","=","inventario.brand")
                    ->on("productos.mpn","=","inventario.mpn");
            })
            ->select(
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.priceweb',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia',
                DB::raw('SUM(inventario.cantidad) as cantidadInventario')
            )
            ->distinct('productos.mpn')
            ->orderBy('c3.prioridad', 'asc')
            ->where([
                "productos.visible" => "si",
                "c3.idCategoriasNivel2" => $nivel2,
                "productos.availability" => "in stock"
            ])
            ->groupBy('productos.productType',
                'productos.brand','productos.mpn')
            ->get();

        return $datos;
    }

    public function getProductsOffer(){
        $datos = DB::table('productos')
            ->join("XML", function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->join("productosCategoriasNivel3", function ($join){
                $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                    ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                    ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
            })
            ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
            ->leftJoin("inventario",function($join){
                $join->on("productos.productType","=","inventario.productType")
                    ->on("productos.brand","=","inventario.brand")
                    ->on("productos.mpn","=","inventario.mpn");
            })
            ->select(
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.priceweb',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia',
                DB::raw('SUM(inventario.cantidad) as cantidadInventario')
            )
            ->distinct('productos.mpn')
            ->orderBy('productos.productType', 'asc')
            ->where([
                "productos.visible" => "si",
                "productos.offer" => "si",
                "productos.availability" => "in stock"
            ])
            ->groupBy('productos.productType',
                'productos.brand','productos.mpn')
            ->get();

        return $datos;
    }

    public function getProductsFilters($nivel2, $filtros, $cant){
        $valores = array();
        array_push($valores, ["productos.visible", '=', "si"]);
        array_push($valores, ["c3.idCategoriasNivel2", '=', $nivel2]);
        array_push($valores, ["productos.availability", "=", "in stock"]);
        $datos = DB::table('productos')
            ->join("XML", function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->join("productosCategoriasNivel3", function ($join){
                $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                    ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                    ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
            })
            ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
            ->leftJoin('producto_caracteristica as pc', function ($join){
                $join->on("pc.producto",
                    DB::raw("binary CONCAT(productos.productType,' ',productos.brand,' ',productos.mpn)"));
            })
            ->leftJoin('caracteristica as c', 'c.id_caracterisca', '=', 'pc.fk_caracteristica')
            ->leftJoin('opcion_caracteristica as opc', 'c.id_caracterisca', '=', 'opc.fk_caracteristica')
            ->leftJoin("inventario",function($join){
                $join->on("productos.productType","=","inventario.productType")
                    ->on("productos.brand","=","inventario.brand")
                    ->on("productos.mpn","=","inventario.mpn");
            })
            ->select(
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.priceweb',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia',
                DB::raw('SUM(inventario.cantidad) as cantidadInventario')
            )
            ->distinct('productos.mpn')
            ->orderBy('pc.producto', 'asc')
            ->where($valores)
            ->whereRaw($filtros)
            ->groupBy('productos.productType',
                'productos.brand','productos.mpn')
            ->get();

        return $datos;
    }

    public function getProductFiltered($producto, $filtros, $cant){
        $datos = DB::table('producto_caracteristica as pc')
            ->leftJoin('caracteristica as c', 'c.id_caracterisca', '=', 'pc.fk_caracteristica')
            ->select(
                'pc.producto',
                DB::raw('COUNT(pc.producto) AS r')
            )
            ->groupBy('pc.producto')
            ->where([
                'pc.producto' => $producto,
                "productos.availability" => "in stock"
            ])
            ->whereRaw($filtros)
            ->groupBy('pc.producto')
            ->having('r', '=', $cant)
            ->get();

        return count($datos);
    }

    public function getProduct($productType, $brand, $mpn){
        $datos = DB::table('productos')
            ->join("XML",function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->join("productosCategoriasNivel3", function ($join){
                $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                    ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                    ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
            })
            ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
            ->leftJoin("inventario",function($join){
                $join->on("productos.productType","=","inventario.productType")
                    ->on("productos.brand","=","inventario.brand")
                    ->on("productos.mpn","=","inventario.mpn");
            })
            ->select(
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.priceweb',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia',
                DB::raw('SUM(inventario.cantidad) as cantidadInventario')
            )
            ->where([
                'productos.productType' => $productType,
                'productos.brand' => $brand,
                'productos.mpn' => $mpn,
                "productos.availability" => "in stock"
            ])
            ->groupBy(
                'productos.productType',
                'productos.brand','productos.mpn'
            )
            ->get();

        return $datos;
    }

    public function getProductsRelated($productType, $brand, $mpn){
        $datos = DB::table('productos')
            ->join("XML",function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->join("productosCategoriasNivel3", function ($join){
                $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                    ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                    ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
            })
            ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
            ->leftJoin("inventario",function($join){
                $join->on("productos.productType","=","inventario.productType")
                    ->on("productos.brand","=","inventario.brand")
                    ->on("productos.mpn","=","inventario.mpn");
            })
            ->select(
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.priceweb',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia',
                DB::raw('SUM(inventario.cantidad) as cantidadInventario')
            )
            ->where([
                ['productos.productType', $productType],
                ['productos.kind', 'MAQ'],
                ['productos.visible', 'si'],
                ['productos.mpn', '!=', $mpn],
                ["productos.availability", "=", "in stock"]
            ])
            ->whereRaw(
                "productos.priceweb >= (select priceweb * 0.75 as priceweb from productos where productType = '".$productType."' AND brand = '".$brand."' AND mpn = '".$mpn."') AND ".
                "productos.priceweb <= (select priceweb * 1.5 as priceweb from productos where productType = '".$productType."' AND brand = '".$brand."' AND mpn = '".$mpn."')"
            )
            ->groupBy(
                'productos.productType',
                'productos.brand','productos.mpn'
            )
            ->get();

        return $datos;
    }

    public function getIdNivel2($nivel1, $nivel2){
/*
        $nivel1 = str_replace("-", " ", $nivel1);
        $nivel2 = str_replace("-", " ", $nivel2);*/

        $categoriaNivel1 = str_replace("_", "-", $nivel1);
        $categoriaNivel2 = str_replace("_", "-", $nivel2);

        $id = DB::table('categoriasNivel2')
            ->join('categoriasNivel1', 'categoriasNivel2.idCategoriasNivel1', '=', 'categoriasNivel1.idCategoriasNivel1')
            ->select(
                'categoriasNivel2.idCategoriasNivel2'
            )
            ->where([
                ['categoriasNivel2.nombreCategoriaNivel2', $categoriaNivel2],
                ['categoriasNivel1.nombreCategoriaNivel1', $categoriaNivel1]
            ])
            ->first();

        return $id->idCategoriasNivel2;
    }

    public function getCategoriasNivel3($idCategoriaNivel2){
        $categoriasNivel3 = DB::table('categoriasNivel3')
            ->join('categoriasNivel2', 'categoriasNivel3.idCategoriasNivel2', '=', 'categoriasNivel2.idCategoriasNivel2')
            ->join('categoriasNivel1', 'categoriasNivel2.idCategoriasNivel1', '=', 'categoriasNivel1.idCategoriasNivel1')
            ->select(
                'categoriasNivel3.idCategoriasNivel3',
                'categoriasNivel3.nombreCategoriaNivel3',
                'categoriasNivel3.enlace'
            )
            ->where([
                ['categoriasNivel3.idCategoriasNivel2', $idCategoriaNivel2]
            ])
            ->orderBy('categoriasNivel3.prioridad', 'asc')
            ->get();

        return $categoriasNivel3;
    }

    public function getCaracteristicas($productType){
        $filters = DB::table('caracteristica as c')
            ->select(
                'c.nombre',
                'c.medida',
                'c.id_caracterisca',
                'c.tipo'
            )
            ->where([
                ['c.productType', $productType]
            ])
            ->orderBy('c.nombre', 'asc')
            ->get();

        return $filters;
    }

    public function getProductosCaracteristica($id_caracterisca){
        $filters = DB::table('producto_caracteristica as pc')
            ->select(
                'pc.producto as name',
                'pc.valor as value'
            )
            ->where([
                ['pc.fk_caracteristica', $id_caracterisca]
            ])
            ->orderBy('pc.producto', 'asc')
            ->get();

        return $filters;
    }

    public function getProductosCaracteristicaValorMax($id_caracterisca){
        $filters = DB::table('producto_caracteristica as pc')
            ->select(DB::raw('MAX(valor_numero) as valor'))
            ->where([
                ['pc.fk_caracteristica', $id_caracterisca]
            ])
            ->first();

        return $filters->valor;
    }

    public function getProductosCaracteristicaValorMin($id_caracterisca){
        $filters = DB::table('producto_caracteristica as pc')
            ->select(DB::raw('MIN(valor_numero) as valor'))
            ->where([
                ['pc.fk_caracteristica', $id_caracterisca]
            ])
            ->first();

        return $filters->valor;
    }

    public function getProductosCaracteristicaOpciones($id_caracterisca){
        $filters = DB::table('opcion_caracteristica')
            ->select('nombre as name', 'id_opcion_caracteristica as id')
            ->where([
                'fk_caracteristica' => $id_caracterisca
            ])
            ->get();

        return $filters;
    }

    public function getProductlevels($productType){
        $levels = DB::table('categoriasNivel2')
            ->join('categoriasNivel1', 'categoriasNivel2.idCategoriasNivel1', '=', 'categoriasNivel1.idCategoriasNivel1')
            ->select('nombreCategoriaNivel2 as name')
            ->where([
                ['nombreCategoriaNivel2', 'like', "%$productType%"]
            ])
            ->get();

        return $levels;
    }

    private function clasificarBusqueda($busqueda){
        //Este metodo calcula si alguna de las palabras buscadas tiene mayor coincidencias y regresa eso
        $split = explode(" ", $busqueda);
        $sql = "SELECT productos.id, productos.productType, productos.brand, productos.mpn, productos.description,
        productos.availability,productos.offer, productos.PrecioDeLista, productos.oferta, productos.priceweb,
        productos.visible, productos.iva, productos.video,productos.volada,productos.visible,
        XML.keywords,XML.metadesc,XML.descriptionweb,XML.resenia, SUM(inventario.cantidad) as cantidadInventario
        FROM productos
        join  XML on productos.productType = XML.productType and productos.brand = XML.brand and  productos.mpn = XML.mpn
        left join  inventario on productos.productType = inventario.productType and productos.brand = inventario.brand and  productos.mpn = inventario.mpn

        join productosCategoriasNivel3 on productos.productType = REPLACE(productosCategoriasNivel3.productType,'_',' ')
                    and productos.brand = REPLACE(productosCategoriasNivel3.brand,'_',' ') and productos.mpn = REPLACE(productosCategoriasNivel3.mpn,'_',' ')
        join categoriasNivel3 as c3 on c3.idCategoriasNivel3 = productosCategoriasNivel3.idCategoriasNivel3 ";

        $sqlType = "";
        $sqlMpn = "";
        $sqlBrand = "";
        $banderaWhere = false;

        foreach ($split as $k => $l) {
            if(strlen($l) >= 3){
                $l = ucfirst ($l);
                $sqlType .= $banderaWhere ?" OR ":"";
                $sqlType .= "productos.productType like '%$l%'";
                $banderaWhere = true;
            }
        }
        $banderaWhere = false;
        foreach ($split as $k => $l) {
            if(strlen($l) >= 3){
                $l = ucfirst ($l);
                $sqlMpn .= $banderaWhere ?" OR ":"";
                $sqlMpn .= "productos.mpn like '%$l%'";
                $banderaWhere = true;
            }
        }
        $banderaWhere = false;
        foreach ($split as $k => $l) {
            if(strlen($l) >= 3) {
                $l = ucfirst($l);
                $sqlBrand .= $banderaWhere ? " OR " : "";
                $sqlBrand .= "productos.brand like '%$l%'";
                $banderaWhere = true;
            }
        }

        $groupBy = "group by productos.productType, productos.brand,productos.mpn";
        if($banderaWhere){
            $sql .= " WHERE productos.availability = 'in stock' and ";
            $productosType = DB::select( DB::raw($sql . $sqlType . $groupBy) );
            $productosMpn = DB::select( DB::raw($sql . $sqlMpn. $groupBy) );
            $productosBrand = DB::select( DB::raw($sql . $sqlBrand. $groupBy) );

            $productos = array ("brand" => $productosBrand, "type" => $productosType, "mpn" => $productosMpn);
            $productosCant = array ("type" => count($productosType), "mpn" => count($productosMpn), "brand" => count($productosBrand));

            $productosOrdenados = array();
            if($productosCant['mpn'] >= 1){
                $importancia = 1;
                foreach ( $productos['mpn'] as $key => $item) {
                    $productosOrdenados[$importancia][$item->id] = $item;
                }
            }
            if($productosCant['brand'] >= 1){
                foreach ($productos['brand'] as $key => $item) {
                    if(!isset($productosOrdenados[1][$item->id])){
                        if($productosCant['type'] >= 1){
                            foreach ($productos['type'] as $k => $i) {
                                if($item->id == $i->id){
                                    $productosOrdenados[1][$item->id] = $item;
                                }
                            }
                        }else{
                            $productosOrdenados[2][$item->id] = $item;
                        }
                    }
                }
            }
            if($productosCant['type'] >= 1){
                foreach ($productos['type'] as $key => $item) {
                    if(!isset($productosOrdenados[1][$item->id])){
                        if(!isset($productosOrdenados[2][$item->id])){
                            $productosOrdenados[3][$item->id] = $item;
                        }
                    }
                }
            }
        }else{
            $productosOrdenados = array();
        }

        return $productosOrdenados;
    }

    public function sendBusqueda($form, $busqueda){
        $tipo= $busqueda != '' ? 'busqueda':'duda';

       // $email = ['ventas1@jardepot.com','ventas2@jardepot.com','ventas4@jardepot.com'];
        $destino='ventas@jardepot.com';
        $asunto='';
        switch ($tipo){
            case 'duda':
                $asunto='Duda o Comentario de Producto';
                $data = [
                    'nombre' => $form->nombre,
                    'telefono' => $form->telefono,
                    'comentario' => $form->comentario,
                    'whatsapp' => $form->whatsapp,
                    'email' => $form->email,
                    'tipo'=>$tipo,
                    'producto' => $form->producto,
                ];
                break;
            case 'busqueda':
                $asunto='Notificación de búsqueda';
                $data = [
                    'nombre' => $form->nombre,
                    'telefono' => $form->telefono,
                    'comentario' => $form->comentario,
                    'tipo'=>$tipo,
                    'busqueda' => $busqueda,
                ];

                break;
            default:
                $asunto='Notificación';
        }

        Mail::send('mails.sendSearchMail', $data, function ($message) use ($asunto, $destino) {
            $message->to($destino)->subject($asunto);
            $message->from('sistemas1@jardepot.com', 'Sistemas Jardepot');
        });

        if( count( Mail::failures() ) > 0 ) {
          return false;
        }
        return true;
    }

    public function getDescriptionNivel2($idNivel2){
        $texto = DB::table('datosCategoriasNivel2')->select('texto','metadescription','metatitle')
            ->where(
                "idCategoriasNivel2" ,$idNivel2
            )->first();
        return $texto;
    }

    public function getProductsSearch($busqueda){

        $encontrados = "";
        $matches = array();
        $matchesCount = 0;
        $busqueda2 = "%".$busqueda."%";

        //busqueda simple
        $productos = $this -> clasificarBusqueda($busqueda);

        foreach ($productos as $key => $productoImportancia) {
            foreach ($productoImportancia as $producto) {
                if($producto -> visible == "si"){

                    $matches[$key][$producto -> id]["id"] = $producto -> id;
                    $matches[$key][$producto -> id]["productType"] = $producto -> productType;
                    $matches[$key][$producto -> id]["brand"] = $producto -> brand;
                    $matches[$key][$producto -> id]["mpn"] = $producto -> mpn;
                    $matches[$key][$producto -> id]["description"] = $producto -> description;
                    $matches[$key][$producto -> id]["availability"] = $producto -> availability;
                    $matches[$key][$producto -> id]["offer"] = $producto -> offer;
                    $matches[$key][$producto -> id]["PrecioDeLista"] = $producto -> PrecioDeLista;
                    $matches[$key][$producto -> id]["oferta"] = $producto -> oferta;
                    $matches[$key][$producto -> id]["priceweb"] = $producto -> priceweb;
                    $matches[$key][$producto -> id]["resenia"] = $producto -> resenia;
                    $matches[$key][$producto -> id]["metadesc"] = $producto -> metadesc;
                    $matches[$key][$producto -> id]["cantidadInventario"] = $producto -> cantidadInventario;
                    $matchesCount ++;

                }
            }
        }//fin de primer while

        $nivelImportancia = 4;

        // buscar separando palabras
        if ($matchesCount < 50) {
            //separa por palabras
            $busqueda = explode(" ", $busqueda);

            foreach ($busqueda as $busqueda2) {

                $busqueda2 = "%".$busqueda2."%";

                $productos = DB::table('productos')
                    ->join("XML", function($join){
                        $join->on("productos.productType","=","XML.productType")
                            ->on("productos.brand","=","XML.brand")
                            ->on("productos.mpn","=","XML.mpn");
                    })
                    ->join("productosCategoriasNivel3", function ($join){
                        $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                            ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                            ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
                    })
                    ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
                    ->leftJoin("inventario",function($join){
                        $join->on("productos.productType","=","inventario.productType")
                            ->on("productos.brand","=","inventario.brand")
                            ->on("productos.mpn","=","inventario.mpn");
                    })
                    ->select(
                        'productos.id',
                        'productos.productType',
                        'productos.brand',
                        'productos.mpn',
                        'productos.description',
                        'productos.availability',
                        'productos.priceweb',
                        'productos.oferta',
                        'productos.PrecioDeLista',
                        'productos.offer',
                        'productos.iva',
                        'productos.video',
                        'productos.volada',
                        'productos.visible',
                        'XML.keywords',
                        'XML.metadesc',
                        'XML.descriptionweb',
                        'XML.resenia',
                        DB::raw('SUM(inventario.cantidad) as cantidadInventario')
                    )
                    ->distinct('productos.mpn')
                    ->where([
                        ["productos.brand" ,"like",$busqueda2 ],
                        ["productos.availability" , "=", "in stock"]
                    ])
                    ->orWhere([
                        ["productos.visible" , '=',"si"],
                        ["productos.productType","like",$busqueda2 ]
                    ])

                    ->orWhere([
                        ["productos.mpn" ,"like", $busqueda2]
                    ])
                    ->groupBy(
                        'productos.productType',
                        'productos.brand','productos.mpn'
                    )
                    ->get();

                foreach ($productos as $producto) {

                    if($producto -> visible == "si" && !isset($matches[1][$producto -> id]) && !isset($matches[2][$producto -> id]) && !isset($matches[3][$producto -> id])){

                        $matches[4][$producto -> id]["id"] = $producto -> id;
                        $matches[4][$producto -> id]["productType"] = $producto -> productType;
                        $matches[4][$producto -> id]["brand"] = $producto -> brand;
                        $matches[4][$producto -> id]["mpn"] = $producto -> mpn;
                        $matches[4][$producto -> id]["description"] = $producto -> description;
                        $matches[4][$producto -> id]["availability"] = $producto -> availability;
                        $matches[4][$producto -> id]["offer"] = $producto -> offer;
                        $matches[4][$producto -> id]["PrecioDeLista"] = $producto -> PrecioDeLista;
                        $matches[4][$producto -> id]["oferta"] = $producto -> oferta;
                        $matches[4][$producto -> id]["priceweb"] = $producto -> priceweb;
                        $matches[4][$producto -> id]["resenia"] = $producto -> resenia;
                        $matches[4][$producto -> id]["metadesc"] = $producto -> metadesc;
                        $matches[4][$producto -> id]["cantidadInventario"] = $producto -> cantidadInventario;
                        $matchesCount ++;

                    }
                }
            }
        }


        // buscar quitando letras
        if ($matchesCount < 50) {
            foreach ($busqueda as $busqueda2) {
                //remueve
                $busqueda2 = chop($busqueda2,"es");
                $busqueda2 = chop($busqueda2,"s");
                $busqueda2 = "%".$busqueda2."%";

                $productos = DB::table('productos')
                    ->join("XML", function($join){
                        $join->on("productos.productType","=","XML.productType")
                            ->on("productos.brand","=","XML.brand")
                            ->on("productos.mpn","=","XML.mpn");
                    })
                    ->join("productosCategoriasNivel3", function ($join){
                        $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                            ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                            ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
                    })
                    ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
                    ->leftJoin("inventario",function($join){
                        $join->on("productos.productType","=","inventario.productType")
                            ->on("productos.brand","=","inventario.brand")
                            ->on("productos.mpn","=","inventario.mpn");
                    })
                    ->select('productos.id',
                        'productos.productType',
                        'productos.brand',
                        'productos.mpn',
                        'productos.description',
                        'productos.availability',
                        'productos.priceweb',
                        'productos.oferta',
                        'productos.PrecioDeLista',
                        'productos.offer',
                        'productos.iva',
                        'productos.video',
                        'productos.volada',
                        'productos.visible',
                        'XML.keywords',
                        'XML.metadesc',
                        'XML.descriptionweb',
                        'XML.resenia',
                        DB::raw('SUM(inventario.cantidad) as cantidadInventario')
                    )
                    ->where([
                        ["productos.brand" ,"like", $busqueda2],
                        ["productos.availability" , "=", "in stock"]
                    ])
                    ->orWhere([
                        ["productos.productType","like", $busqueda2]
                    ])
                    ->orWhere([
                        ["productos.mpn" ,"like", $busqueda2]
                    ])
                    ->groupBy(
                        'productos.productType',
                        'productos.brand','productos.mpn'
                    )
                    ->get();

                foreach ($productos as $producto) {

                    if($producto -> visible == "si" && !isset($matches[1][$producto -> id]) && !isset($matches[2][$producto -> id]) && !isset($matches[3][$producto -> id])){

                        $matches[4][$producto -> id]["id"] = $producto -> id;
                        $matches[4][$producto -> id]["productType"] = $producto -> productType;
                        $matches[4][$producto -> id]["brand"] = $producto -> brand;
                        $matches[4][$producto -> id]["mpn"] = $producto -> mpn;
                        $matches[4][$producto -> id]["description"] = "!!!!".$producto -> description;
                        $matches[4][$producto -> id]["availability"] = $producto -> availability;
                        $matches[4][$producto -> id]["offer"] = $producto -> offer;
                        $matches[4][$producto -> id]["PrecioDeLista"] = $producto -> PrecioDeLista;
                        $matches[4][$producto -> id]["oferta"] = $producto -> oferta;
                        $matches[4][$producto -> id]["priceweb"] = $producto -> priceweb;
                        $matches[4][$producto -> id]["resenia"] = $producto -> resenia;
                        $matches[4][$producto -> id]["metadesc"] = $producto -> metadesc;
                        $matches[4][$producto -> id]["cantidadInventario"] = $producto -> cantidadInventario;
                        $matchesCount ++;

                    }
                }
            }
        }

        $iterator=0;
        $response = array();
        //imprime los resultados de la búsqueda
        foreach ($matches as $matchNivel) {

            foreach ($matchNivel as $key => $match) {
                //solo pone precios si tenemos producto en stock
                if ($match["availability"] == "in stock") {
                    $img = strtolower( $match["productType"] . "-" . $match["brand"] . "-" . $match["mpn"]);

                    $response[$iterator]['id'] = $match["id"];
                    $response[$iterator]['name'] = $match["productType"] . " " . $match["brand"] . " " . $match["mpn"];
                    $response[$iterator]['images'][0]['small'] = 'assets/images/productos/' . $img . '.jpg';
                    $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/' . $img . '.jpg';
                    $response[$iterator]['images'][0]['big'] = 'assets/images/productos/' . $img . '.jpg';
                    if ($match["offer"] == "si") {
                        $response[$iterator]['discount'] = "Oferta";
                        //solo pone precio de lista cuando es mayor!!
                        if ( $match["PrecioDeLista"] > $match["oferta"]) {
                            $response[$iterator]['oldPrice'] = $match["PrecioDeLista"];
                           $response[$iterator]['newPrice'] = $match["oferta"];
                        }else{
                            $response[$iterator]['newPrice'] = $match["oferta"];
                        }
                        //no está de oferta :(
                    }else{
                        //solo pone precio de lista cuando es mayor!!
                        if ($match["PrecioDeLista"] > $match["priceweb"]) {
                            $response[$iterator]['oldPrice'] = $match["PrecioDeLista"];
                            $response[$iterator]['newPrice'] = $match["priceweb"];
                        }else{
                            $response[$iterator]['newPrice'] = $match["priceweb"];
                        }
                    }
                    $response[$iterator]['description'] = $match["description"];
                    $response[$iterator]['dataSheet'] = $match["resenia"];
                    $response[$iterator]['availibilityCount'] = 100;
                    if(isset($match['cantidad'])){
                        $response[$iterator]['cartCount'] = $match["cantidad"];
                    }else{
                        $response[$iterator]['cartCount'] = 0;
                    }
                    $response[$iterator]['brand'] = $match["brand"];
                    $response[$iterator]['mpn'] = $match["mpn"];
                    $response[$iterator]['productType'] = $match["productType"];
                    $response[$iterator]['metaDescription'] = $match["metadesc"];
                    $response[$iterator]['inventory'] = $match["cantidadInventario"];
                    $iterator++;
                }
            }//fin de foreach match
        }
        return $response;
    }

    public function validateImages(){
        $productos = DB::table('productos')
            ->join("XML", function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->join("productosCategoriasNivel3", function ($join){
                $join->on("productos.productType", DB::raw("REPLACE(productosCategoriasNivel3.productType,'_',' ')"))
                    ->on("productos.brand", DB::raw("REPLACE(productosCategoriasNivel3.brand,'_',' ')"))
                    ->on("productos.mpn", DB::raw("REPLACE(productosCategoriasNivel3.mpn,'_',' ')"));
            })
            ->join('categoriasNivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
            ->select(
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.priceweb',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia'
            )
            ->distinct('productos.mpn')
            ->where([
                ["productos.visible" , '=',"si"]
            ])
            ->get();
        return $productos;
    }
}
