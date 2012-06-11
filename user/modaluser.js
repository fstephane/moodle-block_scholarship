$(document).ready(function() {
    
    document.getElementById("centered").style.visibility = 'visible';
    
if(window.location != $("#modal").attr('accept') + "/blocks/scholarship/user/userview.php?userid=" + $('form[name = year]').attr('id'))
    {
        document.getElementById("centered").style.visibility = 'hidden';
        //transition effect     
        $('#mask').fadeIn(1000);    
        $('#mask').fadeTo("slow",0.8);  

        //Set the popup window to center
        $('#dialog').css('top',  20);
        $('#dialog').css('left', 0);

        //transition effect
        $('#dialog').fadeIn(1000);
    }
 
    var winH = $(window).height();
    var winW = $(window).width();
    
    var list = $("#selectyear").find("ul");
    
    //Get the screen height and width
        var maskHeight = winH - 20,
            maskWidth = winW - 20;
            
            $("#centered").css({'top':(winH/2) - 300, 'left':(winW/2) - 200});
            
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
        $('#mask').css({'top':10, 'left':10});
    
    
    
    //select all the a tag with name equal to modal
    $('input[id=modal]').click(function(e) {
        //Cancel the link behavior
        e.preventDefault();
        window.location = $(this).attr('accept') + "/blocks/scholarship/user/userview.php?userid=" + $('form[name = year]').attr('id') + "&year=" + $(this).attr('alt');
        modal();
     });
     
    //if close button is clicked
    $('.window .close').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        $('#mask, .window').hide();
    });
    $(window).resize(function(){
    var winH = $(window).height();
    var winW = $(window).width();
    
    //Get the screen height and width
        var maskHeight = winH - 20,
            maskWidth = winW - 20;
            
            $("#centered").css({'top':(winH/2) - 300, 'left':(winW/2) - 200});
            
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
        $('#mask').css({'top':10, 'left':10});
    });
});