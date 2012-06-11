<?php
function admin_view($year)
{   
    global $DB;
    if($year != 3)
    {
        $courses = $DB->get_records_sql("SELECT DISTINCT courselist.* 
                                    FROM mdl_block_scholarship_courselist AS courselist
                                    JOIN mdl_block_scholarship_courses AS courses ON courselist.id=courses.courseid
                                    WHERE courses.yearid=".$year." ORDER BY courselist.coursename");
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
    
    echo '<a href="#"><div id="endtool" align="center" style="width:540px;height:50px;border:1px white solid;position:absolute;background-color:black;color:white;top:90px;left:700px;font-size:20px;border-top-left-radius:15px 15px;border-top-right-radius:15px 15px;padding-top:12px;"><p id="tooltext" style="visibility:visible;position:absolute;left:73px;">'.get_string('endofyear', 'block_scholarship').'  <img src="down-arrow.png" /></p><p id="hidetool" style="color:orangered;visibility:hidden;">'.get_string('hide', 'block_scholarship').'</p></div></a>';
    echo '<div id="endofyear" align="center" style="background-color:black;border:1px white solid;width:1200px;height:748px;position:absolute;top:141px;left:40px;z-index:2001;visibility:hidden;">';
        echo '<p style="font-size:25px;margin-top:100px;width:650px;">'.get_string('deleteall', 'block_scholarship').'<br/><br/>'.get_string('deleteallcontinue', 'block_scholarship').'</p>';
        echo '<div id="toolyes" onclick="delete_all_scholarships()" style="position:absolute;top:300px;color:white;font-size:20px;padding-top:8px;border: 1px white solid;border-radius:30px 30px;height:40px;width:150px;margin-left:350px;">'.get_string('yes', 'block_scholarship').'</div>';
        echo '<div id="toolno" style="position:absolute;top:400px;color:white;font-size:20px;padding-top:8px;border: 1px white solid;border-radius:30px 30px;height:40px;width:150px;margin-left:350px;">'.get_string('no', 'block_scholarship').'</div>';
        echo '<label style="position:absolute;top:360px;left:600px;font-size:20px;"><input id="deleteallcourses" type="checkbox"/>    '.get_string('deleteallcourses', 'block_scholarship').'</label>';
    echo '</div>';
    echo '<div id="wback" style="width:1201px; height:750px; background-color:white; position:absolute;border:1px black solid;top:140px;left:40px;"></div>';
    echo '<div id="returntomenu" class="return" align="center" style="width:902px;height:70px;position:absolute;top:141px;left:341px;z-index:2000;color:white;font-size:40px;visibility:hidden;"><p id="rtm" style="margin-top:10px;letter-spacing:4px;">'.get_string('return', 'block_scholarship').'</p></div>';
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
            echo '<li><a id="newscholarshipbutton" class="edit">'.get_string('addscholarship', 'block_scholarship').'<p id="hide" style="visibility:hidden;color:orangered;font-size:15px;">'.get_string('hide', 'block_scholarship').'</p></a>';
            echo '<div id="successmessage2" style="overflow-y:scroll;background-color:dimgray;visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
            echo '<input type="button" id="addanother" class="newadd" onclick="add_again()" style="margin-left:-10px;margin-bottom:20px;" value="'.get_string('addanother', 'block_scholarship').'" />';
            echo '<p id="scholarshipadded" style="color:white;"></p>';
            echo '</div>';
            echo '<div id="scholarshiplist" style="width:300px;height:664px;overflow-y:scroll;visibility:hidden;position:absolute;padding-top:15px;border:1px black solid;margin-top:-1px;margin-left:-1px;"></div>';
            echo '<div id="scholarshipform" style="visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                echo '<div id="blink" style="background-color:dimgray;width:300px;height:45px;border:1px black solid;color:white;margin-left:-11px;margin-top:-11px;"><p id="instr" class="'.get_string('fillevery', 'block_scholarship').'" style="padding:5px;">'.get_string('fillevery', 'block_scholarship').'</p></div><br/>';
                echo '<div style="color:black;">';
                    echo get_string('name', 'block_scholarship').':<br/><input type="text" id="scholarshipname" /><br/><br/>';
                    echo get_string('amount', 'block_scholarship').':<br/><input type="text" id="scholarshipamount" style="width:60px;" /><br/><br/>';
                    echo get_string('value', 'block_scholarship').':<br/><input type="text" id="scholarshipvalue" style="width:60px;" /><br/><br/>';
                    echo '<input type="checkbox" id="scholarshipmultiple" /> '.get_string('multiple', 'block_scholarship').'<br/><br/>';
                    echo get_string('opendate','block_scholarship').'<br/>';
                    echo '<input name="opendate" id="DPC_date1" size="14" type="text" datepicker_format="YYYY-MM-DD"><p>';
                    echo get_string('closingdate','block_scholarship').'<br/>';
                    echo '<input name="enddate" id="DPC_date2" size="14" type="text" datepicker_format="YYYY-MM-DD"><p>';
                    switch($year)
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
                    echo '<select id="scholarshiptype" name="scholarshiptype" style="width:230px;">';
                    echo '<option value="1" '.$one.'>'.get_string('firstyear','block_scholarship').'</option>';
                    echo '<option value="2" '.$two.'>'.get_string('secondyear','block_scholarship').'</option>';
                    echo '<option value="3" '.$three.'>'.get_string('all','block_scholarship').'</option>';
                    echo '</select><br/><br/>';
                    echo get_string('description', 'block_scholarship').':<br/><textarea rows="10" cols="33" id="scholarshipdescription"></textarea><br/><br/>';
                echo '</div>';
                    echo '<input type="button" id="newenable2" class="newbuttoncontinue" value="'.get_string('continue', 'block_scholarship').'" style="margin-left:-10px;background-color:darkcyan;width:300px;margin-top:-15px;" />';
                echo '</div>';
                echo '<div id="newscholarship" style="overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;">';
                echo'<p style="color:black;padding:10px;border-left:1px black solid;border-right:1px black solid;margin-bottom:-8px;margin-left:-1px;">'.get_string('selectcourse', 'block_scholarship').'</p>';
                echo'<p style="padding:10px;border-left:1px black solid;border-right:1px black solid;margin-bottom:-4px;margin-left:-1px;color:orangered;font-family:courier;">'.get_string('deletenotice', 'block_scholarship').'</p>';
                    echo '<form>';
                    echo '<input type="button" disabled="disabled" id="newenable" class="newbuttoncontinue" onclick="new_scholarship_form()" value="'.get_string('continue', 'block_scholarship').'" />';
                    echo '<input type="button" class="newbutton" onclick="select_all()" style="margin-top:5px;" value="'.get_string('selectallcourses', 'block_scholarship').'" />';
                    echo '<input type="button" class="newbutton" onclick="clear_all()" style="margin-top:2px;margin-bottom:4px;" value="'.get_string('clearall', 'block_scholarship').'" />';
                    $i = 0;
                        foreach($allcourses as $course)
                        {
                            if(($i % 2) == 0)
                                $color = 'darkgrey';
                            else
                                $color = 'dimgray';
                            echo '<label class="checkbox" style="color:black;background-color:'.$color.'"><input type="checkbox" class="checkbox7" value="'.$course->id.'"/><b style="padding-left:5px;">'.$course->coursename.'</b><br/></label>';
                            $i++;
                        }
                    echo '</form>';
                    echo '<div style="width:283px;height:400px;background-color:dimgray;position:absolute;top:351px;z-index:-1;"></div>';
                echo '</div>';
            echo '</li>';
            echo '<li><a class="edit" id="addcoursebutton">'.get_string('addcourse', 'block_scholarship').'<p id="hide2" style="visibility:hidden;color:orangered;font-size:15px;">'.get_string('hide', 'block_scholarship').'</p></a>';
            echo '<div id="successmessage6" style="overflow-y:scroll;background-color:dimgray;visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                echo '<input type="button" id="backtoinfo2" class="newbutton" style="margin-left:-10px;margin-bottom:10px;margin-top:20px;width:283px;" value="'.get_string('continue', 'block_scholarship').'" />';    
                echo '<p id="courseschanged" style="color:white;margin-top:30px;margin-bottom:50px;"></p>';
            echo '</div>';
            echo '<div id="confirm2" style="overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;background-color:dimgray;position:absolute;">';
                echo '<p style="color:white;margin-left:10px;margin-top:30px;">'.get_string('deletescholarship', 'block_scholarship').'</p>';
                echo '<input type="button" id="confirmbutton2" disabled="disabled" class="newadd" style="margin-bottom:10px;width:283px;margin-top:20px;" value="'.get_string('confirm', 'block_scholarship').'" />';
                echo '<p id="successmessage5" style="color:white;margin-left:10px;margin-bottom:10px;"></p>';
                echo '<input type="button" id="return2" disabled="false" class="newbutton" style="margin-left:-10px;margin-bottom:20px;width:283px;margin-left:0px;" value="'.get_string('cancel', 'block_scholarship').'" />';
            echo '</div>';
            echo '<div id="changecourses" style="overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;position:absolute;">';
                echo'<br/><p style="color:black;padding:10px;border-left:1px black solid;border-right:1px black solid;margin-bottom:-8px;margin-left:-1px;color:black;">'.get_string('selectcourse', 'block_scholarship').'</p>';
                    echo '<form>';
                    echo '<br/><input type="button" disabled="disabled" id="newenable3" class="newbuttoncontinue" style="margin-bottom:3px;" value="'.get_string('continue', 'block_scholarship').'" />';
                    echo '<input type="button" id="cancel" class="newbutton" style="margin-bottom:10px;" value="'.get_string('cancel', 'block_scholarship').'" />';
                    echo '<input type="button" class="newbutton" onclick="select_all()" style="margin-top:5px;" value="'.get_string('selectallcourses', 'block_scholarship').'" />';
                    echo '<input type="button" class="newbutton" onclick="clear_all()" style="margin-top:2px;margin-bottom:4px;" value="'.get_string('clearall', 'block_scholarship').'" />';
                    $i = 0;
                        foreach($allcourses as $course)
                        {
                            if(($i % 2) == 0)
                                $color = 'darkgrey';
                            else
                                $color = 'dimgray';
                            echo '<label class="checkbox" style="color:black;background-color:'.$color.'"><input type="checkbox" class="checkbox5" value="'.$course->id.'"/><b style="padding-left:5px;">'.$course->coursename.'</b><br/></label>';
                            $i++;
                        }
                    echo '</form>';
                    echo '<div style="width:283px;height:400px;background-color:dimgray;position:absolute;top:351px;z-index:-1;"></div>';
                echo '</div>';
            echo '<div id="scholarshipinfo" style="padding-left:15px;width:284px;height:664px;overflow-y:scroll;visibility:hidden;position:absolute;padding-top:15px;border:1px black solid;margin-top:-1px;margin-left:-1px;"></div>';
            echo '<div id="successmessage4" style="background-color:dimgray;visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                echo '<p id="changesmade" style="color:white;margin-top:30px;margin-bottom:50px;"></p>';
                echo '<input type="button" id="backtoinfo" class="newbutton" style="margin-left:-10px;margin-bottom:20px;width:300px;" value="'.get_string('continue', 'block_scholarship').'" />';
            echo '</div>';
            echo '<div id="editscholarship" style="visibility:hidden;width:299px;height:679px;position:absolute;border:1px black solid;margin-left:-1px;margin-top:-1px;"></div>';
                echo '<div id="hidecourseform" style="height:678px;width:300px;border-left:1px black solid;border-right:1px black solid;margin-left:-1px;margin-right:1px;visibility:hidden;"><br/><br/>';
                    echo '<p id="ishidden" style="color:black;margin-left:8px;margin-bottom:30px;">'.get_string('entercoursename', 'block_scholarship').'</p>';
                    echo '<form align="center">';
                        echo '<p style="color:black;text-align:center";">'.get_string('coursename', 'block_scholarship').'</p><div align="center"><input type="text" id="coursename"/></div>';
                        echo '<p style="font:15px;color:orangered;font-family:courier;text-align:left;margin-left:8px;margin-top:25px;">'.get_string('displaynotice', 'block_scholarship').'</p>';
                        echo '<input type="button" class="newbuttoncontinue" id="newcourseenable" style="margin-top:15px;width:300px;background-color:darkcyan;" onclick="new_course()" value="'.get_string('continue', 'block_scholarship').'" />';
                    echo '</form>';
                    echo '<div style="width:298px;height:370px;background-color:dimgray;border:1px black solid;"><p id="successmessage" style="font-family:courier;color:white;padding:8px;"></p></div>';
                echo '</div>';
            echo '</li>';
            echo '<li><a class="edit" id="removebutton" style="margin-left:-2px;width:298px;">'.get_string('deletecourse', 'block_scholarship').'<p id="hide3" style="visibility:hidden;color:orangered;font-size:15px;">'.get_string('hide', 'block_scholarship').'</p></a>';
            echo '<div id="confirm" style="overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;background-color:dimgray;position:absolute;">';
                echo '<input type="button" id="confirmbutton" disabled="disabled" class="newadd" style="margin-left:-10px;margin-bottom:10px;width:283px;margin-left:0px;margin-top:40px;" value="'.get_string('confirm', 'block_scholarship').'" />';
                echo '<p id="successmessage3" style="color:white;margin-left:10px;margin-bottom:10px;"></p>';
                echo '<input type="button" id="return" class="newbutton" style="margin-left:-10px;margin-bottom:20px;width:283px;margin-left:0px;" value="'.get_string('cancel', 'block_scholarship').'" />';
                echo '<p style="color:white;margin-left:10px;">'.get_string('deletecoursemessage', 'block_scholarship').'</p><br/>';
                echo '<pre id="confirmlist" style="margin-left:10px;color:white;margin-top:-10px;"></pre>';
            echo '</div>';
            echo '<div id="removecourse" style="overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;">';
                echo'<p style="color:black;padding:10px;border-left:1px black solid;border-right:1px black solid;margin-bottom:-8px;margin-left:-1px;">'.get_string('removecourse', 'block_scholarship').'</p>';
                    echo '<form>';
                    echo '<input type="button" id="removeenable" class="newbuttoncontinue" disabled="disabled" onclick="remove_courses()" value="'.get_string('continue', 'block_scholarship').'" />';
                    echo '<input type="button" class="newbutton" onclick="clear_all()" style="margin-top:5px;margin-bottom:4px;" value="'.get_string('clearall', 'block_scholarship').'" />';
                    $i = 0;
                        foreach($allcourses as $course)
                        {
                            if(($i % 2) == 0)
                                $color = 'darkgrey';
                            else
                                $color = 'dimgray';
                            echo '<label class="checkbox" style="color:black;background-color:'.$color.'"><input type="checkbox" class="checkbox2" value="'.$course->id.'"/><b name="nameofcourse" style="padding-left:5px;">'.$course->coursename.'</b><br/></label>';
                            $i++;
                        }
                    echo '</form>';
                    echo '<div style="width:283px;height:400px;background-color:dimgray;position:absolute;top:351px;z-index:-1;" />';
                echo '</div>';
            echo '</li>';
        echo '</ul>';
    echo '</div>';
}
?>

