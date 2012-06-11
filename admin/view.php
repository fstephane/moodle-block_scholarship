<?php
 require_once('../../../config.php');
    require_once('../lib.php');
    require_once('../Local_page.php');
    require_login(1, true);
    
    
    global $CFG, $USER, $COURSE, $OUTPUT, $DB;
    $PAGE->requires->js('/blocks/scholarship/lib/datepickercontrol.js');
    $PAGE->requires->js('/blocks/scholarship/lib/scholarship.js');
    $PAGE->requires->css('/blocks/scholarship/admin/style.css');
    $PAGE->requires->css('/blocks/scholarship/datpickercontrol.css');
    $PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/view.php');
    $localpage = new Local_page('view.php', array(), get_string('pluginname', 'block_scholarship'));
    
	$navlinks = array(
            array(
                'name'=>get_string('management', 'block_scholarship'),
                'link'=>$CFG->wwwroot.'/blocks/scholarship/admin/manage.php',
                'type'=>'misc'
                ),
            array(
                'name'=>get_string('addscholarship', 'block_scholarship'),
                'link'=>'',
                'type'=>'misc'
                )
         );

        $nav = build_navigation($navlinks);
	print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'),$nav);

        //context needed for access rights
	$context = get_context_instance(CONTEXT_USER, $USER->id);

 	//Check to see if user has access rights.
if (!has_capability('block/scholarship:manage',$context)) {
    print_string('norights','block_scholarship');
 } else {
     $id = optional_param('id', 0, PARAM_INT);
     $userdocid = optional_param('userdocid', 0, PARAM_INT);
     $userid = optional_param('userid', 0, PARAM_INT);
     $received = optional_param('received', 0, PARAM_INT);
     $submitted = optional_param('submitted', 0, PARAM_TEXT);
     $submittedaward = optional_param('submittedaward', 0, PARAM_TEXT);
     $selectedid = optional_param('selected', 0, PARAM_INT);
     $awarded = optional_param('awarded', 0, PARAM_INT);
     $docid = optional_param('docid', 0, PARAM_INT);
     
     if ($submitted === 'yes') {
         update_record_user_document($docid,$userdocid,$received,$id,$userid);
     }

     if ($submittedaward === 'yes') {
         update_record_user_awarded($selectedid,$awarded,$id,$userid);
     }
 
     print_view_user_scholarships($id,$userid,$selectedid);//SERIOUS PROBLEMS WITH QUERY FUNCTIONS -- MAY NEED TO BE COMPLETELY REDONE
 }
 echo $OUTPUT->footer();
?>
