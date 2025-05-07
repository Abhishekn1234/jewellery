<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Edit Category</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="name">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $category->name; ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="<?= base_url('index.php/products/show_categories'); ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
