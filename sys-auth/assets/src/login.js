function getElement(e){
    return document.getElementById(e);
}

var i_username = getElement('input_username'),
    i_password = getElement('input_password'),
    i_remember = getElement('input_remember');

(() => {
    i_username.focus();
    if(localStorage.lgd_remember_username){
        i_username.value = localStorage.lgd_remember_username;
        i_password.focus();
        i_password.parentNode.classList.add("focused");
        i_remember.checked = true;
    }
})();

