<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;

use App\Recipe;
use App\Ingredient;
use App\RecipeIngredient;

class RecipeController extends Controller
{

    protected $units_of_measure = [
        'mililitru' => 'ml',
        'litri' => 'l',
        'grame' => 'g',
        'kilograme' => 'kg',
        'pieces' => 'pcs',
    ];

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
          'units_of_measure' => $this->units_of_measure
        ]);
    }

    /**
     * Delete Recipes
     *
     * Remove selected recipe from database and all info from recipes_ingredients table
     */
    public function delete($id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();

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
          'units_of_measure' => $this->units_of_measure
        ]);
    }

    /**
     * Update Recipe
     *
     * Allow to update the selected ingredient
     */
    public function update($id, Request $request)
    {
        $recipe = Recipe::find($id);

        $recipe->name            = $request->get('recipe_name');
        $recipe->quantity        = $request->get('recipe_quantity');
        $recipe->unit_of_measure = $request->get('recipe_unit_of_measure');

        $image = $request->file('image_url');

        // Save/upload image in storage
        if( $image ) {
          $recipe->image_url = $image->store('public/recipes_images');
        }

        $recipe->save();

        $recipes_ingredients = RecipeIngredient::where('recipe_id', $recipe->id);
        $recipes_ingredients->delete();

        $ingredients = $request->get('ingredients');
        foreach($ingredients as $ingredient) {

            $data = [
              'recipe'           => $recipe,
              'ingredient'       => $ingredient
            ];

            RecipeIngredient::update_recipe_ingredient($data);
        }

        return redirect()->route('view_recipe', $recipe->id);
    }

    /**
     * Add/save Recipe/RecipeIngredient
     *
     * Save a new recipe/recipe_ingredient into database
     */
    public function save(Request $request)
    {
        $recipe              = new Recipe;
        $recipes_ingredients = new RecipeIngredient;

        $recipe->name            = $request->get('recipe_name');
        $recipe->quantity        = $request->get('recipe_quantity');
        $recipe->unit_of_measure = $request->get('recipe_unit_of_measure');
        $recipe->quantity_left   = $request->get('recipe_quantity');
        $recipe->image_url       = $request->file('image_url')->store('public/recipes_images');

        $recipe->save();

        $ingredients = $request->get('ingredients');

        foreach($ingredients as $ingredient) {

          $data = [
            'recipe'           => $recipe,
            'ingredient'       => $ingredient
          ];

          RecipeIngredient::update_recipe_ingredient($data);
        }

        return redirect()->route('view_recipes');
    }
}
