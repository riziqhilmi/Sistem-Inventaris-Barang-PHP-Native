const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".containerr");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

function reg() {
  let usr = document.getElementById('usr');
  let email = document.getElementById('email');
  let pass = document.getElementById('psw');
  let confirm_pass = document.getElementById('cpsw');
  if (usr.value == "") {
    alert('Isi dulu username');
    return;
  } else if (email.value == "") {
    alert('Isi dulu email') 
    return; 
  } else if (psw.value == ""){
    alert('Isi dulu password')
    return;
  } else if (cpsw.value == ""){
    alert('Isi dulu confirm password dulu')
    return;
  }

  let formData = new FormData();
  formData.append('usernamee', usr.value);
  formData.append('email', email.value);
  formData.append('passwordd', pass.value);
  formData.append('confirm_password', confirm_pass.value);

  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      let data = JSON.parse(this.responseText);
      if(data.status == "success") {
        alert('Pendaftaran Berhasil Silahkan Login!!!');
        document.getElementById('sign-in-btn').click();
        usr.value = "";
        email.value = "";
        pass.value = "";
        confirm_pass.value = "";
      } else if(data.status == 'error') {
        alert('Password dan Confirm Password tidak cocok!!!');
      }
    }
  };

  xhttp.open('POST', 'reg.php', true);
  xhttp.send(formData);
}
function loginn() {
  let user = document.getElementById('username');
  let passs = document.getElementById('login');
 
  if (user.value == "") {
    alert('Isi dulu username');
    return;
  } else if (login.value == "") {
    alert('Isi dulu password') 
    return; 
  }

  let formData = new FormData();
  formData.append('username', user.value);
  formData.append('password', passs.value);

  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      let data = JSON.parse(this.responseText);
      if(data.status == "success") {
        alert(data.message);
        window.location.href = "dashboard.php"
      } else if(data.status == "error1" || data.status == "error2") {
        alert(data.message);
      }
    }
  };
  xhttp.open('POST', 'reg2.php', true);
  xhttp.send(formData);
}

