var i_email = getElement("i_email"),
    i_password = getElement("i_password"),
    i_password_confirm = getElement("i_password_confirm"),
    i_domain_type_own = getElement("i_domain_type_own"),
    i_domain_type_sub = getElement("i_domain_type_sub"),
    i_custom_domain = getElement("i_custom_domain"),
    i_subdomain = getElement("i_subdomain"),
    i_extension = getElement("i_extension"),
    i_captcha_solution = getElement("i_captcha_solution"),
    s_processing = getElement("s_processing"),
    s_signup_form = getElement("s_signup_form"),
    s_custom_domain = getElement("s_custom_domain"),
    s_subdomain = getElement("s_subdomain"),
    s_others = getElement("s_others"),
    a_response = getElement("a_response");
(() => {
    setTimeout(() => {
        i_email.focus();
    }, 300);
})();

function updateDomainTypeView(e) {
    s_others.classList.remove("hidden");
    if (e.target.id == "i_domain_type_own") {
        s_custom_domain.classList.remove("hidden");
        s_subdomain.classList.add("hidden");
        i_custom_domain.focus();
    } else {
        s_subdomain.classList.remove("hidden");
        s_custom_domain.classList.add("hidden");
        i_subdomain.focus();
    }
}
document.querySelectorAll("input[name='domain_type']").forEach((input) => {
    input.addEventListener("change", updateDomainTypeView);
});

function checkSubdomainValidity() {
    let subdomain = i_subdomain.value;
    if (subdomain.length < 4 || subdomain.length > 16) {
        updateSubdomainInfo(
            __("Subdomain must be between 4 to 16 characters in length.")
        );
        return false;
    }
    if (subdomain[subdomain.length - 1] === "-") {
        updateSubdomainInfo(__("Hypens are not allowed at the end of subdomain."));
        return false;
    }
    if (!/^[A-Za-z0-9-]+$(?<!-)/.test(subdomain)) {
        updateSubdomainInfo(
            __("Only alphanumeric characters and hyphens are allowed.")
        );
        return false;
    }
    updateSubdomainInfo();
    return true;
}
function updateSubdomainInfo(contents = false) {
    if (contents && typeof contents === "string") {
        getElement(
            "infobox_subdomain"
        ).innerHTML = `<span style="color:red;">${contents}</span>`;
        return;
    }
    let subdomain = i_subdomain.value;
    getElement("infobox_subdomain").innerHTML =
        subdomain !== ""
            ? `${__("Your website will be available at")} <b>${subdomain}.${getElement("i_extension").value
            }</b>`
            : __("Choose a subdomain and extension");
}
i_subdomain.addEventListener("input", checkSubdomainValidity);
getElement("i_extension").addEventListener("change", updateSubdomainInfo);

function beforeSubmitCheck() {
    // Check Email
    if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(i_email.value).toLowerCase())) {
        checkPassed(i_email);
    } else {
        hasError(i_email, __("Please enter a valid email address."));
        return false;
    }

    // Check Password and confirm password
    if (i_password.value.length < 6 || i_password.value.length > 20) {
        // What if the password is purely spaces tho..?
        hasError(i_password, __("Password must be between 4 to 16 characters in length"));
        return false;
    }
    checkPassed(i_password);
    if (i_password.value !== i_password_confirm.value) {
        hasError(i_password_confirm, __("Passwords do not match. Please re-enter your password."));
        return false;
    }
    checkPassed(i_password_confirm);

    // Check domain OR subdomain
    let domain_type = document.querySelector(`[name="domain_type"]:checked`);
    if (!domain_type) {
        hasError(i_domain_type_sub, "Please select an option.");
        return false;
    }
    checkPassed(i_domain_type_sub);

    if (domain_type.value === "custom") {
        if (/^(?!:\/\/)([a-zA-Z0-9]+\.)?[a-zA-Z0-9][a-zA-Z0-9-]+\.[a-zA-Z]{2,6}?$/i.test(String(i_custom_domain.value).toLowerCase())) {
            checkPassed(i_custom_domain);
        } else {
            hasError(i_custom_domain, __("Please enter a valid domain name."));
            return false;
        }
    } else {
        if (!checkSubdomainValidity()) {
            hasError(i_subdomain, __("Please enter a valid subdomain name."));
            return false;
        }
        checkPassed(i_subdomain);
    }

    // Check Captcha
    if (i_captcha_solution.value.length !== 5) {
        hasError(i_captcha_solution, __("Please enter a captcha with 5 characters."));
        return false;
    }
    checkPassed(i_captcha_solution);

    return true;
}

function showAlert(message, type = 'danger') {
    a_response.innerText = message;
    a_response.classList.remove("alert-success", "alert-danger", "alert-warning");
    a_response.classList.add(`alert-${type}`);
    a_response.classList.remove("hidden");
}

function hideAlert() {
    a_response.classList.add("hidden");
}

function handleSubmit() {
    if (!beforeSubmitCheck()) {
        return false;
    }

    // Handle show/hide sections
    hideAlert();
    s_signup_form.classList.add("hidden");
    s_processing.classList.remove("hidden");

    // Submit data
    let data = new FormData(s_signup_form);
    fetch('/auth/api/signup', {
        method: "POST",
        body: data
    })
    .then(res => {
        if (res.status != 200) { 
            throw new Error("Bad Server Response"); 
        }
        return res.text();
    })
    .then(res => handleResponse(JSON.parse(res)))
    .catch(err => {
        showAlert(`Something went wrong, please try again later.\n${err}`);
    })
    .finally(res => {
        s_processing.classList.add("hidden");
    })
    return false;
}

function handleResponse(res) {
    if (res.status === 'error') {
        if (typeof res.message !== 'undefined') {
            showAlert(res.message);
        }
        if (typeof res.details !== 'undefined') {
            if (typeof res.details.field !== 'undefined') {
                hasError(getElement(`i_${res.details.field}`), res.message);
            }
        }
        s_signup_form.classList.remove("hidden");
    } else if (res.status === 'success') {

    }
}