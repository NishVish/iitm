<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('creative/upload') ?>" method="post" enctype="multipart/form-data">
    <!-- <label for="sender">Sender:</label>
    <input type="text" name="sender" id="sender" required /> -->
    <select id="department-select" name="department" required>
        <option value="">Loading departments...</option>
    </select>

    <label for="image">Choose image to upload:</label>
    <input type="file" name="image" id="image" accept="image/*" required />

    <textarea name="message" placeholder="Your message..." required></textarea>

    <button type="submit">Upload</button>
</form>
