function validateForm(form) {
    const dateRegex=/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/;
    const nameRegex = /^[A-Z][a-z]{2,30}$/;
    const genderRegex = /^M$|^F$/;

    if(!(document.forms["newEmployee"].birthDate.value).match(dateRegex))
    {
        document.getElementById("birthDate").style.borderColor = "red";
        document.getElementById("birthDate").focus();
        var targetSpan = document.getElementById("bdWarning");
        targetSpan.removeAttribute('hidden');
        return false;
    }
    if(!(document.forms["newEmployee"].firstName.value).match(nameRegex))
    {
        document.getElementById("firstName").style.borderColor = "red";
        document.getElementById("firstName").focus();
        var targetSpan = document.getElementById("fnWarning");
        targetSpan.removeAttribute('hidden');
        return false;
    }
    if(!(document.forms["newEmployee"].lastName.value).match(nameRegex))
    {
        document.getElementById("lastName").style.borderColor = "red";
        document.getElementById("lastName").focus();
        var targetSpan = document.getElementById("lnWarning");
        targetSpan.removeAttribute('hidden');
        return false;
    }
    if(!(document.forms["newEmployee"].gender.value).match(genderRegex))
    {
        document.getElementById("gender").style.borderColor = "red";
        document.getElementById("gender").focus();
        var targetSpan = document.getElementById("gWarning");
        targetSpan.removeAttribute('hidden');
        return false;
    }
    if(!(document.forms["newEmployee"].hireDate.value).match(dateRegex))
    {
        document.getElementById("hireDate").style.borderColor = "red";
        document.getElementById("hireDate").focus();
        var targetSpan = document.getElementById("hdWarning");
        targetSpan.removeAttribute('hidden');
        return false;
    }
    return true; // Submits form
}


function returnUsual(fieldID) {
    const dateRegex=/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/;
    const nameRegex = /^[A-Z][a-z]{2,30}$/;
    const genderRegex = /^M$|^F$/;

    var textbox = document.getElementById(fieldID);
    if((textbox.value).match(dateRegex) && fieldID == "birthDate")
    {
        textbox.style.borderColor = "initial";
        var targetSpan = document.getElementById("bdWarning");
        // targetSpan.style.visibility = "hidden";
        targetSpan.setAttribute("hidden", "");
    }

    if((textbox.value).match(nameRegex) && fieldID == "firstName")
    {
        textbox.style.borderColor = "initial";
        var targetSpan = document.getElementById("fnWarning");
        // targetSpan.style.visibility = "hidden";
        targetSpan.setAttribute("hidden", "");
    }
    if((textbox.value).match(nameRegex) && fieldID == "lastName")
    {
        textbox.style.borderColor = "initial";
        var targetSpan = document.getElementById("lnWarning");
        // targetSpan.style.visibility = "hidden";
        targetSpan.setAttribute("hidden", "");
    }
    if((textbox.value).match(genderRegex) && fieldID == "gender")
    {
        textbox.style.borderColor = "initial";
        var targetSpan = document.getElementById("gWarning");
        // targetSpan.style.visibility = "hidden";
        targetSpan.setAttribute("hidden", "");
    }
    if((textbox.value).match(dateRegex) && fieldID == "hireDate")
    {
        textbox.style.borderColor = "initial";
        var targetSpan = document.getElementById("hdWarning");
        // targetSpan.style.visibility = "hidden";
        targetSpan.setAttribute("hidden", "");
    }
}