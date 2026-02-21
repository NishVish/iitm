<h2>Tradev List</h2>
<a href="<?= site_url('tradev/create'); ?>">Add New</a>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php foreach($tradev_list as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $t['title'] ?></td>
        <td><?= $t['name'] ?></td>
        <td><?= $t['email'] ?></td>
        <td>
            <a href="<?= site_url('tradev/edit/'.$t['id']) ?>">Edit</a> |
            <a href="<?= site_url('tradev/delete/'.$t['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>