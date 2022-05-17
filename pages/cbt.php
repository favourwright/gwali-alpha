<div class="cbt-container no_outline unselectable str_col_12">
    <div class="timing str_col_12">
        <ul>
            <li>Start time: <strong>09:23:31am</strong></li>
            <li>Duration: <strong>2 hours</strong></li>
            <li class="countdown">
                <span class="count-time">
                    <span>02:00:00</span>
                    <div class="prog-bar"><div style="width:65%"></div></div>
                </span>
            </li>
        </ul>
    </div>
    <div class="courses str_col_12">
        MTH 101
    </div>
    <div class="questions str_col_12">
        <form id="cbt-form" class="str_col_12">
            <div class="question str_col_12"><!--QUESTIONS--></div>
        </form> 
    </div>
    <div class="progress str_col_12">
        <div class="controls str_col_12">
            <button id="prev">previous</button>
            <button id="next">next</button>
            <button id="skip">skip this question</button>
        </div>
        <div class="indicators str_col_12">
            <?php for($i=1;$i<=json_decode($question_json)->qpe;$i++){ echo "<div class='each flex' id='index-{$i}'>{$i}</div>"; } ?>
        </div>
        <div class="controls str_col_12">
            <button id="quit">Quit exam</button>
        </div>
    </div>
<script> // the question id is supposed to come from the previous page dynamically </script>
<script> CBTHandler(<?php echo $question_json; ?>); </script>
</div>