<?php if(empty($userIdentity->loggedInId)){ ?><div id="passwordReset" class="str_col_12">
	<button data-history class="backHistoryBtn">Back</button>
	<div class="resetForm flex">
    	<form method="post">
            <label data-login="mail"><span>Enter the email you used in registering your account</span>
            <input type="email" name="email" maxlength="40">
            </label>
            
            <button name="submit">Reset Password</button>
            <span class="status"></span>
            <span class="info"></span>
        </form>
    <script src="scripts/passwordReset.js"></script>
    </div>
</div><?php } else { header("Location: index.php"); } ?>