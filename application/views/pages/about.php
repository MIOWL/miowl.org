<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			About Mi OWL!
		</center>
	</h1>

	<div id="body">
        <div id="tabs">
            <ul>
                <li><a href="#howto">How To Use</a></li>
                <li><a href="#create_owl">Create New OWLs</a></li>
            </ul>
            <div id="howto">
                <h2>Browsing libraries</h2>
                <p>You can look through individual organizational libraries by going to them from the MI OWL home page.  Return to the home page by moving the cursor over the MI OWL logo, found on the top left of each page, and clicking on it.  Then click on “OWLs” on the top right of the page.  By selecting the desired library from the drop down list and clicking on “choose”, in the lower right of the screen, you will be taken to the particular OWL.   Clicking “list” under the heading of “categories”, on the left hand side of that OWL’s homepage, will bring up the table of contents for that particular OWL.  Clicking on a particular category within that list will bring up all the document files stored under that category.  More information on a particular file can then be discovered by clicking on the tag icon to the right of the file name.  Another way to look through the files in an OWL is to click on “browse” under the “uploads” heading on the left side of an OWL’s homepage.  This will bring up a list of all the files within that OWL.  More information on a particular file can be discovered by clicking on its tag icon to the right of the file name.  Files can be downloaded, or printed by clicking on the appropriate icon to the right of the file name.</p>
                <br/>
                <h2>Searching content</h2>
                <p>Content within the MI OWL site can be searched by returning to the MI OWL home page by clicking on the MI OWL logo found at the top left of each page.  There “site search” can be clicked on at the top left of the home page.  This will bring up the general “Search form” where you will be prompted to enter 3 different search limits and then the topic to be searched.  Clicking on “search” on the lower right of the page will then run the inquiry.</p>
            </div>
            <div id="create_owl">
                <h2>Under Construction</h2>
                <p>Sorry, this content is still getting written.<br />Please check back at a later date for updates.</p>
            </div>
        </div>
	</div>

    <style type="text/css">
        /* ----------------------------------*/
        /*           Vertical Tabs           */
        /* ----------------------------------*/
        #tabs { border: none !important; min-width: 99% !important; }
        .ui-tabs-vertical { width: 55em; }
        .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
        .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
        .ui-tabs-vertical .ui-tabs-nav li a { display:block; width: 84% !important;}
        .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-selected { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
        .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: left; width: 45.5em; }
    </style>

    <script type="text/javascript">
        $(function() {
            $("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
            $("#tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
        });
    </script>

<?php $this->load->view('template/footer'); ?>
