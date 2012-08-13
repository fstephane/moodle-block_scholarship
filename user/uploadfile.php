<?php

require_once('../../../config.php');
require_login(1, true);

global $DB, $USER, $CFG, $PAGE;

$PAGE->requires->js('/blocks/scholarship/user/requestuser.js');

$array = Array();
 
$array = optional_param_array('doc', array(), PARAM_INT);
$sid = optional_param('sid', '0', PARAM_INT);

$fs = get_file_storage();
$name = $DB->get_record('user', array('id' => $USER->id));

$redo = false;

for($i = 0; $i < count($_FILES); $i++)
{
    if($_FILES['file'.($i + 1)]['name'] == '')
        $redo = true;
}

if(!$redo)
{
    for($i = 0; $i < count($_FILES); $i++)
    {
        // Prepare file record object
        $fileinfo = array(
            'contextid' => 1, // ID of context
            'component' => 'block_scholarship',     // usually = table name
            'filearea' => 'block_scholarship_doc_upload',     // usually = table name
            'itemid' => 1,               // usually = ID of row in table
            'filepath' => '/'.$sid.'scholarship'.$USER->id.'/',           // any path beginning and ending in /
            'filename' => $_FILES['file'.($i + 1)]['name'], // any filename
            'userid' => $USER->id,
            'author' => $name->firstname . ' ' . $name->lastname);
    
        $fs->create_file_from_pathname($fileinfo, $_FILES['file'.($i + 1)]['tmp_name']);
    
        $insert = new stdClass();
        $insert->docid = $array[$i];
        $insert->scholarshipid = $sid;
        $insert->userid = $USER->id;
        $insert->timemodified = time();
        $insert->filename = $_FILES['file'.($i + 1)]['name'];
        $insert->folder = '/'.$sid.'scholarship'.$USER->id.'/';
        $DB->insert_record('block_scholarship_doc_upload', $insert);
    }
    $DB->delete_records('block_scholarship_selected', array("userid" => $USER->id, "scholarshipid" => $sid));
    
    $scholarship = $DB->get_record('block_scholarship', array("id" => $sid));
        
    $record = new stdClass();
    $record->firstname = $name->firstname;
    $record->lastname = $name->lastname;
    $record->userid = $USER->id;
    $record->scholarshipid = $sid;
    $record->scholarshipname = $scholarship->name;
    $record->scholarshiptype = $scholarship->scholarshiptype;
    $record->opendate = $scholarship->opendate;
    $record->enddate = $scholarship->enddate;
    $record->mail = 0;
    $record->received = 0;
    $DB->insert_record('block_scholarship_users', $record);
    
        $DB->delete_records('files', array("component" => 'block_scholarship', "filename" => '.'));
}
echo '<div style="margin:200px 200px;">';
echo '<p>'.get_string('scholarshipapplied', 'block_scholarship'). ' <b>' . $scholarship->name.'</b></p><br/><br/>';
echo '<p>'.get_string('redirect', 'block_scholarship').'<a href="'.$CFG->wwwroot.'/blocks/scholarship/user/userview.php?userid='.$USER->id.'">'.get_string('click', 'block_scholarship').'</a></p>';
echo '</div>';
?>
