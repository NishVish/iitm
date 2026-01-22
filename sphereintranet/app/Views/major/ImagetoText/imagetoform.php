<!DOCTYPE html>
<html>
<head>
    <title>Upload Multiple Images</title>
</head>
<body>
<button onclick="window.location.href='/sphereintranet/home'">Upload Form</button>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('message')): ?>
        <p style="color:green"><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <p style="color:red"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <!-- Image Upload Form -->
    <form action="<?= site_url('imagetotext/upload') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <label>Select Images:</label><br>
        <input type="file" name="images[]" multiple accept="image/*" required><br><br>
        <button type="submit">Upload Images</button>
    </form>

</body>
</html>
