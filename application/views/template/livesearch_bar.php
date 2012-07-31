<div id="livesearch">

    <div class="left">
        <input type="text" class="textInput large ui-autocomplete-input" placeholder="Start typing for live search." name="keyword" id="keyword" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
    </div>
    <div class="right">
        <div class="button-group">
            <a class="button icon cross icon-only" href="" id="search-clear"></a><a class="button icon question icon-only" id="search-info"></a>
        </div>
    </div>
    <div class="clear"></div>

</div>

<!-- search scripts -->
<script type="text/javascript">
    $(function() {

        // clear button
        $('#search-clear').click(function(e){
            e.preventDefault();
            // done with ajax results
            $('ul.saves.build').hide();

            // bring back to live our orgiional results
            $('ul.saves, div.pagination').show();

            // clear our keyword
            $('#keyword').val('');
        });

        // live search
        $("#keyword").autocomplete({
            source: function(request, response) {

                $.ajax({
                    type: 'POST',
                    url: "<?php print site_url('browse/ajax_search') ?>",
                    dataType: "json",
                    data: {
                        keyword: $('#keyword').val()
                    },

                    success: function(data) {
                        // hide our current saves
                        $('ul.saves, div.pagination').hide();

                        // render container for our ajax results
                        $('ul.saves.build').empty().fadeIn();

                        // build our new ajax results for display to the user
                        response($.map(data, function(item) {
                            $('ul.saves.build').append('<li title="Downloads: ' + item.downloads + '">> \
                                <div class="saves_img left"><img src="<?php print site_url("save/save_png/' + item.id + '") ?>" alt="" /></div> \
                                <div class="saves_info left"> \
                                    <span class="title">Name: ' + item.title_save + '</span><br /> \
                                    <span class="title_id">Title ID: '+ item.title_id + '</span><br /> \
                                    <span class="title_game">Title: ' + item.title_name + '</span><br /> \
                                    <span class="saves_by">Uploaded By: ' + item.user_name + '</span> \
                                </div> \
                                 \
                                <div class="saves_desc left">' + item.save_desc.substring(0, 50).replace(/<br[^>]*>/g,"") + '... </div> \
                                <div class="saves_options right"> \
                                    <a href="<?php print site_url("save/view/' + item.id + '") ?>" class="button icon game">View</a> \
                                </div> \
                                <div class="clear"></div> \
                            </li>');

                            /*
                            return {
                                label: item.title_name + ": " + item.title_save,
                                value: item.title_name,
                                id: item.id
                            }*/
                        }));
                    }
                });

            },

            minLength: 3

        });
    });
</script>
