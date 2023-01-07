function updateDomainTypeView(e) {
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