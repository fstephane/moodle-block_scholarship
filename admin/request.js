function new_course()
{
    var string = escape(document.getElementById('coursename').value);
    $('#successmessage').load("request.php?coursename=" + string, function(){
        document.getElementById("coursename").value = "";
    });
}

function delete_all_scholarships()
{
var checked = '0';
    if(document.getElementById("deleteallcourses").checked == true)
        checked = 'true';
    $("#endofyear").load("request.php?deleteall=true&checked=" + checked);
}

function remove_courses()
{
    var courses = new Array();
    var coursenames = new Array();
    var index = 0;
    
    var boxes = document.getElementsByTagName('input');
    
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
    
    $("#return").click(function(){
        document.getElementById("successmessage3").innerHTML = "";
        document.getElementById("removecourse").style.visibility = 'visible';
        document.getElementById("confirm").style.visibility = 'hidden'; 
        clear_all();
    });
}

function remove_continue()
{
    document.getElementById("confirm").style.visibility = 'hidden';
    document.getElementById("removebutton").style.backgroundColor = 'steelblue';
    document.getElementById("hide3").style.visibility = 'hidden';
}

$('a[name = listoption]').click(function(){
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById("returntomenu").style.visibility = 'visible';
    document.getElementById("newscholarshipbutton").style.background = 'slategray';
    document.getElementById("addcoursebutton").style.background = 'slategray';
    document.getElementById("removebutton").style.background = 'slategray';
    
    document.getElementById("scholarshiplist").style.visibility = 'visible';
    var option = $(this);
    var year = document.getElementById("page-wrap").className;
    $('#scholarshiplist').load("request.php?year=" + year + "&list=" + option.attr('value'));
});

function show_info(el)
{
    clear_all();
    document.getElementById("successmessage4").style.visibility = 'hidden';
    document.getElementById("scholarshipinfo").style.visibility = 'visible';
    document.getElementById("editscholarship").style.visibility = 'hidden';
    document.getElementById("confirm2").style.visibility = 'hidden';
    document.getElementById("changecourses").style.visibility = 'hidden';
    document.getElementById("successmessage5").innerHTML = "";
    $('#scholarshipinfo').load("request.php?info=" + el.attr('value'));
}

function edit_scholarship(year)
{   
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById("editscholarship").style.visibility = 'visible';
    $('#editscholarship').load("request.php?edit=" + $('p[name = scholname]').attr('id') + '&year=' + year);
    
}

function delete_scholarship()
{
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    document.getElementById("confirm2").style.visibility = 'visible';
    document.getElementById("confirmbutton2").disabled = false;
    document.getElementById("return2").disabled = false;
    
    var el = $('a.list[value =' + $('p[name = scholname]').attr('id') + ']');
    
    $("#confirmbutton2").click(function(){
        document.getElementById("confirmbutton2").disabled = true;
        document.getElementById("return2").disabled = true;
        $('#successmessage5').load("request.php?remove=" + $('p[name = scholname]').attr('id'));
    });
    
    $("#return2").click(function(){
        if(navigator.appName == "Microsoft Internet Explorer")
            document.getElementById("successmessage5").innerText = "";
        else
            document.getElementById("successmessage5").innerHTML = "";
        document.getElementById("confirm2").style.visibility = 'hidden';
        show_info(el)
    });
}

function delete_continue()
{
    document.getElementById("confirm2").style.visibility = 'hidden';
    show_info($('p[name = scholname]').attr('id'));
}

function change_info(id)
{
    var xml;
    var redo = false;
    
    var ename = document.getElementById("scholarshipnameedit");
    var eamount = document.getElementById("scholarshipamountedit");
    var evalue = document.getElementById("scholarshipvalueedit");
    var emultiple = document.getElementById("scholarshipmultipleedit");
    var eopen = $('input[class = openedit]');
    var eclose = $('input[class = endedit]');
    var etype = document.getElementById("scholarshiptypeedit");
    var edesc = document.getElementById("scholarshipdescriptionedit");
    
    if((ename.value == '') || (eamount.value == '') || (evalue.value == '') || (eopen.attr('value') == '') || (eclose.attr('value') == '') || (etype.value == '') || (edesc.value == ''))
    {
        document.getElementById("instr2").innerHTML = document.getElementById("instr2").className;
        var interval = window.setInterval(blink2, 200);
        window.setTimeout(stop_blink, 1000, interval);
    }
    else
    {
        var mult;
        if(emultiple.checked == true)
            mult = 'yes';
        else
            mult = 'no';

        var sendtext = 'change=true&id=' + id + '&name=' + ename.value + '&amount=' + eamount.value + '&value=' + evalue.value + '&mult=' + mult + '&open=' + eopen.value + '&close=' + eclose.value + '&type=' + etype.value + '&desc=' + edesc.value;
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

        $("#backtoinfo").click(function(){
            show_info($('a.list[value =' + id + ']'));
        });
    }
}

function change_courses()
{
    document.getElementById("scholarshipinfo").style.visibility = 'hidden';
    
    $(document).ready(function(){
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
            document.getElementById("changecourses").style.visibility = 'visible';
            document.getElementById("newenable3").disabled = false;
            document.getElementById("newenable3").style.background = 'darkcyan';
            var checked = xml.responseText.split(",");
            
            var boxes = document.getElementsByTagName('input');
            var allc = false;
            for(i = 0; i < checked.length; i++)
                if(checked[i] == '0')
                    allc = true;
            
                    if(!allc)
                        {
                        for(i = 0; i<boxes.length; i++)
                            {
                                if((boxes[i].type == 'checkbox') && (boxes[i].className == 'checkbox5'))
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
                
                $("#newenable3").click(function(){
                    document.getElementById("changecourses").style.visibility = "hidden";
                    document.getElementById("successmessage6").style.visibility = "visible";
                    
                    var allcheck = true;
                    var courses = new Array();
                    var index = 0;

                    var boxes = document.getElementsByTagName('input');

                    for(i = 0; i<boxes.length; i++)
                        {
                            if(boxes[i].className == 'checkbox5')
                            {
                                if((boxes[i].checked == true) && (boxes[i].value !== 'on'))
                                {
                                    courses[index] = boxes[i].value;
                                    index++;
                                }
                                else if((boxes[i].checked == false) && (boxes[i].value !== 'on'))
                                    allcheck = false;
                            }
                        }
                        var sendchange = 'cc=' + $('p[name = scholname]').attr('id');
                        if(!allcheck)
                            {
                                sendchange += '&courses=';
                                var ii = 0;
                                for(course in courses)
                                {
                                    sendchange += courses[ii] + ',';
                                    ii++;
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
        
        $("#backtoinfo2").click(function(){
           document.getElementById("successmessage6").style.visibility = 'hidden';
           show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'));
        });
    });
    
}

function new_scholarship_form()
{   
    var allcheck = true;
    var courses = new Array();
    var index = 0;
    
    var boxes = document.getElementsByTagName('input');
    document.getElementById("scholarshipmultiple").checked = false;
    
    for(i = 0; i<boxes.length; i++)
        {
            if(boxes[i].className == 'checkbox7')
            {
                if((boxes[i].checked == true) && (boxes[i].value !== 'on'))
                    {
                        courses[index] = boxes[i].value;
                        index++;
                    }
                    else if((boxes[i].checked == false) && (boxes[i].value !== 'on'))
                        allcheck = false;
            }
        }
        
    document.getElementById("newscholarship").style.visibility = 'hidden';
    document.getElementById("scholarshipform").style.visibility = 'visible';
    document.getElementById("scholarshipname").focus();
    
    var name = document.getElementById("scholarshipname");
    var amount = document.getElementById("scholarshipamount");
    var value = document.getElementById("scholarshipvalue");
    var multiple = document.getElementById("scholarshipmultiple");
    var open = document.getElementById("DPC_date1");
    var close = document.getElementById("DPC_date2");
    var type = document.getElementById("scholarshiptype");
    var desc = document.getElementById("scholarshipdescription");
    
    $("#newenable2").click(function(){
        if((name.value == '') || (amount.value == '') || (value.value == '') || (open.value == '') || (close.value == '') || (type.value == '') || (desc.value == ''))
        {
            document.getElementById("instr").innerHTML = document.getElementById("instr").className;
            var interval = window.setInterval(blink, 200);
            window.setTimeout(stop_blink, 1000, interval);
        }
        else
        {
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
                    if(xml.responseText !== 'Good')
                    {
                        redo = true;
                        document.getElementById("instr").innerHTML = xml.responseText;
                        var interval = window.setInterval(blink, 200);
                        window.setTimeout(stop_blink, 1000, interval);
                    }
                    if(!redo)
                    {
                        var mult;
                        if(multiple.checked == true)
                            mult = 'yes';
                        else
                            mult = 'no';

                        var sendtext = 'change=false&name=' + name.value + '&amount=' + amount.value + '&value=' + value.value + '&mult=' + mult + '&open=' + open.value + '&close=' + close.value + '&type=' + type.value + '&desc=' + desc.value;

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
                        {
                            sendtext += '&courses=0';
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
                                document.getElementById("scholarshipadded").innerHTML=xmlhttp.responseText;
                                }
                              }
                            xmlhttp.open("POST","request.php",true);
                            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                            xmlhttp.send(sendtext);
                            

                        document.getElementById("scholarshipform").style.visibility = 'hidden';
                        document.getElementById("successmessage2").style.visibility = 'visible';
                    }
                 }
              }
            xml.open("GET","request.php?check=" + document.getElementById('scholarshipname').value,true);
            xml.send();
        }
    });
}

function blink()
{
    $("#instr").animate({opacity:0},50,"linear",function(){
                $(this).animate({opacity:1},200);
            });
}

function blink2()
{
    $("#instr2").animate({opacity:0},50,"linear",function(){
                $(this).animate({opacity:1},200);
            });
}

function stop_blink(interval)
{
    window.clearInterval(interval);
}
