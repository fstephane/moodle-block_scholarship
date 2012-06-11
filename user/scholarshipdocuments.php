<?php
require_once('../../../config.php');
require_once('../lib.php');
require_login(1, true);

global $CFG, $USER, $COURSE, $OUTPUT, $DB;
$PAGE->requires->js('/blocks/scholarship/lib/scholarship.js');
echo '<link rel="stylesheet" type="text/css" href="../style.php">';

print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'));

//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

//Check to see if user has access rights.
if (!has_capability('block/scholarship:user',$context)) {
	print_string('norights','block_scholarship','',0);
  } else {

    $id = required_param('id',PARAM_INT);
    $doc = $DB->get_record('block_scholarship_document','id',$id);

    print_content_header();
      echo '<h1>'.$doc->name.'</h1><p>';
      echo $doc->description;
      //echo '<br><a href="#" onClick="closeWindow();">Fermer la fenêtre</a>';
      print_content_footer();

}
 print_footer();
?>
