SuperDanger


 
        <div class="badge-card">
            <div class="badge-header">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo">
                <div class="small"><?= esc($event[0]['name'] ?? 'IITM Kolkata'); ?></div>
            </div>
            <div class="badge-body">
                <div class="attendee-name"><?= !empty($alldata['contactName']) ? esc($alldata['contactName']) : 'Jio J'; ?></div>
                <div class="attendee-org"><?= !empty($alldata['companyName']) ? esc($alldata['companyName']) : 'Organization Name'; ?></div>
                
                <div class="qr-container">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($mobile ?? '30053610') ?>" alt="QR Code">
                </div>
                <p class="mt-3 mb-0 small text-secondary">B2B Access Only</p>
            </div>
            <div class="badge-footer">TRADE VISITOR</div>
        </div>

        