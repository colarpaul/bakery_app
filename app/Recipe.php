<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Recipe extends Model
{

    protected $table = 'recipes';

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
        return Recipe::where('id', '=', $id)
            ->with('ingredients')
            ->first();
    }

    // Relationship between recipe and ingredients
    public function ingredients() : BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipes_ingredients')->withPivot('ingredient_quantity');
    }

    // Recalculate recipe quantity
    public static function recalculate_quantity($production) {

      $recipe = Recipe::find($production->recipe_id);

      $recipe->quantity += $production->quantity;

      $recipe->save();
    }
}
