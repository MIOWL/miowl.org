<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Welcome to MI OWL!
		</center>
	</h1>

	<div id="body">
		<p>
			Welcome to Medical Interprofessional Open source Web-based Library, MI OWL.
		</p>

		<p>
			Here Canadian Medical clinics and small Hospitals can create their own document libraries to organize, search and share the information (policies, program descriptions, forms, medical directives, patient resources, etc.) they rely on.
		</p>

		<p>
			MI OWL is created and managed by front line health care providers that use the site themselves.<br />
			We are committed to being: <strong>a free service, open source, widely accessible and advertisement free.</strong>
		</p>

		<p>
			<ul>
				<li>Learn more about MI OWL by clicking on “<a href="/about">about</a>”.</li>
				<li>Want to look through existing libraries?  Click on “<a href="/owls">OWLs</a>” above.</li>
				<li>Searching for something specific?  Click on “<a href="/search">site search</a>” above.</li>
				<li>Interested in learning how to create a new library?  Click on “<a href="/about">about</a>” and then click on “<a href="/about#create_owl">Create New OWL</a>”.</li>
				<li>Questions, or need support?  You can email us at <?php print safe_mailto('support@miowl.org'); ?>.</li>
			</ul>
		</p>
	</div>

<?php $this->load->view('template/footer'); ?>
