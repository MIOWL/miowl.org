	<ul>
<?php if($this->uri->segment(1) === 'owls') : ?>

		<li>
			<?php print $this->owl_model->get_owl_name($owl); ?>
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url('owls'); ?>">choose new owl</a></li>
				<li><a class="owl_nav_button" href="<?php print site_url('owls/display/' . $owl); ?>">details</a></li>
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

		<?php $user_owls = $this->user_model->get_owls; ?>
		<?php if ($user_owls->num_rows() > 1) : ?>
			<li style="list-style-type: none">Active Owl</li>
			<li style="list-style-type: none">
	            <select id="current_owl_chosen" autocompelete="OFF" />
		            <?php foreach ($user_owls->results() as $owl_row) : ?>
	                    <option value="<?php print $owl_row->owl; ?>" <?php print ($this->session->userdata('owl') == $owl_row->owl) ? 'selected' : NULL; ?>>
	                    	<?php print $this->owl_model->get_owl_by_id($owl_row->owl)->row()->owl_name; ?>
	                    </option>
	                <?php endforeach; ?>
	            </select>
			</li>
			<li style="list-style-type: none"><a href="change_owl" class="button">Change</a></li>
			<li style="list-style-type: none">&nbsp;</li>
		<?php endif; ?>

		<li>
			MiOwl
			<ul>
				<li><a class="owl_nav_button" href="<?php print site_url(); ?>">details</a></li>
	<?php if (is_admin()) : ?>
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
	<?php if (is_admin()) : ?>
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

<?php endif; ?>
	</ul>
