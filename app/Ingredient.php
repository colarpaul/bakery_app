<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Ingredient extends Model
{
    protected $table = 'ingredients';

    // Save a new ingredient into database
    public static function save_new_ingredient($data) {

      $ingredient = new Ingredient;

      $ingredient->name            = $data['name'];
      $ingredient->quantity        = 0;
      $ingredient->unit_of_measure = $data['unit_of_measure'];

      if( !$ingredient->save() ){

         throw ValidationException::withMessages([
             'error_saving_ingredient' => 'Can`t save this ingredient. Something went wrong!'
         ]);
      }

      return $ingredient;
    }

    public static function recalculate_quantity($recipe_ingredient)
    {
      $quantity_before_it_changes = $recipe_ingredient->ingredient_quantity;

      $ingredient = Ingredient::find($recipe_ingredient->ingredient_id);
      $ingredient->quantity += $quantity_before_it_changes;

      if( !$ingredient->save() ){

         throw ValidationException::withMessages([
             'error_saving_ingredient' => 'Can`t save this ingredient. Something went wrong!'
         ]);
      }
    }
}
