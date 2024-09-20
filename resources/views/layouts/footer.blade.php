<footer class="py-6 px-6 text-center animate-fade-in">
    <p class="mb-0 fs-4">&copy;2024 Design &amp; Developed by
        <a href="https://muhsalfazi-profile.netlify.app/" 
           rel="noopener noreferrer" 
           target="_blank"
           class="pe-1 text-primary animate-hover">
           M.Salman Fauzi | Ubp Karawang
        </a>
    </p>
</footer>


<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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



<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

<style>
    footer {
        color: #ffffff;
        padding: 20px 0;
        position: relative;
        overflow: hidden;
    }

    footer p {
        margin: 0;
        padding: 0;
        font-family: 'Roboto', sans-serif;
        font-size: 18px;
        color: #adb5bd;
    }

    footer a {
        color: #ffdd57;
        text-decoration: none;
        transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        position: relative;
    }

    footer a::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #050C9C;
        visibility: hidden;
        transform: scaleX(0);
        transition: all 0.3s ease-in-out;
    }

    footer a:hover::after {
        visibility: visible;
        transform: scaleX(1);
    }

    footer a:hover {
        color: #ff6b6b;
        transform: translateY(-2px);
    }

    .animate-hover {
        position: relative;
        display: inline-block;
    }

    @keyframes hoverAnimation {
        from {
            transform: translateY(0);
        }

        to {
            transform: translateY(-5px);
        }
    }

    .animate-fade-in {
        animation: fadeIn 2s ease-in-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>