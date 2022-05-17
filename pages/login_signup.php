<?php
# this is only restrict access to this page for a logged-in user...
# I mean: why would you want to access the login page when you've already logged-in
# and have not logged-out
if(!isset($_SESSION['gwalian_login_session'])){
	$login_page = new stdClass();
	$login_page->home_local = REL_DIR."index.php";
	$login_page->pass_reset = REL_DIR."forgot-my-password";
	#$login_page->pass_reset = REL_DIR."?page=password_reset";
	$login_page->terms = REL_DIR."terms";
	#$login_page->pass_reset = REL_DIR."?page=terms";
?><div class="str_col_12" id="loginPage">

	<div id="mainWrap" class="str_col_12">
        <div id="membersLogin" class="large_col_5 medium_col_6 small_col_12">
            <div class="formUiContainer no_outline unselectable">
                <div class="art">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
                <div class="avatarContainer">
                    <div class="avatar"><img src="images/user.svg" /></div>
                </div>
                
                <form id="login" name="login" method="post">
                    <label data-login="mail"><span data-animated-title>Email</span>
                    <input type="email" name="email" maxlength="40" required>
                    </label>
                    
                    <label data-login="pass"><span data-animated-title>Password</span>
                    <input type="password" name="password" maxlength="40" required>
                    </label>
                    
                    <label class="radio">
                    <input data-login="persist" name="login_persist" type="checkbox"> Keep me logged in
                    <span class="checkmark"></span>
                    </label>
                    
                    <button data-login="btn" name="login" type="submit">Login</button>
                    <span class="login-status"></span>
                </form>
                <a href="<?php echo $login_page->pass_reset ?>"><span class="text_grey">Forgot password?</span></a>
            </div>     
            <script src="<?php echo REL_DIR; ?>scripts/login.js"></script>       
        </div>
    
        <div id="newMembers" class="large_col_7 medium_col_6 small_col_12">
            <div class="formUiContainer no_outline unselectable">
                <div class="art">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
                <div class="tag">
                    New members account creation
                </div>
                
                <form id="signup" name="signup" method="post">
                    <label class="half"><span data-animated-title>First name</span>
                    <input name="firstName" maxlength="50" type="text" required>
                    </label>
                    
                    <label class="half"><span data-animated-title>Last name</span>
                    <input name="lastName" maxlength="50" type="text" required>
                    </label>
                    
                    <label class="half"><span data-animated-title>Enter nickname</span>
                    <input name="nickname" maxlength="20" type="text">
                    </label>
                    
                    <label class="half"><span data-animated-title>Enter a valid email</span>
                    <input name="email" maxlength="40" type="email" required>
                    </label>
                    
                    <label>Gender
                    <select name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    </label>
            
                    <label class="half"><span data-animated-title>Cell number</span>
                    <input name="num1" type="number" minlength="11" maxlength="11">
                    </label>
                    
                    <label class="half"><span data-animated-title>Cell number</span>
                    <input name="num2" type="number" minlength="11" maxlength="11">
                    </label>

                    <label class="half"><span data-animated-title>Enter Reg. num</span>
                    <input name="regNumber" maxlength="40" type="text" required>
                    </label>
                    
                    <label style="margin:0;">Select faculty
                    <select style="margin-top:6px;" class="schoolDetailSelect" name="faculty" id="faculty" required>
                        <option value="">-Please Select-</option>
                        <option value="physical-science">physical science</option>
                        <option value="biological-science">biological science</option>
                        <option value="agricultural-science">agricultural science</option>
                        <option value="arts">arts</option>
                        <option value="business-administration">business administration</option>
                        <option value="education">education</option>
                        <option value="engineering">engineering</option>
                        <option value="dentistry">dentistry</option>
                        <option value="environmental-studies">environmental studies</option>
                        <option value="health-science-and-technology">health science and technology</option>
                        <option value="law">law</option>
                        <option value="pharmaceutical-science">parmaceutical science</option>
                        <option value="social-science">social science</option>
                        <option value="medical-science">medical science</option>
                        <option value="veterinary-medicine">veterinary medicine</option>
                    </select>
                    </label>
                    
                    <select class="schoolDetailSelect" name="department" id="department" required>
                    </select>
            
                    <select style="margin-bottom:17px;" class="schoolDetailSelect" name="level" id="level" required>
                    </select>
                    
                    <label class="half"><span data-animated-title>Password</span>
                    <input id="newPass" onkeyup="checkPass(); return false;" type="password" name="password" maxlength="40" required>
                    </label>
                    <label class="half"><span data-animated-title>Confirm password</span>
                    <input id="confirmPass" onkeyup="checkPass(); return false;" type="password" name="confirmPass" maxlength="40" required>
                    </label>

                    <label class="radio">
                    <input name="terms" type="checkbox" required> I've read and agree with the Tos
                    <span class="checkmark"></span>
                    </label>

                    <button name="signup" type="submit">Signup</button>
                    <span class="signup-status"></span>
                </form>
                <script src="<?php echo REL_DIR; ?>scripts/credential.js"></script>
                <a target="_blank" href="<?php echo $login_page->terms; ?>"><span class="text_grey">Terms of service</span></a>
            </div>
            <script src="<?php echo REL_DIR; ?>scripts/signup.js"></script> 
        </div>
    </div>
	<script src="<?php echo REL_DIR; ?>scripts/formLabelPositioner.js"></script>
    <script src="<?php echo REL_DIR; ?>scripts/passConfirmation.js"></script>
</div><?php
# if user login session is set redirect user to home page
} else { header("Location: index.php"); }?>