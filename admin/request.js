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



//Function for clearing every checkbox in a list
function clear_all()
{
    document.getElementById('newenable').style.background = 'darkslategray';
    document.getElementById('newenable').disabled = true;
    document.getElementById('newenable3').style.background = 'darkslategray';
    document.getElementById('newenable3').disabled = true;
    document.getElementById('removeenable').style.background = 'darkslategray';
    document.getElementById('removeenable').disabled = true;
    var boxes = document.getElementsByTagName('input');
    
    for(i = 0; i<boxes.length; i++)
    {
        if(boxes[i].type == 'checkbox')
            boxes[i].checked = false;
    }
}

//Function for clearing every checkbox in a list
function clear_all8()
{
    var boxes = document.getElementsByTagName('input');
    
    for(i = 0; i<boxes.length; i++)
    {
        if((boxes[i].type == 'checkbox') && (boxes[i].className == 'checkbox8'))
            boxes[i].checked = false;
    }
}

//Function for clearing every checkbox in a list
function clear_all9()
{
    var boxes = document.getElementsByTagName('input');
    
    for(i = 0; i<boxes.length; i++)
    {
        if((boxes[i].type == 'checkbox') && (boxes[i].className == 'checkbox9'))
            boxes[i].checked = false;
    }
}

//Displays a table with information on all available scholarships
function show_table()
{
    $("#details").slideDown('slow');
}

//AJAX call that saves a new course name
function new_course()
{
    var string = escape(document.getElementById("coursename1").value);
    $('#successmessage').load("request.php?coursename=" + string, function(){
        document.getElementById("coursename1").value = "";
    });
}

//AJAX call that indicates that a student's mailed documents have been received
function mail_received(uid, sid)
{
    $("#null").load('request.php?received=' + uid + '&rid=' + sid, function(){
        alert(document.getElementById('scholinstr').className);
        window.location = $("#modal").attr('accept') + "/blocks/scholarship/admin/adminview.php";
    });
}

//Allows the administrator to confirm that a student's mailed documents have been received
$("#mailtool").click(function(){
    //If tool is hidden, display it when clicked. If it is visible, hide it when clicked
    if(document.getElementById('mailtext').style.display !== 'none')
    {
        $("#addmail").slideDown();
        document.getElementById("mailtext").style.display = 'none';
        document.getElementById("hidemail").style.display = 'inline';
        
        //Display/Hide options that follow depending on whether checkbox has been checked yet
        $(".checkbox8").click(function(){
            if(!this.checked)
            {
                clear_all8();
                document.getElementById('schollist').innerHTML = null;
            }
            else
            {
                clear_all8();
                this.checked = true;
                var stid = this.value;
                //loads names of documents required for this scholarship
                $("#schollist").load('request.php?smail=' + stid, function(){
                    //Display/Hide options that follow depending on whether checkbox has been checked yet
                    $(".checkbox9").click(function(){
                        if(!this.checked)
                        {
                            clear_all9();
                            document.getElementById('requiredlist').innerHTML = null;
                        }
                        else
                        {
                            clear_all9();
                            this.checked = true;
                            var sid = this.value;
                            var userid = this.id;
                            $("#requiredlist").load('request.php?dmail=' + sid + '&userid=' + userid, function(){
                                
                                $("#verify").hover(function(){
                                    if(document.getElementById("verify").disabled == false)
                                        document.getElementById("verify").style.backgroundColor = 'darkslategrey';
                                },
                                function(){
                                    if(document.getElementById("verify").disabled == false)
                                        document.getElementById("verify").style.backgroundColor = 'darkcyan';
                                });
                                //Display/Hide options that follow depending on whether checkbox has been checked yet
                                $(".checkbox10").click(function(){
                                    var checked = true;
                                    $("input[class = checkbox10]").each(function(){
                                        if(!this.checked)
                                            checked = false;
                                    });
                                    if(checked)
                                    {
                                        document.getElementById('verify').disabled = false;
                                        document.getElementById("verify").style.backgroundColor = 'darkcyan';
                                    }
                                    else
                                    {
                                        document.getElementById('verify').disabled = true;
                                        document.getElementById("verify").style.backgroundColor = 'darkslategrey';
                                    }
                                });
                            });
                        }
                    });
                });
            }
        });
    }
    //Hide tool
    else
    {
        $("#addmail").slideUp();
        document.getElementById('schollist').innerHTML = null;
        document.getElementById('requiredlist').innerHTML = null
        document.getElementById("mailtext").style.display = 'block';
        document.getElementById("hidemail").style.display = 'none';
        clear_all();
    }
});


//Presents confirmation for whether or not a teacher wants to delete a student's submission (front page tool)
function app_confirm(sid, stid)
{
    document.getElementById('studentinfo').style.display = 'none';
    document.getElementById('deleteapp').style.display = 'inline';
    
    document.getElementById('appyes').className = sid;
    document.getElementById('appno').className = stid;
}

//Cancel button for deleting a submission (front page tool) 
$("#appno").click(function(){
    document.getElementById('studentinfo').style.display = 'inline';
    document.getElementById('deleteapp').style.display = 'none';
});

//Deletes a student's submission (front page tool)
function delete_app()
{
    var sid = document.getElementById('appyes').className;
    var stid = document.getElementById('appno').className;
    $("#deleteapp").load('request.php?dapp=' + sid, '&userid=' + stid, function(){
        window.location.reload();
    });
}

//Presents confirmation for whether or not a teacher wants to delete a student's submission (plugin tool)
function app_confirm2(sid, stid)
{
    document.getElementById('studdocs').style.visibility = 'hidden';
    document.getElementById('sconfirm').style.visibility = 'visible';
    
    document.getElementById('endtool').className = sid;
    document.getElementById('endofyear').className = stid;
}

//Deletes a student's submission (plugin tool)
function delete_app2()
{
    var sid = document.getElementById('endtool').className;
    var stid = document.getElementById('endofyear').className;
    $("#deleteapp").load('request.php?dapp=' + sid, '&userid=' + stid, function(){
        window.location.reload();
    });
}

//Cancel button for delete submission confirmation (plugin tool)
$("#sbysappno").click(function(){
    document.getElementById('studdocs').style.visibility = 'visible';
    document.getElementById('sconfirm').style.visibility = 'hidden';
});

//End of year tool - Deletes a bundle of information
function delete_all_scholarships()
{
    var deleteall = '1';
    if(document.getElementById("checkschol").checked == true)
        deleteall = '2';
    if(document.getElementById("checkcourse").checked == true)
        deleteall = '3';
    $("#endofyear2").load("request.php?deleteall=" + deleteall, function(){
        $("#toolrefresh").hover(function(){
            document.getElementById("toolrefresh").style.backgroundColor = 'white';
            document.getElementById("toolrefresh").style.color = 'black';
        }, function(){
            document.getElementById("toolrefresh").style.backgroundColor = 'black';
            document.getElementById("toolrefresh").style.color = 'white';
        });
    });
}

//Shows the documents a student has submitted
function show_docs(user, sid, mail)
{
    document.getElementById('sbys').style.visibility = 'hidden';
    document.getElementById('studdocs').style.visibility = 'visible';
    $('#studdocs').load('request.php?showdocs=true&userid=' + user + '&scid=' + sid + '&email=' + mail);
}

//Exits student document viewer and returns to plugin
function bts()
{
    document.getElementById('sbys').style.visibility = 'visible';
    document.getElementById('studdocs').style.visibility = 'hidden';
}

//Delete one or more courses
function remove_courses()
{
    var courses = new Array();
    var coursenames = new Array();
    var index = 0;
    
    var boxes = document.getElementsByTagName('input');
    //Check which courses are selected
    for(i = 0; i<boxes.length; i++)
        if(boxes[i].className == 'checkbox2')
            if(boxes[i].checked == true)
            {
                courses[index] = boxes[i].value;
                index++;
            }
                
    document.getElementById("removecourse").style.visibility = 'hidden';
    document.getElementById("confirm").style.visibility = 'visible'; 
    
    var string = 'deletedcourses=';
    var dstring = 'deletemessage=';
    var ii = 0;
    //construct string for AJAX call
    for(course in courses)
    {
        string += courses[ii] + ',';
        dstring += courses[ii] + ',';
        ii++;
    }
    
    $('#confirmlist').load("request.php?" + dstring);
    
    $("#confirmbutton").click(function(){
        document.getElementById("confirmbutton").disabled = true;
        $('#successmessage3').load("request.php?" + string);
    });
    
    //Cancel button
    $("#return").click(function(){
        document.getElementById("successmessage3").innerHTML = "";
        document.getElementById("removecourse").style.visibility = 'visible';
        document.getElementById("confirm").style.visibility = 'hidden'; 
        clear_all();
    });
}

//Exits 'remove course' section
function remove_continue()
{
    document.getElementById("confirm").style.visibility = 'hidden';
    document.getElementById("removebutton").style.backgroundColor = 'steelblue';
    document.getElementById("hide3").style.visibility = 'hidden';
}

//Save a note to show students on student view
function save_note()
{
    var note = encodeURIComponent(document.getElementById("studentnote").value);
    $("#null").load('request.php?note=' + note, function(){
        alert(document.getElementById('greyinfo').className);
    });
}

//When program is selected from menu on left
$('a[name = listoption]').click(function(){
    document.getElementById('editing').style.color = 'dimgray';
    document.getElementById('notice').style.visibility = 'hidden';
    document.getElementById('det').style.visibility = 'hidden';
    document.getElementById('sconfirm').style.visibility = 'hidden';
    document.getElementById('aconfirm').style.visibility = 'hidden';
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById("adddocumentsedit").style.visibility = 'hidden';
    document.getElementById("changedocs").style.visibility = 'hidden';
    document.getElementById("successmessage6").style.visibility = 'hidden';
    document.getElementById("sbys").style.visibility = 'hidden';
    document.getElementById("editscholarship").style.visibility = 'hidden';
    document.getElementById("changecourses").style.visibility = 'hidden';
    document.getElementById("confirm2").style.visibility = 'hidden';
    $("#returntomenu").slideDown('fast');
    document.getElementById("newscholarshipbutton").style.background = 'slategray';
    document.getElementById("addcoursebutton").style.background = 'slategray';
    document.getElementById("removebutton").style.background = 'slategray';
    
    document.getElementById("scholarshiplist").style.visibility = 'visible';
    var option = $(this);
    var year = document.getElementById("page-wrap").className;
    $('#scholarshiplist').load("request.php?year=" + year + "&list=" + option.attr('value'));
});

//Shows info for a student when viewing a list of students who have applied for a certain scholarship
function show_info(el)
{
    clear_all();
    document.getElementById('sconfirm').style.visibility = 'hidden';
    document.getElementById('aconfirm').style.visibility = 'hidden';
    document.getElementById("studdocs").style.visibility = 'hidden';
    document.getElementById("adddocumentsedit").style.visibility = 'hidden';
    document.getElementById("successmessage4").style.visibility = 'hidden';
    document.getElementById("changedocs").style.visibility = 'hidden';
    document.getElementById("scholarshipinfo").style.visibility = 'visible';
    document.getElementById("editscholarship").style.visibility = 'hidden';
    document.getElementById("confirm2").style.visibility = 'hidden';
    document.getElementById("changecourses").style.visibility = 'hidden';
    document.getElementById("successmessage6").style.visibility = 'hidden';
    document.getElementById("sbys").style.visibility = 'visible';
    document.getElementById("successmessage5").innerHTML = "";
    
    $("a[class = list]").css('color', 'blue');
    $("a[class = list]").css('font-weight', 'normal');
    $('#scholarshipinfo').load("request.php?info=" + el.attr('value'), function(){
        el.css('color', '#2D2D5A');
        el.css('font-weight', 'bold');
    });
    $('#applied').load("request.php?sbys=" + el.attr('value'));
}

//Delete a student's submission
function delete_documents()
{
    document.getElementById('scholarshipinfo').style.visibility = 'visible';
    document.getElementById('aconfirm').style.visibility = 'visible';
    
    $("#amessage").load('request.php?dd=' + $('p[name = scholname]').attr('id'));
}

//Shows option to delete all the documents of a particular scholarship
function show_dd()
{
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById('aconfirm').style.visibility = 'visible';
    document.getElementById('docschol').innerHTML = $('p[name = scholname]').html();
}
//Cancel button for 'delete documents' function
$("#canceldd").click(function(){
    document.getElementById('aconfirm').style.visibility = 'hidden';
    show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'))
});

//Shows a form for editing a scholarship
function edit_scholarship(year)
{   
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById("editscholarship").style.visibility = 'visible';
    $('#editscholarship').load("request.php?edit=" + $('p[name = scholname]').attr('id') + '&year=' + year, function(){
        $('#editscholarship').find('.datepicker').datepicker();
    });
    
    $("#canceledit").click(function(){
        document.getElementById("editscholarship").style.visibility = 'hidden';
        show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'))
    });
}

//Deletes an entire scholarship and all the documents submitted for that scholarship
function delete_scholarship()
{
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById("confirm2").style.visibility = 'visible';
    document.getElementById("confirmbutton2").disabled = false;
    document.getElementById("return2").disabled = false;
    
    //Continue button
    $("#confirmbutton2").click(function(){
        document.getElementById("confirmbutton2").disabled = true;
        document.getElementById("sbys").style.visibility = 'hidden';
        document.getElementById("return2").disabled = true;
        $('#successmessage5').load("request.php?remove=" + $('p[name = scholname]').attr('id'));
    });
    
    //Cancel button
    $("#return2").click(function(){
        if(navigator.appName == "Microsoft Internet Explorer")
            document.getElementById("successmessage5").innerText = "";
        else
            document.getElementById("successmessage5").innerHTML = "";
        document.getElementById("confirm2").style.visibility = 'hidden';
        show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'))
    });
}

//Continues after deleting a scholarship
function delete_continue()
{
    document.getElementById("confirm2").style.visibility = 'hidden';
}

//AJAX call for editing scholarship info
function change_info(id)
{
    var xml;
    var redo = false;
    
    var ename = document.getElementById("scholarshipnameedit");
    var eamount = document.getElementById("scholarshipamountedit");
    var evalue = document.getElementById("scholarshipvalueedit");
    var eopen = document.getElementById("openedit");
    var eclose = document.getElementById("closeedit");
    var etype = document.getElementById("scholarshiptypeedit");
    var edesc = document.getElementById("scholarshipdescriptionedit");
    
    //Make message at top blink if any field is left blank
    if((ename.value == '') || (eamount.value == '') || (evalue.value == '') || (eopen.value == '') || (eclose.value == '') || (etype.value == '') || (edesc.value == ''))
    {
        document.getElementById("instr2").innerHTML = document.getElementById("instr2").className;
        var interval = window.setInterval(blink2, 200);
        window.setTimeout(stop_blink, 1000, interval);
    }
    else
    {
        //Open date cannot be after closing date
        if((new Date(eopen.value).getTime() / 1000) > (new Date(eclose.value).getTime() / 1000))
        {
            alert($("#wback").attr('name'));
            redo = true;
        }
        if(!redo)
        {
            var sendtext = 'change=true&id=' + id + '&name=' + ename.value + '&amount=' + eamount.value + '&value=' + evalue.value + '&open=' + eopen.value + '&close=' + eclose.value + '&type=' + etype.value + '&desc=' + edesc.value;
            var xmlhttp;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("changesmade").innerHTML=xmlhttp.responseText;
                    document.getElementById("editscholarship").style.visibility = 'hidden';
                    document.getElementById("successmessage4").style.visibility = 'visible';
                   }
            }
            xmlhttp.open("POST","request.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send(sendtext);
            
            //Button for returning to scholarship info
            $("#backtoinfo").click(function(){
                show_info($('a.list[value =' + id + ']'));
            });
        }
    }
}

//Cancels the 'edit scholarship' function
function cancel_edit()
{
    document.getElementById("editscholarship").style.visibility = 'hidden';
    show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'));
}

//Shows the documents a student has submitted when the student's name is clicked (front page tool)
function student_info(stid, name, mail)
{
    var fullname = escape(name);
    var email = escape(mail);
    $("#studentinfo").load('request.php?student=' + stid + '&fullname=' + fullname + '&email=' + email);
}

//Downloads a student's uploaded submission
function read_file(fid, scholarshipid, userid, f)
{
    var file = escape(f);
    window.location = 'request.php?fid=' + fid + '&scholarshipid=' + scholarshipid + '&userid=' + userid + '&file=' + file;
}

//Change the courses a scholarship belongs to
function change_courses()
{
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    
    $(document).ready(function(){
        //Outer AJAX call is to check courses that scholarship is already a part of
        //Inner Ajax call is to actually change the courses.
        var xml;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xml=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xml=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xml.onreadystatechange=function()
        {
            if (xml.readyState==4 && xml.status==200)
            {
                //This call is to actually change courses
                document.getElementById("changecourses").style.visibility = 'visible';
                document.getElementById("newenable3").disabled = false;
                document.getElementById("newenable3").style.background = 'darkcyan';
                var checked = xml.responseText.split(",");
            
                var boxes = document.getElementsByTagName('input');
                var allc = false;
                for(i = 0; i < checked.length; i++)
                    if(checked[i] == '0')
                        allc = true;
            
                //check off courses scholarship belongs to
                if(!allc)
                {
                    for(i = 0; i<boxes.length; i++)
                    {
                        if((boxes[i].type == 'checkbox') && (boxes[i].className == 'checkbox5'))
                            //second for loop makes sure no duplicate course ids are sent
                            for(ii = 0;ii < checked.length; ii++)
                                if(boxes[i].value == checked[ii])
                                    boxes[i].checked = true;
                    }
                }
                else
                    for(i = 0; i<boxes.length; i++)
                    {
                        if((boxes[i].type == 'checkbox') && (boxes[i].className == 'checkbox5'))
                            boxes[i].checked = true;
                    }
                //Continue Button
                $("#newenable3").click(function(){
                    var allcheck = true;
                    var courses = new Array();
                    
                    //Check which courses were selected
                    $('input').each(function(){
                        if(this.className == 'checkbox5')
                            if(typeof(courses[this.value]) != 'undefined')
                            {
                                if(courses[this.value] == true)
                                    courses[this.value] = this.checked;
                            }
                            else
                                courses[this.value] = this.checked;
                    });
            
                    document.getElementById("changecourses").style.visibility = "hidden";
                    document.getElementById("successmessage6").style.visibility = "visible";
                    
                    for(var c in courses)
                        if(courses[c] == false)
                            allcheck = false;
                    
                    var sendchange = 'cc=' + $('p[name = scholname]').attr('id');
                    if(!allcheck)
                    {
                        sendchange += '&courses=';
                        for(var c in courses)
                        {
                            if((courses[c] == true) && (c !== 'on'))
                                sendchange += c + ',';
                        }
                    }
                    else
                    {
                        sendchange += '&courses=0';
                    }
                    $('#courseschanged').load('request.php?' + sendchange);
                });
                 }
        }
        xml.open("GET","request.php?cc=" + $('p[name = scholname]').attr('id'),true);
        xml.send();
        
        //Return to scholarship info
        $("#backtoinfo2").click(function(){
            document.getElementById("successmessage6").style.visibility = 'hidden';
            show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'));
        });
    });
    
}

//Changes the documents required for a scholarship
function change_documents()
{
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById("changedocs").style.visibility = 'visible';
    //Loads list of existing docs
    $("#editdocs").load('request.php?editdocs=' + $('p[name = scholname]').attr('id'));
    
    //Add another doc button
    $("#anotherdocedit").click(function(){
        add_doc();
    });
    
    //Continue button
    $("#docenableedit").click(function(){
        var dname = document.getElementsByName("docname");
        var ddesc = document.getElementsByName("docdesc");
        var docarray = new Array();
        var docedit = '';
        var empty = false;
        for(i = 0; i < dname.length; i++)
        {
            docedit += dname[i].id + '^' + dname[i].value + '@' + ddesc[i].value + '*';
            //Make message at top blink if any field is left blank
            if((dname[i].value == '') || (ddesc[i].value == ''))
            {
                empty = true;
                document.getElementById("instr4").innerHTML = document.getElementById("instr4").className;
                var interval = window.setInterval(blink4, 200);
                window.setTimeout(stop_blink, 1000, interval);
            }
        }
        var newstring = escape(docedit);
        if(!empty)
        {
            $("#changesmade2").load('request.php?id=' + $('p[name = scholname]').attr('id') + '&editd=' + newstring);
            document.getElementById("successmessage7").style.visibility = 'visible';
            document.getElementById("changedocs").style.visibility = 'hidden';
        }
    });
    
    //Cancel button
    $("#canceldoc").click(function(){
        document.getElementById("changedocs").style.visibility = 'hidden';
        show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'));
    });
}

//Adds another document to a scholarship
function add_doc()
{
    document.getElementById("changedocs").style.visibility = 'hidden';
    document.getElementById("adddocumentsedit").style.visibility = 'visible';
    
    var infoarray = new Array();
    var infoi = 0;
    
    //stores temporary doc name and description and opens another blank doc form
    $("#anotherdoc2").click(function(){
        var redo = false;
        var xml;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xml=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xml=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xml.onreadystatechange=function()
        {
            if (xml.readyState==4 && xml.status==200)
            {
                //Response text is 'Good' if document name has not been taken
                if(xml.responseText !== 'Good')
                {
                    redo = true;
                    document.getElementById("instr5").innerHTML = xml.responseText;
                    var interval = window.setInterval(blink5, 200);
                    window.setTimeout(stop_blink, 1000, interval);
                }
                
                if(!redo)
                {
                    //Make message at top blink if any field is left blank
                    if((document.getElementById("docname2").value == '') || (document.getElementById("docdesc2").value == ''))
                    {
                        document.getElementById("instr5").innerHTML = document.getElementById("instr5").className;
                        var interval = window.setInterval(blink5, 200);
                        window.setTimeout(stop_blink, 1000, interval);
                    }
                    else
                    {
                        infoarray[infoi] = new Array();
                        infoarray[infoi]['name'] = document.getElementById("docname2").value;
                        infoarray[infoi]['description'] = document.getElementById("docdesc2").value;
                        document.getElementById("docname2").value = '';
                        document.getElementById("docdesc2").value = '';
                        infoi++;
                    }
                }
            }
        }
        xml.open("GET","request.php?check2=" + document.getElementById("docname2").value,true);
        xml.send();
    });

    //Continue button
    $("#docenable2").click(function(){
        //Outer AJAX call is to check if doc name has already been taken
        //Inner AJAX call is to actually save info
        var redo = false;
        var xml;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xml=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xml=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xml.onreadystatechange=function()
        {
            if (xml.readyState==4 && xml.status==200)
            {
                //This AJAX call is to save info
                //Response text is 'Good' if scholarship name has not been taken
                if(xml.responseText !== 'Good')
                {
                    redo = true;
                    document.getElementById("instr5").innerHTML = xml.responseText;
                    var interval = window.setInterval(blink5, 200);
                    window.setTimeout(stop_blink, 1000, interval);
                }
                
                if(!redo)
                {
                    //Make message at top blink if any field is left blank
                    if((document.getElementById("docname2").value == '') || (document.getElementById("docdesc2").value == ''))
                    {
                        document.getElementById("instr5").innerHTML = document.getElementById("instr5").className;
                        var interval = window.setInterval(blink5, 200);
                        window.setTimeout(stop_blink, 1000, interval);
                    }
                    else
                    {
                        infoarray[infoi] = new Array();
                        infoarray[infoi]['name'] = document.getElementById("docname2").value;
                        infoarray[infoi]['description'] = document.getElementById("docdesc2").value;
                        document.getElementById("docname2").value = '';
                        document.getElementById("docdesc2").value = '';
                        var doctext = 'id=' + $('p[name = scholname]').attr('id') + '&doc=';
                        for(i = 0; i < infoarray.length; i++)
                        {
                            doctext += infoarray[i]['name'] + ',' + infoarray[i]['description'] + '.';
                        }

                        var xmlhttp;
                        if (window.XMLHttpRequest)
                        {// code for IE7+, Firefox, Chrome, Opera, Safari
                            xmlhttp=new XMLHttpRequest();
                        }
                        else
                        {// code for IE6, IE5
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=function()
                        {
                            if (xmlhttp.readyState==4 && xmlhttp.status==200)
                            {
                                document.getElementById("changesmade2").innerHTML=xmlhttp.responseText;
                               }
                        }
                        xmlhttp.open("POST","request.php",true);
                        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                        xmlhttp.send(doctext);


                        document.getElementById("adddocumentsedit").style.visibility = 'hidden';
                        document.getElementById("successmessage7").style.visibility = 'visible';
                    }
                }
            }
        }
        xml.open("GET","request.php?check2=" + document.getElementById("docname2").value,true);
        xml.send();
    });
}
//return to scholarship info
$("#backtoinfo3").click(function(){
    document.getElementById("successmessage7").style.visibility = 'hidden';
    show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'));
});

//remove a required document from a scholarship
function remove_document(did)
{
    $("#null").load('request.php?deldoc=' + did);
    change_documents();
}

//
function new_scholarship_form()
{   
    var allcheck = true;
    var courses = new Array();
    var index = 0;
    var boxes = new Array();
    
    //Check which courses were selected
    $('input').each(function(){
        if((this.checked == true) && (this.className == 'checkbox7'))
        {
            courses[index] = this.value;
            index++;
        }
        else if((this.checked == false) && (this.className == 'checkbox7'))
            allcheck = false;
    });
        
    document.getElementById("newscholarship").style.display = '';
    document.getElementById("newscholarship").style.visibility = 'hidden';
    document.getElementById("scholarshipform").style.visibility = 'visible';
    document.getElementById("scholarshipname").focus();
    
    var name = document.getElementById("scholarshipname");
    var amount = document.getElementById("scholarshipamount");
    var value = document.getElementById("scholarshipvalue");
    var open = document.getElementById("DPC_date1");
    var close = document.getElementById("DPC_date2");
    var type = document.getElementById("scholarshiptype");
    var desc = document.getElementById("scholarshipdescription");
    
    //Continue button for entering scholarship info
    $("#newenable2").click(function(){
        //Make message at top blink if any field is left blank
        if((name.value == '') || (amount.value == '') || (value.value == '') || (open.value == '') || (close.value == '') || (type.value == '') || (desc.value == ''))
        {
            document.getElementById("instr").innerHTML = document.getElementById("instr").className;
            var interval = window.setInterval(blink, 200);
            window.setTimeout(stop_blink, 1000, interval);
        }
        else
        {  
            //Outer AJAX call is to check if scholarship name has already been taken
            //Inner AJAX call is to save actual information
            var xml;
            var redo = false;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xml=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xml=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xml.onreadystatechange=function()
            {
                if (xml.readyState==4 && xml.status==200)
                {
                    //This AJAX call is to save actual information
                    //Response text is 'Good' if scholarship name has not been taken
                    if(xml.responseText !== 'Good')
                    {
                        redo = true;
                        document.getElementById("instr").innerHTML = xml.responseText;
                        var interval = window.setInterval(blink, 200);
                        window.setTimeout(stop_blink, 1000, interval);
                    }
                    //Checks to make sure open date is before closing date
                    if((new Date(open.value).getTime() / 1000) > (new Date(close.value).getTime() / 1000))
                    {
                        alert($("#wback").attr('name'));
                        redo = true;
                    }
                
                    if(!redo)
                    {
                        document.getElementById("scholarshipform").style.visibility = 'hidden';
                        document.getElementById("adddocuments").style.visibility = 'visible';
                        document.getElementById("docname").focus();

                        var infoarray = new Array();
                        var infoi = 0;
                        //Stores temporary doc info and opens new doc form
                        $("#anotherdoc").click(function(){
                            if((document.getElementById("docname").value == '') || (document.getElementById("docdesc").value == ''))
                            {
                                document.getElementById("instr3").innerHTML = document.getElementById("instr3").className;
                                var interval = window.setInterval(blink3, 200);
                                window.setTimeout(stop_blink, 1000, interval);
                            }
                            else
                            {
                                document.getElementById("docname").focus();
                                infoarray[infoi] = new Array();
                                infoarray[infoi]['name'] = document.getElementById("docname").value;
                                infoarray[infoi]['description'] = document.getElementById("docdesc").value;
                                document.getElementById("docname").value = '';
                                document.getElementById("docdesc").value = '';
                                document.getElementById("docnum").innerHTML = 'Document ' + (infoi + 2);
                                infoi++;
                            }
                        });
                    
                        //Continue button
                        $("#docenable").click(function(){
                            var xml;
                            if (window.XMLHttpRequest)
                            {// code for IE7+, Firefox, Chrome, Opera, Safari
                                xml=new XMLHttpRequest();
                            }
                            else
                            {// code for IE6, IE5
                                xml=new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            xml.onreadystatechange=function()
                            {
                                if (xml.readyState==4 && xml.status==200)
                                {
                                    //Response text is 'Good' if document name has not been taken
                                    if(xml.responseText !== 'Good')
                                    {
                                        redo = true;
                                        document.getElementById("instr3").innerHTML = xml.responseText;
                                        var interval = window.setInterval(blink3, 200);
                                        window.setTimeout(stop_blink, 1000, interval);
                                    }
                                
                                    if(!redo)
                                    {
                                        //Make message at top blink if any field is left blank
                                        if((document.getElementById("docname").value == '') || (document.getElementById("docdesc").value == ''))
                                        {
                                            document.getElementById("instr3").innerHTML = document.getElementById("instr3").className;
                                            var interval = window.setInterval(blink3, 200);
                                            window.setTimeout(stop_blink, 1000, interval);
                                        }
                                        else
                                        {
                                            infoarray[infoi] = new Array();
                                            infoarray[infoi]['name'] = document.getElementById("docname").value;
                                            infoarray[infoi]['description'] = document.getElementById("docdesc").value;
                                            document.getElementById("docname").value = '';
                                            document.getElementById("docdesc").value = '';
                                            document.getElementById("docnum").innerHTML = 'Document1';

                                            var sendtext = 'change=false&name=' + name.value + '&amount=' + amount.value + '&value=' + value.value + '&open=' + open.value + '&close=' + close.value + '&type=' + type.value + '&desc=' + desc.value;

                                            if(!allcheck)
                                            {
                                                var string = '&courses=';
                                                var ii = 0;
                                                for(course in courses)
                                                {
                                                    string += courses[ii] + ',';
                                                    ii++;
                                                }
                                                sendtext += string;
                                            }
                                            else
                                                sendtext += '&courses=0';

                                            var doctext = '&doc=';
                                            for(i = 0; i < infoarray.length; i++)
                                            {
                                                doctext += infoarray[i]['name'] + ',' + infoarray[i]['description'] + '.';
                                            }

                                            sendtext += doctext;
                                    
                                            var xmlhttp;
                                            if (window.XMLHttpRequest)
                                            {// code for IE7+, Firefox, Chrome, Opera, Safari
                                                xmlhttp=new XMLHttpRequest();
                                            }
                                            else
                                            {// code for IE6, IE5
                                                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                                            }
                                            xmlhttp.onreadystatechange=function()
                                            {
                                                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                                {
                                                    document.getElementById("scholarshipadded").innerHTML=xmlhttp.responseText;
                                                   }
                                            }
                                            xmlhttp.open("POST","request.php",true);
                                            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                                            xmlhttp.send(sendtext);


                                            document.getElementById("adddocuments").style.visibility = 'hidden';
                                            document.getElementById("successmessage2").style.visibility = 'visible';
                                        }
                                    }
                                }
                            }
                            xml.open("GET","request.php?check2=" + document.getElementById("docname").value,true);
                            xml.send();
                        });
                    
                        //Continue without documents button
                        $("#nodoc").click(function(){
                            document.getElementById("docname").value = '';
                            document.getElementById("docdesc").value = '';
                            document.getElementById("docnum").innerHTML = 'Document1';

                            var sendtext = 'change=false&name=' + name.value + '&amount=' + amount.value + '&value=' + value.value + '&open=' + open.value + '&close=' + close.value + '&type=' + type.value + '&desc=' + desc.value;

                            if(!allcheck)
                            {
                                var string = '&courses=';
                                var ii = 0;
                                for(course in courses)
                                {
                                    string += courses[ii] + ',';
                                    ii++;
                                }
                                sendtext += string;
                            }
                            else
                                sendtext += '&courses=0';
                        
                            var xmlhttp;
                            if (window.XMLHttpRequest)
                            {// code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp=new XMLHttpRequest();
                            }
                            else
                            {// code for IE6, IE5
                                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            xmlhttp.onreadystatechange=function()
                            {
                                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                {
                                    document.getElementById("scholarshipadded").innerHTML=xmlhttp.responseText;
                                   }
                            }
                            xmlhttp.open("POST","request.php",true);
                            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                            xmlhttp.send(sendtext);
                        
                            document.getElementById("adddocuments").style.visibility = 'hidden';
                            document.getElementById("successmessage2").style.visibility = 'visible';
                        });
                    }
                }
            }
            xml.open("GET","request.php?check=" + document.getElementById('scholarshipname').value,true);
            xml.send();
        
        }
    });
}
//makes an error message blink
function blink()
{
    $("#instr").animate({
        opacity:0
    },50,"linear",function(){
        $(this).animate({
            opacity:1
        },200);
    });
}

function blink2()
{
    $("#instr2").animate({
        opacity:0
    },50,"linear",function(){
        $(this).animate({
            opacity:1
        },200);
    });
}

function blink3()
{
    $("#instr3").animate({
        opacity:0
    },50,"linear",function(){
        $(this).animate({
            opacity:1
        },200);
    });
}

function blink4()
{
    $("#instr4").animate({
        opacity:0
    },50,"linear",function(){
        $(this).animate({
            opacity:1
        },200);
    });
}

function blink5()
{
    $("#instr5").animate({
        opacity:0
    },50,"linear",function(){
        $(this).animate({
            opacity:1
        },200);
    });
}

function stop_blink(interval)
{
    window.clearInterval(interval);
}
