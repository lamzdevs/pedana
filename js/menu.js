const links = document.querySelectorAll('.menu-link');
const sections = document.querySelectorAll('.content-section');
const checkboxes = document.querySelectorAll('.toggle-menu'); // semua checkbox menu utama

function activateSection(targetId) {
  sections.forEach(sec => sec.classList.remove('active'));
  links.forEach(l => l.classList.remove('active'));

  const section = document.getElementById(targetId);
  const link = document.querySelector(`.menu-link[data-target="${targetId}"]`);

  if (section) section.classList.add('active');
  if (link) link.classList.add('active');
}

// klik di semua link menu (termasuk submenu)
links.forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    const target = link.getAttribute('data-target');
    activateSection(target);

    // Tutup semua menu utama kecuali yang berisi link yang diklik
    checkboxes.forEach(cb => {
      const submenu = cb.nextElementSibling?.nextElementSibling;
      if (submenu && submenu.contains(link)) {
        cb.checked = true; // biarkan terbuka kalau link dari submenu ini
      } else {
        cb.checked = false; // tutup menu lain
      }
    });
  });
});

// klik langsung di label menu utama (biar menu lain tertutup juga)
document.querySelectorAll('.menu-label').forEach(label => {
  label.addEventListener('click', () => {
    const thisCheckbox = label.previousElementSibling;

    checkboxes.forEach(cb => {
      if (cb !== thisCheckbox) cb.checked = false; // tutup semua menu lain  
    });
  });
});

// pas halaman pertama kali dibuka, tampilan Dashboard & tutup semua submenu
document.addEventListener('DOMContentLoaded', () => {
  activateSection('dashboardSection');
  checkboxes.forEach(cb => cb.checked = false);
});
