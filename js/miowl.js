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
     * delete upload
     */
    $('.remove').click(function(e) {
        e.preventDefault();

        // get href id
        var id = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: '/owl/uploads/remove/' + id,
            dataType: 'text',
            success: function(response) {
                if (response == "1") {
                    $('#r-' + id).fadeOut('slow', function() {
                        $('#r-' + id).empty();
                    });
                }
            }
        });
    });
    // ------------------------------------------------------------------------

    /*!
     * restore upload
     */
    $('.restore').click(function(e) {
        e.preventDefault();

        // get href id
        var id = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: '/owl/uploads/restore/' + id,
            dataType: 'text',
            success: function(response) {
                if (response == "1") {
                    $('#r-' + id).fadeOut('slow', function() {
                        $('#r-' + id).empty();
                    });
                }
            }
        });
    });
    // ------------------------------------------------------------------------

    /*!
     * change active owl
     */
    $('#owl_choice_area a.button').click(function(e) {
        e.preventDefault();

        $.post('/user/ajax_change_owl',
            {
                owl: function() { return $("#owl_choice_area select option:selected").val(); }
            },

            function(resp) {
                if(resp === 'changed') {
                    window.location.reload();
                }
            }, "text"
        );
    });
    $('a.change_owl').click(function(e) {
        e.preventDefault();

        $.post('/user/ajax_change_owl',
            {
                owl: function() { return $(this).attr('href'); }
            },

            function(resp) {
                if(resp === 'changed') {
                    window.location.reload();
                }
            }, "text"
        );
    });
    // ------------------------------------------------------------------------

    /*!
     * change active owl
     */
    $('a.request_access').click(function(e) {
        e.preventDefault();

        $.post('/user/ajax_request_owl_access',
            {
                owl: function() { return $(this).attr('href'); }
            },

            function(resp) {
                if(resp === 'requested') {
                    window.location.reload();
                }
            }, "text"
        );
    });
    // ------------------------------------------------------------------------

});
