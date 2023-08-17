function determine(){
    var passfield = document.getElementById("pin");
    var showme = document.getElementById("show");
    var hide_it = document.getElementById("hide");

    if(passfield.type === 'password'){
        passfield.type = "text";
        showme.style.display = "block";
        hide_it.style.display = "none";

    }
    else{
        passfield.type = "password";
        showme.style.display = "none";
        hide_it.style.display = "block";

    }
}


        

        
        
