<?php if(!empty($loggin_session)){ ?><div id="user_profile" class="str_col_12">
	<div class="overview str_col_12">
    	<div class="user">
            <div class="avatar flex full_radius"><?php echo $user_profile_img; ?></div>
            <div class="name"><?php echo ucwords("{$userIdentity->userDetails->firstname} <br /> {$userIdentity->userDetails->lastname}"); ?></div>
        </div>
        <style> #user_profile .overview .user::after{ content:"You Joined <?php echo dateParser($userIdentity->userDetails->signupDate); ?>"; } </style>
        
        <div class="class_writters str_col_12 unselectable">
        	<div class="each"><img src="<?php echo REL_DIR; ?>images/user/resized_IMG-20190905-WA0024.png" /></div>
        	<div class="each"><img src="<?php echo REL_DIR; ?>images/user/resized_IMG-20190905-WA0032.png" /></div>
        	<div class="each"><img src="<?php echo REL_DIR; ?>images/user/resized_Screenshot-(79).png" /></div>
            <div class="each more flex text_white"><span>+2</span></div>
        </div>
    </div>
    
    <div class="main str_col_12">
    	<div class="str_col_12 font_16 bold_text padding_bottom_large">Profile</div>
    	<div class="profile_list str_col_12">
        	<div class="each str_col_12 unselectable" data-swipe-trigger="basic_info">
            	<div class="ico flex"><img src="<?php echo REL_DIR; ?>images/profile_ico.svg" /></div>
                <div class="desc">
                	<div class="title">Basic Information</div>
                    <div class="modify">fullname, nickname</div>
                </div>
            </div>
            <div class="swipe_content" data-swipe-content="basic_info">
            	<form name="basic_info" method="post">
                    <input name="firstname" placeholder="Firstname" value="<?php echo ucwords("{$userIdentity->userDetails->firstname}"); ?>" type="text" required>
                    <input name="lastname" placeholder="Lastname" value="<?php echo ucwords("{$userIdentity->userDetails->lastname}"); ?>" type="text" required>
                    <input name="nickname" placeholder="Nickname" value="<?php echo ucwords("{$userIdentity->userDetails->nickname}"); ?>" type="text">
                    <button class="hide" type="submit">update</button>
                </form>
            </div>
            
        	<div class="each str_col_12 unselectable" data-swipe-trigger="academic_info">
            	<div class="ico flex"><img src="<?php echo REL_DIR; ?>images/academic_ico.svg" /></div>
                <div class="desc">
                	<div class="title">Academic Information</div>
                    <div class="modify">university, faculty, department, year of study, registration number, courses offered</div>
                </div>
            </div>
            <div class="swipe_content" data-swipe-content="academic_info">
            	<form name="academic_info" method="post">
                    <select name="school" id="school" required>
                        <option value=""><?php echo "UNN (University of Nigeria Nsukka)"; ?></option>
                    </select>
                    <select name="faculty" id="faculty" disabled required>
                        <option value=""><?php echo ucwords(json_decode($userIdentity->userDetails->academicData)->faculty); ?></option>
                    </select>
                    <select name="department" id="department" disabled required>
                    	<option value="computer_science"><?php echo ucwords(splitAtUpperCase(json_decode($userIdentity->userDetails->academicData)->department)); ?></option>
                    </select>
                    <select name="level" id="level" disabled required>
                    	<option value="level"><?php echo ucwords(json_decode($userIdentity->userDetails->academicData)->level); ?></option>
                    </select>
                    <input name="reg_number" placeholder="registration number" value="<?php echo json_decode($userIdentity->userDetails->academicData)->regNumber; ?>" type="text" disabled required>
                    <button class="hide" type="submit">update</button>
                </form>
            </div>
            
        	<div class="each str_col_12 unselectable" data-swipe-trigger="contact_info">
            	<div class="ico flex"><img src="<?php echo REL_DIR; ?>images/contact_ico.svg" /></div>
                <div class="desc">
                	<div class="title">Contact Information</div>
                    <div class="modify">email address, phone numbers</div>
                </div>
            </div>
            <div class="swipe_content"data-swipe-content="contact_info">
            	<form name="contact_info" method="post">
                    <input name="email" placeholder="email" value="<?php echo "{$userIdentity->userDetails->mail}"; ?>" type="email" required>
                    <input name="phone_one" placeholder="phone one" value="<?php echo json_decode($userIdentity->userDetails->contact)->contact1; ?>" type="number">
                    <input name="phone_two" placeholder="phone two" value="<?php echo json_decode($userIdentity->userDetails->contact)->contact2; ?>" type="number">
                    <button class="hide" type="submit">update</button>
                </form>
            </div>
        </div>
        
        <div class="hr"><div></div></div>
        
        <div class="str_col_12">
        
        </div>
    </div>
    <script src="<?php echo REL_DIR; ?>scripts/swipeModal.js"></script>
    <script src="<?php echo REL_DIR; ?>scripts/profilePageForm.js"></script>
</div><?php } else { header("Location: index.php"); } ?>