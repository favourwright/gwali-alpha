<?php
	$title = "Hi there";
	if($userIdentity->uId){ $title = ucwords("Hi {$userIdentity->userDetails->firstname}"); }
?><div id="contactUs" class="str_col_12">
	<div class="str_col_12">
    	<div class="title sleek_text flex text_center">
        	<span><?php echo $title; ?>, We'll listen to you... <br />pinky-promise</span>
            <span><?php for($i=0;$i<3;$i++){ echo '<img src="images/mail_art.svg" />';} ?></span>
        </div>
    	<div class="form no_outline flex">
            <form name="contactForm" method="post" enctype="multipart/form-data">
                <label class="select">What's this about?
                <select name="purpose" required>
                    <option value="">-select-</option>
                    <option value="suggest">Suggestion</option>
                    <option value="complain">Complaint</option>
                    <option value="enquire">Enquires</option>
                    <option value="bug">Bug report</option>
                </select>
                </label>
                
                <?php
                # if user is logged-in, use the user info for this
				$name = NULL;
				$email = NULL;
				if(!empty($userIdentity->uId)){
					$name = ucfirst($userIdentity->userDetails->firstname);
					$email = $userIdentity->userDetails->mail;
				}
				?>
                <label><span data-animated-title>Name</span>
                    <input name="name" type="text"<?php echo "value='{$name}'"; ?> required>
                </label>
                
                <label><span data-animated-title>Valid email</span>
                    <input name="email" type="email"<?php echo "value='{$email}'"; ?> required>
                </label>
                
                <label>Go ahead, We're listening
                    <textarea name="message" required></textarea>
                </label>
                
                <button name="submit">Send</button>
                <span class="status"></span>
            </form>
			<script src="scripts/formLabelPositioner.js"></script>
			<script src="scripts/contactUs.js"></script>
        </div>
    </div>
</div>