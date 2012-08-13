var maxHeight = 750;

function imposeMaxLength(Object, MaxLen)
{
  return (Object.value.length <= MaxLen);
}

//Function for selecting every checkbox in a list
function select_all()
{
    document.getElementById('newenable').style.background = 'darkcyan';
    document.getElementById('newenable').disabled = false;
    document.getElementById('newenable3').style.background = 'darkcyan';
    document.getElementById('newenable3').disabled = false;
    var boxes = document.getElementsByTagName('input');
    
    for(i = 0; i<boxes.length; i++)
    {
        if(boxes[i].type == 'checkbox')
            boxes[i].checked = true;
    }
}

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

//Function for adding another scholarship
function add_again()
{
    document.getElementById("scholarshipname").value = '';
    document.getElementById("scholarshipamount").value = '';
    document.getElementById("scholarshipvalue").value = '';
    document.getElementById("DPC_date1").value = '';
    document.getElementById("DPC_date2").value = '';
    document.getElementById("scholarshiptype").value = '';
    document.getElementById("scholarshipdescription").value = '';
    document.getElementById("successmessage2").style.visibility = 'hidden';
    document.getElementById("newscholarship").style.visibility = 'visible';
    document.getElementById("hide").style.visibility = 'visible';
    document.getElementById("programbutton").style.background = 'slategray';
    document.getElementById("addcoursebutton").style.background = 'slategray';
    document.getElementById("removebutton").style.background = 'slategray';
    clear_all();
}


$(document).ready(function(){
    //End of year tool - continue button
    $("#toolcontinue").click(function(){
        if(document.getElementById("toolcontinue").style.color !== 'rgb(71, 71, 71)')
        {
            document.getElementById("endofyear").style.display = "none";
            document.getElementById("endofyear2").style.display = "block";
        }
    });
    
    //initialize datepicker plugin
    $( ".datepicker" ).datepicker();
    
    //menu drops when you hover over "year of study"
    $("#selectyear").hover(function(){
        $("#list").slideDown();
    },
    function(){
        $("#list").css('display', 'none');
    });

    //make initial page elemnts visible if modal is closed
    $(".close").click(function(){
        window.location = $("#modal").attr('accept') + "/blocks/scholarship/admin/adminview.php";
    });

    //Enable user to press enter instead of clicking continue when creating new course
    $("#coursename1").keydown(function(e){
        if(e.keyCode == 13)
        {
            e.preventDefault();
            new_course();
        }
    });

    //exits end of year tool when user presses 'no'
    $("#toolno").click(function(){
        document.getElementById("checkinfo").checked = false;
        document.getElementById('toolcontinue').style.border = '1px grey solid';
        document.getElementById('greyinfo').style.backgroundColor = 'black';
        document.getElementById('greyschol').style.backgroundColor = 'black';
        document.getElementById('greycourse').style.backgroundColor = 'black'; 
        document.getElementById('greyschol').style.color = '#474747';
        document.getElementById('greycourse').style.color = '#474747';
        document.getElementById('greyschol').style.border = '1px grey solid';
        document.getElementById('greycourse').style.border = '1px grey solid';
        document.getElementById('toolcontinue').style.color = '#474747';
        document.getElementById('toolcontinue').disabled = true;
        ;
        document.getElementById('checkschol').disabled = true;
        document.getElementById('checkcourse').disabled = true;
        document.getElementById('checkschol').checked = false;
        document.getElementById('checkcourse').checked = false;
        $("#endofyear").slideUp();
        $("#endofyear2").slideUp();
        document.getElementById("tooltext").style.visibility = 'visible';
        document.getElementById("hidetool").style.visibility = 'hidden';
        document.getElementById("deleteallcourses").checked = false;
    });

    //cancel button for course change in edit
    $("#cancel").click(function(){
        document.getElementById("changecourses").style.visibility = 'hidden';
        show_info($('a.list[value =' + $('p[name = scholname]').attr('id') + ']'));
    });
    
    //cancel button for adding extra documents in edit
    $("#cancelextradoc").click(function(){
        document.getElementById("adddocumentsedit").style.visibility = 'hidden';
        document.getElementById("changedocs").style.visibility = 'visible';
        document.getElementById("docnum2").innerHTML = 'Document 1';
    });
    
    //Exits out of scholarship editor when user presses large red tab
    $("#returntomenu").click(function(){
        document.getElementById('editing').style.color = 'gray';
        document.getElementById("block").style.visibility = 'hidden';
        document.getElementById('notice').style.visibility = 'visible';
        document.getElementById('det').style.visibility = 'visible';
        document.getElementById('aconfirm').style.visibility = 'hidden';
        document.getElementById('sconfirm').style.visibility = 'hidden';
        document.getElementById("returntomenu").style.display = 'none';
        document.getElementById("sbys").style.visibility = 'hidden';
        document.getElementById("changedocs").style.visibility = 'hidden';
        document.getElementById("scholarshiplist").style.visibility = 'hidden';
        document.getElementById("confirm2").style.visibility = 'hidden';
        document.getElementById("changecourses").style.visibility = 'hidden';
        document.getElementById("scholarshipinfo").style.visibility = 'hidden';
        document.getElementById("successmessage4").style.visibility = 'hidden';
        document.getElementById("editscholarship").style.visibility = 'hidden';
        document.getElementById("successmessage6").style.visibility = 'hidden';
        document.getElementById("adddocumentsedit").style.visibility = 'hidden';
        document.getElementById("studdocs").style.visibility = 'hidden';
        document.getElementById("programbutton").style.background = 'darkcyan';
        document.getElementById("addcoursebutton").style.background = 'steelblue';
        document.getElementById("newscholarshipbutton").style.background = 'steelblue';
        document.getElementById("removebutton").style.background = 'steelblue';
        clear_all();
    });
    
    //Enables or disables continue button depending on whether or not any courses have been selected (When creating scholarship)
    $('input[class = checkbox7]').click(function(){
        var enable = false;
        
        $('input').each(function(){
            if((this.checked == true) && (this.className == 'checkbox7'))
                enable = true;
        });
        
        if(enable == true)
        {
            document.getElementById('newenable').disabled = false;
            document.getElementById('newenable').style.background = 'darkcyan';
        }
        else
        {
            document.getElementById('newenable').disabled = true;
            document.getElementById('newenable').style.background = 'darkslategray';
        }
    });
    
    //Enables or disables continue button depending on whether or not any courses have been selected (When removing courses)
    $('input[class = checkbox2]').click(function(){
        var boxes = document.getElementsByTagName('input');
        var enable = false;
        for(i = 0; i<boxes.length; i++)
        {
            if((boxes[i].checked == true) && (boxes[i].className = 'checkbox2'))
            {
                enable = true;
            }
        }
        if(enable == true)
        {
            document.getElementById('removeenable').disabled = false;
            document.getElementById('removeenable').style.background = 'darkcyan';
        }
        else
        {
            document.getElementById('removeenable').disabled = true;
            document.getElementById('removeenable').style.background = 'darkslategray';
        }
    });
    
    $('input[class = checkbox5]').click(function(){
        var boxes = document.getElementsByTagName('input');
        var enable = false;
        for(i = 0; i<boxes.length; i++)
        {
            if((boxes[i].checked == true) && (boxes[i].className = 'checkbox5'))
            {
                enable = true;
            }
        }
        if(enable == true)
        {
            document.getElementById('newenable3').disabled = false;
            document.getElementById('newenable3').style.background = 'darkcyan';
        }
        else
        {
            document.getElementById('newenable3').disabled = true;
            document.getElementById('newenable3').style.background = 'darkslategray';
        }
    });
    
    $('input[class = endcheck]').click(function(){
        var boxes = document.getElementsByTagName('input');
        var enable = false;
        for(i = 0; i<boxes.length; i++)
        {
            if((boxes[i].checked == true) && (boxes[i].className = 'endcheck'))
            {
                enable = true;
            }
        }
        if(enable)
        {
            document.getElementById('toolcontinue').disabled = false;
            document.getElementById('toolcontinue').style.color = 'white';
        }
        else
        {
            document.getElementById('toolcontinue').disabled = true;
            document.getElementById('toolcontinue').style.color = 'grey';
        }
    });
    
    $('#checkinfo').click(function(){
        if(document.getElementById('checkinfo').checked)
        {
            document.getElementById('greyinfo').style.backgroundColor = 'grey'; 
            document.getElementById('greyschol').style.color = 'white';
            document.getElementById('checkschol').disabled = false;
            document.getElementById('toolcontinue').disabled = false;
            document.getElementById('greyschol').style.border = '1px white solid';
            document.getElementById('toolcontinue').style.border = '1px white solid';
        }
        else
        {
            document.getElementById('toolcontinue').style.border = '1px grey solid';
            document.getElementById('greyinfo').style.backgroundColor = 'black';
            document.getElementById('greyschol').style.backgroundColor = 'black';
            document.getElementById('greycourse').style.backgroundColor = 'black'; 
            document.getElementById('greyschol').style.color = '#474747';
            document.getElementById('greycourse').style.color = '#474747';
            document.getElementById('greyschol').style.border = '1px grey solid';
            document.getElementById('greycourse').style.border = '1px grey solid';
            document.getElementById('toolcontinue').style.color = '#474747';
            document.getElementById('toolcontinue').disabled = true;
            document.getElementById('checkschol').disabled = true;
            document.getElementById('checkcourse').disabled = true;
            document.getElementById('checkschol').checked = false;
            document.getElementById('checkcourse').checked = false;
        }
    });
    
    $('#checkschol').click(function(){
        if(document.getElementById('checkschol').checked)
        {
            document.getElementById('greyschol').style.backgroundColor = 'grey';
            document.getElementById('greycourse').style.color = 'white';
            document.getElementById('checkcourse').disabled = false;
            document.getElementById('greycourse').style.border = '1px white solid';
        }
        else
        {
            document.getElementById('greyschol').style.backgroundColor = 'black';
            document.getElementById('greycourse').style.backgroundColor = 'black';
            document.getElementById('greyschol').style.border = '1px grey solid';
            document.getElementById('greycourse').style.border = '1px grey solid';
            document.getElementById('greycourse').style.color = '#474747';
            document.getElementById('checkcourse').disabled = true;
            document.getElementById('checkcourse').checked = false;
        }
    });
    
    $('#checkcourse').click(function(){
        if(document.getElementById('checkcourse').checked)
        {
            document.getElementById('greycourse').style.backgroundColor = 'grey';
        }
        else
        {
            document.getElementById('greycourse').style.backgroundColor = 'black'; 
        }
    });
    
    $("#toolcontinue").hover(function(){
        if(document.getElementById('toolcontinue').style.color !== 'rgb(71, 71, 71)')
        {
            document.getElementById('toolcontinue').style.backgroundColor = 'white';
            document.getElementById('toolcontinue').style.color = 'black';
        }
    },function(){
        if(document.getElementById('toolcontinue').style.color !== 'rgb(71, 71, 71)')
        {
            document.getElementById('toolcontinue').style.backgroundColor = 'black';
            document.getElementById('toolcontinue').style.color = 'white';
        }
    });
    
    if(navigator.appName == 'Microsoft Internet Explorer')
    {
        document.getElementById('greyinfo').style.setAttribute("paddingTop", 23 + "px");
        document.getElementById('greycourse').style.setAttribute("paddingTop", 23 + "px");
        document.getElementById('greyinfo').style.setAttribute("paddingBottom", 23 + "px");
        $("textarea").each(function(){
            this.cols = 39;
        });
    }
    
    if (BrowserDetect.browser == "Firefox")
    {
        $("textarea").each(function(){
            this.cols = 32;
        });
    }
    
    //Disables/Enables other tabs when new scholarship tab is clicked
    $("#newscholarshipbutton").click(function(){
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
        {
            document.getElementById('notice').style.visibility = 'hidden';
            document.getElementById('det').style.visibility = 'hidden';
            document.getElementById("newscholarship").style.visibility = 'visible';
            document.getElementById("hide").style.visibility = 'visible';
            document.getElementById("programbutton").style.background = 'slategray';
            document.getElementById("addcoursebutton").style.background = 'slategray';
            document.getElementById("removebutton").style.background = 'slategray';
        }
        else if(document.getElementById("scholarshipform").style.visibility == 'visible')
        {
            document.getElementById("scholarshipname").value = "";
            document.getElementById("scholarshipamount").value = "";
            document.getElementById("scholarshipvalue").value = "";
            document.getElementById("DPC_date1").value = "";
            document.getElementById("DPC_date2").value = "";
            document.getElementById("scholarshipdescription").value = "";
            document.getElementById('notice').style.visibility = 'visible';
            document.getElementById('det').style.visibility = 'visible';
            document.getElementById("scholarshipform").style.visibility = 'hidden';
            document.getElementById("hide").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
            clear_all();
        }
        else if(document.getElementById("successmessage2").style.visibility == 'visible')
        {
            document.getElementById("scholarshipname").value = "";
            document.getElementById("scholarshipamount").value = "";
            document.getElementById("scholarshipvalue").value = "";
            document.getElementById("DPC_date1").value = "";
            document.getElementById("DPC_date2").value = "";
            document.getElementById("scholarshipdescription").value = "";
            document.getElementById('notice').style.visibility = 'visible';
            document.getElementById("successmessage2").style.visibility = 'hidden';
            document.getElementById("hide").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
            clear_all();
        }
        else if (document.getElementById("adddocuments").style.visibility == 'visible')
        {
            document.getElementById("adddocuments").style.visibility = 'hidden';
            document.getElementById("scholarshipname").value = "";
            document.getElementById("scholarshipamount").value = "";
            document.getElementById("scholarshipvalue").value = "";
            document.getElementById("DPC_date1").value = "";
            document.getElementById("DPC_date2").value = "";
            document.getElementById("docname").value = "";
            document.getElementById("docdesc").value = "";
            document.getElementById("scholarshipdescription").value = "";
            document.getElementById('notice').style.visibility = 'visible';
            document.getElementById("hide").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
            clear_all();
        }
        else if(document.getElementById("newscholarship").style.visibility == 'visible')
        {
            document.getElementById('notice').style.visibility = 'visible';
            document.getElementById('det').style.visibility = 'visible';
            document.getElementById("newscholarship").style.visibility = 'hidden';
            document.getElementById("hide").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
            clear_all();
        }
    });
    
    //Disables/Enables other tabs when add course tab is clicked
    $("#addcoursebutton").click(function(){
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
        {
            document.getElementById('notice').style.visibility = 'hidden';
            document.getElementById('det').style.visibility = 'hidden';
            document.getElementById("hidecourseform").style.visibility = 'visible';
            document.getElementById("hide2").style.visibility = 'visible';
            document.getElementById("programbutton").style.background = 'slategray';
            document.getElementById("newscholarshipbutton").style.background = 'slategray';
            document.getElementById("removebutton").style.background = 'slategray';
            document.getElementById("coursename1").focus();
        }
        else if(document.getElementById("hidecourseform").style.visibility == 'visible')
        {
            document.getElementById('notice').style.visibility = 'visible';
            document.getElementById('det').style.visibility = 'visible';
            document.getElementById("hidecourseform").style.visibility = 'hidden';
            document.getElementById("hide2").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("newscholarshipbutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
        }
    });

    //Disables/Enables other tabs when remove course tab is clicked
    $("#removebutton").click(function(){
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
        {
            document.getElementById('notice').style.visibility = 'hidden';
            document.getElementById('det').style.visibility = 'hidden';
            document.getElementById("successmessage3").innerHTML = "";
            document.getElementById("confirmbutton").disabled = false;
            document.getElementById("removecourse").style.visibility = 'visible';
            document.getElementById("hide3").style.visibility = 'visible';
            document.getElementById("programbutton").style.background = 'slategray';
            document.getElementById("newscholarshipbutton").style.background = 'slategray';
            document.getElementById("addcoursebutton").style.background = 'slategray';
        }
        else if(document.getElementById("confirm").style.visibility == 'visible')
        {
            document.getElementById('notice').style.visibility = 'visible';
            document.getElementById('det').style.visibility = 'visible';
            document.getElementById("confirm").style.visibility = 'hidden';
            document.getElementById("removecourse").style.visibility = 'hidden';
            document.getElementById("hide3").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("newscholarshipbutton").style.background = 'steelblue';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            clear_all();
        }
        else if(document.getElementById("removecourse").style.visibility == 'visible')
        {
            document.getElementById('notice').style.visibility = 'visible';
            document.getElementById('det').style.visibility = 'visible';
            document.getElementById("removecourse").style.visibility = 'hidden';
            document.getElementById("hide3").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("newscholarshipbutton").style.background = 'steelblue';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            clear_all();
        }
    });

    //Shows/Hides end of year tool
    $("#endtool").click(function(){
        if((document.getElementById("endofyear").style.display == 'none') && (document.getElementById("endofyear2").style.display == 'none'))
        {
            $("#endofyear").slideDown('slow');
            document.getElementById("tooltext").style.visibility = 'hidden';
            document.getElementById("hidetool").style.visibility = 'visible'; 
        }
        else
        {
            document.getElementById("checkinfo").checked = false;
            document.getElementById('toolcontinue').style.border = '1px grey solid';
            document.getElementById('greyinfo').style.backgroundColor = 'black';
            document.getElementById('greyschol').style.backgroundColor = 'black';
            document.getElementById('greycourse').style.backgroundColor = 'black'; 
            document.getElementById('greyschol').style.color = '#474747';
            document.getElementById('greycourse').style.color = '#474747';
            document.getElementById('greyschol').style.border = '1px grey solid';
            document.getElementById('greycourse').style.border = '1px grey solid';
            document.getElementById('toolcontinue').style.color = '#474747';
            document.getElementById('toolcontinue').disabled = true;
            ;
            document.getElementById('checkschol').disabled = true;
            document.getElementById('checkcourse').disabled = true;
            document.getElementById('checkschol').checked = false;
            document.getElementById('checkcourse').checked = false;
            $("#endofyear").slideUp();
            $("#endofyear2").slideUp();
            document.getElementById("tooltext").style.visibility = 'visible';
            document.getElementById("hidetool").style.visibility = 'hidden';
            document.getElementById("deleteallcourses").checked = false;
        }
    });
    
    //functions for sliding program list
    $(".dropdown > li.program").hover(function() {
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hide2").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && (document.getElementById("adddocuments").style.visibility == 'hidden'))
        {
            document.getElementById("newscholarshipbutton").style.background = 'slategray';
            document.getElementById("addcoursebutton").style.background = 'slategray';
            document.getElementById("removebutton").style.background = 'slategray';
            document.getElementById("programbutton").style.background = 'darkslategray';

            var $container = $(this),
            $list = $container.find("ul"),
            $anchor = $container.find("a"),
            height = $list.height(),       // make sure there is enough room at the bottom
            multiplier = height / maxHeight;     // needs to move faster if list is taller

            document.getElementById("block").style.visibility = 'visible';

            // need to save height here so it can revert on mouseout            
            $container.data("origHeight", $container.height());

            // so it can retain it's rollover color all the while the dropdown is open
            $anchor.addClass("hover");

            // make sure dropdown appears directly below parent list item    
            $list
            .slideDown()
            .css({
                paddingTop: 60
            });

            // don't do any animation if list shorter than max
            if (height > 650) {
                $container
                .css({
                    height: maxHeight,
                    overflow: "hidden",
                    width: 300
                })
                .mousemove(function(e) {
                    var offset = $container.offset();
                    var relativeY = ((e.pageY - offset.top) * multiplier) - ($container.data("origHeight") * multiplier);
                    if (relativeY > $container.data("origHeight")) {
                        $list.css("top", -relativeY + $container.data("origHeight"));
                    };
                });
            }
        }
    }, function() {
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hide2").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && $("#submenu").is(":visible") && (document.getElementById("scholarshiplist").style.visibility == 'hidden'))
        {
            document.getElementById("newscholarshipbutton").style.background = 'steelblue';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
            document.getElementById("programbutton").style.background = 'darkcyan';
        }
        if(document.getElementById("returntomenu").style.display == 'none')
            document.getElementById("block").style.visibility = 'hidden';
        var $el = $(this);

        // put things back to normal
        $el
        .height(73)
        .find("ul")
        .css({
            top: 0
        })
        .hide()
        .end()
        .find("a")
        .removeClass("hover");
    });

    // Add down arrow only to menu items with submenus
    $(".dropdown > li:has('ul')").each(function() {
        $(this).find("a:first").append("<img src='down-arrow.png' />");
    });
    
    //
    //
    //These hover functions cannot just be css because they must be disabled when a particular tab has been clicked
    //
    //
    $("#newscholarshipbutton").hover(function() {
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
            document.getElementById("newscholarshipbutton").style.background = 'midnightblue';
    },
    function(){
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
            document.getElementById("newscholarshipbutton").style.background = 'steelblue';
    });
    
    
    $("#addcoursebutton").hover(function() {
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
            document.getElementById("addcoursebutton").style.background = 'midnightblue';
    },
    function(){
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
            document.getElementById("addcoursebutton").style.background = 'steelblue';
    });
    
    
    $("#removebutton").hover(function() {
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
            document.getElementById("removebutton").style.background = 'midnightblue';
    },
    function(){
        color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
            document.getElementById("removebutton").style.background = 'steelblue';
    });
    
    $("#newenable").hover(function(){
        document.getElementById('newenable').style.background = 'darkslategray';
    },
    function(){
        if(document.getElementById('newenable').disabled == false)
            document.getElementById('newenable').style.background = 'darkcyan';
        else
            document.getElementById('newenable').style.background = 'darkslategray';
    });
    
    $("#cancel").hover(function(){
        document.getElementById('newenable').style.background = 'darkslategray';
    },
    function(){
        document.getElementById('newenable').style.background = 'darkcyan';
    });

    $("#newenable3").hover(function(){
        document.getElementById('newenable3').style.background = 'darkslategray';
    },
    function(){
        if(document.getElementById('newenable3').disabled == false)
            document.getElementById('newenable3').style.background = 'darkcyan';
        else
            document.getElementById('newenable3').style.background = 'darkslategray';
    });
    
    $("#removeenable").hover(function(){
        document.getElementById('removeenable').style.background = 'darkslategray';
    },
    function(){
        if(document.getElementById('removeenable').disabled == false)
            document.getElementById('removeenable').style.background = 'darkcyan';
        else
            document.getElementById('removeenable').style.background = 'darkslategray';
    });
    
    $("#newcourseenable").hover(function(){
        document.getElementById('newcourseenable').style.background = 'darkslategray';
    },
    function(){
        document.getElementById('newcourseenable').style.background = 'darkcyan';
    });
    
    $("#newenable2").hover(function(){
        document.getElementById('newenable2').style.background = 'darkslategray';
    },
    function(){
        document.getElementById('newenable2').style.background = 'darkcyan';
    });
    
    $("#endtool").hover(function(){
        document.getElementById("endtool").style.color = 'goldenrod';
    },
    function(){
        document.getElementById("endtool").style.color = 'white'; 
    });
    
    $("#toolyes").hover(function(){
        document.getElementById("toolyes").style.color = 'black';
        document.getElementById("toolyes").style.backgroundColor = 'white';
    },
    function(){
        document.getElementById("toolyes").style.color = 'white';
        document.getElementById("toolyes").style.backgroundColor = 'black';
    });
    
    $("#toolno").hover(function(){
        document.getElementById("toolno").style.color = 'black';
        document.getElementById("toolno").style.backgroundColor = 'white';
    },
    function(){
        document.getElementById("toolno").style.color = 'white';
        document.getElementById("toolno").style.backgroundColor = 'black';
    });
    
    $("#docenable").hover(function(){
        document.getElementById("docenable").style.backgroundColor = 'darkslategray'; 
    },
    function(){
        document.getElementById("docenable").style.backgroundColor = 'darkcyan'; 
    });
    
    $("#docenable2").hover(function(){
        document.getElementById("docenable2").style.backgroundColor = 'darkslategray'; 
    },
    function(){
        document.getElementById("docenable2").style.backgroundColor = 'darkcyan'; 
    });
    
    $("#docenableedit").hover(function(){
        document.getElementById("docenableedit").style.backgroundColor = 'darkslategray'; 
    },
    function(){
        document.getElementById("docenableedit").style.backgroundColor = 'darkcyan'; 
    });
    
    $("#appno").hover(function(){
        document.getElementById("appno").style.color = 'white';
        document.getElementById("appno").style.backgroundColor = 'black';
    },
    function(){
        document.getElementById("appno").style.color = 'black';
        document.getElementById("appno").style.backgroundColor = 'white';
    });
    
    $("#appyes").hover(function(){
        document.getElementById("appyes").style.color = 'white';
        document.getElementById("appyes").style.backgroundColor = 'black';
    },
    function(){
        document.getElementById("appyes").style.color = 'black';
        document.getElementById("appyes").style.backgroundColor = 'white';
    });
    
    $("#sbysappno").hover(function(){
        document.getElementById("sbysappno").style.color = 'white';
        document.getElementById("sbysappno").style.backgroundColor = 'black';
    },
    function(){
        document.getElementById("sbysappno").style.color = 'black';
        document.getElementById("sbysappno").style.backgroundColor = 'white';
    });
    
    $("#sbysappyes").hover(function(){
        document.getElementById("sbysappyes").style.color = 'white';
        document.getElementById("sbysappyes").style.backgroundColor = 'black';
    },
    function(){
        document.getElementById("sbysappyes").style.color = 'black';
        document.getElementById("sbysappyes").style.backgroundColor = 'white';
    });
    
    $("#hidetable").hover(function(){
        document.getElementById("hidetable").style.color = 'white';
        document.getElementById("hidetable").style.backgroundColor = 'gray';
    },
    function(){
        document.getElementById("hidetable").style.color = 'black';
        document.getElementById("hidetable").style.backgroundColor = 'white';
    });
    
    $("#mailtool").hover(function(){
        document.getElementById("mailtool").style.backgroundColor = '#272727';
    },
    function(){
        document.getElementById("mailtool").style.backgroundColor = 'dimgray';
    });
    
    $("#hidetable").click(function(){
        $("#details").slideUp('slow');
    });
});

var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();
        



