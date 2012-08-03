	Search Filters
	<ul>

		<li>
			keyword
			<ul>
				<li><?php print $this->session->userdata('search')['keyword']; ?></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			owl type
			<ul>
				<li><?php print $this->session->userdata('post')['type']; ?></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			owl province(s)
			<ul>
				<?php foreach ($this->session->userdata('search')['having']['owl_province'] as $province) : ?>
					<li><?php print $province; ?></li>
				<?php endforeach; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			owl(s)
			<ul>
				<?php foreach ($this->session->userdata('search')['having']['owl_id'] as $owl_id) : ?>
					<li><?php print $owl_id; ?></li>
				<?php endforeach; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

	</ul>