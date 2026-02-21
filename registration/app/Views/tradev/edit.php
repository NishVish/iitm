<h2>Edit Tradev</h2>
<form method="post">
    Title: <input type="text" name="title" value="<?= $tradev['title'] ?>" required><br>
    Name: <input type="text" name="name" value="<?= $tradev['name'] ?>"><br>
    Email: <input type="text" name="email" value="<?= $tradev['email'] ?>"><br>
    <input type="submit" value="Update">
</form>
<a href="<?= site_url('tradev'); ?>">Back to List</a>