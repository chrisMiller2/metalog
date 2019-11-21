function passwordVisibility() {
    var pass = document.getElementById("pw");
    if(pass.type === "password"){
        pass.type = "text";
    }else{
        pass.type = "password";
    }
    var passConf = document.getElementById("pw2");
    if(passConf.type === "password"){
        passConf.type = "text";
    }else{
        passConf.type = "password";
    }
}