var myInput = document.getElementById("inputPassword");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalidpwd");
    letter.classList.add("validpwd");
  } else {
    letter.classList.remove("validpwd");
    letter.classList.add("invalidpwd");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalidpwd");
    capital.classList.add("validpwd");
  } else {
    capital.classList.remove("validpwd");
    capital.classList.add("invalidpwd");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalidpwd");
    number.classList.add("validpwd");
  } else {
    number.classList.remove("validpwd");
    number.classList.add("invalidpwd");
  }
  
  // Validate length
  if(myInput.value.length >= 6) {
    length.classList.remove("invalidpwd");
    length.classList.add("validpwd");
  } else {
    length.classList.remove("validpwd");
    length.classList.add("invalidpwd");
  }
}
