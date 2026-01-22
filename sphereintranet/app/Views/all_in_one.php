<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Image OCR and Data Editor</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { display: flex; gap: 30px; }
        .section { border: 1px solid #ccc; padding: 15px; border-radius: 5px; width: 23%; }
        img { max-width: 100%; height: auto; }
        textarea { width: 100%; }
        input[type="text"], input[type="email"] { width: 100%; }
        .navigation a { margin: 0 10px; text-decoration: none; }
        .filter-sort a { margin-right: 10px; }
    </style>
</head>
<body>

<h1>Image OCR & Form Editor</h1>

<!-- Upload Form -->
<section>
    <h2>Upload Images</h2>
<form id="uploadForm" method="post" action="/imagetotext/uploadfiles" enctype="multipart/form-data">
    <input type="file" name="images[]" multiple required>
    <button type="submit">Upload Files</button>
</form>


    <!-- Response will be displayed here -->
    <div id="uploadResult" style="margin-top: 20px;"></div>
</section>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const formData = new FormData(form);
fetch('/imagetotext/uploadfiles', {
    method: 'POST',
    body: formData
})
.then(async response => {
    const contentType = response.headers.get("content-type");
    if (response.ok && contentType && contentType.includes("application/json")) {
        const data = await response.json();

        // Show result
        let resultDiv = document.getElementById('uploadResult');
        resultDiv.innerHTML = `
            <p><strong>Total Files:</strong> ${data.total_files}</p>
            <p><strong>New Entries:</strong> ${data.new_entries}</p>
            <p><strong>Duplicates:</strong> ${data.duplicates}</p>
            <p><strong>Uploaded Files:</strong></p>
            <ul>
                ${data.uploaded.map(file => `<li>${file}</li>`).join('')}
            </ul>
        `;
    } else {
        const text = await response.text(); // Try to show raw response
        throw new Error(text || 'Unexpected server error.');
    }
})
.catch(error => {
    console.error('Upload error:', error);
    document.getElementById('uploadResult').innerHTML = `
        <p style="color:red;">Error: ${error.message}</p>
    `;
});

});
</script>

<hr>

<?php if ($current): ?>
<div class="container">

    <!-- Layout 1: Image -->
    <div class="section">
        <h3>Image</h3>
        <img src="<?= base_url('writable/uploads/' . $current['image_path']) ?>" alt="Uploaded Image">
    </div>

    <!-- Layout 2: OCR Data -->
    <div class="section">
        <h3>OCR Text</h3>
        <pre><?= esc($current['ocr_text']) ?></pre>
    </div>

    <!-- Layout 3: Notepad -->
    <div class="section">
        <h3>Notepad (Editable)</h3>
        <textarea rows="15"><?= esc($current['ocr_text']) ?></textarea>
    </div>

    <!-- Layout 4: Form -->
    <div class="section">
        <h3>Edit Form</h3>
        <form method="post" action="/imagetotext/updatedata/<?= $current['id'] ?>">
            <label>Company Name:<br>
                <input type="text" name="company_name" value="<?= esc($current['company_name']) ?>">
            </label><br><br>

            <label>Email:<br>
                <input type="email" name="email" value="<?= esc($current['email']) ?>">
            </label><br><br>

            <label>Phone:<br>
                <input type="text" name="phone" value="<?= esc($current['phone']) ?>">
            </label><br><br>

            <label>Address:<br>
                <input type="text" name="address" value="<?= esc($current['address']) ?>">
            </label><br><br>

            <label>Website:<br>
                <input type="text" name="website" value="<?= esc($current['website']) ?>">
            </label><br><br>

            <button type="submit">Save</button>
        </form>
    </div>

</div>

<!-- Navigation -->
<!-- <div class="navigation" style="margin-top: 20px;">
    <?php if ($prevId): ?>
<a href="/imagetotext/allinone?id=<?= $prevId ?>&filter=<?= $filter ?>&sort=<?= $sort ?>">⬅️ Previous</a>
    <?php endif; ?>
    <?php if ($nextId): ?>
<a href="/imagetotext/allinone?id=<?= $nextId ?>&filter=<?= $filter ?>&sort=<?= $sort ?>">Next ➡️</a>
    <?php endif; ?>
</div> -->

<!-- Filter & Sort -->
<div class="filter-sort" style="margin-top: 20px;">
    <strong>Filter:</strong>
    <a href="/imagetotext/allinone?filter=all">All</a> |
    <a href="/imagetotext/allinone?filter=verified">Verified</a> |
    <a href="/imagetotext/allinone?filter=unverified">Unverified</a>

    <br><br>

    <strong>Sort by:</strong>
    <a href="/imagetotext/allinone?sort=id">ID</a> |
    <a href="/imagetotext/allinone?sort=company_name">Company Name</a>
</div>

<?php else: ?>
<p>No images found. Please upload files.</p>
<?php endif; ?>

</body>
</html>
