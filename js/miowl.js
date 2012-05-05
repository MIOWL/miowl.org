/*!
 * MiOWL JS
 * Yummy JQuery
 *
 * author: A. Wynn
 *
 */
$(document).ready(function() {

    /*!
     * close notification boxes
     */
    $('a.close-notification').click(function(e) {
        e.stopPropagation();
        $(this).parent().hide();
    });
    // ------------------------------------------------------------------------

    // jQuery Tipsy
    $('[rel=tooltip]').tipsy({
        gravity: 's',
        fade: true
    });

    $('.frmTip').tipsy({
        trigger: 'focus',
        gravity: 'w',
        fade: true
    });
    // ------------------------------------------------------------------------

    /*!
     * forum element background animation
     * on focus and blur
     */
    $("select, textarea, .textInput").focus(function(e) {
        $(this).animate({
            backgroundColor: '#f9f2ba',
            borderTopColor: '#e9d315',
            borderRightColor: '#e9d315',
            borderBottomColor: '#e9d315',
            borderLeftColor: '#e9d315'
        }, 500, function() {
            // done
        });
    });

    $("select, textarea, .textInput").blur(function(e){
        $(this).animate({
            backgroundColor: '#ffffff',
            borderTopColor: '#aaaaaa',
            borderRightColor: '#aaaaaa',
            borderBottomColor: '#aaaaaa',
            borderLeftColor: '#aaaaaa'
        }, 900, function() {
            // done
        });
    });
    // ------------------------------------------------------------------------

    /*!
     * cross-browser opacity
     */
     $(".opac").fadeTo(0, 0.60);
     $(".opac1").fadeTo(0, 0.25);

     $(".opac, .opac1").mouseenter(function(e) {
         $(this).fadeTo("fast", 1)
     });

     $(".opac").mouseleave(function(e) {
        $(this).fadeTo("slow", 0.60)
     });

     $(".opac1").mouseleave(function(e) {
         $(this).fadeTo("slow", 0.25);
     });
     // ------------------------------------------------------------------------

    /*!
     * accept member
     */
    $('.approve').click(function(e) {
    	
    	alert("cehcking");
    	e.preventDefault();

    	// get href id
    	var id = $(this).attr('href');

    	$.ajax({
            type: 'GET',
            url: '/projects/miowl/owl/members/accept/' + id,
            dataType: 'text',
            success: function(response) {
                if (response == 1) {
                	alert("hide: " + response);
                	$(this).parent('tr').hide();
                } 
            }
        });


    });

    
    // ------------------------------------------------------------------------

});
