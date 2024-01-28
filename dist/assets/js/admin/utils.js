export function removeErrors(e) {
    const { target } = e;
    if (target.value) {
        target.classList.remove('is-invalid');
    }
}