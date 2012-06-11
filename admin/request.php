<?php
require_once('../../../config.php');

$PAGE->requires->css('/blocks/scholarship/datepickercontrol.css');
$PAGE->requires->js('/blocks/scholarship/lib/datepickercontrol.js');
$PAGE->requires->js('/blocks/scholarship/jquery.js');
$PAGE->requires->js('/blocks/scholarship/jquery.min.js');
$PAGE->requires->js('/blocks/scholarship/admin/request.js');

global $DB;

$coursename = optional_param('coursename', '0', PARAM_TEXT);
$name = optional_param('name', '0', PARAM_TEXT);
$amount = optional_param('amount', '0', PARAM_INT);
$value = optional_param('value', '0', PARAM_TEXT);
$mult = optional_param('mult', '0', PARAM_TEXT);
$open = optional_param('open', '0', PARAM_TEXT);
$close = optional_param('close', '0', PARAM_TEXT);
$type = optional_param('type', '0', PARAM_INT);
$desc = optional_param('desc', '0', PARAM_TEXT);
$courses = optional_param('courses', '-1', PARAM_TEXT);
$check = optional_param('check', '0', PARAM_TEXT);
$delete = optional_param('deletedcourses', '0', PARAM_TEXT);
$message = optional_param('deletemessage', '0', PARAM_TEXT);
$list = optional_param('list', '-1', PARAM_INT);
$info = optional_param('info', '0', PARAM_INT);
$edit = optional_param('edit', '0', PARAM_INT);
$year = optional_param('year', '0', PARAM_INT);
$change = optional_param('change', '0', PARAM_TEXT);
$sid = optional_param('id', '0', PARAM_INT);
$cc = optional_param('cc', '0', PARAM_INT);
$remove = optional_param('remove', '0', PARAM_INT);
$deleteall = optional_param('deleteall', '0', PARAM_TEXT);
$checked = optional_param('checked', '0', PARAM_TEXT);


if($deleteall !== '0')
{
    $DB->delete_records('block_scholarship', array());
    $DB->delete_records('block_scholarship_courses', array());
    $DB->delete_records('block_scholarship_doc_upload', array());
    $DB->delete_records('block_scholarship_selected', array());
    $DB->delete_records('block_scholarship_document', array());
    $DB->delete_records('block_scholarship_doc', array());
    $DB->delete_records('block_scholarship_users', array());
    if($checked !== '0')
    {
        $DB->delete_records('block_scholarship_courselist', array());
        echo '<br/><br/><br/><br/><br/><br/><p style="font-size:25px;">'.get_string('alldeletedcourses', 'block_scholarship').'</p>';
    }
    else
        echo '<br/><br/><br/><br/><br/><br/><p style="font-size:25px;">'.get_string('alldeleted', 'block_scholarship').'</p>';
}


if($remove !== '0')
{
    $scholname = $DB->get_record('block_scholarship', array("id" => $remove));
    
    echo get_string('scholarshiperased', 'block_scholarship');
    echo '<br/><br/>';
    echo '<pre style="color:white;margin-left:10px;margin-bottom:10px;">';
    echo '-'.$scholname->name;
    echo '</pre>';
    echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">'.get_string('refreshpage', 'block_scholarship').'</p>';
    echo '<input type="button" class="newbutton" onclick="delete_continue()" style="margin-left:-10px;margin-top:15px;width:283px;" value="'.get_string('continue', 'block_scholarship').'" /><br/><br/>';
    
    $DB->delete_records('block_scholarship', array("id" => $remove));
    $DB->delete_records('block_scholarship_courses', array("scholarshipid" => $remove));
}


if(($cc !== '0') && ($courses == '-1'))
{
    $checked = $DB->get_records('block_scholarship_courses', array("scholarshipid" => $cc));
    foreach($checked as $ch)
        echo $ch->courseid.',';
}


if(($cc !== '0') && ($courses !== '-1'))
{
    $getyear = $DB->get_record('block_scholarship', array("id" => $cc));
    $DB->delete_records('block_scholarship_courses', array("scholarshipid" => $cc));
    $record = new stdClass();
    if($courses == '0')
    {
        $record->scholarshipid = $cc;
        $record->yearid = $getyear->scholarshiptype;
        $record->courseid = 0;
        $DB->insert_record('block_scholarship_courses', $record);
        echo get_string('scholarshipadded', 'block_scholarship');
        echo '<br/><br/><pre>-'.get_string('allcourses', 'block_scholarship').'</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">'.get_string('refreshpage', 'block_scholarship').'</p>';
    }
    else
    {
        $arraycourse = explode(",", $courses, -1);
        foreach($arraycourse as $ac)
        {
            $record->scholarshipid = $cc;
            $record->yearid = $getyear->scholarshiptype;
            $record->courseid = $ac; 
            $DB->insert_record('block_scholarship_courses', $record);
        }
        echo get_string('scholarshipadded', 'block_scholarship');
        echo '<pre>';
        foreach($arraycourse as $ac)
        {
            $acname = $DB->get_record('block_scholarship_courselist', array("id" => $ac), 'coursename');
            echo "<br/>-".$acname->coursename;
        }
        echo '</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">'.get_string('refreshpage', 'block_scholarship').'</p>';
    }
}

if($coursename !== '0')
{
    $decode = urldecode($coursename);
    if($coursename == '')
    {
        echo get_string('errorempty', 'block_scholarship');
    }
    else if(is_object($DB->get_record('block_scholarship_courselist', array('coursename' => $decode))))
    {
        echo get_string('coursenametaken', 'block_scholarship');
    }
    else if(($coursename !== '0') && isset($decode))
    {
        $record = new stdClass();
        $record->coursename = $decode;
        $DB->insert_record('block_scholarship_courselist', $record);
        echo get_string('courseadded', 'block_scholarship');
    }
}


if($message !== '0')
{
    $dmessage = explode(",", $message, -1);
    
    foreach($dmessage as $m)
    {
        $dname = $DB->get_record('block_scholarship_courselist', array("id" => $m), 'coursename');
        echo "-".$dname->coursename."<br/>";
    }
}


if($delete !== '0')
{
    $deletearray = explode(",", $delete, -1);
    
    echo get_string('coursesdeleted', 'block_scholarship');
    echo '<br/><br/>';
    echo '<pre style="color:white;margin-left:10px;margin-bottom:10px;">';
    foreach($deletearray as $d)
    {
        $delname = $DB->get_record('block_scholarship_courselist', array("id" => $d), 'coursename');
        echo "-".$delname->coursename."<br/>";
    }
    echo '</pre>';
    echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">'.get_string('refreshpage', 'block_scholarship').'</p>';
    
    foreach($deletearray as $del)
        $DB->delete_records('block_scholarship_courselist', array("id" => $del));
    
    foreach($deletearray as $del)
        $DB->delete_records('block_scholarship_courses', array("courseid" => $del));
}


if($check !== '0')
{
    if(is_object($DB->get_record('block_scholarship', array('name' => $check))))
        echo get_string('nametaken', 'block_scholarship');
    else
        echo 'Good';
}


if($list !== '-1')
{
    echo '<div style="height:13px;"></div><b style="text-decoration:underline;font-size:25px;margin-left:15px;color:black;">'.get_string('pluginname', 'block_scholarship').'</b><br/><br/>';
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
                                           WHERE courses.courseid IN ('.$list.', 0) AND courses.yearid IN ('.$year.', 3) 
                                           ORDER BY scholarship.name');
            foreach($slist as $s)
            {
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


if($info !== '0')
{
    $sinfo = $DB->get_record('block_scholarship', array("id" => $info));
    
    if($sinfo->multiple == 1)
        $sinfo->multiple = 'yes';
    else
        $sinfo->multiple = 'no';
    echo '<input type="button" class="newbutton" onclick="edit_scholarship('.$year.')" style="margin-left:-15px;margin-top:15px;margin-bottom:10px;width:282px;" value="'.get_string('editscholarship', 'block_scholarship').'" /><br/><br/>';
    echo '<input type="button" class="newbutton" onclick="delete_scholarship()" style="margin-left:-15px;margin-top:5px;margin-bottom:10px;width:282px;" value="'.get_string('removescholarship', 'block_scholarship').'" /><br/><br/>';
    echo '<input type="button" class="newadd" onclick="change_courses()" style="font-size:13px;margin-left:-15px;margin-bottom:30px;width:282px;" value="'.get_string('changecourses', 'block_scholarship').'" /><br/>';
    echo '<b style="color:black;">'.get_string('name', 'block_scholarship').':</b><br/>';
    echo '<p id="'.$sinfo->id.'" name="scholname" style="font-weight:normal;color:black;">'.$sinfo->name.'</p><br/>';
    echo '<b style="color:black;">'.get_string('amount', 'block_scholarship').':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">'.$sinfo->amount.'</p><br/>';
    echo '<b style="color:black;">'.get_string('value', 'block_scholarship').':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">'.$sinfo->value.'</p><br/>';
    echo '<b style="color:black;">'.get_string('multiple', 'block_scholarship').'</b><br/>';
    echo '<p style="font-weight:normal;color:black;">'.$sinfo->multiple.'</p><br/>';
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


if($edit !== '0')
{
    $sedit = $DB->get_record('block_scholarship', array("id" => $edit));
    
    echo '<div style="padding-left:10px;padding-top:10px;color:black;">';
    echo '<div id="blink" style="background-color:dimgray;width:299px;height:45px;border:1px black solid;color:white;margin-left:-11px;margin-top:-11px;"><p id="instr2" class="'.get_string('fillevery', 'block_scholarship').'" style="padding:5px;">'.get_string('fillevery', 'block_scholarship').'</p></div><br/>';
    echo get_string('name', 'block_scholarship').':<br/><input type="text" id="scholarshipnameedit" value="'.$sedit->name.'" /><br/><br/>';
    echo get_string('amount', 'block_scholarship').':<br/><input type="text" id="scholarshipamountedit" style="width:60px;" value="'.$sedit->amount.'" /><br/><br/>';
    echo get_string('value', 'block_scholarship').':<br/><input type="text" id="scholarshipvalueedit" style="width:60px;" value="'.$sedit->value.'" /><br/><br/>';
    if($sedit->multiple == 0)
        echo '<input type="checkbox" id="scholarshipmultipleedit" /> '.get_string('multiple', 'block_scholarship').'<br/><br/>';
    else
        echo '<input type="checkbox" id="scholarshipmultipleedit" checked="checked" /> '.get_string('multiple', 'block_scholarship').'<br/><br/>';
    echo get_string('opendate','block_scholarship').'<br/>';
    echo '<input name="opendate" id="DPC_date1" class="openedit" size="14" type="text" value="'.date('Y-m-d', $sedit->opendate).'" datepicker_format="YYYY-MM-DD"><p>';
    echo get_string('closingdate','block_scholarship').'<br/>';
    echo '<input name="enddate" id="DPC_date2" class="endedit" size="14" type="text" value="'.date('Y-m-d', $sedit->enddate).'" datepicker_format="YYYY-MM-DD"><p>';
    $one = ''; $two = ''; $three = '';
    switch($sedit->scholarshiptype)
    {
        case 1:
            $one = 'selected';
            break;
        case 2:
            $two = 'selected';
            break;
        case 3:
            $three = 'selected';
            break;
    }
    echo get_string('type','block_scholarship');
    echo '<select id="scholarshiptypeedit" name="scholarshiptype" style="width:230px;">';
    echo '<option value="1" '.$one.'>'.get_string('firstyear','block_scholarship').'</option>';
    echo '<option value="2" '.$two.'>'.get_string('secondyear','block_scholarship').'</option>';
    echo '<option value="3" '.$three.'>'.get_string('all','block_scholarship').'</option>';
    echo '</select><br/><br/>';
    echo get_string('description', 'block_scholarship').':<br/><textarea rows="10" cols="33" id="scholarshipdescriptionedit">'.$sedit->description.'</textarea><br/><br/>';
    echo '<input type="button" id="changevalues" class="newadd" onclick="change_info('.$sedit->id.')" value="'.get_string('continue', 'block_scholarship').'" style="margin-left:-10px;width:299px;margin-top:-2px;" />';
    echo '</div>';
}


if(($name !== '0') && ($change == 'true'))
{
    $record = new stdClass();
    $ychange = $DB->get_record('block_scholarship', array("id" => $sid));
    if($ychange->scholarshiptype !== $type)
    {
        $clist = $DB->get_records('block_scholarship_courses', array("scholarshipid" => $sid));
        
        foreach($clist as $cl)
        {
            $record->scholarshipid = $sid;
            $record->yearid = $type;
            $record->courseid = $cl->courseid;
            $record->id = $cl->id;
            $DB->update_record('block_scholarship_courses', $record);
        }
    }
        
    $opentime = strtotime($open.' 00:00:00');
    $closetime = strtotime($close.' 00:00:00');
    if($mult == "yes")
        $multiple = 1;
    else
        $multiple = 0;

    $record->name = $name;
    $record->amount = $amount;
    $record->value = $value;
    $record->multiple = $multiple;
    $record->opendate = $opentime;
    $record->enddate = $closetime;
    $record->scholarshiptype = $type;
    $record->description = $desc;
    $record->timecreated = time();
    $record->timemodified = time();
    $record->id = $sid;
    $DB->update_record('block_scholarship', $record);
    
    echo get_string('changesmade', 'block_scholarship');
}


if(($name !== '0') && ($change !== 'true'))
{
    $opentime = strtotime($open.' 00:00:00');
    $closetime = strtotime($close.' 00:00:00');
    if($mult == "yes")
        $multiple = 1;
    else
        $multiple = 0;

    $record = new stdClass();
    $record->name = $name;
    $record->amount = $amount;
    $record->value = $value;
    $record->multiple = $multiple;
    $record->opendate = $opentime;
    $record->enddate = $closetime;
    $record->scholarshiptype = $type;
    $record->description = $desc;
    $record->timecreated = time();
    $record->timemodified = time();
    $DB->insert_record('block_scholarship', $record);
    $id = $DB->get_record('block_scholarship', array('name' => $name), 'id');

    $record = new stdClass();

    if($courses == '-1')
    {
        $record->scholarshipid = $id->id;
        $record->yearid = $type;
        $record->courseid = $courses;
        $DB->insert_record('block_scholarship_courses', $record);
    }
    else
    {
        $coursearray = explode(",", $courses, -1);

        foreach($coursearray as $course)
        {
            $record->scholarshipid = $id->id;
            $record->yearid = $type;
            $record->courseid = $course;
            $DB->insert_record('block_scholarship_courses', $record);
        }
    }
    echo get_string('scholarshipadded', 'block_scholarship');
    if($courses == '0')
    {
        echo '<br/><pre>-'.get_string('allcourses', 'block_scholarship').'</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">'.get_string('refreshpage', 'block_scholarship').'</p>';
    }
    else
    {
        echo '<pre>';
        foreach($coursearray as $course)
        {
            $cname = $DB->get_record('block_scholarship_courselist', array("id" => $course), 'coursename');
            echo "<br/>-".$cname->coursename;
        }
        echo '</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">'.get_string('refreshpage', 'block_scholarship').'</p>';
    }
}
?>
