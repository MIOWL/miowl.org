	<ul>
<?php if($this->uri->segment(1) === 'owl') : ?>

		<li>
			MiOwl
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url(); ?>">details</a></li>
	<?php if ($this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/edit_details'); ?>">edit details</a></li>
	<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			members
			<ul>
				<li>
					<a class="owl_nav_button" href="<?php print site_url('owl/members'); ?>">list</a>
					<ul>
						<li><a class="owl_nav_button" href="<?php print site_url('owl/members/admin'); ?>">admins</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url('owl/members/editor'); ?>">editors</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url('owl/members/user'); ?>">users</a></li>
					</ul>
				</li>
	<?php if ($this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/members/requests'); ?>">requests</a></li>
	<?php endif; ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/members/invite'); ?>">invite</a></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			categories
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories'); ?>">list</a></li>
	<?php if ($this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories/organize'); ?>">organize</a></li>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories/create'); ?>">create</a></li>
	<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			uploads
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads'); ?>">browse</a></li>
	<?php if ($this->session->userdata('editor')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads/upload'); ?>">upload</a></li>
	<?php endif; if ($this->session->userdata('admin')) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads/bin'); ?>">recycle bin</a></li>
	<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

<?php elseif($this->uri->segment(1) === 'owls') : ?>

		<li>
			MiOwl
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owls'); ?>">choose new owl</a></li>
				<li><a class="owl_nav_button" href="<?php print site_url('owls/display/' . $owl); ?>">details</a></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			members
			<ul>
				<li>
					<a class="owl_nav_button" href="<?php print site_url('owl/members/list/' . $owl); ?>">list</a>
					<ul>
						<li><a class="owl_nav_button" href="<?php print site_url('owls/members/admin/' . $owl); ?>">admins</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url('owls/members/editor/' . $owl); ?>">editors</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url('owls/members/user/' . $owl); ?>">users</a></li>
					</ul>
				</li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			categories
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owls/categories/' . $owl); ?>">list</a></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			uploads
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owls/uploads/' . $owl); ?>">browse</a></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

<?php endif; ?>
	</ul>
