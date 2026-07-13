/* ==========================================================================
   public/assets/js/script.js  (sumber: resources/js/script.js)
   --------------------------------------------------------------------------
   Pengganti seluruh logic React (useState/useEffect) yang sifatnya
   interaktif di sisi client. File ini akan terus bertambah setiap kali
   halaman baru (dashboard, modal, tab, dsb) selesai dikonversi.

   Pola konversi yang dipakai konsisten di seluruh project:
   - useState(x)              -> variabel biasa / dataset atribut HTML
   - useEffect(() => {...},[])-> document.addEventListener("DOMContentLoaded", fn)
   - onClick={fn}             -> element.addEventListener("click", fn)
   - conditional render (open && <Modal/>) -> classList.toggle("hidden")
   ========================================================================== */

document.addEventListener("DOMContentLoaded", function () {
  // Placeholder inisialisasi global. Setiap halaman yang butuh JS spesifik
  // akan menambahkan fungsinya sendiri di bagian bawah file ini dengan
  // komentar penanda "── HALAMAN: <nama> ──" supaya mudah ditelusuri.
});
