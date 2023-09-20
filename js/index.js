function checksingin() {
  document.getElementById("massege").innerText = "الرجاء تسجيل الدخول اولا أو انشئ حساب";
}

function checkvalid(x,y){
  document.getElementById(x).style.display="block";
  document.getElementById(y).removeAttribute("class");
  document.getElementById(y).setAttribute("class","modal-content");
}
filterSelection("all")

function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("order-card");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    addClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) removeClass(x[i], "show");
  }
}

// Show filtered elements
function addClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {
      element.className += " " + arr2[i];
    }
  }
}

// Hide elements that are not selected
function removeClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);
    }
  }
  element.className = arr1.join(" ");
}

// Add active class to the current control button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}

//function for edit button in cpp/dpp page
function edit_func() {
  var profile = document.getElementById("profile").elements;
  for (var i = 2; i < profile.length; i++) {
    profile[i].removeAttribute("disabled");
  }
}

//"createAcc" page functions:

//Checking password function
function checkpass() {
  var pass = document.getElementById('password').value;
  var passconfirm = document.getElementById('confirm_password').value;

  if (pass == passconfirm) {
    document.getElementById('passmessage').innerHTML = null;

    if (pass == "" && passconfirm == "") {
      document.getElementById('passmsg').innerHTML = '*';
      document.getElementById('confmessage').innerHTML = '*';
    }
  } else {
    document.getElementById('passmsg').innerHTML = null;
    document.getElementById('confmessage').innerHTML = null;
    document.getElementById('passmessage').style.color = 'red';
    document.getElementById('passmessage').innerHTML = ' كلمة المرور غير متطابقة *';
  }
}


//Checking empty fields functions
function checkCard() {
  var exp = document.getElementById('card-exp').value;
  var cvc = document.getElementById('cvc').value;
  var c_name = document.getElementById('card-name').value;
  var c_number = document.getElementById('card-number').value;

  if (exp != "" && cvc != "" && c_name != "" && c_number != "") {
    document.getElementById('cardmsg').innerHTML = null;
  } else {
    document.getElementById('cardmsg').innerHTML = '*';
  }
}

function checkname() {
  var name = document.getElementById('username').value;

  if (name == "") {
    document.getElementById('usermsg').innerHTML = '*';
  } else {
    document.getElementById('usermsg').innerHTML = null;
  }
}

function checkId() {
  var id = document.getElementById('nationalId').value;
  if (id == "") {
    document.getElementById('idmsg').innerHTML = '*';
  } else {
    document.getElementById('idmsg').innerHTML = null;
  }
}

function checkPhone() {
  var phone = document.getElementById('phone-number').value;
  if (phone == "") {
    document.getElementById('phonemsg').innerHTML = '*';
  } else {
    document.getElementById('phonemsg').innerHTML = null;
  }
}

function checkemail() {
  var id = document.getElementById('email').value;
  if (id == "") {
    document.getElementById('emailmsg').innerHTML = '*';
  } else {
    document.getElementById('emailmsg').innerHTML = null;
  }
}

//Checking if the input is a number
function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
  return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

// Checking for ContactUs page

function checkCon() {

  var email = document.getElementById('email').value;
  var title = document.getElementById('title').value;
  var content = document.getElementById('content').value;

  if (email == "" || title == "" || content == "") {
    alert("رجاءًأدخل جميع الحقول");
    return false;
  } else {

    alert("تم أستلام رسالتك بنجاح");
    return true;
  }
}
function checkWhole(){
  var whole = document.getElementById('whole').value;
  if(whole>3000){
  document.getElementById('massege1').innerHTML="الرجاء ادخال مبلغ اقل من 3000";
  }
}
