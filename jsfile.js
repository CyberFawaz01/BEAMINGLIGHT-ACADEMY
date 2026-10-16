 function togglePassword(){

    const passwordInput= document.getElementById('password');
    const iconPass = document.getElementById('icon');
    
    if(passwordInput.type==="password"){
        passwordInput.type="text";
        iconPass.classList.remove("fa-eye-slash");
        iconPass.classList.add('fa-eye');
    
    }
    else{
        passwordInput.type="password";
        iconPass.classList.remove("fa-eye");
        iconPass.classList.add("fa-eye-slash");
    }
    }
   
