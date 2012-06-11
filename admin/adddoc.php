<?php

require_once('../../../config.php');
require_once('../lib.php');
require_once('../Local_page.php');
require_login(1, true);
	
global $CFG, $PAGE, $OUTPUT, $DB, $USER;
$PAGE->requires->js('/blocks/scholarship/lib/datepickercontrol.js');
$PAGE->requires->css('/blocks/scholarship/style.css');
$PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
$PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/adddoc.php');

//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

//Check to see if user has access rights.
if (!has_capability('block/scholarship:manage',$context)) {
    print_string('norights','block_scholarship');
} else {

     //Optional parameters
     $id = required_param('id', PARAM_INT); //scholarship id
     $name = optional_param('name', 0, PARAM_TEXT);
     $description = optional_param('description', 0, PARAM_TEXT);
     $submitted = optional_param('submitted', 0, PARAM_TEXT);
     $existingdoc = optional_param('existingdoc', 0, PARAM_INT);

       $navlinks = array(
            array(
                'name'=>get_string('management', 'block_scholarship'),
                'link'=>$CFG->wwwroot.'/blocks/scholarship/admin/manage.php',
                'type'=>'misc'
                ),
            array(
                'name'=>get_string('editscholarship', 'block_scholarship'),
                'link'=>$CFG->wwwroot.'/blocks/scholarship/admin/edit.php?id='.$id,
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
	
           if($submitted == 'yes'){

              insert_record_document($id,$existingdoc,$name,$description);

            } else {

              print_content_header();
              print_add_document_form($id);
              print_content_footer();

            }
}
	
 echo $OUTPUT->footer();

?>