<?php
function admin_view($year)
{   
    global $DB;
    
    //$courses only grabs courses with active scholarships in indicated year of study
        if($year != 3)
        {
            $courses = $DB->get_records_sql("SELECT DISTINCT courselist.* 
                                        FROM mdl_block_scholarship_courselist AS courselist
                                        JOIN mdl_block_scholarship_courses AS courses ON courselist.id=courses.courseid
                                        WHERE courses.yearid in (".$year.", 3) ORDER BY courselist.coursename");
        }
        else
        {
            $courses = $DB->get_records_sql('SELECT DISTINCT courselist.*
                                            FROM mdl_block_scholarship_courselist AS courselist
                                            JOIN mdl_block_scholarship_courses AS courses ON courselist.id=courses.courseid
                                            WHERE yearid IN (1, 2, 3)
                                            ORDER BY courselist.coursename');
        }
//$allcourses is for lists that must contain every course (for editing purposes) not just courses with scholarships
    $allcourses = $DB->get_records('block_scholarship_courselist', array(), 'coursename');
        
    $notice = $DB->get_record('block_scholarship_notice', array());
    
//End of year tool
    echo '<a href="#"><div id="endtool" align="center" style="width:540px;height:50px;border:1px white solid;position:absolute;background-color:black;color:white;top:60px;left:700px;font-size:20px;border-top-left-radius:15px 15px;border-top-right-radius:15px 15px;padding-top:12px;"><p id="tooltext" style="visibility:visible;text-align:center;font-size:18px;">'.get_string('endofyear', 'block_scholarship').'  <img src="down-arrow.png" /></p><p id="hidetool" style="color:orangered;visibility:hidden;position:absolute;top:10px;left:110px;">'.get_string('hide', 'block_scholarship').'</p></div></a>';
    //Select which elements to delete
    echo '<div id="endofyear" style="background-color:black;border:1px white solid;width:1200px;height:748px;position:absolute;top:111px;left:40px;z-index:2001;display:none;"><br/><br/><br/>';
        echo '<p style="font-size:30px;padding:20px;width:800px;margin-left:130px;">'.get_string('selectitems', 'block_scholarship').'</p>';
        echo '<div style="height:239px;border:1px white solid;position:absolute;width:50px;left:149px;"><br/>';
            echo '<input type="checkbox" id="checkinfo" class="endcheck" style="margin-left:18px;margin-top:6px;"></input><br/><br/><br/><br/><br/>';
            echo '<input type="checkbox" id="checkschol" class="endcheck" disabled="disabled" style="margin-left:18px;"></input><br/><br/><br/><br/>';
            echo '<input type="checkbox" id="checkcourse" class="endcheck" disabled="disabled" style="margin-left:18px;margin-top:15px;"></input>';
        echo '</div>';
        echo '<div style="height:239px;border:1px white solid;position:absolute;width:0px;left:1041px;"></div>';
        echo '<p id="greyinfo" class="'.get_string('notesaved', 'block_scholarship').'" style="font-size:18px;padding:22px;width:800px;margin-left:149px;border:1px white solid;padding-left:70px;">'.get_string('deleteinfo', 'block_scholarship').'</p>';
        echo '<p id="greyschol" style="font-size:18px;padding:23px;width:799px;margin-left:149px;border:1px grey solid;padding-left:70px;color:#474747;">'.get_string('deletescholarships', 'block_scholarship').'</p>';
        echo '<p id="greycourse" style="font-size:18px;padding:22px;width:800px;margin-left:149px;border:1px grey solid;padding-left:70px;color:#474747;">'.get_string('deletecourses', 'block_scholarship').'</p>';
        echo '<div id="toolcontinue" align="center" style="position:absolute;top:500px;color:#474747;font-size:20px;padding-top:8px;border: 1px grey solid;border-radius:30px 30px;height:40px;width:300px;margin-left:150px;">'.get_string('continue', 'block_scholarship').'</div>';
    echo '</div>';
    //Confirm page
    echo '<div id="endofyear2" align="center" style="background-color:black;border:1px white solid;width:1200px;height:748px;position:absolute;top:111px;left:40px;z-index:2001;display:none;">';
        echo '<p style="font-size:25px;margin-top:100px;width:650px;">'.get_string('deleteitems', 'block_scholarship').'<br/><br/>'.get_string('deleteallcontinue', 'block_scholarship').'</p>';
        echo '<div id="toolyes" onclick="delete_all_scholarships()" style="position:absolute;top:270px;color:white;font-size:20px;padding-top:8px;border: 1px white solid;border-radius:30px 30px;height:40px;width:150px;margin-left:350px;">'.get_string('yes', 'block_scholarship').'</div>';
        echo '<div id="toolno" style="position:absolute;top:270px;left:320px;color:white;font-size:20px;padding-top:8px;border: 1px white solid;border-radius:30px 30px;height:40px;width:150px;margin-left:350px;">'.get_string('no', 'block_scholarship').'</div>';
    echo '</div>';
//white background
    echo '<div id="wback" name="'.get_string('baddates', 'block_scholarship').'" style="width:1201px; height:750px; background-color:white; position:absolute;border:1px black solid;top:110px;left:40px;z-index:-3;"></div>';
    echo '<div id="returntomenu" class="return" align="center" style="width:902px;height:70px;position:absolute;top:111px;left:341px;z-index:2000;color:white;font-size:40px;display:none;"><p id="rtm" style="margin-top:10px;letter-spacing:4px;">'.get_string('return', 'block_scholarship').'</p></div>';
//grey background behind sliding course menu
    echo '<div id="block" align="center" style="top:159px;left:40px;position:absolute; background-color:gray; width:300px; height:750px; border:1px black solid; visibility:hidden;margin-top:-49px;"><p id="editing" style="font-size:40px;color:gray;margin-top:200px;width:215px;margin-left:-25px;">'.get_string('editing', 'block_scholarship').'</p></div>';
//Button for scholarship details
    echo '<div id="det" align="center" class="details" onclick="show_table()" style="z-index:-1;">'.get_string('table', 'block_scholarship').'</div>';
//Scholarship Details Table
    echo '<div id="details" style="background-color:black;border:1px white solid;width:1200px;height:748px;position:absolute;top:111px;left:40px;z-index:2000;display:none;overflow-y:scroll;">';
        echo '<div id="hidetable" align="center" style="height:30px;width:400px;background-color:white;border:3px dimgray solid;color:black;border-bottom-right-radius:30px 30px;border-bottom-left-radius:30px 30px;margin-left:370px;padding-top:10px;font-size:20px;">'.get_string('hidetable', 'block_scholarship').'</div><br/><br/><br/>';
        echo'<table border="1" style="border:1px black white;">';
            echo '<tr>';
            echo '<td style="width:180px;">'.get_string('name', 'block_scholarship').'</td><td style="width:150px;">'.get_string('opendate', 'block_scholarship').'</td><td style="width:150px;">'.get_string('closingdate', 'block_scholarship').'</td><td style="width:130px;">'.get_string('number', 'block_scholarship').'</td><td style="width:130px;">'.get_string('numberselected', 'block_scholarship').'</td><td style="width:150px;">'.get_string('amount', 'block_scholarship').'</td><td>'.get_string('value', 'block_scholarship').'</td><td>'.get_string('year', 'block_scholarship').'<br/>(1 / 2+)</td>';
            $info = $DB->get_records('block_scholarship', array(), 'name');
            foreach($info as $i)
            {
                switch($i->scholarshiptype)
                {
                    case 1: $type = '1';
                        break;
                    case 2: $type = '2+';
                        break;
                    case 3: $type = '1 / 2+';
                        break;
                }
                echo '<tr>';
                echo '<td>'.$i->name.'</td><td>'.date("F j, Y", $i->opendate).'</td><td>'.date("F j, Y", $i->enddate).'</td>';
                $acount = $DB->get_records('block_scholarship_users', array("scholarshipid" => $i->id), '', 'id');
                $scount = $DB->get_records('block_scholarship_selected', array("scholarshipid" => $i->id), '', 'id');
                echo '<td>'.count($acount).'</td><td>'.count($scount).'</td><td>'.$i->amount.'</td><td>'.$i->value.'</td><td>'.$type.'</td>';
                echo '</tr>';
            }
            echo '</table>';
    echo '</div>';
//Note section
    echo '<div id="notice" style="height:679px;width:299px;border:1px black solid;position:absolute;top:181px;left:40px;visibility:visible;z-index:-2;">';
        echo '<div align="center" style="width:299px;height:40px;background-color:chocolate;padding-top:0px;border:1px black solid;margin:-1px;margin-top:300px;"><p style="padding-top:10px;font-size:16px;">'.get_string('notice', 'block_scholarship').'</p></div>';
        echo '<br/><b style="color:black;margin-left:125px;">'.get_string('note', 'block_scholarship').'</b><br/><br/>';
        if($DB->get_record('block_scholarship_notice', array()))
            echo '<textarea id="studentnote" rows="12" cols="37" onkeypress="return imposeMaxLength(this, 850);" style="resize:none;margin-top:1px;margin-left:10px;">'.$notice->notice.'</textarea><br/><br/>';
        else
            echo '<textarea id="studentnote" rows="12" cols="37" onkeypress="return imposeMaxLength(this, 850);" style="resize:none;margin-top:1px;margin-left:10px;"></textarea><br/><br/>'; 
        echo '<input type="button" class="newadd" onclick="save_note()" value="'.get_string('save', 'block_scholarship').'" style="width:299px;"/>';
    echo '</div>';
//main container
    echo '<div id="page-wrap" class='.$year.'>';
    //this list contains four main tabs
        echo '<ul id="button" class="dropdown" style="position:absolute;top:95px;left:11px;">';
        ////*Sliding program list
            echo '<li class="program"><a id="programbutton">'.get_string('selectbyprogram', 'block_scholarship').'</a>';
                echo '<ul id="submenu" class="sub_menu">';
                    echo '<li style="height:50px;"></li>';
                    echo '<li class="notice" style="padding-bottom:25px;"><a value="0" style="font-size:15px;color:peru;background:black !important;">'.get_string('onlyprograms', 'block_scholarship').'</a></li>';
                    echo '<li><a name="listoption" value="0" style="color:black;">'.get_string('allcourses', 'block_scholarship').'</a></li>';
                    foreach($courses as $course)
                    {
                        echo '<li><a name="listoption" value="'.$course->id.'" style="font-size:16px;">'.$course->coursename.'</a></li>';
                    }
                 echo '</ul>';
            echo '</li>';
        ////*New Scholarship Tab
            echo '<li><a id="newscholarshipbutton" class="edit">'.get_string('addscholarship', 'block_scholarship').'<p id="hide" style="visibility:hidden;color:orangered;font-size:15px;">'.get_string('hide', 'block_scholarship').'</p></a>';
            //Page 1: Course selector for new scholarship
                echo '<div id="newscholarship" style="position:absolute;overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;">';
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
                echo '</div>';
            //Page 2: New scholarship form
                echo '<div id="scholarshipform" style="visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                    echo '<div id="blink" style="background-color:dimgray;width:300px;height:45px;border:1px black solid;color:white;margin-left:-11px;margin-top:-11px;"><p id="instr" class="'.get_string('fillevery', 'block_scholarship').'" style="padding:5px;">'.get_string('fillevery', 'block_scholarship').'</p></div><br/>';
                    echo '<div style="color:black;">';
                        echo get_string('name', 'block_scholarship').':<br/><input type="text" id="scholarshipname" /><br/><br/>';
                        echo get_string('amount', 'block_scholarship').':<br/><input type="text" id="scholarshipamount" style="width:60px;" /><br/><br/>';
                        echo get_string('value', 'block_scholarship').':<br/><input type="text" id="scholarshipvalue" style="width:60px;" /><br/><br/>';
                        echo get_string('opendate','block_scholarship').'<br/>';
                        echo '<input name="opendate" class="datepicker" id="DPC_date1" size="14" type="text" datepicker_format="YYYY-MM-DD"><br/>';
                        echo get_string('closingdate','block_scholarship').'<br/>';
                        echo '<input name="enddate" class="datepicker" id="DPC_date2" size="14" type="text" datepicker_format="YYYY-MM-DD"><br/><br/>';
                        $one = '';
                        $two = '';
                        $three = '';
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
                        echo get_string('description', 'block_scholarship').':<br/><textarea rows="10" cols="33" id="scholarshipdescription" style="resize:none;"></textarea><br/><br/>';
                    echo '</div>';
                    echo '<input type="button" id="newenable2" class="newbuttoncontinue" value="'.get_string('continue', 'block_scholarship').'" style="margin-left:-10px;background-color:darkcyan;width:300px;margin-top:-15px;" />';
                echo '</div>';
            //Page 3: Document adder
                echo '<div id="adddocuments" style="position:absolute;color:black;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;">';
                echo '<div id="blink" style="background-color:dimgray;width:300px;height:45px;border:1px black solid;color:white;margin-left:-1px;margin-top:-1px;"><p id="instr3" class="'.get_string('fillevery', 'block_scholarship').'" style="padding:5px;">'.get_string('fillevery', 'block_scholarship').'</p></div><br/>';
                    echo '<div style="padding-left:10px;">';
                    echo '<p style="padding-top:5px;">'.get_string('adddocuments', 'block_scholarship').'</p>';
                    echo '<p style="color:red;font-weight:normal;">'.get_string('transcript', 'block_scholarship').'</p>';
                    echo '<p id="docnum" style="font-size:25px;text-decoration:underline;">Document 1</p>';
                    echo get_string('name', 'block_scholarship').':<br/><input type="text" id="docname"></input><br/><br/>';
                    echo get_string('description', 'block_scholarship').':<br/><textarea rows="10" cols="33" id="docdesc" style="resize:none;"></textarea><br/><br/>';
                    echo '</div>';
                    echo '<input type="button" id="anotherdoc" class="newbutton" style="margin-top:5px;width:300px;" value="'.get_string('anotherdoc', 'block_scholarship').'" /><br/><br/>';
                    echo '<input type="button" id="docenable" class="newbuttoncontinue" value="'.get_string('continue', 'block_scholarship').'" style="background-color:darkcyan;width:300px;"/><br/><br/>';
                    echo '<input type="button" id="nodoc" class="newbutton" style="width:300px;font-size:16px;" value="'.get_string('nodoc', 'block_scholarship').'" /><br/><br/>';
                echo '</div>';
            //Page 4: 'Scholarship successfully added' message
                echo '<div id="successmessage2" style="overflow-y:scroll;background-color:dimgray;visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                    echo '<input type="button" id="addanother" class="newadd" onclick="add_again()" style="margin-left:-10px;margin-bottom:20px;" value="'.get_string('addanother', 'block_scholarship').'" />';
                    echo '<p id="scholarshipadded" style="color:white;"></p>';
                echo '</div>';
            //List of scholarships generated from program list (Scholarship Edit view)
                echo '<div id="scholarshiplist" style="width:300px;height:664px;overflow-y:scroll;visibility:hidden;position:absolute;padding-top:15px;border:1px black solid;margin-top:-1px;margin-left:-1px;"></div>';
            echo '</li>';
        ////*Add Course tab
            echo '<li><a class="edit" id="addcoursebutton">'.get_string('addcourse', 'block_scholarship').'<p id="hide2" style="visibility:hidden;color:orangered;font-size:15px;">'.get_string('hide', 'block_scholarship').'</p></a>';
            //New Course form
                echo '<div id="hidecourseform" style="position:absolute;height:678px;width:300px;border-left:1px black solid;border-right:1px black solid;margin-left:-1px;margin-right:1px;visibility:hidden;"><br/><br/>';
                    echo '<p id="ishidden" style="color:black;margin-left:8px;margin-bottom:30px;">'.get_string('entercoursename', 'block_scholarship').'</p>';
                    echo '<form align="center">';
                        echo '<p style="color:black;text-align:center";">'.get_string('coursename', 'block_scholarship').'</p><div align="center"><input type="text" id="coursename1"/></div>';
                        echo '<p style="font:15px;color:orangered;font-family:courier;text-align:left;margin-left:8px;margin-top:25px;">'.get_string('displaynotice', 'block_scholarship').'</p>';
                        echo '<input type="button" class="newbuttoncontinue" id="newcourseenable" style="margin-top:15px;width:300px;background-color:darkcyan;" onclick="new_course()" value="'.get_string('continue', 'block_scholarship').'" />';
                    echo '</form>';
                    echo '<div style="width:298px;height:370px;background-color:dimgray;border:1px black solid;"><p id="successmessage" style="font-family:courier;color:white;padding:8px;"></p></div>';
                echo '</div>';
            //Scholarship info (Scholarship edit view)
                echo '<div id="scholarshipinfo" style="padding-left:15px;width:284px;height:664px;overflow-y:scroll;visibility:hidden;position:absolute;padding-top:15px;border:1px black solid;margin-top:-1px;margin-left:-1px;"></div>';
            //Edit scholarship Info (Scholarship edit view)
                echo '<div id="editscholarship" style="visibility:hidden;width:299px;height:679px;position:absolute;border:1px black solid;margin-left:-1px;margin-top:-1px;"></div>';
            //Success message for scholarship edit (Scholarship edit view)
                echo '<div id="successmessage4" style="background-color:dimgray;visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                    echo '<p id="changesmade" style="color:white;margin-top:30px;margin-bottom:50px;"></p>';
                    echo '<input type="button" id="backtoinfo" class="newbutton" style="margin-left:-10px;margin-bottom:20px;width:300px;" value="'.get_string('continue', 'block_scholarship').'" />';
                echo '</div>';
            //Remove scholarship page (Scholarship edit view)
                echo '<div id="confirm2" style="height:679px;width:299px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;background-color:dimgray;position:absolute;">';
                    echo '<p style="color:white;margin-left:10px;margin-top:30px;">'.get_string('deletescholarship', 'block_scholarship').'</p>';
                    echo '<input type="button" id="confirmbutton2" disabled="disabled" class="newadd" style="margin-bottom:10px;width:299px;margin-top:20px;" value="'.get_string('confirm', 'block_scholarship').'" />';
                    echo '<p id="successmessage5" style="color:white;margin-left:10px;margin-bottom:10px;"></p>';
                    echo '<input type="button" id="return2" disabled="false" class="newbutton" style="margin-left:-10px;margin-bottom:20px;width:299px;margin-left:0px;" value="'.get_string('cancel', 'block_scholarship').'" />';
                echo '</div>';
            //Change scholarship's courses page (Scholarship edit view)
                echo '<div id="changecourses" style="overflow-y:scroll;height:679px;width:299px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;position:absolute;">';
                    echo'<br/><p style="color:black;padding:10px;border-left:1px black solid;border-right:1px black solid;margin-bottom:-8px;margin-left:-1px;color:black;">'.get_string('selectcourse', 'block_scholarship').'</p>';
                    echo '<form>';
                        echo '<br/><input type="button" disabled="disabled" id="newenable3" class="newbuttoncontinue" style="margin-bottom:3px;width:280px;" value="'.get_string('continue', 'block_scholarship').'" />';
                        echo '<input type="button" id="cancel" class="newbutton" style="margin-bottom:10px;width:280px;" value="'.get_string('cancel', 'block_scholarship').'" />';
                        echo '<input type="button" class="newbutton" onclick="select_all()" style="margin-top:5px;width:280px;" value="'.get_string('selectallcourses', 'block_scholarship').'" />';
                        echo '<input type="button" class="newbutton" onclick="clear_all()" style="margin-top:2px;margin-bottom:4px;width:280px;" value="'.get_string('clearall', 'block_scholarship').'" />';
                        $i = 0;
                            foreach($allcourses as $course)
                            {
                                if(($i % 2) == 0)
                                    $color = 'darkgrey';
                                else
                                    $color = 'dimgray';
                                echo '<label class="checkbox" style="color:black;background-color:'.$color.';width:258px;"><input type="checkbox" class="checkbox5" value="'.$course->id.'"/><b style="padding-left:5px;">'.$course->coursename.'</b><br/></label>';
                                $i++;
                            }
                    echo '</form>';
                    echo '<div style="width:283px;height:400px;background-color:dimgray;position:absolute;top:351px;z-index:-1;"></div>';
                echo '</div>';
            //'Courses successfully changed' message (Scholarship edit view)
                echo '<div id="successmessage6" style="overflow-y:scroll;background-color:dimgray;visibility:hidden;height:659px;width:279px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                    echo '<p id="courseschanged" style="color:white;margin-top:30px;margin-bottom:50px;"></p>';
                echo '</div>';
            //Edit Documents form (Scholarship edit view)
                echo '<div id="changedocs" style="overflow-x:hidden;overflow-y:scroll;height:679px;width:299px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;position:absolute;">';
                    echo '<div id="blink" style="background-color:dimgray;width:300px;height:45px;border:1px black solid;color:white;margin-left:-1px;margin-top:-1px;"><p id="instr4" class="'.get_string('fillevery', 'block_scholarship').'" style="padding:5px;">'.get_string('fillevery', 'block_scholarship').'</p></div><br/>';
                    echo '<p style="color:black;padding-left:10px;margin-bottom:10px;">'.get_string('scrolltobottom', 'block_scholarship').'</p>';
                    echo '<p style="color:black;padding-left:10px;color:orangered;font-weight:normal;">'.get_string('changedocs', 'block_scholarship').'</p>';
                    echo '<div id="editdocs"></div>';
                    echo '<input type="button" id="anotherdocedit" class="newbutton" style="margin-top:5px;" value="'.get_string('anotherdoc', 'block_scholarship').'" /><br/><br/>';
                    echo '<input type="button" id="docenableedit" class="newbuttoncontinue" value="'.get_string('continue', 'block_scholarship').'" style="background-color:darkcyan;"/><br/><br/>';
                    echo '<input type="button" id="canceldoc" class="newbutton" value="'.get_string('cancel', 'block_scholarship').'" /><br/><br/>';
                echo '</div>';
            //Edit docs- Add extra documents (Scholarship edit view)
                echo '<div id="adddocumentsedit" style="position:absolute;color:black;height:679px;width:299px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;">';
                    echo '<div id="blink" style="background-color:dimgray;width:299px;height:45px;border:1px black solid;color:white;margin-left:-1px;margin-top:-1px;"><p id="instr5" class="'.get_string('fillevery', 'block_scholarship').'" style="padding:5px;">'.get_string('fillevery', 'block_scholarship').'</p></div><br/>';
                        echo '<div style="padding-left:10px;">';
                        echo '<p style="padding-top:5px;">'.get_string('adddocuments', 'block_scholarship').'</p><br/>';
                        echo '<p id="docnum2" style="font-size:25px;text-decoration:underline;">Document</p>';
                        echo get_string('name', 'block_scholarship').':<br/><input type="text" id="docname2"></input><br/><br/>';
                        echo get_string('description', 'block_scholarship').':<br/><textarea rows="10" cols="33" id="docdesc2" style="resize:none;"></textarea><br/><br/>';
                        echo '</div>';
                        echo '<input type="button" id="anotherdoc2" class="newbutton" style="margin-top:5px;width:300px;" value="'.get_string('anotherdoc', 'block_scholarship').'" /><br/><br/>';
                        echo '<input type="button" id="docenable2" class="newbuttoncontinue" value="'.get_string('continue', 'block_scholarship').'" style="background-color:darkcyan;width:300px;"/><br/><br/>';
                        echo '<input type="button" id="cancelextradoc" class="newbutton" style="width:300px;" value="'.get_string('cancel', 'block_scholarship').'" />';
                echo '</div>';
            //Documents added success message (Scholarship edit view)
                echo '<div id="successmessage7" style="background-color:dimgray;visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                    echo '<p id="changesmade2" style="color:white;margin-top:30px;margin-bottom:50px;"></p>';
                    echo '<input type="button" id="backtoinfo3" class="newbutton" style="margin-left:-10px;margin-bottom:20px;width:300px;" value="'.get_string('continue', 'block_scholarship').'" />';
                echo '</div>';
            //Submitted documents deleted success message (Scholarship edit view)
                echo '<div id="aconfirm" style="background-color:dimgray;visibility:hidden;height:659px;width:280px;margin-left:-1px;border-left:1px black solid;border-right:1px black solid;padding:10px;position:absolute;">';
                    echo '<br/><br/><br/><input type="button" class="newadd" onclick="delete_documents()" value="' . get_string('continue', 'block_scholarship') . '" style="margin-left:-10px;width:299px;margin-top:-2px;" /><br/><br/>';
                    echo '<div id="amessage"></div>';
                    echo '<input type="button" id="canceldd" class="newbutton" style="width:300px;margin-left:-10px;margin-top:3px;" value="' . get_string('cancel', 'block_scholarship') . '" /><br/><br/>';
                    echo '<p>'.get_string('docconfirm', 'block_scholarship').'</p>';
                    echo '<pre id="docschol"></pre>';
                echo '</div>';
            echo '</li>';
        ////*Remove Course Tab
            echo '<li><a class="edit" id="removebutton" style="margin-left:-2px;width:300px;">'.get_string('deletecourse', 'block_scholarship').'<p id="hide3" style="visibility:hidden;color:orangered;font-size:15px;">'.get_string('hide', 'block_scholarship').'</p></a>';
            //Remove courses page
                echo '<div id="removecourse" style="overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;position:absolute;">';
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
                echo '</div>';
            //Courses Removed confirm page and success message
                echo '<div id="confirm" style="overflow-y:scroll;height:679px;width:300px;margin-left:-1px;visibility:hidden;border-left:1px black solid;border-right:1px black solid;background-color:dimgray;position:absolute;">';
                    echo '<input type="button" id="confirmbutton" disabled="disabled" class="newadd" style="margin-left:-10px;margin-bottom:10px;width:283px;margin-left:0px;margin-top:40px;" value="'.get_string('confirm', 'block_scholarship').'" />';
                    echo '<p id="successmessage3" style="color:white;margin-left:10px;margin-bottom:10px;"></p>';
                    echo '<input type="button" id="return" class="newbutton" style="margin-left:-10px;margin-bottom:20px;width:283px;margin-left:0px;" value="'.get_string('cancel', 'block_scholarship').'" />';
                    echo '<p style="color:white;margin-left:10px;">'.get_string('deletecoursemessage', 'block_scholarship').'</p><br/>';
                    echo '<pre id="confirmlist" style="margin-left:10px;color:white;margin-top:-10px;"></pre>';
                echo '</div>';
            //List of students that have applied for selected scholarship (Scholarship Edit View)
                echo '<div id="sbys" style="overflow-y:scroll;height:659px;width:280px;margin-left:-2px;visibility:hidden;position:absolute;border:1px black solid;padding:10px;margin-top:-1px;">';
                    echo '<br/><p style="color:midnightblue;font-size:18px;margin-top:-5px;">'.get_string('applied', 'block_scholarship').'</p>';
                    echo '<div id="applied"></div>';
                echo '</div>';
            //Selected student's submitted documents
                echo '<div id="studdocs" style="overflow-y:scroll;height:659px;width:280px;margin-left:-2px;visibility:hidden;position:absolute;border:1px black solid;padding:10px;margin-top:-1px;">';
                echo '</div>';
            //Confirm page for deleting a student's application
                echo '<div id="sconfirm" align="center" style="height:659px;width:280px;margin-left:-2px;visibility:hidden;position:absolute;border:1px black solid;padding:10px;margin-top:-1px;">';
                    echo '<br/><p style="font-size:20px;color:black;">'.get_string("appconfirm", "block_scholarship").'</p><br/><br/>';
                    echo '<div id="sbysappyes" onclick="delete_app2()" align="center" style="padding-top:8px;color:black;font-size:20px;border: 1px black solid;border-radius:30px 30px;height:40px;width:150px;">'.get_string("yes", "block_scholarship").'</div><br/><br/>';
                    echo '<div id="sbysappno" align="center" style="color:black;font-size:20px;padding-top:8px;border: 1px black solid;border-radius:30px 30px;height:40px;width:150px;">'.get_string("no", "block_scholarship").'</div>';
                echo '</div>';
            echo '</li>';
        echo '</ul>';
    echo '</div>';
    //div to load ajax text when you don't want any text returned
    echo '<div id="null" style="visibility:hidden;"></div>';
}
?>

