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
          'units_of_measure' => config('global.units_of_measure')
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

        if( $production->delete() ) {

            // Recalculate recipe quantity
            Recipe::recalculate_quantity($production);
        } else {

            throw ValidationException::withMessages([
                'error_removing_production' => 'Can`t remove this production. Something went wrong!'
            ]);
        }

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
          'units_of_measure' => config('global.units_of_measure')
        ]);
    }

    /**
     * Update Production Page
     *
     * Allow to update the selected production
     */
    public function update($id, Request $request)
    {
        $production = Production::find($id);

        $this->validation($request, $production);

        $quantity_before_it_changes  = $production->quantity;

        $this->save_production($request, $production, $quantity_before_it_changes);

        return redirect()->route('view_production', $production->id);
    }

    /**
     * Add/save Production Modal
     *
     * Save a new production into database
     */
    public function save(Request $request)
    {
        $this->validation($request);

        $production = new Production;
        $this->save_production($request, $production);

        return redirect()->route('view_production', $production->id);
    }

    /**
    * Saving the Production into database
    * Recalculate quantity for the recipe
    *
    * Catch Exception
    */
    public function save_production($request, $production, $quantity_before_it_changes = 0) {

      $production->name            = $request->get('name');
      $production->recipe_id       = $request->get('recipe_id');
      $production->quantity        = $request->get('quantity');
      $production->unit_of_measure = $request->get('unit_of_measure');

      if( $production->save() ) {

          // Recalculate recipe quantity
          $production->quantity = $quantity_before_it_changes - $production->quantity ;
          Recipe::recalculate_quantity($production);
      } else {

          throw ValidationException::withMessages([
            'error_creating_production' => 'Can`t create this production. Something went wrong!'
          ]);
      }
    }

    /**
    * Validation used for the SAVE and UPDATE methods from ProductionController
    */
    public function validation($request, $production = null)
    {
      $request->validate([
        'name'            => 'required',
        'recipe_id'       => 'required',
        'unit_of_measure' => 'required',
        'quantity'        => [
          'required',
          $this->validate_quantity($request, $production),
        ]
      ]);
    }
    
    public function validate_quantity($request, $production = null)
    {
      $recipe = Recipe::find($request->get('recipe_id'));

      $total_quantity = $recipe->quantity;
      if( $production ) {

        $total_quantity += $production->quantity;
      }

      if($request->get('quantity') > $total_quantity) {

        throw ValidationException::withMessages(['error_quantity' => 'Don`t try to hack the value!']);
      }

    }
}
