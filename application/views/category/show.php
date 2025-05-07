<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Category List</h2>
    <a href="<?= base_url('index.php/products/add_categories'); ?>" class="btn btn-primary mb-3">Add Category</a>
    <a href="<?= base_url('index.php/products/index'); ?>" class="btn btn-sucess mb-3">Back</a>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat->id ?></td>
                    <td><?= $cat->name ?></td>
                    <td>
                        <a href="<?= base_url('index.php/products/edit_categories/' . $cat->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= base_url('index.php/products/delete_categories/' . $cat->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No categories found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
