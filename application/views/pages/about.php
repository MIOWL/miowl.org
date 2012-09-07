<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			About MI OWL!
		</center>
	</h1>

	<div id="body">
        <div id="tabs">
            <ul>
                <li><a href="#who_we_are">Who We Are</a></li>
                <li><a href="#howto">How To Use</a></li>
                <li><a href="#create_owl">Create New OWL</a></li>
                <li><a href="#disclaimer">Disclaimer &amp; Privacy</a></li>
            </ul>
            <div id="who_we_are">
                <h2>Genesis</h2>
                <p>
                    The development of Medical Interprofessional Open source Web-based Library (MI OWL) occurred when a group of physicians in the rural, remote community of Marathon, in Northwestern Ontario, became a Family Health Team in 2005.  Becoming an interprofessional team was an impetus to create a variety of new programs for our patient population.  We were challenged in this endeavor by the lack of available information on such clinical innovations and the inability to easily share information with other clinical teams.  With an Innovations grant from the Ontario Ministry of Health and Long Term Care one of the Marathon Family Health Team physicians, Eliseo Orrantia, embarked on creating MI OWL with the help of Joseph Newing (IT) and Margaret Cousins (epidemiologist).  We employed the services of Alan Wynn, of friendlydev.com as the primary programmer.
                </p>
                <br />
                <h2>Principles</h2>
                <p>
                    MI OWL is rooted in several principles which include being: a free service, advertisement free, open source and widely accessible.  MI OWL is a noncommercial site.  Its creators do not wish to make any financial profit from its use, nor have others do so.  Being open source allows for the program to be improved upon by other interested parties.  It can also be adapted, with minor modifications, to provide a similar service in other countries.  Beyond the health care application, the basic programming of MI OWL could be used to make a library of libraries for any myriad of topics.   The primary intent of MI OWL is to support health care providers in their care provision within our Canadian health care system.  As our system is publically funded, we believe that the body of knowledge that it creates should be freely accessible to all.  Improved sharing among health care providers can enhance the system’s function and evolution.  As well, transparency with the public makes us more directly accountable.
                </p>
                <br />
                <h2>Goals</h2>
                <p>
                    MI OWL has been created to provide Canadian primary care clinics and small community hospitals with a tool to create their own web-based document libraries.  These libraries allow the organizing, searching and sharing of the information that health care facilities rely on to provide patient care.   Such information can be policies, program descriptions, forms, medical directives and patient resources for example.  Individual libraries can be organized as desired depending on need and preference.
                </p>
                <p>
                    A fundamental goal of MI OWL is to create access to information.  This is achieved by allowing the libraries to be perused and searched by all those interested.   This facilitates us to share and build on what health organizations have already created.  It saves time and effort as well as creating a greater collaborative culture in health care.
                </p>
            </div>
            <div id="howto">
                <h2>Browsing libraries</h2>
                <p>You can look through individual libraries by clicking on “OWLs” on the top right of MI OWL pages.  This will bring you to the OWL Choice page.  From there you can select the desired library from the drop down list by clicking on “choose”, in the lower right of that screen.  You will be taken to the particular library’s OWL Details page.   Clicking “list” under the heading of “categories”, on the left hand side of that page, will bring up the table of contents for that particular OWL.  Clicking on a particular category within that list will bring up all the document files stored under that category.  More information on a particular file can then be discovered by clicking on the tag icon to the right of the file name.  Another way to look through the files in a particular OWL is to click on “browse” under the “uploads” heading on the left side of an OWL’s Details page.  This will bring up a list of all the files within that OWL.  More information on a particular file can be discovered by clicking on its tag icon to the right of the file name.  Files can be downloaded, or printed by clicking on the appropriate icon to the right of the file name.</p>
                <br/>
                <h2>Searching content</h2>
                <p>Content within the MI OWL site and all its libraries can be searched by clicking on “site search” at the top left of the MI OWL’s pages.  This will bring up the general “Search form” page where you will be prompted to enter 3 different search limits and then the topic to be searched.  Clicking on “search” on the lower right of the Search Form page will then run the inquiry.</p>
            </div>
            <div id="create_owl">
                <h2>Under Construction</h2>
                <p>Sorry, this content is still getting written.<br />Please check back at a later date for updates.</p>
            </div>
            <div id="disclaimer">
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

        /* paragraph padding */
        #tabs p { padding-left: 30px; }

        /* h2 bottom border */
        #tabs h2 {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
    </style>

    <script type="text/javascript">
        $(function() {
            $("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
            $("#tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
        });
    </script>

<?php $this->load->view('template/footer'); ?>
