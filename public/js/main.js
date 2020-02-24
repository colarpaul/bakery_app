//INGREDIENT-RECIPE
var counter = $('.ingredient-row-to-clone').length;

$('.btn-add-ingredient-row').on('click', function(){

  var cloned_ingredient_row = $('.ingredient-row-to-clone:first').clone();

  cloned_ingredient_row.find('.ingredient_name').val('');
  cloned_ingredient_row.find('.ingredient_quantity').val('');
  cloned_ingredient_row.find('.ingredient_unit_of_measure').val('');

  cloned_ingredient_row.find('.ingredient_name').attr('name', 'ingredients['+ counter +'][name]');
  cloned_ingredient_row.find('.ingredient_quantity').attr('name', 'ingredients['+ counter +'][quantity]');
  cloned_ingredient_row.find('.ingredient_unit_of_measure').attr('name', 'ingredients['+ counter +'][unit_of_measure]');

  $('.ingredient-row-to-clone:last').after(cloned_ingredient_row);

  counter++;
});

$(document).on('click', '.btn-remove-ingredient-row', function(){

  $(this).parent('.ingredient-row-to-clone').not(':first-child').remove();
});

//PRODUCTION
$('.production_recipe_id').on('change', function() {
   var recipe_quantity        = $(this).find(':selected').data('quantity');
   var recipe_unit_of_measure = $(this).find(':selected').data('uom');
   console.log(recipe_quantity); 

   $('.production_unit_of_measure option:selected').removeAttr('selected');
   $('.production_unit_of_measure option').prop('disabled', true);
   $('.production_unit_of_measure option[value="'+ recipe_unit_of_measure +'"]').prop('selected', true);
   $('.production_unit_of_measure option[value="'+ recipe_unit_of_measure +'"]').prop('disabled', false);

   $('.production_quantity').attr('max', recipe_quantity);
   $('.production_quantity').attr('placeholder', 'Max quantity for this recipe will be ' + recipe_quantity);
});
