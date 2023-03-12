var i_email = getElement('i_email'),
    i_password = getElement('i_password'),
    i_password_confirm = getElement('i_password_confirm'),
    i_domain_type_own = getElement('i_domain_type_own'),
    i_custom_domain = getElement('i_custom_domain'),
    i_subdomain = getElement('i_subdomain'),
    i_domain_type_sub = getElement('i_domain_type_sub'),
    s_custom_domain = getElement('s_custom_domain'),
    s_subdomain = getElement('s_subdomain'),
    s_others = getElement('s_others');
(() => {
    setTimeout(() => {
        i_email.focus();
    }, 300);
})();

function updateDomainTypeView(e) {
    s_others.classList.remove("hidden");
    if (e.target.id == 'i_domain_type_own') {
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
    input.addEventListener('change', updateDomainTypeView);
});

function checkSubdomainValidity() {
    let subdomain = i_subdomain.value;
    if (subdomain.length < 4 || subdomain.length > 16) {
        updateSubdomainInfo(__("Subdomain must be between 4 to 16 characters in length"));
        return false;
    }
    if (subdomain[subdomain.length - 1] === '-') {
        updateSubdomainInfo(__("Hypens are not allowed at the end of subdomain"));
        return false;
    }
    if (!/^[A-Za-z0-9-]+$(?<!-)/.test(subdomain)) {
        updateSubdomainInfo(__("Only alphanumeric characters and hyphens are allowed"));
        return false;
    }
    updateSubdomainInfo();
    return true;
}
function updateSubdomainInfo(contents = false) {
    if (contents && typeof contents === 'string') {
        getElement('infobox_subdomain').innerHTML = `<span style="color:red;">${contents}</span>`;
        return;
    }
    let subdomain = i_subdomain.value;
    getElement('infobox_subdomain').innerHTML = (subdomain !== '')
        ? `${__("Your website will be available at")} <b>${subdomain}.${getElement('i_extension').value}</b>`
        : __("Choose a subdomain and extension");
}
i_subdomain.addEventListener('input', checkSubdomainValidity);
getElement('i_extension').addEventListener('change', updateSubdomainInfo);

function handleSubmit() {

    return false;
}