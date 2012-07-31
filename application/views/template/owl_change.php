<?php
    $user_owls = $this->user_model->get_owls();
    if ($user_owls->num_rows() > 1) :
?>
    <div id="owl_choice_area" class="right">
        Active Owl <br />
        <select id="current_owl_chosen" autocompelete="OFF" />
            <?php foreach ($user_owls->result() as $owl_row) : ?>
                <option value="<?php print $owl_row->owl; ?>" <?php print ($this->session->userdata('owl') == $owl_row->owl) ? 'selected' : NULL; ?>>
                    <?php print $this->owl_model->get_owl_by_id($owl_row->owl)->row()->owl_name; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <a href="change_owl" class="button right">Change</a></li>
    </div>
<?php endif; ?>
