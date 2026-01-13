const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

if (togglePassword && passwordInput) {
    togglePassword.addEventListener('mousedown', function(event) {
        event.preventDefault(); 
    }); // Mencegah input password kehilangan fokus saat ikon diklik

    togglePassword.addEventListener('click', function() {
        const caretPosition = passwordInput.selectionStart;
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type); // Menampilkan password

        setTimeout(() => {
        passwordInput.selectionStart = caretPosition;
        passwordInput.selectionEnd = caretPosition;
        passwordInput.focus(); 
        }, 0); // Memposisikan caret

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash'); // Mengubah ikon mata
    });

    passwordInput.addEventListener('blur', function() {
        if (this.getAttribute('type') === 'text') {
            
            this.setAttribute('type', 'password');

            if (togglePassword.classList.contains('fa-eye-slash')) {
                togglePassword.classList.remove('fa-eye-slash');
                togglePassword.classList.add('fa-eye');
            }
        }
    }); // Menyembunyikan password saat sudah diisi
}

document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    if (username === 'Nuralam' && password === 'pedana123') {
        alert('Login Berhasil! Selamat datang di Pedana!');
        window.location.href = 'dashboard.html'; 
    } else {
        alert('Username atau Password salah. Silakan coba lagi.');
    }
}); // Memvalidasi username dan password