<?php
require_once('../../../config.php');
require_once('../lib.php');
require_login(1, true);

global $CFG, $USER, $COURSE, $OUTPUT, $DB;
$PAGE->requires->js('/blocks/scholarship/lib/scholarship.js');
$PAGE->requires->css('/blocks/scholarship/admin/style.css');
$PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
$PAGE->set_url($CFG->wwwroot.'/blocks/scholarships/user/view.php');

$navlinks = array(
            
            array(
                'name'=>get_string('availablescholarships', 'block_scholarship'),
                'link'=>'',
                'type'=>'misc'
                )

         );

$nav = build_navigation($navlinks);
print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'),$nav);

//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

//Check to see if user has access rights.
if (!has_capability('block/scholarship:user',$context)) {
	print_string('norights','block_scholarship','',0);
  } else {
      
    $id = optional_param('id', 0, PARAM_INT);
    $scholarshipid = optional_param('scholarshipid', 0, PARAM_INT);
    $userid = optional_param('userid', 0, PARAM_INT);
    $submitted = optional_param('submitted', 0, PARAM_TEXT);
    $delete = optional_param('delete', 0, PARAM_INT);
    $confirmdelete = optional_param('confirm', 0, PARAM_INT);
    $selectedid = optional_param('selectedid', 0, PARAM_INT);
    $yearid = optional_param('yearid', 0, PARAM_INT);
    
    if ($submitted === 'yes'){
       
        insert_record_selected($scholarshipid,$userid);
        redirect('view.php?yearid='.$yearid);
    }

    if ($confirmdelete === 1){
        delete_record_selected($selectedid,$id);
        redirect('view.php?yearid='.$yearid);//NOT WORKING
    }

    if ($delete === 1){
            $message = get_string('deletemessage','block_scholarship');
            $linkyes = $CFG->wwwroot.'/blocks/scholarship/user/view.php?id='.$id.'&selectedid='.$selectedid.'&confirm=1';
            $linkno = $CFG->wwwroot.'/blocks/scholarship/user/view.php?id='.$id;
            echo $OUTPUT->confirm($message, $linkyes, $linkno);

     } else {
      print_available_scholarships($id, $yearid);
     }
}
 $OUTPUT->footer();
?>
