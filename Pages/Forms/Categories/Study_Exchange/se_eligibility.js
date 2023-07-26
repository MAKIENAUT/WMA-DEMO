// FUNCTION FOR NAVBAR TRANSFROM RESPONSIVE LAYOUT
function myFunction() {
    var x = document.getElementById("myNavBar");
    if (x.className === "navbar") {
        x.className += " responsive";
        document.getElementById('section').style.marginTop = '200px';
    } else {
        x.className = "navbar";
        document.getElementById('section').style.marginTop = '0px';
    }
}

function validate() {
    const inputFields = [
        "lastname",
        "firstname",
        "address",
        "country",
        "phone_number",
        "email",
        "profession"
    ];

    let isFormValid = true;

    for (let i = 0; i < inputFields.length; i++) {
        const inputField = document.forms["myForm"][inputFields[i]];
        const nextInputField = document.forms["myForm"][inputFields[i + 1]];

        if (inputField.value === "") {
            inputField.style.border = "1px solid red";

            if (nextInputField) {
                nextInputField.style.border = "1px solid red";
            }

            isFormValid = false;
        } else {
            inputField.style.border = "none";
        }
    }

    const yesButton = document.getElementById("yes");
    const yesLabel = document.getElementById("yes_label");

    if (isFormValid) {
        window.personalInfo = true;
        yesButton.disabled = false;
        yesLabel.innerHTML = "YES!";
    } else {
        window.personalInfo = false;
        yesButton.disabled = true;
        document.getElementById("no").click();
        yesLabel.innerHTML = "YES - If unclickable, please check form.";
    }
}

// COMMANDS TO VALIDATE PROFESSION SELECTION
function showfield(profession){
    if(profession != 'Other'){
        document.getElementById('profession').style.width="100%";
        document.getElementById('div1').style.display="none";
        document.getElementById("other").value = "Other";
        
    } else {
        document.getElementById('profession').style.width="30%";
        document.getElementById('div1').style.display="block";
        document.getElementById("other").value = "";
        change()
        
    }
}

function change() {
    if (document.forms["myForm"]["other_option"].value == "") {
        document.getElementById("other").value = "";
        document.forms["myForm"]["profession"].style.border = "1px solid red";
        document.forms["myForm"]["other_option"].style.border = "1px solid red";
        validate();
        document.getElementById("yes").disabled = true;
        
    } else {
        document.forms["myForm"]["other_option"].style.border = "none";
        document.forms["myForm"]["profession"].style.border = "none";
        document.getElementById("other").value = "Profession/" + document.getElementById("other_option").value;
        validate();
    }
    
}


function termsAgree() {
    validate()
    if (document.getElementById("terms").checked === true && document.getElementById("yes").checked === true){
        console.log(1);
        window.terms = true
    } else {
        validate();
        window.terms = false;
    }
}

function fileChecker() {
    var i = document.forms["myForm"]["resume"];
    var j = document.forms["myForm"]["credential"];
    var k = document.forms["myForm"]["reference"];
    var l = document.forms["myForm"]["passport"];
    if (i.files.length == 1) {
        document.getElementById("resume_label").style.backgroundColor = "green";
    }else{
        document.getElementById("resume_label").style.backgroundColor = "red";
    }
    
    if (j.files.length == 1) {
        document.getElementById("credential_label").style.backgroundColor = "green";
    }else{
        document.getElementById("credential_label").style.backgroundColor = "rgb(214, 214, 214)";
    }

    if (k.files.length == 1) {
        document.getElementById("reference_label").style.backgroundColor = "green";
    }else{
        document.getElementById("reference_label").style.backgroundColor = "rgb(214, 214, 214)";
    }

    if (l.files.length == 1) {
        document.getElementById("passport_label").style.backgroundColor = "green";
    }else{
        document.getElementById("passport_label").style.backgroundColor = "red";
    }

    if (i.files.length == 1 && l.files.length == 1) {
        window.a = true
    } else {
        window.a = false
    }
}

function submitActivator() {
    validate()
    const myStyles = `
        padding: 10px;
        margin-top: 10px;
        color: black;
        border-radius: 8px;
        background-color: goldenrod;
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
        font-family: "Montserrat", sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
      `;
    if (window.a == true && window.terms == true && window.personalInfo == true) {
        document.getElementById("submit").disabled = false;
        document.getElementById("validity_check").innerHTML = "You're all set! :>"
        document.getElementById("submit").style = myStyles;
    } else {
        document.getElementById("submit").disabled = true;
        document.getElementById("validity_check").innerHTML = "If submit button is still disabled, Please check the form's validity!"
    }
}
