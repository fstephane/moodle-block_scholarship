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

//Shows a list of scholarships by the program selected
$('a[name = listoption]').click(function(){
    document.getElementById("infoind").style.visibility = 'hidden';
    document.getElementById("scholind").style.visibility = 'visible';
    document.getElementById("scholarshiplist").style.visibility = 'visible';
    document.getElementById("scholarshipinfo").innerHTML = '';
    var year = document.getElementById("page-wrap").className;
    var option = $(this);
    $('#scholarshiplist').load("requestuser.php?year=" + year + "&list=" + option.attr('value'));
});

//Confirms that submission will be mailed
function mail_send(uid)
{
    $("#null").load('requestuser.php?send=' + uid + '&sid=' + document.getElementById('scholid').className, function(){
        alert(document.getElementById('programbutton').className);
        window.location = $("#modal").attr('accept') + "/blocks/scholarship/user/userview.php?userid=" + uid;
    });
}

//Shows info for the scholarship selected
function show_info(el)
{
    document.getElementById("infoind").style.visibility = 'visible';
    
    $("a[class = list]").css('color', 'blue');
    $("a[class = list]").css('font-weight', 'normal');
    $('#scholarshipinfo').load("requestuser.php?info=" + el.attr('value'), function(){
        el.css('color', '#2D2D5A');
        el.css('font-weight', 'bold');
    });
}

//Shows instructions for mailing documents
function mail()
{
    document.getElementById('applydocs').style.visibility = 'hidden';
    document.getElementById('mail').style.visibility = 'visible';
    $("#listdocs").load('requestuser.php?mail=' + document.getElementById('scholid').className);
}

//Adds a scholarship to a student's list of selected scholarships
function add_to_list(schol)
{
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
            if(xmlhttp.responseText == 'Good')
            {
                document.getElementById("applydocs").style.visibility = 'hidden';
                document.getElementById("uploaddocs").style.visibility = 'hidden';
                document.getElementById("mylist").style.visibility = 'visible';
                $('#mylist').load("requestuser.php?mylist=" + schol + "&userid=" + $('form[name = year]').attr('id'));
            }
            else
                alert(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET","requestuser.php?check=" + schol,true);
    xmlhttp.send();
}

//Deletes a scholarship from a student's list
function delete_selected(sid)
{
    $('#mylist').load("requestuser.php?delete=" + sid + "&userid=" + $('form[name = year]').attr('id'))
}

//Shows required documents and presents option of either mailing documents or submitting them electronically
function apply_docs(sid)
{
    document.getElementById("mylist").style.visibility = 'hidden';
    document.getElementById("applydocs").style.visibility = 'visible';
    
    $("#doclist").load("requestuser.php?docs=" +  sid);
}

//Tool for uploading documents electronically
function upload_docs(year)
{
    document.getElementById("applydocs").style.visibility = 'hidden';
    document.getElementById("uploaddocs").style.visibility = 'visible';
    
    $("#uploadform").load("requestuser.php?upload=" + document.getElementById("scholid").className, function(){
        $("#applysubmit").hover(function(){
            if(!document.getElementById('applysubmit').disabled)
                document.getElementById('applysubmit').style.backgroundColor = 'darkslategrey';
        },function(){
            if(!document.getElementById('applysubmit').disabled)
                document.getElementById('applysubmit').style.backgroundColor = 'darkcyan';
        });
    });
}

//Exits uploading tool
function back_to_docs()
{
    document.getElementById("applydocs").style.visibility = 'visible';
    document.getElementById("uploaddocs").style.visibility = 'hidden';
    document.getElementById("mail").style.visibility = 'hidden';
}

//Uploads documents to server - puts constraints on the files and shows error message if constraints are not met (correct file type, etc.)
function apply()
{
    var cont = true;
    
    $('input[type = file]').each(function(){
        if(this.value == '')
            cont = false;
    });
    
    if(!cont)
        alert(document.getElementById("showname").className);
    else
    {
        //checks to see that all required documents have been uploaded, and that no 2 files have the same name
        var same = new Array();
        var i = 0;
        $('input[type = file]').each(function(){
            same[i] = this.value;
            i++;
        });
    
        var count = new Array();
        for(i = 0; i < same.length; i++)
            count[i] = 0;
        i = 0;
        $('input[type = file]').each(function(){
            for(s in same)
                if(same[s] == this.value)
                    count[i]++;
            i++;
        });
        for(i = 0; i < count.length; i++)
            if(count[i] > 1)
                cont = false;
        if(!cont)
            alert(document.getElementById('block').className);
        //check file extensions
        else
        {
            var extension = new Array();
        
            extension[0] = ".602";
            extension[1] = ".abw";
            extension[2] = ".acl";
            extension[3] = ".afp";
            extension[4] = ".ans";
            extension[5] = ".cwk";
            extension[6] = ".aww";
            extension[7] = ".cff";
            extension[8] = ".doc";
            extension[9] = ".docx";
            extension[10] = ".dot";
            extension[11] = ".dotx";
            extension[12] = ".egt";
            extension[13] = ".fdx";
            extension[14] = ".ftm";
            extension[15] = ".ftx";
            extension[16] = ".html";
            extension[17] = ".hwp";
            extension[18] = ".hwpml";
            extension[19] = ".lwp";
            extension[20] = ".mbp";
            extension[21] = ".mcw";
            extension[22] = ".odm";
            extension[23] = ".odt";
            extension[24] = ".ott";
            extension[25] = ".omm";
            extension[26] = ".pages";
            extension[27] = ".pap";
            extension[28] = ".pdax";
            extension[29] = ".pdf";
            extension[30] = ".rtf";
            extension[31] = ".rpt";
            extension[32] = ".sdw";
            extension[33] = ".stw";
            extension[34] = ".sxw";
            extension[35] = ".info";
            extension[36] = ".txt";
            extension[37] = ".uof";
            extension[38] = ".uoml";
            extension[39] = ".wpd";
            extension[40] = ".wps";
            extension[41] = ".wpt";
            extension[42] = ".wrd";
            extension[43] = ".wrf";
            extension[44] = ".wri";
            extension[45] = ".xps";
    
            var redo = false;
        
            $("input[class = extension]").each(function(){
                var badext = true;
                var fieldvalue = this.value;

                var thistext = fieldvalue.substr(fieldvalue.lastIndexOf('.'));
                for(var i = 0; i < extension.length; i++) 
                {
                    if(thistext == extension[i]) 
                        badext = false;
                }
                if(badext)
                    redo = true;
            });
            if(!redo)
                document.forms["application"].submit();
            else
                alert(document.getElementById("wback").className);
        }
    }
}