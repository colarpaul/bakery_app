<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Database\QueryException;

use App\Ingredient;

class IngredientController extends Controller
{

    protected $units_of_measure = [
        'mililitru' => 'ml',
        'litri' => 'l',
        'grame' => 'g',
        'kilograme' => 'kg',
        'pieces' => 'pcs',
    ];

    /**
     * View Ingredients
     *
     * Returns all ingredients data from database
     */
    public function index()
    {
        $ingredients = Ingredient::paginate(5);

        return view('components.ingredients.index', [
          'ingredients'      => $ingredients,
          'units_of_measure' => $this->units_of_measure
        ]);
    }

    /**
     * Delete Ingredients
     *
     * Remove selected ingredient from database
     */
    public function delete($id)
    {
        $ingredient = Ingredient::find($id);

        try {
           $ingredient->delete();

        } catch(QueryException $error) {

           return redirect()->route('view_ingredients')->withErrors("Before you want to delete $ingredient->name from ingredients, please remove it from recipes.");
        }

        return redirect()->route('view_ingredients');
    }

    /**
     * View Ingredient
     *
     * Show all information about selected ingredient
     */
    public function view($id)
    {
        $ingredient = Ingredient::find($id);

        return view('components.ingredients.view', [
          'ingredient' => $ingredient
        ]);
    }

    /**
     * Edit Ingredient Page
     *
     * Returns the edit page of the selected ingredient
     */
    public function edit($id)
    {
        $ingredient = Ingredient::find($id);

        return view('components.ingredients.edit', [
          'ingredient' => $ingredient,
          'units_of_measure' => $this->units_of_measure
        ]);
    }

    /**
     * Update Ingredient Page
     *
     * Allow to update the selected ingredient
     */
    public function update($id, Request $request)
    {
        $ingredient = Ingredient::find($id);

        $ingredient->name            = $request->get('name');
        $ingredient->quantity        = $request->get('quantity');
        $ingredient->unit_of_measure = $request->get('unit_of_measure');

        $ingredient->save();

        return redirect()->route('view_ingredient', $ingredient->id);
    }

    /**
     * Add/save Ingredient Modal
     *
     * Save a new ingredient into database
     */
    public function save(Request $request)
    {
        $ingredient = new Ingredient;

        $ingredient->name            = $request->get('name');
        $ingredient->quantity        = $request->get('quantity');
        $ingredient->unit_of_measure = $request->get('unit_of_measure');

        $ingredient->save();

        return redirect()->route('view_ingredient', $ingredient->id);
    }
}
