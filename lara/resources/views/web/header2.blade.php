<style>
    .header2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: #4c4c4cb2;
        margin-bottom: 100px;
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .header2.scrolled {
        background: #0000003b;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .header2 table {
        width: 100%;
        border-collapse: collapse;
    }

    .logo img {
        height: 40px;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        margin: 0 12px;
        font-size: 16px;
    }

    .cta a {
        background: #ffcc00;
        color: #000;
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }
</style>

<div class="header2" id="header2">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 20%; padding: 10px 20px;">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" style="height:40px;">
            </td>

            <td class="nav-links" style="width: 60%; text-align: center;">
                <a href="{{ route('web') }}">Home</a>
                <a href="/about-us">About Us</a>
                <a href="/contact-us">Contact Us</a>
            </td>

            <td style="width: 20%; text-align: right; padding: 10px 20px;">
                <a class="cta" href="/enquiry">Connect Now</a>
            </td>
        </tr>
    </table>
</div>

<script>
    window.addEventListener("scroll", () => {
        document.getElementById("header2")
            .classList.toggle("scrolled", window.scrollY > 50);
    });
</script>