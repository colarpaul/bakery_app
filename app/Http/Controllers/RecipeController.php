<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

use App\Recipe;
use App\Ingredient;
use App\RecipeIngredient;

class RecipeController extends Controller
{

    /**
     * View Recipes
     *
     * Returns all recipes data from database
     */
    public function index()
    {
        $recipes = Recipe::get_recipes();

        return view('components.recipes.index', [
          'recipes'          => $recipes,
          'units_of_measure' => config('global.units_of_measure')
        ]);
    }

    /**
     * Delete Recipes
     *
     * Remove selected recipe from database and all info from recipes_ingredients table
     */
    public function delete($id)
    {
        $recipe              = Recipe::find($id);
        $recipes_ingredients = RecipeIngredient::where('recipe_id', $id)->get();

        if( $recipe->delete() ) {

            foreach($recipes_ingredients as $recipe_ingredient) {
                Ingredient::recalculate_quantity($recipe_ingredient);
            }
        } else {

            throw ValidationException::withMessages([
                'error_removing_recipe' => 'Can`t remove this recipe. Something went wrong!'
            ]);
        }

        return redirect()->route('view_recipes');
    }

    /**
     * View Recipe
     *
     * Show all information about selected ingredient
     */
    public function view($id)
    {
        $recipe = Recipe::get_recipe($id);

        return view('components.recipes.view', [
          'recipe' => $recipe
        ]);
    }

    /**
     * Edit Recipe
     *
     * Returns the edit page of the selected recipe
     */
    public function edit($id)
    {
        $recipe = Recipe::get_recipe($id);

        return view('components.recipes.edit', [
          'recipe'           => $recipe,
          'units_of_measure' => config('global.units_of_measure')
        ]);
    }

    /**
     * Update Recipe
     *
     * Allow to update the selected ingredient
     */
    public function update($id, Request $request)
    {
        $this->validation($request);

        // Update the selected Recipe
        $recipe = Recipe::find($id);
        $recipe = $this->save_recipe($recipe, $request);

        // Remove RecipeIngredient
        $recipes_ingredients = RecipeIngredient::where('recipe_id', $recipe->id)->get();
        foreach($recipes_ingredients as $recipe_ingredient) {
            Ingredient::recalculate_quantity($recipe_ingredient);

            if( !$recipe_ingredient->delete() ) {

              throw ValidationException::withMessages([
                'error_removing_recipe_ingredient' => 'Can`t remove this recipe ingredient. Something went wrong!'
              ]);
            }
        }

        $this->update_recipe_ingredient($request, $recipe);

        return redirect()->route('view_recipe', $recipe->id);
    }

    /**
     * Add/save Recipe/RecipeIngredient
     *
     * Save a new recipe/recipe_ingredient into database
     */
    public function save(Request $request)
    {
        $this->validation($request);

        // Save a new Recipe
        $recipe = new Recipe;
        $recipe = $this->save_recipe($recipe, $request);

        $this->update_recipe_ingredient($request, $recipe);

        return redirect()->route('view_recipes');
    }

    /**
    * Saving the Recipe into database
    *
    * Returns $recipe Object
    * Otherwise catch exception
    */
    public function save_recipe($recipe, $request)
    {
      $recipe->name            = $request->get('recipe_name');
      $recipe->quantity        = $request->get('recipe_quantity');
      $recipe->unit_of_measure = $request->get('recipe_unit_of_measure');

      $image = $request->file('image_url');
      if( $image ) {

        $recipe->image_url = $image->store('public/recipes_images');
      }

      if( $recipe->save() ) {

          return $recipe;
      } else {

          throw ValidationException::withMessages([
            'error_creating_recipe' => 'Can`t create this recipe. Something went wrong!'
          ]);
      }

    }

    /**
    * Create a new RecipeIngredient with a given $recipe Object
    *
    * Catch exception
    */
    public function update_recipe_ingredient($request, $recipe) {

      $ingredients = $request->get('ingredients');
      foreach($ingredients as $ingredient) {
          RecipeIngredient::update_recipe_ingredient($recipe, $ingredient);
      }
    }

    /**
    * Validation used for the SAVE and UPDATE methods from RecipeController
    */
    public function validation($request)
    {
      $request->validate([
        'recipe_name'                     => 'required',
        'recipe_quantity'                 => 'required',
        'recipe_unit_of_measure'          => 'required'
      ]);
    }
}
