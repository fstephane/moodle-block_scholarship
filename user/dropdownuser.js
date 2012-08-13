var maxHeight = 750;

$(document).ready(function(){
    //Fix for IE9 bug where margin is off
    if(navigator.appName == 'Microsoft Internet Explorer')
    {
        document.getElementById("scholarshiplist").style.setAttribute("marginTop", -10 + "px");
        document.getElementById("mail").style.setAttribute("marginTop", -18 + "px");
        document.getElementById("scholarshipinfo").style.setAttribute("marginTop", -10 + "px");
        document.getElementById("mylist").style.setAttribute("marginTop", -18 + "px");
        document.getElementById("applydocs").style.setAttribute("marginTop", -18 + "px");
        document.getElementById("uploaddocs").style.setAttribute("marginTop", -18 + "px");
    }
        
    //Shows drop down menu when you hover over 'select year of study'
    $("#selectyear").hover(function(){
        $("#list").slideDown();
    },
    function(){
        $("#list").css('display', 'none');
    });
    
    //make initial page elemnts visible if modal is closed
    $(".close").click(function(){
        window.location = window.location = $("#modal").attr('accept') + "/blocks/scholarship/user/userview.php?userid=" + document.getElementById('scholarshiplist').className;
    });

    //Functions for sliding program list
    $(".dropdown > li.program").hover(function() {
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
    }, function() {
        
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
    
    $("#backtolist").click(function(){
        document.getElementById("applydocs").style.visibility = 'hidden';
        document.getElementById("mylist").style.visibility = 'visible';
    });
});
        



