	<ul>
<?php if($this->uri->segment(1) === 'owls') : ?>

		<li>
			<?php print $this->owl_model->get_owl_name($owl); ?>
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owls'); ?>">choose new OWL</a></li>
				<li><a class="owl_nav_button" href="<?php print site_url('owls/display/' . $owl); ?>">details</a></li>

				<?php if($this->session->userdata('authed')) : ?>
					<?php if(is_member($owl)) : ?>
						<li><a class="change_owl owl_nav_button" href="<?php print $owl; ?>">change active owl</a></li>
					<?php else : ?>
						<li><a class="request_access owl_nav_button" href="<?php print $owl; ?>">request membership</a></li>
					<?php endif; ?>
				<?php endif; ?>

				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<?php /*<li>
			members
			<ul>
				<li>
					<a class="owl_nav_button" href="<?php print site_url('owls/members/list/' . $owl); ?>">list</a>
					<ul>
						<li><a class="owl_nav_button" href="<?php print site_url('owls/members/admin/' . $owl); ?>">admins</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url('owls/members/editor/' . $owl); ?>">editors</a></li>
						<li><a class="owl_nav_button" href="<?php print site_url('owls/members/user/' . $owl); ?>">users</a></li>
					</ul>
				</li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>*/ ?>

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

<?php else : ?>

		<li>
			MI OWL
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url(); ?>">details</a></li>
	<?php if (is_admin()) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/edit_details'); ?>">edit details</a></li>
	<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			uploads
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads'); ?>">browse</a></li>
	<?php if (is_editor()) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads/upload'); ?>">upload</a></li>
	<?php endif; if (is_admin()) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/uploads/bin'); ?>">recycle bin</a></li>
	<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			categories
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories'); ?>">list</a></li>
	<?php if (is_admin()) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories/organize'); ?>">organize</a></li>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/categories/create'); ?>">create</a></li>
	<?php endif; ?>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

		<li>
			licenses
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/licenses'); ?>">list</a></li>
	<?php if (is_admin()) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/licenses/create'); ?>">create</a></li>
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
	<?php if (is_admin()) : ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/members/requests'); ?>">requests</a></li>
	<?php endif; ?>
				<li><a class="owl_nav_button" href="<?php print site_url('owl/members/invite'); ?>">invite</a></li>
				<li style="list-style-type: none">&nbsp;</li>
			</ul>
		</li>

<?php endif; ?>
	</ul>
