// public/js/menu.js
const checkboxes = document.querySelectorAll('.toggle-menu');

checkboxes.forEach(cb => {
    cb.addEventListener('change', function() {
        if (this.checked) {
            checkboxes.forEach(otherCb => {
                if (otherCb !== this) {
                    otherCb.checked = false;
                }
            });
        }
    });
});
