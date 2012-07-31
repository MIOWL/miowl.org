<?php
	if($this->session->userdata('authed')) :
	    $user_owls = $this->user_model->get_owls();
	    if ($user_owls->num_rows() > 1) :
?>
	<div id="owl_choice_area">
	 	<div id="owl_choice_area_b">
	        <span>Active Owl</span>
	        <br />
	        <select id="current_owl_chosen" autocompelete="OFF" />
	            <?php foreach ($user_owls->result() as $owl_row) : ?>
	                <option value="<?php print $owl_row->owl; ?>" <?php print ($this->session->userdata('owl') == $owl_row->owl) ? 'selected' : NULL; ?>><?php print $this->owl_model->get_owl_by_id($owl_row->owl)->row()->owl_name; ?></option>
	            <?php endforeach; ?>
	        </select>
	        <br />
	        <a href="#" class="button right">Change</a></li>
	    </div>
	</div>
<?php endif; endif; ?>
