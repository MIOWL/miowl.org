/* ********************************************************************************************** */
/* vars                                                                                           */
/* ********************************************************************************************** */

// this is the speed for the hide animation
var timeLimit = 2500; //this is in milliseconds

// this is the effect we wish to use
var effect = 'blind';

// this is the effect options
var options = {};


/* ********************************************************************************************** */
/* functions list                                                                                 */
/* ********************************************************************************************** */

/*
 * reset form function()
 */
function resetForm() {
    // reset all checkbox's
    $("input[type=checkbox]").each(function() {
        this.checked = false ;
    });

    // reset all the text input box's
    $("input[type=text]").val(null);

    // reset all the select box's
    $("select").val('default');

    // hide the div's again
    $("#provinceSelection").hide(effect, options, timeLimit);
    $("#owlSelection").hide(effect, options, timeLimit);
    $("#keywordSelection").hide(effect, options, timeLimit);
}

/*
 * checkAll function()
 *
 * @param field - the field we want to look at
 */
function checkAll(field)
{
    $(field).each(function() {
        this.checked = true ;
    });

    if(field === '.province_list') {
        province_list();
    }
    if(field === '.owl_list') {
        owl_list();
    }
}

/*
 * uncheckAll function()
 *
 * @param field - the field we want to look at
 */
function uncheckAll(field)
{
    $(field).each(function() {
        this.checked = false ;
    });

    if(field === '.province_list') {
        province_list();
    }
    if(field === '.owl_list') {
        owl_list();
    }
}

/*
 * list functions()
 */
function type_list() {
    var str = $("#type option:selected").val();
    if(str != "default") {
        $.getJSON('get_results/type/' + str, function(data) {
            var input_list = '';
            $(data.names).each(function(i, name){
                input_list += '<input type="checkbox" name="province[]" class="province_list" value="' + name + '" onclick="province_list()" />&nbsp;&nbsp;&nbsp;&nbsp;' + name + '<br />';
            });
            input_list += '<span class="save button" onclick="checkAll(\'.province_list\')" > Check All </span><span class="delete button" onclick="uncheckAll(\'.province_list\')" > Uncheck All </span>';
            $('#province_list').html(input_list);
        });

        if($("#provinceSelection").css("display") != "block") {
            $(this).show(effect, options, timeLimit, province_list);
        }
        if($("#owlSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit, owl_list);
        }
        if($("#keywordSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit);
        }
    }
    else {
        if($("#provinceSelection").css("display") != "none") {
            $(this).show(effect, options, timeLimit, province_list);
        }
        if($("#owlSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit, owl_list);
        }
        if($("#keywordSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit);
        }
    }
}
function province_list() {
    if(($("#type option:selected").val() != "default") && ($(".province_list:checked").length > 0)) {
        var province_list = null;
        $(".province_list:checked").each(function() {
            province_list += '-' + $(this).val();
        });

        $.getJSON('get_results/province/' + province_list, function(data) {
            var owl_list = '';
            $(data.owls).each(function(i, owl){
                owl_list += '<input type="checkbox" name="owl[]" class="owl_list" value="' + owl.id + '" onclick="owl_list()" />&nbsp;&nbsp;&nbsp;&nbsp;' + owl.name + '<br />';
            });
            owl_list += '<span class="save button" onclick="checkAll(\'.owl_list\')"   > Check All </span><span class="delete button" onclick="uncheckAll(\'.owl_list\')" > Uncheck All </span>';
            $('#owl_list').html(owl_list);
        });

        if($("#owlSelection").css("display") != "block") {
            $(this).hide(effect, options, timeLimit, owl_list);
        }
        if($("#keywordSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit);
        }
    }
    else {
        if($("#owlSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit, owl_list);
        }
        if($("#keywordSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit);
        }
    }
}
function owl_list() {
    if(($("#type option:selected").val() != "default") && ($(".province_list:checked").length > 0) && ($(".owl_list:checked").length > 0)) {
        if($("#keywordSelection").css("display") != "block") {
            $(this).hide(effect, options, timeLimit);
        }
    }
    else {
        if($("#keywordSelection").css("display") != "none") {
            $(this).hide(effect, options, timeLimit);
        }
    }
}



/* ********************************************************************************************** */
/* use the functions                                                                              */
/* ********************************************************************************************** */

/*
 * Set our default settings
 */
$(function() {
    resetForm();
});


/*
 * hide the areas from a clear button
 */
$("button[type=reset]").click(function(e) {
    // prevent the default
    e.preventDefault();

    // run the reset function
    resetForm();
});

/*
 * type selection change
 */
$("#type").change(function() { type_list(); }).change();

/*
 * check we have at least one checkbox chosen in the province list
 */
$('.province_list').click(function() { province_list(); });

/*
 * check we have at least one checkbox chosen in the owl list
 */
$('.owl_list').click(function() { owl_list(); });

