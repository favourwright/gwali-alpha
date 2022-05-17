<?php if(!empty($userIdentity->g_admin)){ ?><div id="adminDashboard" class="str_col_12">
	<div class="str_col_12">
    	<div class="actionBtnGroup unselectable">
        
        	<div data-action="new entry" class="each">
            	<div class="ico text">+</div>
                <div class="name">
                	<div class="main">New post</div>
                    <div class="sub">Creat a new assignment or note</div>
                </div>
            </div>
        	<div data-action="manage entries" class="each">
            	<div class="ico"><i class=" icon-tools-2"></i></div>
                <div class="name">
                	<div class="main">Manage posts</div>
                    <div class="sub">Edit, Delete all submitted posts</div>
                </div>
            </div>
        	<div data-action="new courses" class="each">
            	<div class="ico text">+</div>
                <div class="name">
                	<div class="main">Supported courses</div>
                    <div class="sub">Add to the list of our supported courses</div>
                </div>
            </div>
        	<div data-action="manage courses" class="each">
            	<div class="ico"><i class=" icon-tools-2"></i></div>
                <div class="name">
                	<div class="main">Manage courses</div>
                    <div class="sub">Edit, Delete supported courses</div>
                </div>
            </div>
            
        </div>
    	<div class="actionBtnGroup unselectable">
        
        	<div data-action="contact us" class="each">
            	<div class="ico"><i class="icon-envelope"></i><span></span></div>
                <div class="name">
                	<div class="main">Messages</div>
                    <div class="sub">Attend to messages from our "contact us" page</div>
                </div>
            </div>
        	<div data-action="password recovery" class="each">
            	<div class="ico"><i class="icon-key4"></i><span></span></div>
                <div class="name">
                	<div class="main">Password recovery</div>
                    <div class="sub">Manage our password recovery requests</div>
                </div>
            </div>
            
        </div>
        
        <div id="actionModalWrap">
        	<div class="actionModal">
            	<div class="head str_col_12 unselectable">
                    <div class="backBtn"><i class="icon-navigate_before sleek_text"></i></div>
                    <div class="actionName str_col_12"></div>
                </div>
                <div class="content str_col_12"></div>
            </div>
        </div>
    </div>
    <script src="<?php echo REL_DIR; ?>scripts/adminDashboard.js" type="text/jscript"></script>
</div><?php } else { header("Location: index.php"); } ?>