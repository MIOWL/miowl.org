//On document load
$(function(){
      //Set button disabled
      $('#owl_choice').attr("disabled", "disabled");

      //Append a change event listener to you inputs
      $('#owl').change(function(){
            //Validate your form here, example:
            var validated = false;
            if($('#owl').val() != 'new') validated = true;

            //If form is validated enable form
            if(validated){
                  $('#owl_choice').removeAttr("disabled");  // Enable the button
                  $("#owl option[value='new']").remove();   // Remove the 'New Owl' option.
            }

      });

      //Trigger change function once to check if the form is validated on page load
      $('#owl').trigger('change');
})
