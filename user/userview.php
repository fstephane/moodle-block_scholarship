<?php
require_once('../../../config.php');
require_once('renderviewuser.php');
require_login(1, true);

global $PAGE, $OUTPUT, $DB, $CFG, $USER;

$PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/user/userview.php');
$PAGE->requires->js('/blocks/scholarship/jquery.js');
$PAGE->requires->js('/blocks/scholarship/jquery.min.js');
$PAGE->requires->js('/blocks/scholarship/user/dropdownuser.js');
$PAGE->requires->css('/blocks/scholarship/user/scrollmenuuser.css');
$PAGE->requires->css('/blocks/scholarship/modal.css');
$PAGE->requires->js('/blocks/scholarship/user/modaluser.js');
$PAGE->requires->js('/blocks/scholarship/user/requestuser.js');
echo $OUTPUT->header();

$userid = optional_param('userid', '0', PARAM_INT);

$year = optional_param('year', '0', PARAM_INT);

$name = $DB->get_record('user', array("id" => $userid), 'firstname, lastname');
$fullname = $name->firstname.' '.$name->lastname;

?>
<div id="centered" style="position:absolute;visibility:hidden;">
<div id="selectyear" style="position:absolute; width:400px; height:50px;"><p style="padding:10px; color:white; font-size:26px; text-align: center;"><?php echo get_string('selectyear', 'block_scholarship');?><img src='down-arrow.png' /></p>
    <ul id="list" style="position:absolute; visibility:hidden;top:36px;left:-31px;">
        <form name="year" method="get" id="<?php echo $userid; ?>" action="userview.php?userid=<?php echo $userid; ?>">
            <input type="button" alt="1" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('firstyear', 'block_scholarship'); ?>" id="modal"/>
            <input type="button" alt="2" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('secondyear', 'block_scholarship'); ?>" id="modal"/>
            <input type="button" alt="3" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('all', 'block_scholarship'); ?>" id="modal"/>
        </form>
    </ul>
</div>
</div>
<div id="boxes">
    <div id="dialog" class="window" style="position:absolute">
        <b style="color:white;"><?php echo get_string('pluginname', 'block_scholarship') ?> | </b><a href="#" class="close"><b style="color:dodgerblue;">Close</b></a>
        <br/><br/><br/>
        <div style="width:800px;margin-left:20px;position:absolute;">
        <?php
        switch($year)
        {
            case 1:
                echo '<b style="font-size:30px;color:white;">'.get_string('firstyear', 'block_scholarship').'</b>';
                break;
            case 2:
                echo '<b style="font-size:30px;color:white;">'.get_string('secondyear', 'block_scholarship').'</b>';
                break;
            case 3:
                echo '<b style="font-size:30px;color:white;">'.get_string('all', 'block_scholarship').'</b>';
                break;
        }
        echo '</div>';
        user_view($year, $userid, $fullname);
        ?>
        
    </div>
    <div id="mask" style="position:absolute;"></div>
</div>
<?php
echo '<div style="width:1500px; height:900px;"></div>';
echo $OUTPUT->footer();
?>