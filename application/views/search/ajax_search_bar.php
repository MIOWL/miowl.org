<div id="ajax_search">
    <span class="icon_font" id="keyword_search">L</span>
    <input type="text" name="keyword" id="keyword" placeholder="Live Search..." style="width: 90%; margin: 12px;">
    <span class="icon_font" id="keyword_clear">'</span>
</div>
<table class="ajax_search_results"></table>

<!-- Ajax Search Javascript -->
<script type="text/javascript">
    $(function() {
        // clear button
        $('#keyword_clear').click(function(e){
            e.preventDefault();
            // done with ajax results
            $('.ajax_search_results').fadeOut().empty();

            // bring back to live our original results
            $('table.original, div.pagination').fadeIn();

            // remove the class from the table
            $('table.original').removeClass('original');

            // clear our keyword
            $('#keyword').val('');
        });

        // live search
        $("#keyword").autocomplete({
            source: function(request, response) {

                $.ajax({
                    type: 'POST',
                    url: "<?php print site_url('search/ajax_search') ?>",
                    dataType: "html",
                    data: {
                        keyword: $('#keyword').val(),
                        owl: <?php print 1 /*($this->uri->segment(1) === 'owls') ? $this->uri->segment(3) : $this->session->userdata('owl')*/; ?>
                    },

                    success: function(data) {
                        // hide our current files
                        $('table').addClass('original').fadeOut();

                        // hide the pagination
                        $('div.pagination').hide();

                        // render container for our ajax results
                        $('table.ajax_search_results').empty().show();

                        // build the new table to populate
                        // $('#owl_body').append(' <table class="ajax_search_results" style="display: none;"> \
                        $('table.ajax_search_results').append('<thead> \
                                                                    <tr> \
                                                                        <th>OWL</th> \
                                                                        <th>Category</th> \
                                                                        <th>Filename</th> \
                                                                        <th>License</th> \
                                                                        <th>File Type</th> \
                                                                        <th>Download</th> \
                                                                        <th>Info</th> \
                                                                    </tr> \
                                                                </thead> \
                                                                <tbody> \
                                                                </tbody> \
                                                            ');

                        // build our new ajax result for display to the user
                        $('.ajax_search_results tbody').append(data);

                        // show the table
                        // $('.ajax_search_results').fadeIn()
                    }
                });

            },

            minLength: 3

        });
    });
</script>
