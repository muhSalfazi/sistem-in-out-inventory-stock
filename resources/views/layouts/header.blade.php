<style>
     #digital-clock {
        color: #7c7f80;
        /* Warna teks */
        font-size: 18px;
        /* Ukuran font */
        font-weight: 600;
        /* Tebal font */
        letter-spacing: 1px;
        /* Jarak antar huruf */
        font-family: 'Courier New', Courier, monospace;
        /* Font jam digital */
    }
</style>
<header class="app-header animate__animated animate__fadeInDown">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <!-- Uncomment this section if notifications are needed -->
            <!--
                <li class="nav-item">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                        <i class="ti ti-bell-ringing"></i>
                        <div class="notification bg-primary rounded-circle"></div>
                    </a>
                </li>
                -->
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                 <!-- Digital Clock -->
            <div id="digital-clock" class="ms-auto me-4"></div>
            <!-- End Digital Clock -->

              
            </ul>
        </div>
    </nav>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


<script>
    function updateClock() {
        const clock = document.getElementById('digital-clock');
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        clock.textContent = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateClock, 1000); // Update setiap detik
    updateClock(); // Inisialisasi
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.querySelector('.toggle-sidebar-btn');
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;

        toggleButton.addEventListener('click', function() {
            body.classList.toggle('sidebar-collapsed');
        });
    });
</script>