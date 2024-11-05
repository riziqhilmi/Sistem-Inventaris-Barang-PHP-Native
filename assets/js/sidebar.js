document.addEventListener("DOMContentLoaded", function () {
  const inventarisSubMenu = document.getElementById("inventarisSubMenu");
  const laporanSubMenu = document.getElementById("laporanSubMenu");

  // Fungsi untuk menutup semua submenu
  function closeAllSubMenus(except = null) {
    if (except !== inventarisSubMenu) {
      inventarisSubMenu.classList.remove("show");
      localStorage.setItem("inventarisSubMenu", "hide");
    }
    if (except !== laporanSubMenu) {
      laporanSubMenu.classList.remove("show");
      localStorage.setItem("laporanSubMenu", "hide");
    }
  }

  // Cek dan tambahkan kelas 'show' berdasarkan localStorage saat halaman dimuat
  if (localStorage.getItem("inventarisSubMenu") === "show") {
    inventarisSubMenu.classList.add("show");
  }

  if (localStorage.getItem("laporanSubMenu") === "show") {
    laporanSubMenu.classList.add("show");
  }

  // Event listener klik untuk submenu Inventaris
  document
    .querySelector('a[href="#inventarisSubMenu"]')
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah reload halaman
      if (!inventarisSubMenu.classList.contains("show")) {
        closeAllSubMenus(inventarisSubMenu); // Menutup semua submenu kecuali Inventaris
        inventarisSubMenu.classList.add("show");
        localStorage.setItem("inventarisSubMenu", "show");
      } else {
        inventarisSubMenu.classList.remove("show");
        localStorage.setItem("inventarisSubMenu", "hide");
      }
    });

  // Event listener klik untuk submenu Laporan
  document
    .querySelector('a[href="#laporanSubMenu"]')
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah reload halaman
      if (!laporanSubMenu.classList.contains("show")) {
        closeAllSubMenus(laporanSubMenu); // Menutup semua submenu kecuali Laporan
        laporanSubMenu.classList.add("show");
        localStorage.setItem("laporanSubMenu", "show");
      } else {
        laporanSubMenu.classList.remove("show");
        localStorage.setItem("laporanSubMenu", "hide");
      }
    });
});
