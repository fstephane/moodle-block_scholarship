<?php
require_once('../../../config.php');

global $DB;

$list = optional_param('list', '-1', PARAM_INT);
$info = optional_param('info', '0', PARAM_INT);
$year = optional_param('year', '0', PARAM_INT);
$mylist = optional_param('mylist', '0', PARAM_INT);
$userid = optional_param('userid', '0', PARAM_INT);
$delete = optional_param('delete', '0', PARAM_INT);

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
    echo '<input type="button" class="newadd" onclick="add_to_list('.$info.')" style="margin-left:-15px;margin-bottom:30px;width:282px;" value="'.get_string('addtolist', 'block_scholarship').'" /><br/>';
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
            echo '<pre style="font-family:courier;width:250px;">-'.$s->name.'<a title="'.get_string('removefromlist', 'block_scholarship').'" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected('.$s->scholarshipid.')"><img src="delete.gif" /></a><a href"#" style="background-color:transparent;border:none;padding:0px;margin:0px;margin-left:-50px;float:up;color:blue;font-size:14px;">'.get_string('applyforscholarship', 'block_scholarship').'</a></pre>';  
    }
    else
    {
    $selected = $DB->get_records_sql('SELECT schol.name, selected.*
                                        FROM mdl_block_scholarship as schol
                                        JOIN mdl_block_scholarship_selected as selected ON schol.id=selected.scholarshipid
                                        WHERE selected.userid='.$userid.'
                                        ORDER BY schol.name');
        foreach($selected as $s)
            echo '<pre style="font-family:courier;width:250px;">-'.$s->name.'<a title="'.get_string('removefromlist', 'block_scholarship').'" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected('.$s->scholarshipid.')"><img src="delete.gif" /></a><a href"#" style="background-color:transparent;border:none;padding:0px;margin:0px;margin-left:-50px;float:up;color:blue;font-size:14px;">'.get_string('applyforscholarship', 'block_scholarship').'</a></pre>';
        }
}

if($delete !== '0')
{
    $DB->delete_records('block_scholarship_selected', array("scholarshipid" => $delete, "userid" => $userid));
    
    $selected = $DB->get_records_sql('SELECT schol.name, selected.*
                                        FROM mdl_block_scholarship as schol
                                        JOIN mdl_block_scholarship_selected as selected ON schol.id=selected.scholarshipid
                                        WHERE selected.userid='.$userid.'
                                        ORDER BY schol.name');
    foreach($selected as $s)
        echo '<pre style="font-family:courier;width:250px;">-'.$s->name.'<a title="'.get_string('removefromlist', 'block_scholarship').'" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected('.$s->scholarshipid.')"><img src="delete.gif" /></a><a href"#" style="background-color:transparent;border:none;padding:0px;margin:0px;margin-left:-50px;float:up;color:blue;font-size:14px;">'.get_string('applyforscholarship', 'block_scholarship').'</a></pre>';
}
?>
