<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* NAMESPACED WRAPPER - Prevents all conflicts */
    #profile-app {
        --p-brand: #4f46e5;
        --p-brand-light: #eef2ff;
        --p-surface: #ffffff;
        --p-text-base: #475569;
        --p-text-heading: #0f172a;
        --p-danger: #ff4d4f;
        
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 40px 20px;
        max-width: 1100px;
        margin: auto;
        background-color: #fbfcfe;
        min-height: 100vh;
    }

    /* Hero Profile Section */
    #profile-app .profile-hero {
        background: var(--p-surface);
        border-radius: 32px;
        padding: 40px;
        display: flex;
        align-items: center;
        gap: 30px;
        box-shadow: 0 10px 40px -15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border: 1px solid #f1f5f9;
    }

    #profile-app .avatar-wrapper {
        position: relative;
        cursor: pointer;
    }

    #profile-app .profile-avatar, 
    #profile-app #contactImage {
        width: 120px;
        height: 120px;
        border-radius: 40px;
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 44px;
        font-weight: 800;
        transition: transform 0.3s ease;
        box-shadow: 0 15px 30px -10px rgba(79, 70, 229, 0.3);
    }

    #profile-app .profile-avatar {
        background: linear-gradient(135deg, var(--p-brand), #818cf8);
        color: white;
    }

    #profile-app .avatar-wrapper:hover .profile-avatar,
    #profile-app .avatar-wrapper:hover #contactImage {
        transform: scale(1.05);
    }

    #profile-app .profile-info h1 {
        margin: 0;
        font-size: clamp(24px, 5vw, 32px);
        color: var(--p-text-heading);
        letter-spacing: -1px;
    }

    #profile-app .profile-info .designation-text {
        margin: 4px 0 16px 0;
        color: var(--p-brand);
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    #profile-app .contact-pills {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    #profile-app .pill {
        background: var(--p-brand-light);
        color: var(--p-brand);
        padding: 10px 18px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid rgba(79, 70, 229, 0.1);
    }

    /* Bento Grid */
    #profile-app .bento-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    #profile-app .bento-item {
        background: var(--p-surface);
        padding: 28px;
        border-radius: 28px;
        border: 1px solid #f1f5f9;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #profile-app .bento-item:hover {
        border-color: var(--p-brand);
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
    }

    #profile-app .bento-item.large {
        grid-column: span 2;
        background: linear-gradient(135deg, var(--p-brand), #6366f1);
        color: white;
        border: none;
    }

    #profile-app .bento-item.logout-card {
        background: #fff1f0;
        border-color: #ffa39e;
        color: var(--p-danger);
        cursor: pointer;
    }

    #profile-app .bento-item.logout-card:hover {
        background: var(--p-danger);
        color: white;
    }

    #profile-app .bento-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 800;
        margin-bottom: 8px;
        opacity: 0.6;
    }

    #profile-app .bento-value {
        font-size: 18px;
        font-weight: 700;
        line-height: 1.3;
    }

    #profile-app .bento-item.large .bento-value {
        font-size: 26px;
    }

    #profile-app .b-icon {
        width: 44px;
        height: 44px;
        background: #f8fafc;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        color: var(--p-brand);
        font-size: 18px;
    }

    #profile-app .large .b-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    #profile-app .logout-card .b-icon {
        background: rgba(255, 77, 79, 0.1);
        color: var(--p-danger);
    }
    
    #profile-app .logout-card:hover .b-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    @media (max-width: 850px) {
        #profile-app .bento-grid { grid-template-columns: 1fr; }
        #profile-app .bento-item.large { grid-column: span 1; }
        #profile-app .profile-hero { flex-direction: column; text-align: center; padding: 30px; }
        #profile-app .contact-pills { justify-content: center; }
    }


    /* MODAL FIX: This ensures it sits on top of the entire window */
.modal-overlay {
    position: fixed; /* Fixes it to the viewport, not the page content */
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.9); /* Darker backdrop for focus */
    display: none; /* Controlled by JS */
    align-items: center;
    justify-content: center;
    z-index: 99999; /* Higher than everything else */
    backdrop-filter: blur(8px);
}

.modal-content {
    position: relative;
    width: 90%;
    max-width: 600px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

#modalPreview {
    width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 16px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

.close-modal {
    position: absolute;
    top: -50px;
    right: 0;
    color: white;
    font-size: 35px;
    cursor: pointer;
    padding: 10px;
}
</style>



<div id="profile-app">
    <div class="profile-hero">
        <div class="avatar-wrapper">
            <div class="profile-avatar" id="initials">...</div>
            <img id="contactImage" src="" alt="Profile" style="display:none;">
        </div>
        <div class="profile-info">
            <h1 id="name">Loading...</h1>
            <p class="designation-text" id="designation">User Profile</p>
            <div class="contact-pills">
                <div class="pill"><i class="fa-solid fa-envelope"></i> <span id="email">...</span></div>
                <div class="pill"><i class="fa-solid fa-phone"></i> <span id="mobile">...</span></div>
            </div>
        </div>
    </div>

    <div class="bento-grid">
        <div class="bento-item large">
            <div class="b-icon"><i class="fa-solid fa-building"></i></div>
            <span class="bento-label">Primary Organization</span>
            <span class="bento-value" id="company_name">Connecting...</span>
        </div>

        <div class="bento-item">
            <div class="b-icon"><i class="fa-solid fa-database"></i></div>
            <span class="bento-label">System Node</span>
            <span class="bento-value" id="database_name">DB_INSTANCE</span>
        </div>

        <div class="bento-item">
            <div class="b-icon"><i class="fa-solid fa-location-dot"></i></div>
            <span class="bento-label">Regional Location</span>
            <span class="bento-value"><span id="city">City</span>, <span id="state">State</span></span>
        </div>

        <div class="bento-item">
            <div class="b-icon"><i class="fa-solid fa-layer-group"></i></div>
            <span class="bento-label">Classification</span>
            <span class="bento-value" id="entry_type">Standard</span>
        </div>

        <div class="bento-item">
            <div class="b-icon"><i class="fa-solid fa-id-card"></i></div>
            <span class="bento-label">Business Card</span>
            <div class="bento-value" style="display: flex; align-items: center; justify-content: center; min-height: 60px;">
                <img id="businessCardImage" src="" alt="Business Card" style="max-width: 100%; max-height: 80px; border-radius: 8px; cursor: pointer; display: none;">
                <div id="noCardPlaceholder" style="cursor:pointer; font-size: 14px; opacity: 0.6; text-align: center;">
                    <i class="fa-solid fa-plus-circle"></i><br>Tap to add card
                </div>
            </div>
        </div>

        <div class="bento-item">
            <div class="b-icon"><i class="fa-solid fa-id-badge"></i></div>
            <span class="bento-label">Client Token</span>
            <span class="bento-value">#<?= session()->get('company_id') ?></span>
        </div>

        <a href="logout" style="text-decoration:none; grid-column: span 1;">
            <div class="bento-item logout-card" style="height: 100%;">
                <div class="b-icon"><i class="fa-solid fa-power-off"></i></div>
                <span class="bento-label">Security</span>
                <span class="bento-value">Terminate Session</span>
            </div>
        </a>
    </div>

    <div id="imageModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <img id="modalPreview" src="" alt="Preview">
            <div class="modal-actions">
                <button id="changeImageBtn" class="pill" style="background: var(--p-brand); color: white; border: none; padding: 12px 24px; cursor: pointer; font-weight: 700;">
                    <i class="fa-solid fa-camera"></i> Change Photo
                </button>
            </div>
        </div>
    </div>
</div>

<input type="file" id="imageUpload" accept="image/*" style="display:none;">
<input type="file" id="businessCardUpload" accept="image/*" style="display:none;">



<script>


document.addEventListener('DOMContentLoaded', () => {
    // 1. Grab Elements
    const contactImage = document.getElementById('contactImage');
    const initials = document.getElementById('initials');
    const businessCardImage = document.getElementById('businessCardImage');
    const cardPlaceholder = document.getElementById('noCardPlaceholder');
    
    const imageModal = document.getElementById('imageModal');
    const modalPreview = document.getElementById('modalPreview');
    const changeBtn = document.getElementById('changeImageBtn');
    
    const profileInput = document.getElementById('imageUpload');
    const cardInput = document.getElementById('businessCardUpload');

    let activeEditType = ''; // 'profile' or 'card'

    // 2. Fetch and Fill Data
    fetch('<?= base_url('user/companyDetails/json') ?>')
        .then(res => res.json())
        .then(data => {
            if (!data) return;
console.log(data);
            // Fill all text fields automatically (Company Name included here!)
            const fields = ['name', 'designation', 'email', 'mobile', 'company_name', 'database_name', 'city', 'state', 'entry_type'];
            fields.forEach(field => {
                const el = document.getElementById(field);
                if (el) el.innerText = data[field] || '---';
            });

            // Handle Profile Image
            if (data.image) {
                contactImage.src = '<?= base_url('public/uploads/contacts') ?>/' + data.image;
                contactImage.style.display = 'block';
                initials.style.display = 'none';
            } else {
                initials.style.display = 'flex';
                // Set initials based on name
                if (data.name) {
                    const parts = data.name.split(' ');
                    initials.innerText = parts.length > 1 ? (parts[0][0] + parts[1][0]).toUpperCase() : parts[0][0].toUpperCase();
                }
            }

            // Handle Business Card
            if (data.business_card_image) {
                businessCardImage.src = '<?= base_url('public/uploads/contacts') ?>/' + data.business_card_image;
                businessCardImage.style.display = 'block';
                cardPlaceholder.style.display = 'none';
            }
        });

    // 3. View/Change Logic
    const openModal = (src, type) => {
        modalPreview.src = src;
        activeEditType = type;
        imageModal.style.display = 'flex';
    };

    // Click triggers
    [contactImage, initials].forEach(el => {
        el.onclick = () => (contactImage.style.display !== 'none') ? openModal(contactImage.src, 'profile') : profileInput.click();
    });

    [businessCardImage, cardPlaceholder].forEach(el => {
        el.onclick = () => (businessCardImage.style.display !== 'none') ? openModal(businessCardImage.src, 'card') : cardInput.click();
    });

    changeBtn.onclick = () => {
        imageModal.style.display = 'none';
        (activeEditType === 'profile') ? profileInput.click() : cardInput.click();
    };

    document.querySelector('.close-modal').onclick = () => imageModal.style.display = 'none';
    imageModal.onclick = (e) => { if(e.target === imageModal) imageModal.style.display = 'none'; };

    // 4. Upload Logic
    profileInput.onchange = (e) => handleUpload(e, 'image', 'user/uploadProfileImage', contactImage, initials);
    cardInput.onchange = (e) => handleUpload(e, 'business_card_image', 'user/uploadBusinessCardImage', businessCardImage, cardPlaceholder);
});

function handleUpload(event, param, url, imgEl, hideEl) {
    const file = event.target.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append(param, file);

    fetch('<?= base_url() ?>' + url, { method: 'POST', body: formData })
    .then(res => res.json())
    .then(resp => {
        if (resp.success) {
            imgEl.src = resp.path + '?t=' + new Date().getTime();
            imgEl.style.display = 'block';
            if (hideEl) hideEl.style.display = 'none';
        }
    });
}
</script>