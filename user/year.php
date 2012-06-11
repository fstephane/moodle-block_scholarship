<?php
require_once('../../../config.php');
require_once('../lib.php');
require_login(1, true);


global $CFG, $USER, $COURSE, $OUTPUT, $DB;
$PAGE->requires->js('/blocks/scholarship/lib/scholarship.js');
$PAGE->requires->css('/blocks/scholarship/admin/style.css');
$PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
$PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/user/year.php');
$navlinks = array(
            array(
                'name'=>get_string('availablescholarships', 'block_scholarship'),
                'link'=>'',
                'type'=>'misc'
                )
         );
    $nav = build_navigation($navlinks);
    print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'),$nav);
    $DB->delete_records('block_scholarship_year', array("id" => 5));
    //context needed for access rights
    $context = get_context_instance(CONTEXT_USER, $USER->id);

    //Check to see if user has access rights.
    if (!has_capability('block/scholarship:user',$context)) {
            print_string('norights','block_scholarship');
      } else {

        $yearid = optional_param('yearid', 0, PARAM_INT);
        $submitted = optional_param('submitted', 0, PARAM_TEXT);

        if  ($submitted === 'yes'){

            $insert = new object();
            $insert->yearid = $yearid;
            $insert->userid = $USER->id;
            $insert->timecreated = time();
            $insert->timemodified = time();
            
            $DB->delete_records('block_scholarship_year', array("userid" => $USER->id));
            
            if (!$DB->insert_record('block_scholarship_year',$insert)) {
                echo 'data not saved!';
                redirect($CFG->wwwroot.'/blocks/scholarship/user/view.php?id=','',0);
            }
            
            redirect($CFG->wwwroot.'/blocks/scholarship/user/view.php?yearid='.$yearid);
        }
         echo get_string('selectyear','block_scholarship').'<br>';
         echo '<form name="yearform" action="" method="get">';
         echo '<input type="hidden" name="submitted" value="yes">';
         echo '<select name="yearid">';
         echo '<option value="1" selected>'.get_string('firstyear','block_scholarship');
         echo '<option value="2">'.get_string('secondyear','block_scholarship');
         echo '</select><br>';
         echo '<input type="submit" value="'.get_string('save','block_scholarship').'">';
         echo '</form>';
      }
?>
