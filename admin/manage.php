<?php

    require_once('../../../config.php');
    require_once('../Local_page.php');
    require_login(1, true);
    global $USER, $COURSE, $DB, $localpage;
    
    $PAGE->set_url($CFG->wwwroot.'/blocks/scholarship/admin/manage.php');
    $PAGE->requires->css('/blocks/scholarship/admin/styles.css');
    
    $localpage = new Local_page('manage.php', array(), get_string('pluginname', 'block_scholarship'));
    echo $localpage->generate_header_html();

	
	$nav = build_navigation(get_string('management','block_scholarship'));
	
	//include('../header.html');
	//context needed for access rights
	$context = get_context_instance(CONTEXT_USER, $USER->id);

	//Check to see if user has access rights.
	if (!has_capability('block/scholarship:manage',$context)) {
		print_string('norights','block_scholarship');
		} else {      
	
        //get scholarships from table
        $shcolarships = $DB->get_records_sql("SELECT * FROM mdl_block_scholarship WHERE deleted=0");

	echo '<div class="cornerBox">'."\n";
	echo '<div class="corner TL"></div>'."\n";
	echo '<div class="corner TR"></div>'."\n";
	echo '<div class="corner BL"></div>'."\n";
	echo '<div class="corner BR"></div>'."\n";
	echo '	<div class="cornerBoxInner">'."\n";
	
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">'."\n";
	echo '<tbody>'."\n";
	echo '	<tr>'."\n";
	echo '		  <td>'.get_string('name','block_scholarship').'</td>'."\n";
	echo '		  <td>'.get_string('amount','block_scholarship').'</td>'."\n";
	echo '		  <td>'.get_string('opendate','block_scholarship').'</td>'."\n";
	echo '		  <td>'.get_string('closingdate','block_scholarship').'</td>'."\n";
	echo '		  <td></td>'."\n";
	echo '	</tr>'."\n";
	
	//used to change row colors
	$i = 1;
	foreach ($shcolarships as  $scholarship) {
	
	 if ($i % 2) {
		$bgcolor = ' bgcolor = "#E9E9E9" ';	
	  } else {
		$bgcolor = '';
	  }
	echo '	<tr'.$bgcolor.'>'."\n";
	echo '	  <td><a href="edit.php?id='.$scholarship->id.'">'.$scholarship->name.'</a></td>'."\n";
	echo '	  <td>'.$scholarship->amount.'</td>'."\n";
	echo '	  <td>'.date('Y-m-d',$scholarship->opendate).'</td>'."\n";
	echo '	  <td>'.date('Y-m-d',$scholarship->enddate).'</td>'."\n";
	echo '	  <td><a href="edit.php?id='.$scholarship->id.'&delete=yes">'.get_string('delete','block_scholarship').'</a></td>'."\n";
	echo '	</tr>'."\n";
	$i++;
	}
	echo '	<tr>'."\n";
	echo '	  <td></td>'."\n";
	echo '	  <td></td>'."\n";
	echo '	  <td></td>'."\n";
	echo '	  <td><br><input type="button" name="addscholarship" value="'.get_string('addscholarship','block_scholarship').'" onclick="window.location=\'add.php\'"></td>'."\n";
	echo '	  <td><input type="button" name="viewscholarships" value="'.get_string('viewuserscholarships','block_scholarship').'" onclick="window.location=\'view.php?id=0\'"></td>'."\n";
	echo '	</tr>'."\n";
	echo '  </tbody>'."\n";
	echo '</table>'."\n";
	echo '</div>'."\n";
		
	echo '	</div>'."\n";
	echo '</div>'."\n";
	}
    echo $OUTPUT->footer();
?>