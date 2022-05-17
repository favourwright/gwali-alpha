<?php
	$page_links = new stdClass();
	$page_links->home_local = REL_DIR."index.php";
	$page_links->home = $meta->site_home_link;
	#$page_links->knowledge_b = "?page=knowledge_base";
	$page_links->knowledge_b = REL_DIR."knowledge-base";
	#$page_links->admin_d = "?page=admin_dashboard";
	$page_links->admin_d = REL_DIR."admin";
	#$page_links->login_signup = "?page=login_signup";
	$page_links->login_signup = REL_DIR."login";
	#$page_links->settings = "?page=settings";
	$page_links->settings = REL_DIR."settings";
	#$page_links->profile = "?page=profile";
	$page_links->profile = REL_DIR."profile";
	
	# this is to enable me dynamically change the header background
	# when users on the profile page for starters
	$css = NULL;
	if(!empty($_GET['page']) && $_GET['page']=="profile"){ $css = "background:#31353e;border-color:rgba(255, 255, 255, 0.2);"; }
?><header class="unselectable" style="<?php echo $css; ?>">
    <div id="logo">
    	<a href="<?php echo $page_links->home; ?>"><img src="<?php echo REL_DIR; ?>images/gwali.svg" /></a>
    </div>
    
    <div class="menu_toggler hide_large" id="courseOptions">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="optBtn" data-id="unopened"></div>
    </div>
    
    <div class="tooltipGroup">
    	<div class="each">
			<?php
			# cache the login session
			$loggin_session = NULL;
			if(!empty($_SESSION['gwalian_login_session'])){ $loggin_session = $_SESSION['gwalian_login_session']; }
			# handle displaying user image or a default avatar
			$user_avatar = $student->getAvatar($loggin_session);
			# default image
			$user_profile_img = "<img src='".REL_DIR."images/user.svg' />";
			# if there is something in the variable $avatar, then the user uploaded an image
			if($user_avatar){
				$user_profile_img = "<img src='".REL_DIR."images/user/{$user_avatar}' />";
				echo "<div class='ico round'>{$user_profile_img}</div>";
			} elseif($loggin_session!=NULL) {
				$user_profile_img = "<img src='".REL_DIR."images/user/initials/{$userIdentity->userDetails->initial}.svg' />";
				echo "<div class='ico round'>{$user_profile_img}</div>";
			} else { echo "<div class='ico'>{$user_profile_img}</div>"; }
			
            # if user is logged-in display tooltip
			if(!empty($userIdentity->userDetails->firstname)){ $g_name = $userIdentity->userDetails->firstname; }
			if(!empty($userIdentity->userDetails->nickname)){ $g_name = $userIdentity->userDetails->nickname; }
			if($loggin_session){ ?>
            <div class="tooltip" data-state="closed">
            	<?php echo $student->showCare($g_name); ?>
                <div class="floatingBtn">
                    <?php
					# before giving user access to this admin area button check that the user is actually an admin else dont display
					if((!empty($userIdentity->g_admin) && $userIdentity->g_admin==$userIdentity->uId) || (!empty($userIdentity->s_admin) && $userIdentity->s_admin==$userIdentity->uId)){ ?>
                    <button>Admin<a href="<?php echo $page_links->admin_d; ?>"></a></button><?php } ?>
                    <button name="logout">log out</button>
                </div>
            </div>
            <?php
            # if not, display the login page link
			} else { ?>
            <a href="<?php echo $page_links->login_signup; ?>"></a>
            <?php } ?>
        </div>
    </div>
    
    
    <nav class="menu">
        <ul class="desktop unselectable hide_small hide_medium">
            <li class="abs_a">Home <a href="<?php echo $page_links->home_local; ?>"></a></li>
            <li class="abs_a">Knowledge Base <a href="<?php echo $page_links->knowledge_b; ?>"></a></li>
            <?php if(!empty($loggin_session)){ ?><li class="abs_a">Profile <a href="<?php echo $page_links->profile; ?>"></a></li><?php } ?>
            <?php
			# before giving user access to this admin area button check that the user is actually an admin else dont display
			if((!empty($userIdentity->g_admin) && $userIdentity->g_admin==$userIdentity->uId) || (!empty($userIdentity->s_admin) && $userIdentity->s_admin==$userIdentity->uId)){ ?>
			<li class="abs_a">Admin Dashboard <a href="<?php echo $page_links->admin_d; ?>"></a></li><?php } ?>
            <li class="abs_a">Settings <a href="<?php echo $page_links->settings; ?>"></a></li>
        </ul>
        
        
        <div class="mobile_nav hide_large" data-state="closed">
        	<div class="head">
            	<?php
				$blur_bg = NULL;
				if(!empty($userIdentity->userDetails->initial)){ $blur_bg = "user/initials/".$userIdentity->userDetails->initial.".svg"; }
				if(!empty($userIdentity->userDetails->thumb)){ $blur_bg = "user/resized_".$userIdentity->userDetails->thumb; }
				?>
            	<div class="blur_bg" style="background-image:url(<?php echo REL_DIR."images/".$blur_bg; ?>);"></div>
            	<span><?php if(isset($userIdentity->userDetails->firstname)){ echo ucfirst($userIdentity->userDetails->firstname); } else { echo "Gwalian"; } if((!empty($userIdentity->g_admin) && $userIdentity->g_admin==$userIdentity->uId) || (!empty($userIdentity->s_admin) && $userIdentity->s_admin==$userIdentity->uId)){ echo "<img src='".REL_DIR."images/verified_white.svg' />"; }?>
                </span>
            </div>
            <ul>
                <li class="abs_a active"><i class="icon-globe"></i> Home <a href="<?php echo $page_links->home_local; ?>"></a></li>
                <li class="abs_a"><i class="icon-lab"></i> Knowledge Base <a href="<?php echo $page_links->knowledge_b; ?>"></a></li>
                <?php if(!empty($loggin_session)){ ?><li class="abs_a"><i class="icon-person"></i> Profile <a href="<?php echo $page_links->profile; ?>"></a></li><?php } ?>
				<?php
                # before giving user access to this admin area button check that the user is actually an admin else dont display
                if((!empty($userIdentity->g_admin) && $userIdentity->g_admin==$userIdentity->uId) || (!empty($userIdentity->s_admin) && $userIdentity->s_admin==$userIdentity->uId)){ ?>
                <li class="abs_a"><i class="icon-combination-lock1"></i> Admin Dashboard <a href="<?php echo $page_links->admin_d; ?>"></a></li><?php } ?>
                <li class="abs_a"><i class="icon-cog1"></i> Settings <a href="<?php echo $page_links->settings; ?>"></a></li>
            </ul>
        </div>
    </nav>
</header>