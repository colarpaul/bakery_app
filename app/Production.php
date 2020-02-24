<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{
    protected $table = 'production';

    // Get info about all productions from the database
    public static function get_productions()
    {
        return DB::table('production')
                 ->join('recipes', 'recipes.id', '=', 'production.recipe_id')
                 ->select('production.id as id',
                          'production.name as name',
                          'production.quantity as quantity',
                          'production.unit_of_measure as unit_of_measure',
                          'recipes.quantity_left as quantity_left',
                          'recipes.name as recipe_name')
                 ->groupBy('production.id',
                           'production.name',
                           'production.quantity',
                           'recipes.quantity_left',
                           'production.unit_of_measure',
                           'recipes.name')
                 ->paginate(5);
    }

    // Get info about selected production from the database
    public static function get_production($id)
    {
        return DB::table('production')
                 ->where('production.id', $id)
                 ->join('recipes', 'recipes.id', '=', 'production.recipe_id')
                 ->select('production.id as id',
                          'production.name as name',
                          'production.quantity as quantity',
                          'recipes.quantity_left as quantity_left',
                          'production.unit_of_measure as unit_of_measure',
                          'recipes.name as recipe_name')
                 ->first();
    }
}
