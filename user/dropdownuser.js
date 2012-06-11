var maxHeight = 750;

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
});
        



