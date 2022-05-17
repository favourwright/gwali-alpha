<div class="post-container str_col_12 unselectable no_outline">
<?php
	$post = array(
				array( "resized_Screenshot-(79).png", "Kill shot", "@killshot", "15 mins ago", "COS 201", "pdf", "note", "2m", "Algorithms: OOP stuctural algorithmic constructional processes", "200", "56" ),
				array( "resized_20180104_111038.jpg", "Sire", "@favourwright", "30 mins ago", "PHY 221", "jpeg", "assignment", "99k", "Relativity", "170", "41" )
					);
					
	for($i=0;$i<count($post);$i++){
?>    
    <div class="each str_col_12">
        <div class="uploader str_col_12">
            <div class="profile-pic abs_a">
                <div class="img-wrap flex">
                    <img src="../images/user/<?php echo $post[$i][0]; ?>" />
                    <a href=""></a>
                </div>
                <div class="badge"></div>
            </div>
            <div class="about">
                <div class="display-name"><?php echo $post[$i][1]; ?></div>
                <div class="username"><?php echo $post[$i][2]; ?></div>
                <div class="upload-time"><?php echo $post[$i][3]; ?></div>
            </div>
        </div>
        <div class="post">
            <div class="wrap str_col_12 abs_a">
                <div class="thumbnail flex">
                    <div class="course"><?php echo $post[$i][4]; ?></div>
                    <div class="type">
                        <div class="file-type"><?php echo $post[$i][5]; ?></div>
                        <div class="post-type"><?php echo $post[$i][6]; ?></div>
                    </div>
                    <div class="like-wrap">
                        <button class="like flex"><img src="../images/like_ico_<?php echo $theme; ?>.svg" /></button>
                        <div class="count"><?php echo $post[$i][7]; ?></div>
                    </div>
                </div>
                <div class="title"><?php echo $post[$i][8]; ?></div>
                <a href=""></a>
            </div>
            <div class="stat">
                <div class="views"><img src="../images/views_ico_<?php echo $theme; ?>.svg" /><span class="count"><?php echo $post[$i][9]; ?></span></div>
                <div class="comments"><img src="../images/comments_ico_<?php echo $theme; ?>.svg" /><span class="count"><?php echo $post[$i][10]; ?></span></div>
            </div>
        </div>
    </div><?php } ?>
</div>