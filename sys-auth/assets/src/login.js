function __(s) {
    if (typeof translations[s] === 'undefined') {
        return s;
    }
    return translations[s];
}

var i_username = getElement('i_username'),
    i_password = getElement('i_password'),
    i_remember = getElement('i_remember');

(() => {
    setTimeout(() => {
        i_username.focus();
    }, 300);
    if (localStorage.lgd_remember_username) {
        if (localStorage.lgd_remember_username == 'null') {
            localStorage.removeItem('lgd_remember_username');
            return;
        }
        i_username.value = localStorage.lgd_remember_username;
        setTimeout(() => {
            i_remember.checked = true;
            i_password.focus();
            i_password.parentNode.classList.add("focused");
        }, 500);
    }
})();

function handleSubmit() {
    let submit = true;

    if (/^[a-zA-Z0-9]{1,6}_[0-9]{8}$/.test(i_username.value)) {
        checkPassed(i_username);
    } else {
        hasError(i_username, __("Username is not valid"));
        submit = false;
    }

    if (i_password.value.length >= 6) {
        checkPassed(i_password);
    } else {
        if (i_password.value.length == 0) {
            hasError(i_password, __("Password cannot be empty"));
        } else {
            hasError(i_password, __("Password is too short"));
        }
        submit = false;
    }

    if (submit && i_remember.checked) {
        localStorage.lgd_remember_username = i_username.value;
    }

    return submit;
}