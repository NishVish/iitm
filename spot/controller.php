<div style="margin-bottom: 7px; margin-left:45px;">
    <div style="display: flex; gap: 15px;">
        <!-- <div>
          <label for="topInput">Top</label><br>
          <input type="number" id="topInput" style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div>
          <label for="leftInput">Left</label><br>
          <input type="number" id="leftInput" style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
        </div> -->


        <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; font-family: sans-serif;">

            <!-- Up Button -->
            <button onclick="adjustPosition('up')"
                style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                ↑
            </button>

            <!-- Input Controls and Left/Right Buttons -->
            <div style="display: flex; align-items: center; gap: 20px;">

                <!-- Left Button -->
                <button onclick="adjustPosition('left')"
                    style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    ←
                </button>

                <!-- Inputs -->
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div>
                        <input type="number" id="topInput"
                            style="width: 80px; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <input type="number" id="leftInput"
                            style="width: 80px; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>

                <!-- Right Button -->
                <button onclick="adjustPosition('right')"
                    style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    →
                </button>
            </div>

            <div style="display: flex; gap: 20px;">
                <!-- Down Button -->


                <button onclick="increasefontsize()"
                    style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    2+
                </button>
                <button onclick="adjustPosition('down')"
                    style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    ↓
                </button>
                <button onclick="decresefontsize()"
                    style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    2-
                </button>


            </div>


            <script>
                // Restore saved font sizes when page loads
                window.addEventListener("load", function () {
                    const name = document.getElementById("nameEditable");
                    const company = document.getElementById("companyEditable");

                    const savedNameSize = localStorage.getItem("nameFontSize");
                    const savedCompanySize = localStorage.getItem("companyFontSize");

                    if (name && savedNameSize) {
                        name.style.fontSize = savedNameSize + "px";
                    }

                    if (company && savedCompanySize) {
                        company.style.fontSize = savedCompanySize + "px";
                    }
                });

                // NAME FONT
                function increasefontsize() {
                    const el = document.getElementById("nameEditable");
                    if (!el) return;

                    let size = parseInt(window.getComputedStyle(el).fontSize);
                    size += 2;

                    el.style.fontSize = size + "px";
                    localStorage.setItem("nameFontSize", size);
                }

                function decresefontsize() {
                    const el = document.getElementById("nameEditable");
                    if (!el) return;

                    let size = parseInt(window.getComputedStyle(el).fontSize);

                    if (size > 14) {
                        size -= 2;
                        el.style.fontSize = size + "px";
                        localStorage.setItem("nameFontSize", size);
                    }
                }

                // COMPANY FONT
                function increasefontsizecompany() {
                    const el = document.getElementById("companyEditable");
                    if (!el) return;

                    let size = parseInt(window.getComputedStyle(el).fontSize);
                    size += 2;

                    el.style.fontSize = size + "px";
                    localStorage.setItem("companyFontSize", size);
                }

                function decreasefontsizecompany() {
                    const el = document.getElementById("companyEditable");
                    if (!el) return;

                    let size = parseInt(window.getComputedStyle(el).fontSize);

                    if (size > 12) {
                        size -= 2;
                        el.style.fontSize = size + "px";
                        localStorage.setItem("companyFontSize", size);
                    }
                }
            </script>
            </script>
            <div style="display: flex; gap: 20px;">

                <button onclick="increasefontsizecompany()"
                    style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    2+
                </button>

                <button onclick="reset_position()"
                    style="padding: 8px 12px; background-color:rgb(100, 143, 223); color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                    ↻
                </button>
                <button onclick="decreasefontsizecompany()"
                    style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    2-
                </button>



            </div>
        </div>
    </div>
</div>

<!-- Mobile Search Form -->
<div style="margin-bottom: 10px;">
    <h3 style="margin-bottom: 10px; font-size: 16px; color: #333;">Search by Mobile</h3>
    <form method="POST" action="" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="mobile" placeholder="Enter mobile number" required
            style="flex: 1; min-width: 150px; padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit"
            style="padding: 6px 10px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Search</button>
    </form>
</div>
<?php include('options.php') ?>



<!-- Print Button -->
<div style="display: flex; gap: 10px; width: 100%; margin-top: 10px;">

    <!-- Print Button (Fixed width 70px) -->
    <button type="button" onclick="compareAndSubmitEdit()"
        style="width: 200px; padding: 8px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
        Print
    </button>

    <!-- Refresh/Back Button (fills remaining space) -->
    <button onclick="window.location.href='https://iitmindia.com/reg/spot/search_form5.php'"
        style="flex: 1; padding: 8px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
        Refresh
    </button>

</div>

<div>


    <a href="https://iitmindia.com/backend/">Backend</a>
    <a href="https://iitmindia.com/backend/volenteer/">Volunteer Guidelines</a>

</div>

<script>

    window.addEventListener('afterprint', function () {
        if (overlayText && originalTop !== null) {
            overlayText.style.top = `${originalTop}px`;
        }
    });


    window.addEventListener('load', function () {
        restorePosition();
                    <?php if ($auto_print): ?> window.print(); <?php endif; ?>
    });


    function toggleOpacity(enable) {
        const container = document.querySelector('.image-container');
        if (enable) {
            container.classList.add('opacity-enabled');
        } else {
            container.classList.remove('opacity-enabled');
        }
    }

    function restorePosition() {
        const top = localStorage.getItem('overlayTop') || '155';
        const left = localStorage.getItem('overlayLeft') || '45';

        document.getElementById('topInput').value = top;
        document.getElementById('leftInput').value = left;

        applyPosition(top, left);
    }

    function reset_position() {
        document.getElementById('topInput').value = 155;
        document.getElementById('leftInput').value = 45;

        applyPosition(155, 45); // Make sure it updates the overlay visually
        localStorage.setItem('overlayTop', 155);
        localStorage.setItem('overlayLeft', 45);
    }


    function applyPosition(top, left) {
        const overlay = document.querySelector('.overlay-text');
        overlay.style.top = top + 'px';
        overlay.style.left = left + 'px';
    }

    function adjustPosition(direction) {
        let top = parseInt(document.getElementById('topInput').value, 10);
        let left = parseInt(document.getElementById('leftInput').value, 10);
        const step = 5; // pixels to move per click

        switch (direction) {
            case 'up':
                top -= step;
                break;
            case 'down':
                top += step;
                break;
            case 'left':
                left -= step;
                break;
            case 'right':
                left += step;
                break;
        }

        document.getElementById('topInput').value = top;
        document.getElementById('leftInput').value = left;

        applyPosition(top, left);

        localStorage.setItem('overlayTop', top);
        localStorage.setItem('overlayLeft', left);
    }

    // Auto-save when user changes input
    document.addEventListener('DOMContentLoaded', () => {
        const topInput = document.getElementById('topInput');
        const leftInput = document.getElementById('leftInput');

        topInput.addEventListener('input', () => {
            localStorage.setItem('overlayTop', topInput.value);
            applyPosition(topInput.value, leftInput.value);
        });

        leftInput.addEventListener('input', () => {
            localStorage.setItem('overlayLeft', leftInput.value);
            applyPosition(topInput.value, leftInput.value);
        });
    });
</script>