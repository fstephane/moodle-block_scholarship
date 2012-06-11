<?php
require_once('../../../config.php');
require_once('renderviewadmin.php');
require_login(1, true);

global $PAGE, $OUTPUT, $DB, $CFG, $USER;

$PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/adminview.php');
$PAGE->requires->js('/blocks/scholarship/jquery.js');
$PAGE->requires->js('/blocks/scholarship/jquery.min.js');
$PAGE->requires->js('/blocks/scholarship/admin/dropdown.js');
$PAGE->requires->css('/blocks/scholarship/admin/scrollmenu.css');
$PAGE->requires->css('/blocks/scholarship/modal.css');
$PAGE->requires->js('/blocks/scholarship/modal.js');
$PAGE->requires->js('/blocks/scholarship/admin/request.js');
$PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
$PAGE->requires->js('/blocks/scholarship/lib/datepickercontrol.js');
echo $OUTPUT->header();

$year = optional_param('year', '0', PARAM_INT);

?>
<div id="centered" style="position:absolute;visibility:hidden;">
<div id="selectyear" style="position:absolute; width:400px; height:50px;"><p style="padding:10px; color:white; font-size:26px; text-align: center;"><?php echo get_string('selectyear', 'block_scholarship');?><img src='down-arrow.png' /></p>
    <ul id="list" style="position:absolute; visibility:hidden;top:36px;left:-31px;">
        <form name="year" method="get" action="adminview.php">
            <input type="button" alt="1" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('firstyear', 'block_scholarship'); ?>" id="modal"/>
            <input type="button" alt="2" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('secondyear', 'block_scholarship'); ?>" id="modal"/>
            <input type="button" alt="3" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('all', 'block_scholarship'); ?>" id="modal"/>
        </form>
    </ul>
</div>
</div>
<p>Add list of students</p>
<div id="boxes">
    <div id="dialog" class="window" style="position:absolute">
        <b style="color:white;"><?php echo get_string('pluginname', 'block_scholarship') ?> | <a href="#" class="close"><b style="color:dodgerblue;">Close</b></a>
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
        admin_view($year);
        ?>
        
    </div>
    <div id="mask" style="position:absolute;"></div>
</div>
<?php
echo '<div style="width:1500px; height:900px;"></div>';
echo $OUTPUT->footer();
?>
