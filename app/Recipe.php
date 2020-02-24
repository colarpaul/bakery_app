<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Recipe extends Model
{

    // Get info about all recipes from the database
    public static function get_recipes()
    {
        return DB::table('recipes_ingredients')
                 ->join('recipes', 'recipes.id', '=', 'recipes_ingredients.recipe_id')
                 ->select('recipe_id as id',
                          'recipes.name as name',
                          'recipes.quantity as quantity',
                          'recipes.unit_of_measure as unit_of_measure',
                          'recipes.image_url as image_url',
                          DB::raw('count(recipes_ingredients.ingredient_id) as total_ingredients'))
                 ->groupBy('recipes_ingredients.recipe_id',
                           'recipes.quantity',
                           'recipes.unit_of_measure',
                           'recipes.image_url',
                           'recipes.name')
                 ->paginate(5);
    }

    // Get info about selected recipe from the database
    public static function get_recipe($id)
    {
        $recipe_data = DB::table('recipes_ingredients')
                 ->where('recipes_ingredients.recipe_id', $id)
                 ->join('recipes', 'recipes.id', '=', 'recipes_ingredients.recipe_id')
                 ->join('ingredients', 'ingredients.id', '=', 'recipes_ingredients.ingredient_id')
                 ->select('recipe_id as recipe_id',
                          'recipes.name as recipe_name',
                          'recipes.quantity as recipe_quantity',
                          'recipes.unit_of_measure as recipe_unit_of_measure',
                          'recipes.image_url as recipe_image_url',
                          'ingredients.id as ingredient_id',
                          'ingredients.name as ingredient_name',
                          'recipes_ingredients.ingredient_quantity as ingredient_quantity',
                          'recipes_ingredients.ingredient_unit_of_measure as ingredient_unit_of_measure')
                 ->get();


        //@todo
        // Don't process data here.
        // Try to get this data also in the sql query
        $recipe = [
          'id'              => $recipe_data[0]->recipe_id,
          'name'            => $recipe_data[0]->recipe_name,
          'quantity'        => $recipe_data[0]->recipe_quantity,
          'unit_of_measure' => $recipe_data[0]->recipe_unit_of_measure,
          'image_url'       => $recipe_data[0]->recipe_image_url,
        ];

        foreach($recipe_data as $key => $data) {

          $recipe['ingredients'][$key] = [
            'id'              => $data->ingredient_id,
            'name'            => $data->ingredient_name,
            'quantity'        => $data->ingredient_quantity,
            'unit_of_measure' => $data->ingredient_unit_of_measure,
          ];
        }

        return $recipe;
    }

    // Recalculate recipe quantity
    public static function add_quantity($production) {

      $recipe = Recipe::find($production->recipe_id);

      $recipe->quantity_left = $recipe->quantity_left + $production->quantity;

      $recipe->save();
    }

    // Recalculate recipe quantity
    public static function drop_quantity($production) {

      $recipe = Recipe::find($production->recipe_id);

      $recipe->quantity_left = $recipe->quantity_left - $production->quantity;

      $recipe->save();
    }
}
