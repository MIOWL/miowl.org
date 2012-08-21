<?php $this->load->view('template/header'); ?>

    <h1>
        <center>
            <?=$page_title?>
        </center>
    </h1>

	<div id="body">

        <?php if ($this->session->userdata('authed')) : ?>
            <p>
                Hey there <?=$this->session->userdata('name')?>,
                <br />
                <br />
                We can see that your currently logged in, thats good news!<br />
                It looks like somebody has invited you into the <?=$owl_name?> OWL.<br />
                If this is correct, please click the button below to request membership. Once approved you will be a fully fledged member of this OWL.
            </p>

            <div class="buttonHolder">
                <a href="<?php print site_url(); ?>" class="button">Cancel</a>
                <a class="button request_access" href="<?=$owl_id?>">Request Membership</a>
            </div>
        <?php else : ?>
            <p>
                Why hello there,
                <br />
                <br />
                We can see that your not currently logged in or registered.<br />
                It looks like somebody has invited you into the <?=$owl_name?> OWL.<br />
                To become a member of this OWL please login and then request membership, or register for access to the owl.
            </p>

            <div class="buttonHolder">
                <a href="<?php print site_url('/user/login/user-join-' . $owl_id); ?>" class="button">Login</a>
                <a href="<?php print site_url('user/register/' . $owl_id); ?>" class="button">Register</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {

        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
