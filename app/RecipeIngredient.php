<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class RecipeIngredient extends Model
{
    protected $table = 'recipes_ingredients';

    // Save a new ingredient into database
    public static function save_new_recipe_ingredient($recipe, $ingredient) {

      $recipes_ingredients = new RecipeIngredient;

      $recipes_ingredients->recipe_id                  = $recipe->id;
      $recipes_ingredients->ingredient_id              = $ingredient->id;
      $recipes_ingredients->ingredient_quantity        = $ingredient->quantity;
      $recipes_ingredients->ingredient_unit_of_measure = $ingredient->unit_of_measure;

      $recipes_ingredients->save();
    }

    // Attach ingredients to recipes
    public static function update_recipe_ingredient($recipe, $ingredient) {

      $quantity_before_it_changes = $ingredient['quantity'];
      $ingredient_found = Ingredient::where('name', $ingredient['name'])->first();

      if ( $ingredient_found )
      {
        $ingredient_found->quantity -= $quantity_before_it_changes;
        if( $ingredient_found->quantity >= 0 ) {

          $ingredient_found->save();

          $ingredient = $ingredient_found;
          $ingredient->quantity = $quantity_before_it_changes;
        } else {

          throw ValidationException::withMessages([
            'error_quantity' => 'RecipeIngredient quantity can`t be higher than Ingredient quantity.'
          ]);
        }

      } else {

        $ingredient = Ingredient::save_new_ingredient($ingredient);
        $ingredient->quantity = $quantity_before_it_changes;
      }
      RecipeIngredient::save_new_recipe_ingredient($recipe, $ingredient);
    }
}
