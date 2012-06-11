<?php

    require_once('../../../config.php');
    require_once('../Local_page.php');
    require_login(1, true);

    $PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/details.php');
    $PAGE->requires->css('/blocks/scholarship/style.css');
    
	
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
        $zero = 0;
        echo '<br/><br/>';
        foreach($scholarships as $scholarship){
            $userinfosql = 'SELECT row_number() OVER (ORDER BY mdl_block_scholarship.id), mdl_user.*, mdl_block_scholarship_selected.id AS selectedid
                FROM (mdl_block_scholarship_selected INNER JOIN mdl_block_scholarship ON mdl_block_scholarship_selected.scholarshipid = mdl_block_scholarship.id)
                INNER JOIN mdl_user ON mdl_block_scholarship_selected.userid = mdl_user.id
                WHERE (mdl_block_scholarship.id)='.$scholarship->id.' AND mdl_block_scholarship.deleted='.$zero.'
                ORDER BY mdl_user.lastname';
            
        $userinfo = $DB->get_records_sql($userinfosql);
        echo '<table width="100%" border="1" style="margin-top:-42px;" >';
        echo '<tr>';
        echo ' <td colspan="4">';
        echo '<b><font size="4px">'.$scholarship->name.'</font></b>';
        echo ' </td>';

        echo '</tr>';
        echo '<tr>';
        echo ' <td>';
        echo '<b>Nom</b>';
        echo ' </td>';
        echo ' <td>';
        echo '<b>Courriel</b>';
        echo ' </td>';
        echo ' <td>';
        echo '<b>Numéro étudiant</b>';
        echo ' </td>';
        echo ' <td>';
        echo '<b>Documents</b>';
        echo ' </td>';
        echo '</tr>';
        //print student list for scholarship
            foreach ($userinfo as $user){
                echo '<tr>';
                echo ' <td>';
                echo $user->lastname.', '.$user->firstname;
                echo ' </td>';
                echo ' <td>';
                echo $user->email;
                echo ' </td>';
                echo ' <td>';
                echo $user->idnumber;
                echo ' </td>';
                //documents must be grabbed from scholarship_doc_upload table
                $documents = $DB->get_records('block_scholarship_doc_upload',array("selectedid" => $user->selectedid));
                echo ' <td>';
                    foreach($documents as $document){
                        $docname = $DB->get_record('block_scholarship_document', array("id" => $document->docid));
                        Echo $docname->name.': ';
                        if ($document->mail == 1){
                            echo 'Document envoyé par la poste<br>';
                        } else if(!empty($document->filename)) {
                            echo '<a href="'.$CFG->wwwroot.'/file.php/1/block_scholarship/'.$user->id.'/'.$document->folder.'/'.$document->filename.'" title="'.get_string('viewdocument','block_scholarship').'">'.$document->filename.'</a><br>';
                        } else {
                          echo 'Cette personne n\'a pas completé la demande.<br>';
                        }
                    }
                echo ' </td>';
                echo '</tr>';
            }
        echo '<tr>';
        echo '</tr>';
        echo '</table>';
        echo '<p>&nbsp;</p>';
        }

}
	
 echo $OUTPUT->footer();

?>