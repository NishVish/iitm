<form method="post" action="<?= site_url('dash/register') ?>">
    <?= csrf_field() ?>

    <label>Email:</label>
    <input type="email" name="email" value="<?= set_value('email', $data['email'] ?? '') ?>" required>
    <?php if (isset($validation) && $validation->hasError('email')): ?>
        <p style="color:red"><?= $validation->getError('email') ?></p>
    <?php endif; ?>

    <label>Password:</label>
    <input type="password" name="password" required>
    <?php if (isset($validation) && $validation->hasError('password')): ?>
        <p style="color:red"><?= $validation->getError('password') ?></p>
    <?php endif; ?>

    <label>Category:</label>
    <select name="category" required>
        <option value="general" <?= (isset($data['category']) && $data['category'] === 'general') ? 'selected' : '' ?>>General</option>
        <option value="admin" <?= (isset($data['category']) && $data['category'] === 'admin') ? 'selected' : '' ?>>Admin</option>
    </select>
    <?php if (isset($validation) && $validation->hasError('category')): ?>
        <p style="color:red"><?= $validation->getError('category') ?></p>
    <?php endif; ?>

    <button type="submit">Register</button>
</form>
