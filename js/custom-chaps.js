document.addEventListener('DOMContentLoaded', function () {
    console.log('Custom chaps form script loaded.');

    document.querySelectorAll('.tag-options').forEach(group => {
        const name = group.dataset.name;
        const inputContainer = document.getElementById(`${name}-inputs`);

        group.addEventListener('click', function (e) {
            if (!e.target.classList.contains('tag-option')) return;
            const tag = e.target;
            const value = tag.dataset.value;

            tag.classList.toggle('selected');

            const existing = inputContainer.querySelector(`input[value="${value}"]`);
            if (existing) {
                existing.remove();
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `${name}[]`;
                hiddenInput.value = value;
                inputContainer.appendChild(hiddenInput);
            }
        });
    });
});
