var maxHeight = 750;
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

function add_again()
{
    document.getElementById("scholarshipname").value = '';
    document.getElementById("scholarshipamount").value = '';
    document.getElementById("scholarshipvalue").value = '';
    document.getElementById("scholarshipmultiple").checked = false;
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
    
    $("#selectyear").hover(function(){
            $("#list").css('visibility', 'visible');
        },
        function(){
            $("#list").css('visibility', 'hidden');
    });

    $(".close").click(function(){
        document.getElementById("centered").style.visibility = 'visible'; 
    });

    $("#coursename").keydown(function(e){
       if(e.keyCode == 13)
       {
           e.preventDefault();
           new_course();
       }
    });

    $("#toolno").click(function(){
        document.getElementById("endofyear").style.visibility = 'hidden';
        document.getElementById("tooltext").style.visibility = 'visible';
        document.getElementById("hidetool").style.visibility = 'hidden';
        document.getElementById("deleteallcourses").checked = false;
    });

    $("#cancel").click(function(){
        document.getElementById("changecourses").style.visibility = 'hidden';
        show_info($('p[name = scholname]').attr('id'));
    });
    
    $("#returntomenu").click(function(){
        document.getElementById("returntomenu").style.visibility = 'hidden';
        document.getElementById("scholarshiplist").style.visibility = 'hidden';
        document.getElementById("confirm2").style.visibility = 'hidden';
        document.getElementById("changecourses").style.visibility = 'hidden';
        document.getElementById("scholarshipinfo").style.visibility = 'hidden';
        document.getElementById("successmessage4").style.visibility = 'hidden';
        document.getElementById("editscholarship").style.visibility = 'hidden';
        document.getElementById("successmessage6").style.visibility = 'hidden';
        document.getElementById("programbutton").style.background = 'darkcyan';
        document.getElementById("addcoursebutton").style.background = 'steelblue';
        document.getElementById("newscholarshipbutton").style.background = 'steelblue';
        document.getElementById("removebutton").style.background = 'steelblue';
        clear_all();
    });
    
    $('input[class = checkbox7]').click(function(){
        var boxes = document.getElementsByTagName('input');
        var enable = false;
        for(i = 0; i<boxes.length; i++)
            {
                if((boxes[i].checked == true) && (boxes[i].className = 'checkbox7'))
                {
                    enable = true;
                }
            }
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
    
    $('input[class = checkbox3]').click(function(){
        var boxes = document.getElementsByTagName('input');
        var enable = false;
        for(i = 0; i<boxes.length; i++)
            {
                if((boxes[i].checked == true) && (boxes[i].className = 'checkbox3'))
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
    
    $("#newscholarshipbutton").click(function(){
            color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
        {
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
            document.getElementById("scholarshipmultiple").checked = false;
            document.getElementById("DPC_date1").value = "";
            document.getElementById("DPC_date2").value = "";
            document.getElementById("scholarshipdescription").value = "";
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
            document.getElementById("scholarshipmultiple").checked = false;
            document.getElementById("DPC_date1").value = "";
            document.getElementById("DPC_date2").value = "";
            document.getElementById("scholarshipdescription").value = "";
            document.getElementById("successmessage2").style.visibility = 'hidden';
            document.getElementById("hide").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
            clear_all();
        }
        else if(document.getElementById("newscholarship").style.visibility == 'visible')
        {
            document.getElementById("newscholarship").style.visibility = 'hidden';
            document.getElementById("hide").style.visibility = 'hidden';
            document.getElementById("programbutton").style.background = 'darkcyan';
            document.getElementById("addcoursebutton").style.background = 'steelblue';
            document.getElementById("removebutton").style.background = 'steelblue';
            clear_all();
        }
    });
        $("#addcoursebutton").click(function(){
            color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
        {
            document.getElementById("hidecourseform").style.visibility = 'visible';
            document.getElementById("hide2").style.visibility = 'visible';
            document.getElementById("programbutton").style.background = 'slategray';
            document.getElementById("newscholarshipbutton").style.background = 'slategray';
            document.getElementById("removebutton").style.background = 'slategray';
            document.getElementById("coursename").focus();
        }
        else if(document.getElementById("hidecourseform").style.visibility == 'visible')
            {
             document.getElementById("hidecourseform").style.visibility = 'hidden';
             document.getElementById("hide2").style.visibility = 'hidden';
             document.getElementById("programbutton").style.background = 'darkcyan';
             document.getElementById("newscholarshipbutton").style.background = 'steelblue';
             document.getElementById("removebutton").style.background = 'steelblue';
            }
        });
        
        $("#removebutton").click(function(){
            color = 'rgb(0, 139, 139)';
        if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hidecourseform").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden') && ($("#programbutton").css('backgroundColor') == color))
        {
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
             document.getElementById("removecourse").style.visibility = 'hidden';
             document.getElementById("hide3").style.visibility = 'hidden';
             document.getElementById("programbutton").style.background = 'darkcyan';
             document.getElementById("newscholarshipbutton").style.background = 'steelblue';
             document.getElementById("addcoursebutton").style.background = 'steelblue';
             clear_all();
        }
        });
    
        $("#endtool").click(function(){
            if(document.getElementById("endofyear").style.visibility == 'hidden')
            {
                document.getElementById("endofyear").style.visibility = 'visible';
                document.getElementById("tooltext").style.visibility = 'hidden';
                document.getElementById("hidetool").style.visibility = 'visible'; 
            }
            else
            {
                document.getElementById("endofyear").style.visibility = 'hidden';
                document.getElementById("tooltext").style.visibility = 'visible';
                document.getElementById("hidetool").style.visibility = 'hidden';
                document.getElementById("deleteallcourses").checked = false;
            }
        });
    
    $(".dropdown > li.program").hover(function() {
            if((document.getElementById("newscholarship").style.visibility == 'hidden') && (document.getElementById("hide2").style.visibility == 'hidden') && (document.getElementById("removecourse").style.visibility == 'hidden') && (document.getElementById("scholarshipform").style.visibility == 'hidden') && (document.getElementById("successmessage2").style.visibility == 'hidden') && (document.getElementById("confirm").style.visibility == 'hidden'))
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
                    .show()
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
        
        document.getElementById("block").style.visibility = 'hidden';
        var $el = $(this);

        // put things back to normal
        $el
            .height(73)
            .find("ul")
            .css({top: 0})
            .hide()
            .end()
            .find("a")
            .removeClass("hover");
    });

    // Add down arrow only to menu items with submenus
    $(".dropdown > li:has('ul')").each(function() {
        $(this).find("a:first").append("<img src='down-arrow.png' />");
    });
    
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
});
        



