<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
**************************************************************************
**                              Plugin Name                             **
**************************************************************************
* @package     block                                                    **
* @subpackage  Scholarship                                              **
* @name        Scholarship                                              **
* @copyright   oohoo.biz                                                **
* @link        http://oohoo.biz                                         **
* @author      Stephane                                                 **
* @author      Fagnan                                                   **
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
**************************************************************************
**************************************************************************/


require_once('../../../config.php');
require_once('renderviewadmin.php');
require_login(1, true);

global $PAGE, $OUTPUT, $DB, $CFG, $USER;

//context needed for access rights
	$context = get_context_instance(CONTEXT_USER, $USER->id);

	//Check to see if user has access rights.
	if (!has_capability('block/scholarship:manage',$context)) {
		print_string('norights','block_scholarship');
		} else {      

$PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/adminview.php');
$PAGE->requires->js('/blocks/scholarship/jquery.min.js');
$PAGE->requires->js('/blocks/scholarship/admin/dropdown.js');
$PAGE->requires->css('/blocks/scholarship/admin/scrollmenu.css');
$PAGE->requires->css('/blocks/scholarship/modal.css');
$PAGE->requires->js('/blocks/scholarship/modal.js');
$PAGE->requires->js('/blocks/scholarship/admin/request.js');
$PAGE->requires->js('/blocks/scholarship/js/jquery-ui-1.8.21.custom.min.js');
$PAGE->requires->css('/blocks/scholarship/css/ui-lightness/jquery-ui-1.8.21.custom.css');
echo $OUTPUT->header();

//records the year of study selected
$year = optional_param('year', '0', PARAM_INT);

//Creates a list of students that have applied for a scholarship
$students = $DB->get_records_sql("SELECT DISTINCT us.userid, us.firstname, us.lastname, u.email 
                                FROM mdl_block_scholarship_users AS us
                                JOIN mdl_user AS u ON u.id=us.userid
                                ORDER BY lastname, firstname");

//Creates a list of scholarships that students have applied for 
$schol = $DB->get_records('block_scholarship_users', array(), '', 'id, firstname, lastname, scholarshipid, userid, scholarshipname');

//Creates a list of documents for scholarships
$docs = $DB->get_records('block_scholarship_doc_upload', array());

//Creates a list of students who have mailed in their submissions
$stud = $DB->get_records_sql('SELECT DISTINCT userid, firstname, lastname
                            FROM mdl_block_scholarship_users AS u
                            WHERE mail=1 AND received=0
                            ORDER BY lastname, firstname');

?>
<p id="scholinstr" class="<?php echo get_string('mailreceived', 'block_scholarship'); ?>" style="position:absolute;visibility:hidden;font-size:20px;color:black;"><?php echo get_string('view', 'block_scholarship'); ?></p>
<!-- Select year drop down menu -->
<div id="centered" style="position:absolute;visibility:hidden;">
<div id="selectyear" style="position:absolute; width:500px; height:50px;"><p style="padding:10px; color:white; font-size:26px; text-align: center;"><?php echo get_string('select', 'block_scholarship');?><img src='down-arrow.png' /></p>
    <ul id="list" style="position:absolute; display:none;top:35px;left:-31px;z-index:200;">
        <form name="year" method="get" action="adminview.php">
            <input type="button" alt="1" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('firstyear', 'block_scholarship'); ?>" id="modal" style="width:500px;font-size:13px;"/>
            <input type="button" alt="2" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('secondyear', 'block_scholarship'); ?>" id="modal" style="width:500px;font-size:14px;"/>
            <input type="button" alt="3" accept="<?php echo $CFG->wwwroot; ?>" name="year" value="<?php echo get_string('all', 'block_scholarship'); ?>" id="modal" style="width:500px;font-size:14px;"/>
        </form>
    </ul>
</div>
</div>
<p id="or" style="font-size:45px;position:absolute;visibility:hidden;"><?php echo get_string('or', 'block_scholarship'); ?></p>

<!-- Student Browser -->
<div id="studentlist" style="position:absolute;width:800px;height:500px;visibility:hidden;">
    <div  align="center" style="background-color:black;width:800px;height:40px;color:white;font-size:30px;border-top-right-radius:20px 20px;border-top-left-radius:20px 20px;"><?php echo get_string('browse', 'block_scholarship'); ?>
        <a href="#"><div id="mailtool" align="center" style="margin-left:60px;background-color:dimgray;margin-top:-102px;width:240px;height:50px;border:3px black solid;position:absolute;border-top-left-radius:15px 15px;border-top-right-radius:15px 15px;padding-top:12px;"><p id="mailtext" style="font-size:15px;color:white;"><?php echo get_string('mailconfirm', 'block_scholarship'); ?><img src="down-arrow.png" /></p><p id="hidemail" style="color:orange;display:none;font-size:16px;"><?php echo get_string('hide', 'block_scholarship'); ?></p></div></a>
    </div>
    <div style="width:248px;height:360px;border:1px black solid;margin-top:-1px;overflow-y:scroll;">
        <?php
        echo '<p style="padding-top:15px;"/>';
        foreach($students as $s)
            echo '<b style="margin-left:5px;">-</b><a class="student" name="'.$s->email.'" id="'.$s->userid.'" href="#" onclick="student_info(this.id, this.innerHTML, this.name)" style="padding-left:10px;">'.$s->firstname.' '.$s->lastname.'</a><br/>';
        ?>
    </div>
    <div id="studentinfo" style="width:549px;height:360px;border:1px black solid;float:right;margin-top:-362px;overflow-y:scroll;display:inline;">
    </div>
    <div id="deleteapp" align="center" style="width:549px;height:360px;border:1px black solid;float:right;margin-top:-362px;overflow-y:scroll;display:none;">
        <br/><p style="font-size:20px;"><?php echo get_string('appconfirm', 'block_scholarship'); ?></p><br/><br/>
        <div id="appyes" onclick="delete_app()" align="center" style="padding-top:8px;color:black;font-size:20px;border: 1px black solid;border-radius:30px 30px;height:40px;width:150px;"><?php echo get_string('yes', 'block_scholarship'); ?></div><br/><br/>
        <div id="appno" align="center" style="color:black;font-size:20px;padding-top:8px;border: 1px black solid;border-radius:30px 30px;height:40px;width:150px;"><?php echo get_string('no', 'block_scholarship'); ?></div>
    </div>
    <div id="addmail" style="width:800px;height:400px;border:1px black solid;background-color:dimgray;margin-top:-401px;position:relative;display:none;border-top-right-radius:20px 20px;border-top-left-radius:20px 20px;">
        <div  align="center" style="background-color:black;width:800px;height:40px;color:white;font-size:20px;border-top-right-radius:20px 20px;border-top-left-radius:20px 20px;"><p style="padding-top:5px;"><?php echo get_string('mailconfirm', 'block_scholarship'); ?></p></div>
        <div style="border:1px black solid;width:300px;height:360px;margin-left:-1px;overflow-y:scroll;">
        <?php
    //Creates list of students in order to confirm mailed submissions
        $i = 0;
        foreach($stud as $s)
        {
            if(($i % 2) == 0)
                                $color = 'darkgrey';
                            else
                                $color = 'lightgray';
            echo '<label class="checkbox" style="color:black;background-color:'.$color.'"><input type="checkbox" class="checkbox8" value="'.$s->userid.'"/><b style="padding-left:5px;">'.$s->firstname.' '.$s->lastname.'</b><br/></label>';
            $i++;
        }
        ?>
        </div>
        <div id="schollist" style="border:1px black solid;width:300px;height:360px;margin-left:300px;overflow-y:scroll;margin-top:-362px;"></div>
        <div id="requiredlist" style="border:1px black solid;width:198px;height:360px;margin-left:601px;overflow-y:scroll;margin-top:-362px;"></div>
    </div>
</div>
<div id="boxes">
    <div id="dialog" class="window" style="position:absolute">
        
    <!--Close button -->
        <div style="margin-top:-20px;"><b style="color:white;"><?php echo get_string('pluginname', 'block_scholarship') ?> | <a href="#" class="close"><b style="color:dodgerblue;"><?php echo get_string('close', 'block_scholarship');?></b></a></div>
        <br/><br/><br/>
        <div style="width:580px;margin-left:20px;position:absolute;margin-top:-40px;">
        <?php
    //Title for popup window
        switch($year)
        {
            case 1:
                echo '<b style="font-size:30px;color:white;">'.get_string('firstyear', 'block_scholarship').'</b>';
                break;
            case 2:
                echo '<b style="font-size:30px;color:white;position:absolute;top:20px;">'.get_string('secondyear', 'block_scholarship').'</b>';
                break;
            case 3:
                echo '<b style="font-size:30px;color:white;position:absolute;top:20px;">'.get_string('all', 'block_scholarship').'</b>';
                break;
        }
        echo '</div>';
    //Renders rest of popup window
        admin_view($year);
        ?>
        
    </div>
    <div id="mask" style="position:absolute;"></div>
</div>
<?php
echo '<div style="width:1500px; height:900px;"></div>';
echo $OUTPUT->footer();
                }
?>
