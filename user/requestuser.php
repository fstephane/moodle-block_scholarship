<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
**************************************************************************
**                              Plugin Name                             **
**************************************************************************
* @package     block                                                    **
* @subpackage  Scholarship                                              **
* @name        Scholarship                                              **
* @copyright   oohoo.biz                                                **
* @link        http://oohoo.biz                                         **
* @author      Stephane                                                 **
* @author      Fagnan                                                   **
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
**************************************************************************
**************************************************************************/


require_once('../../../config.php');
require_once('../../../lib/form/filepicker.php');
require_login(1, true);

global $DB, $CFG, $PAGE;

$list = optional_param('list', '-1', PARAM_INT);        //Lists scholarships by program
$info = optional_param('info', '0', PARAM_INT);         //Shows scholarship info
$year = optional_param('year', '0', PARAM_INT);         //indicates year of study
$mylist = optional_param('mylist', '0', PARAM_INT);     //Builds list of selected scholarships
$userid = optional_param('userid', '0', PARAM_INT);     //indicates userid
$delete = optional_param('delete', '0', PARAM_INT);     //Removing scholarships from selected list
$docs = optional_param('docs', '0', PARAM_INT);         //Shows documents to be completed in order to apply
$upload = optional_param('upload', '0', PARAM_INT);     //Renders form to upload documents
$check = optional_param('check', '0', PARAM_INT);       //Checks to see if user has already applied for this scholarship
$mail = optional_param('mail', '0', PARAM_INT);         //Generates list of required documents for mailing
$send = optional_param('send', '0', PARAM_INT);         //Confirms that a student will mail or hand in their documents
$sid = optional_param('sid', '0', PARAM_INT);           //Scholarship id

//Confirms that a student will mail or hand in their documents
if($send !== '0')
{
    $name = $DB->get_record("user", array("id" => $send));
    $scid = $DB->get_record('block_scholarship', array("id" => $sid));
    $record = new stdClass();
    $record->firstname = $name->firstname;
    $record->lastname = $name->lastname;
    $record->scholarshipname = $scid->name;
    $record->scholarshipid = $scid->id;
    $record->scholarshiptype = $scid->scholarshiptype;
    $record->opendate = $scid->opendate;
    $record->enddate = $scid->enddate;
    $record->scholarshipname = $scid->name;
    $record->userid = $send;
    $record->mail = 1;
    $record->received = 0;
    
    $DB->insert_record('block_scholarship_users', $record);
    $DB->delete_records('block_scholarship_selected', array("userid" => $send, "scholarshipid" => $sid));
}

//Generates list of required documents for mailing
if($mail !== '0')
{
    $doclist = $DB->get_records_sql('SELECT doc.name, doc.description
                                    FROM mdl_block_scholarship_document AS doc
                                    JOIN mdl_block_scholarship_doc AS ds ON doc.id=ds.documentid
                                    WHERE ds.scholarshipid='.$mail);
    echo '<br/><hr/><br/><p style="font-weight:normal;">-'.get_string('unofficial', 'block_scholarship').'</p>';
    
    foreach($doclist as $d)
    {
        echo '<p style="font-weight:normal;">-'.$d->name.'</p>';
    }
    echo '<hr/><br/>';
    echo '<input type="button" class="newadd" onclick="mail_send('.$USER->id.')" style="margin-left:-10px;margin-bottom:10px;width:282px;font-size:12px;" value="' . get_string('mailsend', 'block_scholarship') . '" />';
    echo '<input type="button" class="newbutton" onclick="back_to_docs()" style="margin-left:-10px;width:282px;font-size:14px;" value="'.get_string('backtodocs', 'block_scholarship').'" />';
}

//Checks to see if user has already applied for this scholarship
if($check !== '0')
{
    if(!$DB->get_record('block_scholarship_users', array("userid" => $USER->id, "scholarshipid" => $check)))
        echo 'Good';
    else
        echo get_string('alreadyapplied', 'block_scholarship');
}


//Renders form to upload documents
if($upload !== '0')
{
    echo '<br/><hr/><br/><form name="application" action="uploadfile.php" method="POST" enctype="multipart/form-data">';
    echo '<label for="file">Unofficial Transcript / High School Diploma:</label><br/><br/>';
    echo '<input type="hidden" name="doc[]" value="0"/>';
    echo '<input type="hidden" name="sid" value="'.$upload.'"/>';
    echo '<input type="file" class="extension" name="file1" id="file" style="border:1px black solid;width:250px;"/><br /><br/>';
    
    $dlist = $DB->get_records_sql('SELECT doc.id, doc.name, doc.description
                                    FROM mdl_block_scholarship_document AS doc
                                    JOIN mdl_block_scholarship_doc AS ds ON doc.id=ds.documentid
                                    WHERE ds.scholarshipid='.$upload);
    $incr = 2;
    foreach($dlist as $d)
    {
        echo '<hr/><br/><form action="upload_file.php" method="post" enctype="multipart/form-data">';
        echo '<label for="file">'.$d->name.':</label><br/><br/>';
        echo '<input type="file" class="extension" name="file'.$incr.'" id="file" style="border:1px black solid;width:250px;"/><br /><br/>';
        echo '<input type="hidden" name="doc[]" value="'.$d->id.'" />';
        $incr++;
    }
    echo '<hr/><br/>';
    echo '<input type="button" id="applysubmit" onclick="apply()" class="newadd2"  style="margin-left:-10px;margin-bottom:10px;width:282px;background-color:darkcyan;" value="'.get_string('applyforscholarship', 'block_scholarship').'" />';
    echo '<input type="button" class="newbutton" onclick="back_to_docs()" style="margin-left:-10px;margin-bottom:10px;width:282px;font-size:14px;" value="'.get_string('backtodocs', 'block_scholarship').'" />';
    echo '</form>';
}


//Shows documents to be completed in order to apply
if($docs !== '0')
{
    $doclist = $DB->get_records_sql('SELECT doc.name, doc.description
                                    FROM mdl_block_scholarship_document AS doc
                                    JOIN mdl_block_scholarship_doc AS ds ON doc.id=ds.documentid
                                    WHERE ds.scholarshipid='.$docs);
    echo '<hr /><br/>';
    echo '<p id="scholid" class="'.$docs.'">'.get_string('document', 'block_scholarship').':</p>';
    echo '<p style="font-weight:normal;">'.get_string('unofficial', 'block_scholarship').'</p>';
    
    foreach($doclist as $d)
    {
        echo '<hr /><br/>';
        echo '<p>'.get_string('document', 'block_scholarship').':</p>';
        echo '<p style="font-weight:normal;">'.$d->name.'</p>';
        echo '<p>'.get_string('description', 'block_scholarship').':</p>';
        echo '<p style="font-weight:normal;">'.$d->description.'</p><br/>';
    }
}


//Lists scholarships by program
if($list !== '-1')
{
    if($year != 3)
    {
        if($list == '0')
        {
            echo '<p style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">'.get_string('allcourses', 'block_scholarship').':</p>';
            $slist = $DB->get_records_sql('SELECT * FROM mdl_block_scholarship
                                            WHERE scholarshiptype IN ('.$year.', 3)
                                            ORDER BY name');
            foreach($slist as $s)
            {
                if((time() > $s->opendate) && (time() < $s->enddate))
                    echo '<a class="list" onclick="show_info($(this))" href="#" value="'.$s->id.'">- '.$s->name.'</a>';
            }
        }
        else
        {
            $coname = $DB->get_record('block_scholarship_courselist', array("id" => $list));
            echo '<p id="coursename" style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">'.$coname->coursename.':</p>';
            $slist = $DB->get_records_sql('SELECT DISTINCT scholarship.name, scholarship.id, scholarship.opendate, scholarship.enddate 
                                           FROM mdl_block_scholarship as scholarship
                                           JOIN mdl_block_scholarship_courses as courses ON scholarship.id=courses.scholarshipid
                                           WHERE courses.courseid IN ('.$list.', 0) AND courses.yearid IN ('.$year.', 3) 
                                           ORDER BY scholarship.name');
            foreach($slist as $s)
            {
                if((time() > $s->opendate) && (time() < $s->enddate))
                    echo '<a class="list" onclick="show_info($(this))" href="#" value="'.$s->id.'">- '.$s->name.'</a>';
            }
        }
    }
    else
    {
        if($list == '0')
        {
            echo '<p style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">'.get_string('allcourses', 'block_scholarship').':</p>';
            $slist = $DB->get_records('block_scholarship', array(), 'name');
            foreach($slist as $s)
            {
                echo '<a class="list" onclick="show_info($(this))" href="#" value="'.$s->id.'">- '.$s->name.'</a>';
            }
        }
        else
        {
            $coname = $DB->get_record('block_scholarship_courselist', array("id" => $list));
            echo '<p id="coursename" style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">'.$coname->coursename.':</p>';
            $slist = $DB->get_records_sql('SELECT DISTINCT scholarship.name, scholarship.id 
                                           FROM mdl_block_scholarship as scholarship
                                           JOIN mdl_block_scholarship_courses as courses ON scholarship.id=courses.scholarshipid
                                           WHERE courses.courseid IN ('.$list.', 0)
                                           ORDER BY scholarship.name');
            foreach($slist as $s)
            {
                echo '<a class="list" onclick="show_info($(this))" href="#" value="'.$s->id.'">- '.$s->name.'</a>';
            }
        }
    }
}


//Shows scholarship info
if($info !== '0')
{
    $sinfo = $DB->get_record('block_scholarship', array("id" => $info));
    
    echo '<input type="button" class="newadd" onclick="add_to_list('.$info.')" style="margin-left:-15px;margin-bottom:30px;width:282px;" value="'.get_string('addtolist', 'block_scholarship').'" /><br/>';
    echo '<b style="color:black;">'.get_string('name', 'block_scholarship').':</b><br/>';
    echo '<p id="'.$sinfo->id.'" name="scholname" style="font-weight:normal;color:black;">'.$sinfo->name.'</p><br/>';
    echo '<b style="color:black;">'.get_string('amount', 'block_scholarship').':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">'.$sinfo->amount.'</p><br/>';
    echo '<b style="color:black;">'.get_string('value', 'block_scholarship').':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">'.$sinfo->value.'</p><br/>';
    echo '<b style="color:black;">'.get_string('activefrom', 'block_scholarship').':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">'.date("F j, Y" , $sinfo->opendate).' - '.date("F j, Y" , $sinfo->enddate).'</p><br/>';
    echo '<b style="color:black;">'.get_string('type', 'block_scholarship').':</b><br/>';
    switch($sinfo->scholarshiptype)
    {
        case 1:
            echo '<p style="font-weight:normal;color:black;">'.get_string('firstyear', 'block_scholarship').'</p><br/>';
            break;
        case 2:
            echo '<p style="font-weight:normal;color:black;">'.get_string('secondyear', 'block_scholarship').'</p><br/>';
            break;
        case 3:
            echo '<p style="font-weight:normal;color:black;">'.get_string('all', 'block_scholarship').'</p><br/>';
            break;
    }
    echo '<b style="color:black;">'.get_string('description', 'block_scholarship').':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">'.$sinfo->description.'</p><br/>';
}


//Builds list of selected scholarships
if($mylist !== '0')
{
    if(!is_object($DB->get_record('block_scholarship_selected', array("scholarshipid" => $mylist, "userid" => $userid))))
    {
        $record = new stdClass();
        $record->scholarshipid = $mylist;
        $record->userid = $userid;
        $record->timemodified = time();

        $DB->insert_record('block_scholarship_selected', $record);

        $selected = $DB->get_records_sql('SELECT schol.name, selected.*
                                        FROM mdl_block_scholarship as schol
                                        JOIN mdl_block_scholarship_selected as selected ON schol.id=selected.scholarshipid
                                        WHERE selected.userid='.$userid.'
                                        ORDER BY schol.name');
        foreach($selected as $s)
            echo '<pre style="font-family:courier;width:250px;">-'.$s->name.'<a title="'.get_string('removefromlist', 'block_scholarship').'" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected('.$s->scholarshipid.')"><img src="delete.gif" /></a><a href"#" onclick="apply_docs('.$s->scholarshipid.')" style="background-color:transparent;border:none;padding:0px;margin:0px;color:blue;float:up;font-size:14px;cursor:pointer;width:30px;height:20px;margin-left:20px;">'.get_string('applyforscholarship', 'block_scholarship').'</a></pre><br/>';
    }
    else
    {
    $selected = $DB->get_records_sql('SELECT schol.name, selected.*
                                        FROM mdl_block_scholarship as schol
                                        JOIN mdl_block_scholarship_selected as selected ON schol.id=selected.scholarshipid
                                        WHERE selected.userid='.$userid.'
                                        ORDER BY schol.name');
        foreach($selected as $s)
            echo '<pre style="font-family:courier;width:250px;">-'.$s->name.'<a title="'.get_string('removefromlist', 'block_scholarship').'" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected('.$s->scholarshipid.')"><img src="delete.gif" /></a><a href"#" onclick="apply_docs('.$s->scholarshipid.')" style="background-color:transparent;border:none;padding:0px;margin:0px;color:blue;float:up;font-size:14px;cursor:pointer;width:30px;height:20px;margin-left:20px;">'.get_string('applyforscholarship', 'block_scholarship').'</a></pre><br/>';
        }
}


//Removing scholarships from selected list
if($delete !== '0')
{
    $DB->delete_records('block_scholarship_selected', array("scholarshipid" => $delete, "userid" => $userid));
    
    $selected = $DB->get_records_sql('SELECT schol.name, selected.*
                                        FROM mdl_block_scholarship as schol
                                        JOIN mdl_block_scholarship_selected as selected ON schol.id=selected.scholarshipid
                                        WHERE selected.userid='.$userid.'
                                        ORDER BY schol.name');
    foreach($selected as $s)
        echo '<pre style="font-family:courier;width:250px;">-'.$s->name.'<a title="'.get_string('removefromlist', 'block_scholarship').'" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected('.$s->scholarshipid.')"><img src="delete.gif" /></a><a href"#" onclick="apply_docs('.$s->scholarshipid.')" style="background-color:transparent;border:none;padding:0px;margin:0px;color:blue;float:up;font-size:14px;cursor:pointer;width:30px;height:20px;margin-left:20px;">'.get_string('applyforscholarship', 'block_scholarship').'</a></pre><br/>';
}
?>
