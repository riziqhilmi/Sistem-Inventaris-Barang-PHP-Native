// Fungsi untuk menyimpan status submenu ke localStorage
function saveMenuState(menuId, state) {
  localStorage.setItem(menuId, state);
}

// Mengatur status submenu berdasarkan localStorage saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
  const inventarisSubMenu = document.getElementById("inventaris");
  const laporanSubMenu = document.getElementById("laporan");

  // Cek status dari localStorage dan tambahkan kelas 'show' jika seharusnya terbuka
  if (localStorage.getItem("inventaris") === "show") {
    inventarisSubMenu.classList.add("show");
  }
  if (localStorage.getItem("laporan") === "show") {
    laporanSubMenu.classList.add("show");
  }

  // Event listener untuk menyimpan status submenu Inventaris
  inventarisSubMenu.addEventListener("shown.bs.collapse", function () {
    saveMenuState("inventaris", "show");
  });
  inventarisSubMenu.addEventListener("hidden.bs.collapse", function () {
    saveMenuState("inventaris", "hide");
  });

  // Event listener untuk menyimpan status submenu Laporan
  laporanSubMenu.addEventListener("shown.bs.collapse", function () {
    saveMenuState("laporan", "show");
  });
  laporanSubMenu.addEventListener("hidden.bs.collapse", function () {
    saveMenuState("laporan", "hide");
  });
});
