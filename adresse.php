<?php
require_once('../../config.php');
require_once('lib.php');
require_once('Local_page_1.php');
require_login(1, true);

global $CFG, $USER, $COURSE, $OUTPUT, $DB;
$PAGE->requires->js('/blocks/scholarship/lib/scholarship.js');
$PAGE->requires->css('/blocks/scholarship/style.css');
$PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/adresse.php');

print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'));

//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

//Check to see if user has access rights.
if (!has_capability('block/scholarship:user',$context)) {
	print_string('norights','block_scholarship','',0);
  } else {

 echo '
<h2>Pour envoyer vos documents par la poste, voici l\'adresse:</h2>
Bureau des admissions<br>
2-02, pavillon McMahon<br>
8406, rue Marie-Anne-Gaboury (91 St)<br>
Edmonton, AB T6C 4G9.<br>
<h2>Pour déposer en personne vos documents:</h2>
Bureau des affaires étudiantes - Local 2-21 ';

}
 echo $OUTPUT->footer();
?>