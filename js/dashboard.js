document.addEventListener('DOMContentLoaded', () => {
    // SELEKTOR ELEMEN
    const msgIcon = document.getElementById('msgIcon');
    const bellIcon = document.getElementById('bellIcon');
    const msgDropdown = document.getElementById('msgDropdown');
    const bellDropdown = document.getElementById('bellDropdown');
    
    const msgModal = document.getElementById('messageModal');
    const notifModal = document.getElementById('notifModal');
    const writeModal = document.getElementById('writeMessageModal');
    
    const messageForm = document.getElementById('messageForm');

    // LOGIKA DROPDOWN (Pesan & Notifikasi)
    const toggleDropdown = (dropdownToToggle, dropdownToClose) => {
        dropdownToClose.classList.remove('show-dropdown');
        dropdownToToggle.classList.toggle('show-dropdown');
    };

    msgIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown(msgDropdown, bellDropdown);
    });

    bellIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown(bellDropdown, msgDropdown);
    });

    // Mencegah dropdown tertutup saat area dalamnya diklik
    [msgDropdown, bellDropdown].forEach(dropdown => {
        dropdown.addEventListener('click', (e) => e.stopPropagation());
    });


    // LOGIKA MODAL DETAIL (Pesan & Notifikasi)
    
    // Klik Pesan di Dropdown
    document.querySelectorAll('#msgDropdown .dropdown-list li').forEach(item => {
        item.addEventListener('click', function() {
            const sender = this.querySelector('strong').innerText;
            const content = this.querySelector('p').innerText;
            const time = this.querySelector('small').innerText;
            openMsg(sender, time, content);
        });
    });

    // Klik Notifikasi di Dropdown
    document.querySelectorAll('#bellDropdown .dropdown-list li').forEach(item => {
        item.addEventListener('click', function() {
            const text = this.querySelector('p').innerText;
            const time = this.querySelector('small').innerText;
            openNotif('Sistem Pedana', time, text);
        });
    });

    // Event listener untuk tombol Tutup Modal (X)
    document.getElementById('closeModal').onclick = () => msgModal.style.display = 'none';
    document.getElementById('closeNotifModal').onclick = () => notifModal.style.display = 'none';
    document.getElementById('closeWriteModal').onclick = () => writeModal.style.display = 'none';


    // FITUR TULIS & BALAS PESAN
    
    // Tombol Tulis Pesan Baru
    const btnNewMsg = document.querySelector('.btn-write-new');
    if (btnNewMsg) {
        btnNewMsg.addEventListener('click', (e) => {
            e.preventDefault();
            prepareWriteModal("Tulis Pesan Baru", "", false);
        });
    }

    // Tombol Balas di Modal Detail
    document.querySelector('.btn-reply').addEventListener('click', () => {
        const sender = document.getElementById('modalSender').innerText.replace("Dari: ", "");
        msgModal.style.display = 'none';
        prepareWriteModal("Balas Pesan", sender, true);
    });

    function prepareWriteModal(title, to, isReadOnly) {
        document.getElementById('writeModalTitle').innerText = title;
        document.getElementById('msgTo').value = to;
        document.getElementById('msgTo').readOnly = isReadOnly;
        document.getElementById('msgText').value = "";
        writeModal.style.display = 'flex';
        if (isReadOnly) document.getElementById('msgText').focus();
    }


    // LOGIKA NAVIGASI SPA (Lihat Semua)
    const handleViewAll = (selector, sectionId, dropdown) => {
        const btn = document.querySelector(selector);
        if (btn) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                if (typeof activateSection === "function") activateSection(sectionId);
                dropdown.classList.remove('show-dropdown');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    };

    handleViewAll('#msgDropdown .view-all', 'allMessagesSection', msgDropdown);
    handleViewAll('#bellDropdown .view-all', 'allNotificationsSection', bellDropdown);


    // GLOBAL CLICK HANDLER (Tutup Dropdown & Modal)
    window.addEventListener('click', (event) => {
        // Tutup Dropdown
        msgDropdown.classList.remove('show-dropdown');
        bellDropdown.classList.remove('show-dropdown');

        // Tutup Modal jika klik di area background (overlay)
        if (event.target === msgModal) msgModal.style.display = 'none';
        if (event.target === notifModal) notifModal.style.display = 'none';
        if (event.target === writeModal) writeModal.style.display = 'none';
    });


    // SIMULASI KIRIM PESAN
    if (messageForm) {
        messageForm.onsubmit = (e) => {
            e.preventDefault();
            const to = document.getElementById('msgTo').value;
            const btnSubmit = messageForm.querySelector('button[type="submit"]');

            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            btnSubmit.disabled = true;

            setTimeout(() => {
                alert(`Pesan berhasil dikirim ke ${to}!`);
                writeModal.style.display = 'none';
                messageForm.reset();
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim';
                btnSubmit.disabled = false;
            }, 1500);
        };
    }
});

// FUNGSI GLOBAL (Bisa dipanggil dari HTML)
function openMsg(sender, time, content) {
    document.getElementById('modalSender').innerText = "Dari: " + sender;
    document.getElementById('modalBody').innerText = content;
    document.getElementById('modalTime').innerText = "Dikirim pada: " + time;
    document.getElementById('messageModal').style.display = 'flex';
}

function openNotif(source, time, content) {
    document.getElementById('notifSource').innerText = "Sumber: " + source;
    document.getElementById('notifTime').innerText = "Waktu: " + time;
    document.getElementById('notifBody').innerText = content;
    document.getElementById('notifModal').style.display = 'flex';
}