<!-- <div class="page-header">

    <div>

        <h1>
            Dashboard
        </h1>

        <p>
            Welcome back. Here's what's happening today.
        </p>

    </div>

</div>


<div class="card">

    <h2>
        Main Content
    </h2>

    <p>
        Put your page content here.
    </p>

</div> -->

</div>

</main>


<!-- =========================================================
         JAVASCRIPT
    ========================================================= -->

<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
    }

    menuBtn.addEventListener('click', toggleSidebar);

    overlay.addEventListener('click', closeSidebar);

    /*
     * Close mobile sidebar after clicking a link
     */
    document.querySelectorAll('.nav a').forEach(function (link) {

        link.addEventListener('click', function () {

            if (window.innerWidth <= 768) {
                closeSidebar();
            }

        });

    });
</script>

</body>

</html>