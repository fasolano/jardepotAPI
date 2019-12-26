<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;


class MenuRepository{

    public function getNivel1(){
        $categoriasNivel1 = DB::table('categoriasNivel1')
            ->select(
                'idCategoriasNivel1',
                'nombreCategoriaNivel1'
            )
            ->where([
                ['ubicacion', 'navbar']
            ])
            ->orWhere([
                ['ubicacion', 'ambos']
            ])
            ->orderBy('prioridad', 'asc')
            ->get();

        return $categoriasNivel1;
    }

    public function getNivel2($nivel1){
        $categoriasNivel2 = DB::table('categoriasNivel2')
            ->select(
                'idCategoriasNivel2 as id',
                'nombreCategoriaNivel2 as name'
            )
            ->where([
                ['idCategoriasNivel1', $nivel1]
            ])
            ->orderBy('prioridad', 'asc')
            ->get();

        return $categoriasNivel2;
    }

    public function getIdProductTypes(){
        $idCategoria = DB::table('categoriasNivel1')
            ->select(
                'idCategoriasNivel1 as id',
                'nombreCategoriaNivel1 as name'
            )
            ->where([
                ['nombreCategoriaNivel1', 'Equipos']
            ])
            ->orWhere([
                ['ubicacion', 'ambos'],
                ['ubicacion', 'sidebar'],
            ])
            ->first();

        return $idCategoria;
    }

    public function getIdBrands(){
        $idCategoria = DB::table('categoriasNivel1')
            ->select(
                'idCategoriasNivel1 as id'
            )
            ->where([
                'nombreCategoriaNivel1' => 'Marcas'
            ])
            ->orWhere([
                ['ubicacion', 'ambos'],
                ['ubicacion', 'sidebar'],
            ])
            ->first();

        return $idCategoria;
    }

    public function getAdditional(){
        $idCategorias = DB::table('categoriasNivel1')
            ->select(
                'idCategoriasNivel1 as id',
                'nombreCategoriaNivel1 as name'
            )
            ->where([
                ['nombreCategoriaNivel1', '!=', 'Marcas'],
                ['nombreCategoriaNivel1', '!=', 'Equipos']
            ])
            ->whereRaw("(ubicacion = 'ambos' OR ubicacion = 'sidebar')")
            ->get();

        return $idCategorias;
    }



}
