function updateDomainTypeView(e) {
    getElement('section_others').classList.remove("hidden");
    if (e.target.id == 'i_domain_type_own') {
        getElement('section_custom_domain').classList.remove("hidden");
        getElement('section_subdomain').classList.add("hidden");
        getElement('input_domain').focus();
    } else {
        getElement('section_subdomain').classList.remove("hidden");
        getElement('section_custom_domain').classList.add("hidden");
        getElement('input_subdomain').focus();
    }
}
document.querySelectorAll("input[name='i_domain_type']").forEach((input) => {
    input.addEventListener('change', updateDomainTypeView);
});

function updateSubdomainInfoboxText(e) {
    let subdomain = getElement('input_subdomain').value;
    getElement('infobox_subdomain').innerHTML = (subdomain !== '')
        ? `${__("Your website will be available at")} <b>${subdomain}.${getElement('input_extension').value}</b>`
        : __("Choose a subdomain and extension");
}
getElement('input_subdomain').addEventListener('input', updateSubdomainInfoboxText);
getElement('input_extension').addEventListener('change', updateSubdomainInfoboxText);

function handleSubmit() {
    
    return false;
}