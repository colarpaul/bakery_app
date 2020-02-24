<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    protected $table = 'recipes_ingredients';

    // Save a new ingredient into database
    public static function save_new_recipe_ingredient($data) {

      $recipes_ingredients = new RecipeIngredient;

      $recipes_ingredients->recipe_id                  = $data['recipe']->id;
      $recipes_ingredients->ingredient_id              = $data['new_ingredient']->id;
      $recipes_ingredients->ingredient_quantity        = $data['ingredient']['quantity'];
      $recipes_ingredients->ingredient_unit_of_measure = $data['ingredient']['unit_of_measure'];

      $recipes_ingredients->save();
    }

    // Attach ingredients to recipes
    public static function update_recipe_ingredient($data) {

      $ingredient = Ingredient::where('name', 'like', '%'.$data['ingredient']['name'].'%')->first();

      if ($ingredient)
      {

        $data['new_ingredient'] = $ingredient;

        RecipeIngredient::save_new_recipe_ingredient($data);
      } else {

        $new_ingredient = Ingredient::save_new_ingredient($data['ingredient']);

        $data['new_ingredient'] = $new_ingredient;

        RecipeIngredient::save_new_recipe_ingredient($data);
      }
    }
}
