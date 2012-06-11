<?php

    require_once('../../../config.php');
    require_once('../Local_page.php');
    require_login(1, true);

    $PAGE->requires->css('/blocks/scholarship/style.css');
    $PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/email.php');
    
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
	
    //get scholarships from table	
    $userstoemail = $DB->get_records_sql('SELECT mdl_user.*
FROM mdl_block_scholarship_selected INNER JOIN mdl_user ON mdl_block_scholarship_selected.userid = mdl_user.id
GROUP BY mdl_block_scholarship_selected.userid, mdl_user.id;');

    //print_object($userstoemail);
$body = '<p>Chers étudiants et étudiantes,</p>

<p>Ceci est un rappel que la date limite pour soumettre et <b><u><font color="red">compléter</font></u></b> une demande de bourses est le 14 mai, 2010 à minuit.</p>

<p><b><font color="red">Veuillez s\'il vous plaît vous assurer que vous avez bien soumis que ce soit directement en ligne ; par voie postale ou en personne les documents requis (Relevé de notes, lettres de présentation ; lettres de recommandation ; Budgets etc..) pour toutes les bourses auxquelles vous avez soumis une demande et qui requièrent ces documents.</font></b></p>

<p>Faute d\'accomplir cela, votre demande ne sera pas considérée !<p>

<p>--------------------------------------------------------<br>
Julie Carbonneau<br>
Conseiller académique/Academic Student Advisor<br>
Campus Saint-Jean - University of Alberta<br>
Tel:  780-465-8602<br>
Fax: 780-465-8760<br>
www.csj.ualberta.ca<br>
--------------------------------------------------------</p>';

$sender = $DB->get_record('user',array("id" => '5799')); //Julie Carbonneau
foreach ($userstoemail as  $email) {

          if (!email_to_user($email,$sender,'Bourse: Rappelle IMPORTANT','',$body)){
            echo 'Courriel na pas été envoyé pour: '.$email->firstname.' '.$email->lastname.' numéro id Moodle: '.$email->id;
            }

	
	}
}
	
 echo $OUTPUT->footer();

?>