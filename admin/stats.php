<?php

    require_once('../../../config.php');
    require_once('../Local_page.php');
    require_login(1, true);
    
    $PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/stats.php');

	echo '<link rel="stylesheet" type="text/css" href="../style.php">';
	
	$nav = build_navigation(get_string('management','block_scholarship'));
	print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'),$nav);
	global $USER, $COURSE, $DB;
	
	//include('../header.html');
	//context needed for access rights
	$context = get_context_instance(CONTEXT_USER, $USER->id);

	//Check to see if user has access rights.
	if (!has_capability('block/scholarship:manage',$context)) {
		print_string('norights','block_scholarship');
		} else {      
	
$scholarships = $DB->get_records('block_scholarship');
       // print_object($scholarships);
            echo '<table width="75%">';
            echo '<tr>';
            echo '<td>';
            echo '<b>Bourse</b>';
            echo '</td>';
            echo '<td>';
            echo '<b>Nombre d\'applicant</b>';
            echo '</td>';
            echo '</tr>';
        foreach($scholarships as $scholarship){
            $numscholarship = $DB->count_records_select('block_scholarship_selected', 'scholarshipid ='.$scholarship->id, null, 'scholarshipid');
            echo '<tr>';
            echo '<td>';
            echo $scholarship->name;
            echo '</td>';
            echo '<td>';
            echo $numscholarship;
            echo '</td>';
            echo '</tr>';         
        }
        echo '</table>';
}
	
 echo $OUTPUT->footer();

?>