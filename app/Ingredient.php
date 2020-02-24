<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';

    // Save a new ingredient into database
    public static function save_new_ingredient($data) {

      $ingredient = new Ingredient;

      $ingredient->name            = $data['name'];
      $ingredient->quantity        = $data['quantity'];
      $ingredient->unit_of_measure = $data['unit_of_measure'];

      $ingredient->save();

      return $ingredient;
    }
}
