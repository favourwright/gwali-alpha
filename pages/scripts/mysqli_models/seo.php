<?php
# remember to put seo for search filter


class Seo extends Records {
	# provide the proper title
	public function meta($get, $server){
		# cache important variables here
		$reqSc = $server["REQUEST_SCHEME"]; // http, https, ftp...
		$prot = "$reqSc://"; // server protocol used
		$n = "Gwali"; // name
		$n_ = "Gwalian"; // pronoun
		$cn = "Gwali note"; // company name
		$sn = "gwalinotes.com"; // site name
		$shl = $prot."www.gwalinotes.com"; // site home link
		$al = $prot.$sn; // absolute link
		$lf = $al."/images/logo_favicon.png"; // logo favicon
		$smi = $al."/images/share_note_image.png"; // share me image... Image used while sharing the post
		$nsi = $al."/images/normal_share_image.png"; // normal share me image... Image not sharing a post
		$meta = new stdClass();
		
		$meta->server = $server;
		$meta->get = $get;
		$meta->prot = $prot;
		
		$meta->uri = $shl.$server['REQUEST_URI'];
		$meta->site_name = $cn;
		$meta->site_home_link = $shl;
		# the title is home as a default
		$title = "{$cn}s official website";
		$keywords = "{$n}, {$cn}, {$cn}s, {$cn}s official, {$cn} home page, {$cn} landing page";
		$desc = "Here at {$cn}, we provide reviewed notes, past questions, materials and assignment solutions, Gwali Notes(related to your department or your area of interst) serve as a personal study assistant to every student. Join and study for that first class result you deserve";
		$favicon = $lf;
		$share_me_img = $nsi;
		
		# check if page isset... meaning we're no longer on home page
		if(!empty($get['page'])){
			$page = $get['page'];
			
			# user is viewing an entry( assignment or note )
			if($page=="view_page"){
				$data = $this->getViewDetail($_GET);
				# display this page only if the record exists
				if($type = $data->response=="done"){
					$entryId = $data->data->entryId;
					$type = $data->type;
					$fType = strtoupper($data->file->type);
					$cc = $data->courseCode;
					$uploader = $data->uploader;
					$dated = strtolower($data->dated);
					
					$title = $data->data->title. " &#8226; {$fType}";
					$keywords = "keys";
					$desc = "{$cc} {$type} for {$dated}";
					$share_me_img = $smi;
				}
			}
			if($page=="admin_dashboard"){
				$title = "{$n} Administrators dashboard";
				$keywords = "{$n} admin, {$n} administrator, {$cn} admin, {$cn} administrator, {$cn} admin dashboard, {$cn} administrator dashboard";
				$desc = "";
			}
			if($page=="contact_us"){
				$title = "Send {$cn} a message";
				$keywords = "contact {$n}, contact {$cn}, contact us, send us a message";
				$desc = "";
			}
			if($page=="about_us"){
				$title = "About {$cn}";
				$keywords = "about {$n}, about {$cn}, about us";
				$desc = "";
			}
			if($page=="privacy_policy"){
				$title = "{$cn}s privacy policy";
				$keywords = "{$cn}s privacy policy, our privacy policy, your privacy, privacy, site privacy";
				$desc = "";
			}
			if($page=="terms"){
				$title = "{$cn}s terms of service";
				$keywords = "{$cn}s terms, {$cn}s terms of service, our terms, our terms of service, terms, terms of service";
				$desc = "";
			}
			if($page=="login_signup"){
				$title = "Login to {$cn} or signup if you are not a member";
				$keywords = "{$cn} signup, {$cn} sign-up, {$cn} login, {$cn} log-in, login, log-in, signin, sign-in, register, signup, sign-up, new member";
				$desc = "";
			}
			if($page=="password_reset"){
				$title = "Send a password reset request";
				$keywords = "reset password, forgot password, new password, retriev passord, recover password";
				$desc = "";
			}
			if($page=="settings"){
				$title = "{$n} Settings and Preferences";
				$keywords = "settings, preferences";
				$desc = "";
			}
			if($page=="profile"){
				$title = "{$n} user profile";
				$keywords = "{$n} user profile, {$cn} user profile, user profile";
				$desc = "";
			}
			if($page=="knowledge_base"){
				$title = "{$n} for {departement}";
				$keywords = "{$n} for {departement}, {$n} resource, {$cn}s recource, {$n} {department}";
				$desc = "";
			}
		}
		# compile them also remove any unwanted characters
		$meta->page_title = stripChars($title);
		$meta->keyword = stripChars($keywords);
		$meta->description = stripChars($desc);
		$meta->favicon = $favicon;
		$meta->share_me_img = $share_me_img;
		
		# finally return the meta data
		return $meta;
	}
}