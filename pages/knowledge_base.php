<div id="knowledge_base" class="str_col_12" data-check='{"page":"<?php echo $_GET['page']; ?>", "uId":"<?php if(!empty($userIdentity->loggedInId)){ echo $userIdentity->loggedInId; } ?>"}'>
	<script>
    // this is important so that user don't view this page unless they're signed in
    redirectNonUsers("knowledge_base", "knowledge_base");
    </script>
	<div class="landing str_col_12 abs_ref bg">
    	<div class="department font_36 abs_ref"><?php if(isset($_GET['department'])){ echo $_GET['department']; } else { echo "Physics and Astronomy"; } ?></div>
    	<div class="rel_faculty">Knowledge Base <i class="icon-navigate_next"></i> Physical science</div>
    </div>
    
    <div class="under_construction flex abs_ref">
    	<img src="<?php echo REL_DIR; ?>images/under_construction.png" />
        <i class="abs"></i>
    </div>
</div>