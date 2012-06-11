<?php

    require_once('../../../config.php');
    require_once('../lib.php');	
    require_once('../Local_page.php');
    require_login(1, true);
    
    global $CFG, $PAGE, $OUTPUT, $DB, $USER;
    $PAGE->requires->js('/blocks/scholarship/lib/datepickercontrol.js');
    $PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
    $PAGE->requires->css('/blocks/scholarship/style.css');
    $PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/edit.php');

    
    $localpage = new Local_page('edit.php', array(), get_string('pluginname', 'block_scholarship'));
    //function write_view()
    //{
global $CFG, $PAGE, $OUTPUT, $DB, $USER;
    //Navigation menu array
        $navlinks = array(
            array(
                'name'=>get_string('management', 'block_scholarship'),
                'link'=>$CFG->wwwroot.'/blocks/scholarship/admin/manage.php',
                'type'=>'misc'
                ),
            array(
                'name'=>get_string('editscholarship', 'block_scholarship'),
                'link'=>'',
                'type'=>'misc'
                )
         );

        //Build mavigation menu
        $nav = build_navigation($navlinks);
    //Print page header
    print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'),$nav);
    //}
    //
        //context needed for access rights
	$context = get_context_instance(CONTEXT_USER, $USER->id);

	//Check to see if user has access rights.
	if (!has_capability('block/scholarship:manage',$context)) {
		print_string('norights','block_scholarship');
		} else {
        $submitted = 'no';
        $delete = 'no';
        $deleconfirm = '0';
        //Parameters (data gathered from submitted form)
        $id = required_param('id', PARAM_INT);
        $submitted = optional_param('submitted', 0, PARAM_TEXT);
        $name = optional_param('name', 0, PARAM_TEXT);
        $description = optional_param('description', 0, PARAM_TEXT);
        $opendate = optional_param('opendate', 0, PARAM_TEXT);
        $enddate = optional_param('enddate', 0, PARAM_TEXT);
        $amount = optional_param('amount', 0, PARAM_TEXT);
        $multiple = optional_param('multiple', 0, PARAM_INT);
        $scholarshiptypeid = optional_param('scholarshiptype', 0, PARAM_INT);
        $delete = optional_param('delete', 0, PARAM_TEXT);
        $deleconfirm = optional_param('confirm', 0, PARAM_TEXT);
        //convert unix timestamp to string date
        //$opendatestr = date("Y-m-d",$opendate);
        //$enddatestr = date("Y-m-d",$enddate);
        
        //delete record confirmation message
        if ($delete === 'yes') {
            $message = get_string('deletemessage','block_scholarship');
            $linkyes = $CFG->wwwroot.'/blocks/scholarship/admin/edit.php?id='.$id.'&confirm=1';            
            $linkno = $CFG->wwwroot.'/blocks/scholarship/admin/manage.php';
            echo $OUTPUT->confirm($message, $linkyes, $linkno);
        }
        
        //Actually delete the record
        if ($deleconfirm === '1') {
            delete_record_scholarship($id);
            redirect('manage.php');
        }

	//If form is submitted
        if ($submitted === 'yes'){

        update_record_scholarship($id,$name,$description,$opendate,$enddate,$amount,$scholarshiptypeid,$multiple);
        redirect('manage.php');
        } 
        elseif ($delete !== 'yes') {
            print_edit_scholarship_form($id);
	echo $localpage->generate_footer_html();
        }
}
echo $OUTPUT->footer();

?>