const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".containerr");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});


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
      if(data.status === "success") {
        window.location.href = "dashboard.php";
      } else if(data.status == "error1" || data.status == "error2") {
        console.log(this.responseText); 
        alert(data.message);
      }
    }
  };
  xhttp.open('POST', 'reg2.php', true);
  xhttp.send(formData);
}

