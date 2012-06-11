<?php
function user_view($year, $userid, $fullname)
{
    global $DB;
    
    if($year != 3)
    {
        $coursearray = $DB->get_records_sql("SELECT DISTINCT courseid
                                            FROM mdl_block_scholarship_courses
                                            WHERE yearid IN (".$year.", 3) AND courseid!=0");
        $i = 0;
        foreach($coursearray as $ca)
        {
            $array[$i] = $DB->get_record('block_scholarship_courselist', array("id" => $ca->courseid), 'coursename');
            $i++;
        }
        sort($array);
        $i = 0;
        foreach($array as $a)
        {
            $courses[$i] = $DB->get_record('block_scholarship_courselist', array("coursename" => $a->coursename));
            $i++;
        }
    }
    else
    {
        $courses = $DB->get_records_sql('SELECT DISTINCT courselist.*
                                        FROM mdl_block_scholarship_courselist AS courselist
                                        JOIN mdl_block_scholarship_courses AS courses ON courselist.id=courses.courseid
                                        WHERE yearid IN (1, 2, 3)
                                        ORDER BY courselist.coursename');
    }
        
    $allcourses = $DB->get_records('block_scholarship_courselist', array(), 'coursename');
    
    echo '<div id="showname" align="center" style="width:500px;height:30px;border:1px white solid;position:absolute;background-color:black;color:white;top:110px;left:741px;font-size:25px;border-top-left-radius:15px 15px;border-top-right-radius:15px 15px;">'.$fullname.'</div>';
    echo '<div id="wback" style="width:1201px; height:750px; background-color:white; position:absolute;border:1px black solid;top:140px;left:40px;"></div>';
    echo '<div id="returntomenu" class="return" align="center" style="width:900px;height:70px;position:absolute;top:140px;left:341px;background-color:dimgray;border:1px black solid;"></div>';
    echo '<div id="block" align="left" style="top:189px;left:40px;position:absolute; background-color:gray; width:300px; height:750px; border:1px black solid; visibility:hidden;margin-top:-49px;"></div>';
    echo '<div id="page-wrap" class='.$year.'>';
    echo '<ul id="button" class="dropdown" style="position:absolute;top:125px;left:11px;">';
        echo '<li class="program"><a id="programbutton">'.get_string('selectbyprogram', 'block_scholarship').'</a>';
            echo '<ul id="submenu" class="sub_menu">';
                echo '<li class="notice" style="padding-bottom:15px;"><a value="0" style="font-size:15px;color:peru;background:black !important;">'.get_string('onlyprograms', 'block_scholarship').'</a></li>';
                echo '<li><a name="listoption" value="0" style="color:black;">'.get_string('allcourses', 'block_scholarship').'</a></li>';
                foreach($courses as $course)
                {
                    echo '<li><a name="listoption" value="'.$course->id.'">'.$course->coursename.'</a></li>';
                }
             echo '</ul>';
        echo '</li>';
        echo '<li id="scholind" class="indicator" style="visibility:hidden;background-color:steelblue;"><p style="font-size:30px;color:white;text-align:center;padding-top:15px;">'.get_string('pluginname', 'block_scholarship').'</p>';
            echo '<div id="scholarshiplist" style="width:300px;height:664px;overflow-y:scroll;visibility:hidden;position:absolute;padding-top:15px;border:1px black solid;margin-top:-11px;margin-left:-1px;"></div>';
        echo '</li>';
        echo '<li id="infoind" class="indicator" style="visibility:hidden;background-color:maroon;"><p style="font-size:30px;color:white;text-align:center;padding-top:15px;">'.get_string('info', 'block_scholarship').'</p>';
        echo '<div id="scholarshipinfo" style="padding-left:15px;width:285px;height:664px;overflow-y:scroll;padding-top:15px;border:1px black solid;margin-top:-11px;margin-left:-1px;"></div>';
        echo '</li>';
        echo '<li id="listind" class="indicator" style="visibility:visible;background-color:goldenrod;"><p style="font-size:25px;color:white;text-align:center;padding-top:5px;">'.get_string('myscholarships', 'block_scholarship').'</p>';
        echo '<div id="mylist" style="padding-left:15px;width:284px;height:654px;overflow-y:scroll;padding-top:25px;border:1px black solid;margin-top:-22px;margin-left:-1px;">';
        $selected = $DB->get_records_sql('SELECT schol.name, selected.*
                                        FROM mdl_block_scholarship as schol
                                        JOIN mdl_block_scholarship_selected as selected ON schol.id=selected.scholarshipid
                                        WHERE selected.userid='.$userid.'
                                        ORDER BY schol.name');
        
        foreach($selected as $s)
            echo '<pre style="font-family:courier;width:250px;">-'.$s->name.'<a title="'.get_string('removefromlist', 'block_scholarship').'" style="background-color:transparent;width:10px;height:10px;border:none;padding:0px;margin:0px;float:right;" href="#" onclick="delete_selected('.$s->scholarshipid.')"><img src="delete.gif" /></a><a href"#" style="background-color:transparent;border:none;padding:0px;margin:0px;margin-left:-50px;color:blue;float:up;font-size:14px;">'.get_string('applyforscholarship', 'block_scholarship').'</a></pre>';
        echo '</div>';
        echo '</li>';
    echo '</div>';
}
?>
