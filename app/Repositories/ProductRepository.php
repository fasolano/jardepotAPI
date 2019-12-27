<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;


class ProductRepository{

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
            ->join('categoriasnivel3 as c3', 'c3.idCategoriasNivel3', '=', 'productosCategoriasNivel3.idCategoriasNivel3')
            ->leftJoin('producto_caracteristica as pc', function ($join){
                $join->on("pc.producto",
                    DB::raw("binary CONCAT(productos.productType,' ',productos.brand,' ',productos.mpn)"));
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
                'XML.resenia'
            )
            ->distinct('productos.mpn')
            ->orderBy('pc.producto', 'asc')
            ->where([
                "productos.visible" => "si",
                "c3.idCategoriasNivel2" => $nivel2
            ])
            ->get();

        return $datos;
    }

    public function getProductsFilters($nivel2, $filtros, $cant){
        $valores = array();
        array_push($valores, ["productos.visible", '=', "si"]);
        array_push($valores, ["c3.idCategoriasNivel2", '=', $nivel2]);
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
            ->orderBy('pc.producto', 'asc')
            ->where($valores)
            ->whereRaw($filtros)
            ->groupBy('productos.mpn')
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
            ->where(['pc.producto' => $producto])
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
            ->where([
                'productos.productType' => $productType,
                'productos.brand' => $brand,
                'productos.mpn' => $mpn,
            ])
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
            ->where([
                ['productos.productType', $productType],
                ['productos.kind', 'MAQ'],
                ['productos.visible', 'si'],
                ['productos.mpn', '!=', $mpn]
            ])
            ->whereRaw(
                "productos.priceweb >= (select priceweb * 0.75 as priceweb from productos where productType = '".$productType."' AND brand = '".$brand."' AND mpn = '".$mpn."') AND ".
                "productos.priceweb <= (select priceweb * 1.5 as priceweb from productos where productType = '".$productType."' AND brand = '".$brand."' AND mpn = '".$mpn."')"
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
                ['nombreCategoriaNivel2', 'like', "%$productType%"],
                ['nombreCategoriaNivel1', '=', 'Equipos']
            ])
            ->get();

        return $levels;
    }

}
