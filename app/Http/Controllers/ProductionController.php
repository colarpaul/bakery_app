<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

use App\Production;
use App\Recipe;

class ProductionController extends Controller
{

    protected $units_of_measure = [
        'mililitru' => 'ml',
        'litri' => 'l',
        'grame' => 'g',
        'kilograme' => 'kg',
        'pieces' => 'pcs',
    ];

    /**
     * View Productions
     *
     * Returns all production data from database
     */
    public function index()
    {
        $productions = Production::get_productions();
        $recipes     = Recipe::get();

        return view('components.productions.index', [
          'productions'      => $productions,
          'recipes'          => $recipes,
          'units_of_measure' => $this->units_of_measure
        ]);
    }

    /**
     * Delete Production
     *
     * Remove selected production from database
     */
    public function delete($id)
    {
        $production = Production::find($id);

        // Recalculate recipe quantity
        Recipe::add_quantity($production);

        $production->delete();

        return redirect()->route('view_productions');
    }

    /**
     * View Production
     *
     * Show all information about selected production
     */
    public function view($id)
    {
        $production = Production::get_production($id);

        return view('components.productions.view', [
          'production' => $production
        ]);
    }

    /**
     * Edit Production Page
     *
     * Returns the edit page of the selected production
     */
    public function edit($id)
    {
        $production = Production::get_production($id);
        $recipes    = Recipe::get();

        return view('components.productions.edit', [
          'production'      => $production,
          'recipes'          => $recipes,
          'units_of_measure' => $this->units_of_measure
        ]);
    }

    /**
     * Update Production Page
     *
     * Allow to update the selected production
     */
    public function update($id, Request $request)
    {
        $this->validate_quantity($request);

        $production = Production::find($id);

        // Recalculate recipe quantity
        Recipe::add_quantity($production);

        $production->name            = $request->get('name');
        $production->recipe_id       = $request->get('recipe_id');
        $production->quantity        = $request->get('quantity');
        $production->unit_of_measure = $request->get('unit_of_measure');

        $production->save();

        // Recalculate recipe quantity
        Recipe::drop_quantity($production);

        return redirect()->route('view_production', $production->id);
    }

    /**
     * Add/save Production Modal
     *
     * Save a new production into database
     */
    public function save(Request $request)
    {
        $this->validate_quantity($request);

        $production = new Production;

        $production->name            = $request->get('name');
        $production->recipe_id       = $request->get('recipe_id');
        $production->quantity        = $request->get('quantity');
        $production->unit_of_measure = $request->get('unit_of_measure');

        $production->save();

        // Recalculate recipe quantity
        Recipe::drop_quantity($production);

        return redirect()->route('view_production', $production->id);
    }

    public function validate_quantity($request)
    {
      $recipe = Recipe::find($request->get('recipe_id'));

      if($request->get('quantity') > $recipe->quantity_left) {

        throw ValidationException::withMessages(['error_quantity' => 'Don`t try to hack the value!']);
      }
    }
}
