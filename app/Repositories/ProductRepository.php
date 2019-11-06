<?php


namespace App\Repositories;
use DB;


class ProductRepository{

    public function getProducts($nivel3){

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
                "productos.visible" => "si",
                "productosCategoriasNivel3.idCategoriasNivel3" => $nivel3
            ])
            ->get();

        return $datos;
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
        $categoriaNivel1 = str_replace("-", " ", $nivel1);
        $categoriaNivel2 = str_replace("-", " ", $nivel2);

        $categoriaNivel1 = str_replace("_", "-", $categoriaNivel1);
        $categoriaNivel2 = str_replace("_", "-", $categoriaNivel2);

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

}
