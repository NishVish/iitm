<header id="simple-header">
    <div class="header-content">
        <span class="brand">IITM</span>
        <span class="divider">|</span>
        <span class="name">{{ trim(str_replace(['IITM', 'iitm'], '', $eventinfo->name)) }}</span>
        <span class="divider">|</span>
        <span class="year">{{ $eventinfo->year }}</span>
    </div>
</header>

<style>
    #simple-header {
        margin: 30px auto 0;
        padding: 10px 25px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #851919;
        border-radius: 50px;
        display: flex;
        justify-content: center;
        width: fit-content;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .brand {
        font-weight: 700;
        color: #851919;
        font-size: 16px;
    }

    .divider {
        color: #bbb;
    }

    .name {
        font-weight: 600;
        color: #333;
    }

    .year {
        color: #666;
    }
</style>