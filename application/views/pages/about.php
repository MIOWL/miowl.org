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
                <li><a href="#disclamer">Disclamer &amp; Privacy</a></li>
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
            <div id="disclamer">
                <h2>Disclaimer and Privacy Policy</h2>
                <p>
                    The operators of this site specifically disclaim all responsibility for any liability, risk, personal or otherwise which is incurred as a consequence, directly or indirectly, of the use and application of any of the material on this site.
                </p>
                <p>
                    MI OWL makes no representations or warranties in relation to the information on this website.  MI OWL does not warrant that the medical information on this website will be constantly available, or available at all.  It also does not warrant that the medical information on this website is complete, true, accurate, up-to-date, or non-misleading.
                </p>
                <p>
                    If you use, or browse through our website we do collect some basic data about your visit.  This information is kept and used in aggregate for analysis, but is not personal to you and cannot be used to identify you. We use this aggregate data to determine traffic patterns, visits, and other statistics we then use to help us make MI OWL more useful.
                </p>
                <p>
                    MI OWL does not share, sell, or lease personal information about you to any third parties for their marketing use.  Any personal and contact information collected is only used in the function of MI OWL and its evolution.
                </p>
                <p>
                    By using this site, you agree to the terms and conditions of our Website Disclaimer and Privacy Policy and you assume full responsibility for use of any information within MI OWL. You also agree that MI OWL is not responsible or liable for any claim, loss or damage resulting from the use of this site by you, or any user. We reserve the right to modify, including add, or remove contents of this Website Disclaimer and Privacy Policy at any time. We reserve the right to remove contents from MI OWL at any time.  Please periodically review our Website Disclaimer and Privacy Policy for any changes.
                </p>
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
