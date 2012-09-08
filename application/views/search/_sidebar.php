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
			OWL type
			<ul>
				<li><?php print $post['type']; ?></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			OWL province(s)
			<ul>
				<?php if($search['having'] && $search['having']['owl_province'] != FALSE) foreach ($search['having']['owl_province'] as $province) : ?>
					<li><?php print $province; ?></li>
				<?php endforeach; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			OWL(s)
			<ul>
				<?php if($search['having'] && $search['having']['owl_id'] != FALSE) foreach ($search['having']['owl_id'] as $owl_id) : ?>
					<li><?php print $this->owl_model->get_owl_name($owl_id); ?></li>
				<?php endforeach; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

	</ul>
