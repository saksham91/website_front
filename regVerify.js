var inputFields = document.theform.getElementsByTagName("input");
var myError = document.getElementById('formerror');

for (key in inputFields) {

  var myField = inputFields[key];

  myField.onchange = function() {

    var myPattern = validationInfo[this.name].pattern;
    var myPlaceholder = validationInfo[this.name].placeholder;
    var isValid = this.value.search(myPattern) >= 0;

    if (!(isValid)) {
      myError.innerHTML = "Input does not match expected pattern: " + myPlaceholder;
    } else { 
      myError.innerHTML = "";
    }
} 