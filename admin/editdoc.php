<?php

require_once('../../../config.php');
require_once('../lib.php');
require_login(1, true);
	
global $CFG, $PAGE, $OUTPUT, $DB, $USER;
$PAGE->requires->js('/blocks/scholarship/lib/datepickercontrol.js');
$PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
$PAGE->requires->css('/blocks/scholarshipt/style.css');
//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

//Check to see if user has access rights.
if (!has_capability('block/scholarship:manage',$context)) {
    print_string('norights','block_scholarship');
} else {

        //Optional parameters
        $id = required_param('id', PARAM_INT);
        $scholarshipid = optional_param('scholarshipid', 0, PARAM_INT);
        $name = optional_param('name', 0, PARAM_TEXT);
        $description = optional_param('description', 0, PARAM_TEXT);
        $submitted = optional_param('submitted', 0, PARAM_TEXT);
        $delete = optional_param('delete', 0, PARAM_INT);
        $deleconfirm = optional_param('confirm', 0, PARAM_TEXT);

        //get document
        $document = $DB->get_record('scholarship_document','id',$id);

	$navlinks = array(
            array(
                'name'=>get_string('management', 'block_scholarship'),
                'link'=>$CFG->wwwroot.'/blocks/scholarship/admin/manage.php',
                'type'=>'misc'
                ),
            array(
                'name'=>get_string('editscholarship', 'block_scholarship'),
                'link'=>$CFG->wwwroot.'/blocks/scholarship/admin/edit.php?id='.$scholarshipid,
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

//Actually delete the record
  if ($deleconfirm == '1') {
      delete_record_document_scholarship($id,$scholarshipid);
     }

 //If delete is selected
 //the id used is the id inside the shcolarship_doc table NOT scholarship_document
  if ($delete == 'yes') {
     $message = get_string('deletemessage','block_scholarship');
     $linkyes = $CFG->wwwroot.'/blocks/scholarship/admin/editdoc.php?id='.$id.'&confirm=1&scholarshipid='.$scholarshipid;
     $linkno = $CFG->wwwroot.'/blocks/scholarship/admin/edit.php?id='.$scholarshipid;
     notice_yesno($message, $linkyes, $linkno);
    } else {

      if($submitted == 'yes'){
         update_record_document ($id,$name,$description,$scholarshipid);
        } else {
 
	print_content_header();
        print_edit_document_form($id,$scholarshipid);
        print_content_footer();
			
        } 
    }

}
	
 echo $OUTPUT->footer();

?>