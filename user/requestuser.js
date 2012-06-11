$('a[name = listoption]').click(function(){
    document.getElementById("scholind").style.visibility = 'visible';
    document.getElementById("scholarshiplist").style.visibility = 'visible';
    document.getElementById("scholarshipinfo").innerHTML = '';
    var year = document.getElementById("page-wrap").className;
    var option = $(this);
    $('#scholarshiplist').load("requestuser.php?year=" + year + "&list=" + option.attr('value'));
});

function show_info(el)
{
    document.getElementById("infoind").style.visibility = 'visible';
    $('#scholarshipinfo').load("requestuser.php?info=" + el.attr('value'));
}

function add_to_list(schol)
{
    $('#mylist').load("requestuser.php?mylist=" + schol + "&userid=" + $('form[name = year]').attr('id'));
}

function delete_selected(sid)
{
    $('#mylist').load("requestuser.php?delete=" + sid + "&userid=" + $('form[name = year]').attr('id'))
}

