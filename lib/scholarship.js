

function emaildoc($email,$subject){
    
       document.location='mailto:'+$email+'?subject='+$subject;
}

function closeWindow() {
window.open('','_parent','');
window.close();
}


