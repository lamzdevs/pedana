const toggleBtn = document.querySelector('#togglePassword');
const password = document.querySelector('#passwordInput');
const eyeClosed = document.querySelector('#eyeClosed');
const eyeOpen = document.querySelector('#eyeOpen');

toggleBtn.style.display = 'none';

function checkInput() {
    if (password.value.length > 0) {
        toggleBtn.style.display = 'flex';
    } else {
        toggleBtn.style.display = 'none';
    }
}

password.addEventListener('input', checkInput);
password.addEventListener('focus', checkInput);
password.addEventListener('blur', function () {
    setTimeout(() => {
        if (document.activeElement !== toggleBtn) {
            toggleBtn.style.display = 'none';
        }
    }, 200);
});

toggleBtn.addEventListener('mousedown', function (e) {
    e.preventDefault(); 
});

toggleBtn.addEventListener('click', function (e) {
    e.preventDefault(); 

    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    if (type === 'password') {
        eyeClosed.style.display = 'block';
        eyeOpen.style.display = 'none';
    } else {
        eyeClosed.style.display = 'none';
        eyeOpen.style.display = 'block';
    }
    
    toggleBtn.style.display = 'flex';
    
    password.focus();
});