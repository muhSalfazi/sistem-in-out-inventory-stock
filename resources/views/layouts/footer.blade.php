<footer class="py-6 px-6 text-center animate-fade-in">
    <p class="mb-0 fs-4">&copy2024|Design and Developed by
        <a href="" rel="noopener noreferrer" target="_blank"
            class="pe-1 text-primary animate-hover">M.Salman Fauzi | Ubp Karawang</a>
    </p>
</footer>

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/js/dashboard.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil elemen tabel
        var table = document.querySelector('.datatable');

        // Inisialisasi Simple DataTable
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>
