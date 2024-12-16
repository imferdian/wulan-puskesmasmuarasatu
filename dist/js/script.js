function validate(val) {
    v1 = document.getElementById("nama");
    v2 = document.getElementById("nip");
    v3 = document.getElementById("golongan");
    v4 = document.getElementById("jabatan");
    v5 = document.getElementById("password");
    v6 = document.getElementById("password2");

    flag1 = true;
    flag2 = true;
    flag3 = true;
    flag4 = true;
    flag5 = true;
    flag6 = true;

    if(val>=1 || val==0) {
        if(v1.value == "") {
            v1.style.borderColor = "red";
            flag1 = false;
        }
        else {
            v1.style.borderColor = "green";
            flag1 = true;
        }
    }

    if(val>=2 || val==0) {
        if(v2.value == "") {
            v2.style.borderColor = "red";
            flag2 = false;
        }
        else {
            v2.style.borderColor = "green";
            flag2 = true;
        }
    }
    if(val>=3 || val==0) {
        if(v3.value == "") {
            v3.style.borderColor = "red";
            flag3 = false;
        }
        else {
            v3.style.borderColor = "green";
            flag3 = true;
        }
    }
    if(val>=4 || val==0) {
        if(v4.value == "") {
            v4.style.borderColor = "red";
            flag4 = false;
        }
        else {
            v4.style.borderColor = "green";
            flag4 = true;
        }
    }
    if(val>=5 || val==0) {
        if(v5.value == "") {
            v5.style.borderColor = "red";
            flag5 = false;
        }
        else {
            v5.style.borderColor = "green";
            flag5 = true;
        }
    }
    if(val>=6 || val==0) {
        if(v6.value == "") {
            v6.style.borderColor = "red";
            flag6 = false;
        }
        else {
            v6.style.borderColor = "green";
            flag6 = true;
        }
    }

    flag = flag1 && flag2 && flag3 && flag4 && flag5 && flag6;

    return flag;
}


const register = document.querySelector("#formRegister")

register.addEventListener("submit", function(e) {
    const pass = document.getElementById("password").value;
    const pass2 = document.getElementById("password2").value;
    // e.preventDefault();
    // console.log(pass.length);

    if(pass.length < 6){
        e.preventDefault(); // Batalkan submit
        Swal.fire({
            icon: 'error',
            toast: true,
            position: 'top',
            title: 'Registrasi Gagal',
            text: 'Password harus terdiri dari 6 karakter atau lebih',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        })
    }

    if(pass !== pass2){
        e.preventDefault(); // Batalkan submit
        Swal.fire({
            icon: 'error',
            toast: true,
            position: 'top',
            title: 'Registrasi Gagal',
            text: 'Konfirmasi Password Salah',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        })
    }
});
