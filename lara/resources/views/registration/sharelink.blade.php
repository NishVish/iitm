<div class="share-card mt-4">

    <div class="share-header">
        <div class="icon">
            <i class="bi bi-people-fill"></i>
        </div>

        <div>
            <h5 class="title">Add More Delegates</h5>
            <p class="subtitle">Invite your colleagues easily</p>
        </div>
    </div>

    <p class="description">
        Share this link with your colleagues or fill in their details using the same company registration flow.
    </p>

    <div class="share-box">
        <input type="text" id="shareLink" value="{{ $shareLink }}" readonly>
        <button type="button" onclick="copyLink(this)">Copy Link</button>
    </div>

</div>

<script>
    function copyLink(btn) {
        const input = document.getElementById('shareLink');
        input.select();
        input.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(input.value);

        const original = btn.innerText;
        btn.innerText = "Copied ✓";
        btn.classList.add("copied");

        setTimeout(() => {
            btn.innerText = original;
            btn.classList.remove("copied");
        }, 1500);
    }
</script>
<style>
    .share-card {
        background: #ffffff;
        border: 1px solid #eef0f3;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        max-width: 600px;
    }

    .share-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .share-header .icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f8cff, #1e60ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
    }

    .title {
        margin: 0;
        font-weight: 700;
    }

    .subtitle {
        margin: 0;
        font-size: 13px;
        color: #6c757d;
    }

    .description {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .share-box {
        display: flex;
        gap: 10px;
    }

    .share-box input {
        flex: 1;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #f8f9fa;
        font-size: 14px;
    }

    .share-box button {
        padding: 12px 18px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #4f8cff, #1e60ff);
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .share-box button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(30, 96, 255, 0.25);
    }

    .share-box button.copied {
        background: #28a745 !important;
    }
</style>