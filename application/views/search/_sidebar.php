<?php
	$search = $this->session->userdata('search');
	$post 	= $this->session->userdata('post');
?>
	Search Filters
	<ul>

		<li>
			keyword
			<ul>
				<li><?php print $search['keyword']; ?></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			owl type
			<ul>
				<li><?php print $post['type']; ?></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			owl province(s)
			<ul>
				<?php foreach ($search['having']['owl_province'] as $province) : ?>
					<li><?php print $province; ?></li>
				<?php endforeach; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			owl(s)
			<ul>
				<?php foreach ($search['having']['owl_id'] as $owl_id) : ?>
					<li><?php print $owl_id; ?></li>
				<?php endforeach; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

	</ul>