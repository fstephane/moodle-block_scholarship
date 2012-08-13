<?php

function user_view($year, $userid, $fullname) {
    global $DB;
    $empty = false;

    if ($year != 3) {
        if (!$DB->get_records('block_scholarship_courses', array("yearid" => 3)))
            if (!$DB->get_records_sql('SELECT * FROM mdl_block_scholarship_courses 
                                WHERE yearid=' . $year . ' AND courseid!=0'))
                $empty = true;
    }
    else
    if (!$DB->get_records('block_scholarship_courses', array()))
        $empty = true;

    if (!$empty) {
        if ($year != 3) {
            $coursearray = $DB->get_records_sql("SELECT DISTINCT courseid
                                                FROM mdl_block_scholarship_courses
                                                WHERE yearid IN (" . $year . ", 3) AND courseid!=0");
            $i = 0;
            foreach ($coursearray as $ca) {
                $array[$i] = $DB->get_record('block_scholarship_courselist', array("id" => $ca->courseid), 'coursename');
                $i++;
            }
            sort($array);
            $i = 0;
            foreach ($array as $a) {
                $courses[$i] = $DB->get_record('block_scholarship_courselist', array("coursename" => $a->coursename));
                $i++;
            }
        } else {
            $courses = $DB->get_records_sql('SELECT DISTINCT courselist.*
                                            FROM mdl_block_scholarship_courselist AS courselist
                                            JOIN mdl_block_scholarship_courses AS courses ON courselist.id=courses.courseid
                                            WHERE yearid IN (1, 2, 3)
                                            ORDER BY courselist.coursename');
            $courses = $DB->get_records_sql('SELECT DISTINCT courselist.*
                                            FROM mdl_block_scholarship_courselist AS courselist
                                            JOIN mdl_block_scholarship_courses AS courses ON courselist.id=courses.courseid
                                            WHERE yearid IN (1, 2, 3)
                                            ORDER BY courselist.coursename');
        }
    }

//Displays user's name
    echo '<div id="showname" class="' . get_string('upload', 'block_scholarship') . '" align="center" style="width:500px;height:30px;border:1px white solid;position:absolute;background-color:black;color:white;top:80px;left:741px;font-size:25px;border-top-left-radius:15px 15px;border-top-right-radius:15px 15px;">' . $fullname . '</div>';
//White background
    echo '<div id="wback" class="' . get_string('badextension', 'block_scholarship') . '" style="width:1201px; height:750px; background-color:white; position:absolute;border:1px black solid;top:110px;left:40px;"></div>';
//grey background behind tabs
    echo '<div id="returntomenu" class="return" align="center" style="width:900px;height:70px;position:absolute;top:110px;left:341px;background-color:dimgray;border:1px black solid;"></div>';
//grey block behind sliding program list
    echo '<div id="block" class="' . get_string('samename', 'block_scholarship') . '" align="left" style="top:159px;left:40px;position:absolute; background-color:gray; width:300px; height:750px; border:1px black solid; visibility:hidden;margin-top:-49px;"></div>';
//Main container
    echo '<div id="page-wrap" class=' . $year . '>';
//this list contains four main tabs
    echo '<ul id="button" class="dropdown" style="position:absolute;top:95px;left:11px;">';
    ////*Program list
    echo '<li class="program"><a id="programbutton" class="'.get_string('confirmation', 'block_scholarship').'" style="text-align:center;">' . get_string('selectbyprogram', 'block_scholarship') . '</a>';
    echo '<ul id="submenu" class="sub_menu">';
    echo '<li style="height:50px;"></li>';
    echo '<li class="notice" style="padding-bottom:25px;"><a value="0" style="font-size:15px;color:peru;background:black !important;">' . get_string('onlyprograms', 'block_scholarship') . '</a></li>';
    echo '<li><a name="listoption" value="0" style="color:black;">' . get_string('allcourses', 'block_scholarship') . '</a></li>';
    if (!$empty)
        foreach ($courses as $course) {
            echo '<li><a name="listoption" value="' . $course->id . '" style="font-size:16px;">' . $course->coursename . '</a></li>';
        }
    echo '</ul>';
    echo '</li>';
    ////*List of scholarships according to selected program
    echo '<li id="scholind" class="indicator" style="visibility:hidden;background-color:steelblue;"><p style="font-size:30px;color:white;text-align:center;padding-top:15px;">' . get_string('pluginname', 'block_scholarship') . '</p>';
    echo '<div id="scholarshiplist" class="'.$userid.'" style="width:300px;height:664px;overflow-y:scroll;visibility:hidden;position:absolute;padding-top:15px;border:1px black solid;margin-top:-11px;margin-left:-1px;"></div>';
    echo '</li>';
    ////*Scholarship info
    echo '<li id="infoind" class="indicator" style="visibility:hidden;background-color:maroon;"><p style="font-size:30px;color:white;text-align:center;padding-top:15px;">' . get_string('info', 'block_scholarship') . '</p>';
    echo '<div id="scholarshipinfo" style="padding-left:15px;width:285px;height:664px;overflow-y:scroll;padding-top:15px;border:1px black solid;margin-top:-11px;margin-left:-1px;"></div>';
    echo '</li>';
    ////*My Selected Scholarships tab
    echo '<li id="listind" class="indicator" style="visibility:visible;background-color:goldenrod;"><p style="font-size:25px;color:white;text-align:center;padding-top:5px;">' . get_string('myscholarships', 'block_scholarship') . '</p>';
    //List of selected scholarships
    echo '<div id="mylist" style="position:absolute;visibility:visible;padding-left:15px;width:284px;height:654px;overflow-y:scroll;padding-top:25px;border:1px black solid;margin-top:-22px;margin-left:-1px;">';
    $selected = $DB->get_records_sql('SELECT schol.name, selected.*
                                            FROM mdl_block_scholarship as schol
                                            JOIN mdl_block_scholarship_selected as selected ON schol.id=selected.scholarshipid
                                            WHERE selected.userid=' . $userid . '
                                            ORDER BY schol.name');

    foreach ($selected as $s)
        echo '<pre style="font-family:courier;width:250px;">-' . $s->name . '<a title="' . get_string('removefromlist', 'block_scholarship') . '" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected(' . $s->scholarshipid . ')"><img src="delete.gif" /></a><a href"#" onclick="apply_docs(' . $s->scholarshipid . ')" style="background-color:transparent;border:none;padding:0px;margin:0px;color:blue;float:up;font-size:14px;cursor:pointer;width:30px;height:20px;margin-left:20px;">' . get_string('applyforscholarship', 'block_scholarship') . '</a></pre><br/>';
    echo '</div>';
    //List of docs for selected scholarship
    echo '<div id="applydocs" style="position:absolute;visibility:hidden;padding-left:10px;width:289px;height:664px;overflow-y:scroll;padding-top:15px;border:1px black solid;margin-top:-22px;margin-left:-1px;">';
    echo '<p>' . get_string('documentsneeded', 'block_scholarship') . '</p>';
    echo '<input type="button" class="newadd" onclick="upload_docs()" style="margin-left:-10px;margin-bottom:10px;width:282px;font-size:16px;" value="' . get_string('electronic', 'block_scholarship') . '" />';
    echo '<input type="button" class="yellowbtn" id="maildocs" onclick="mail()" style="font-size:18px;margin-left:-10px;margin-bottom:10px;height:30px;width:282px;font-weight:bold;border:2px lightgrey outset;color:white;" value="' . get_string('mail', 'block_scholarship') . '" />';
    echo '<input type="button" id="backtolist" class="newadd2" style="margin-left:-10px;margin-bottom:20px;width:282px;" value="' . get_string('backtolist', 'block_scholarship') . '" /><br/>';
    echo '<div id="doclist" style="color:black;width:260px;"></div>';
    echo '</div>';
    //Page for uploading completed documents (Applying)
    echo '<div id="uploaddocs" style="position:absolute;visibility:hidden;padding-left:10px;width:289px;height:664px;overflow-y:scroll;padding-top:15px;border:1px black solid;margin-top:-22px;margin-left:-1px;">';
    echo '<p>' . get_string('upload', 'block_scholarship') . '</p>';
    echo '<p style="font-weight:normal;color:orangered;width:260px;">' . get_string('final', 'block_scholarship') . '</p>';
    echo '<div id="uploadform"></div>';
    echo '</div>';
    //Mailing instructions
    echo '<div id="mail" style="position:absolute;visibility:hidden;padding-left:10px;width:289px;height:664px;overflow-y:scroll;padding-top:15px;border:1px black solid;margin-top:-22px;margin-left:-1px;">';
    echo '<b style="font-size:22px;text-decoration:underline;">' . get_string('mailinfo', 'block_scholarship') . '</b><br/><br/>';
    echo '<p style="color:orangered;font-weight:normal;">'.get_string('mailnotice', 'block_scholarship').'</p><hr/>';
    echo '<b style="font-size:16px;">' . get_string('mailinstr', 'block_scholarship') . '</b><br/><br/>';
    echo '<p style="font-weight:normal;">Bureau des admissions<br/>2-02, pavillon McMahon<br/>8406, rue Marie-Anne-Gaboury (91 St)<br/>Edmonton, AB T6C 4G9.<br/><br/>';
    echo '<b style="font-size:16px;">' . get_string('inperson', 'block_scholarship') . '</b><br/>';
    echo '<p style="font-weight:normal;width:260px;">Bureau des affaires étudiantes - Local 2-21</p><hr/><hr/><br/>';
    echo '<b style="font-size:20px;">' . get_string('required', 'block_scholarship') . '</b><br/>';
    echo '<div id="listdocs"></div>';
    echo '</div>';
    echo '</li>';
    echo '</div>';
    //div to load ajax text when you don't want any text returned
    echo '<div id="null" style="visibility:hidden;"></div>';
}

?>
