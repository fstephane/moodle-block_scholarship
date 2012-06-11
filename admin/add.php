<?php

    require_once('../../../config.php');
    require_once('../lib.php');
    require_once('../Local_page.php');
    require_login(1, true);
	
    global $CFG, $PAGE, $OUTPUT, $DB, $USER;
    $PAGE->requires->js('/blocks/scholarship/lib/datepickercontrol.js');
    $PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
    $PAGE->requires->css('/blocks/scholarship/admin/style.css');
    $PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/add.php');
    
    $courses = $DB->get_records('block_scholarship_courselist');
    
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
    $submitted = 'no';
    //Optional parameters
    $submitted = optional_param('submitted', 0, PARAM_TEXT);
    $name = optional_param('name', 0, PARAM_TEXT);
    $description = optional_param('description', 0, PARAM_TEXT);
    $opendate = optional_param('opendate', 0, PARAM_TEXT);
    $enddate = optional_param('enddate', 0, PARAM_TEXT);
    $amount = optional_param('amount', 0, PARAM_TEXT);
    $multiple = optional_param('multiple', 0, PARAM_INT);
    $scholarshiptypeid = optional_param('scholarshiptype', 0, PARAM_INT);


    //If form has already been submitted, don't display the player again
    if($submitted === 'yes'){
    $newid = insert_record_scholarship($name,$description,$opendate,$enddate,$amount,$scholarshiptypeid,$multiple);
    redirect('edit.php?id='.$newid.'&submitted=yes');
    } else {
    print_add_scholarship_form();
    }
}
	
 echo $OUTPUT->footer();

?>