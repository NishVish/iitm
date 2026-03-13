<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --brand: #4f46e5;
        --brand-light: #eef2ff;
        --surface: #ffffff;
        --text-base: #475569;
        --text-heading: #0f172a;
    }

    .modern-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 40px 20px;
        max-width: 1100px;
        margin: auto;
        background-color: #fbfcfe;
    }

    /* Hero Profile Section */
    .profile-hero {
        background: var(--surface);
        border-radius: 24px;
        padding: 40px;
        display: flex;
        align-items: center;
        gap: 30px;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.04);
        margin-bottom: 30px;
        border: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        background: var(--brand);
        color: white;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: 800;
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
    }

    .profile-info h1 {
        margin: 0;
        font-size: 28px;
        color: var(--text-heading);
        letter-spacing: -0.02em;
    }

    .profile-info p {
        margin: 5px 0 15px 0;
        color: var(--brand);
        font-weight: 600;
        font-size: 16px;
    }

    .contact-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .pill {
        background: var(--brand-light);
        color: var(--brand);
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Bento Grid for Company Data */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, auto);
        gap: 20px;
    }

    .bento-item {
        background: var(--surface);
        padding: 24px;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .bento-item:hover {
        border-color: var(--brand);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05);
    }

    .bento-item.large {
        grid-column: span 2;
        background: var(--brand);
        color: white;
    }

    .label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 700;
        margin-bottom: 8px;
        display: block;
        opacity: 0.8;
    }

    .value {
        font-size: 18px;
        font-weight: 700;
        display: block;
    }

    .bento-item.large .value {
        font-size: 24px;
    }

    .icon-box {
        width: 40px;
        height: 40px;
        background: #f8fafc;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        color: var(--brand);
    }

    .bento-item.large .icon-box {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    /* Mobile Adaptability */
    @media (max-width: 768px) {
        .bento-grid { grid-template-columns: 1fr; }
        .bento-item.large { grid-column: span 1; }
    .profile-hero { flex-direction: column; text-align: center; }
        
    }
</style>

<div class="modern-wrapper">
<div class="profile-hero">
    <div class="profile-avatar" id="initials">JD</div>
    <img id="contactImage" src="default.jpg" alt="Contact Image" style="width:100px; border-radius:50%; display:none;">
    <div class="profile-info">
        <h1 id="name">Loading...</h1>
        <p id="designation">Please wait</p>
        <div class="contact-pills">
            <div class="pill"><i class="fa-solid fa-envelope"></i> <span id="email">...</span></div>
            <div class="pill"><i class="fa-solid fa-phone"></i> <span id="mobile">...</span></div>
        </div>
    </div>
</div>

    <div class="bento-grid">
        <div class="bento-item large">
            <div class="icon-box"><i class="fa-solid fa-building"></i></div>
            <span class="label">Organization</span>
            <span class="value" id="company_name">...</span>
        </div>

        <div class="bento-item">
            <div class="icon-box"><i class="fa-solid fa-database"></i></div>
            <span class="label">System Database</span>
            <span class="value" id="database_name">...</span>
        </div>

        <div class="bento-item">
            <div class="icon-box"><i class="fa-solid fa-location-dot"></i></div>
            <span class="label">Location</span>
            <span class="value"><span id="city">...</span>, <span id="state">...</span></span>
        </div>

        <div class="bento-item">
            <div class="icon-box"><i class="fa-solid fa-layer-group"></i></div>
            <span class="label">Entry Classification</span>
            <span class="value" id="entry_type">...</span>
        </div>

        <div class="bento-item">
            <div class="icon-box"><i class="fa-solid fa-id-card"></i></div>
            <span class="label">Client ID</span>
            <span class="value">#<?= session()->get('company_id') ?></span>
        </div>

<a href="logout" style="text-decoration:none;">
    <div class="bento-item">
        <div class="icon-box"><i class="fa-solid fa-power-off"></i></div>
        <span class="label">Kill Session</span>
        <span class="value">Logout</span>
    </div>
</a>
<style>
    .bento-item.logout {
    background:#ff4d4f;
    color:white;
}
</style>
</div>
<!-- Hidden file input -->
<input type="file" id="imageUpload" accept="image/*" style="display:none;">

<script>
document.addEventListener('DOMContentLoaded', () => {
    const contactImage = document.getElementById('contactImage');
    const initials = document.getElementById('initials');
    const fileInput = document.getElementById('imageUpload');

    // Fetch profile data
    fetch('<?= base_url('user/companyDetails/json') ?>')
        .then(res => res.json())
        .then(data => {
            if (data) {
                // Handle Image / Initials
                if (data.image) {
                    contactImage.src = '<?= base_url('writable/uploads/contacts') ?>/' + data.image;
                    contactImage.style.display = 'block';
                    initials.style.display = 'none';
                } else {
                    contactImage.style.display = 'none';
                    initials.style.display = 'flex';
                }

                // Set Text Fields
                document.getElementById('name').innerText = data.name;
                document.getElementById('designation').innerText = data.designation;
                document.getElementById('email').innerText = data.email;
                document.getElementById('mobile').innerText = data.mobile;
                document.getElementById('company_name').innerText = data.company_name;
                document.getElementById('database_name').innerText = data.database_name;
                document.getElementById('city').innerText = data.city;
                document.getElementById('state').innerText = data.state;
                document.getElementById('entry_type').innerText = data.entry_type;

                // Set Initials
                const nameParts = data.name.split(' ');
                const initialsText = nameParts.length > 1 ? nameParts[0][0] + nameParts[1][0] : nameParts[0][0];
                initials.innerText = initialsText.toUpperCase();
            }
        })
        .catch(err => console.error('Error:', err));

    // Click handler for uploading
    contactImage.addEventListener('click', () => fileInput.click());
    initials.addEventListener('click', () => fileInput.click());

    // Handle file selection
    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);

        // Send to server (use your own upload endpoint)
        fetch('<?= base_url('user/uploadProfileImage') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.success) {
                // Update UI immediately
                contactImage.src = resp.path; // server returns new path
                contactImage.style.display = 'block';
                initials.style.display = 'none';
            } else {
                alert('Upload failed: ' + resp.message);
            }
        })
        .catch(err => console.error('Upload error:', err));
    });
});
</script>