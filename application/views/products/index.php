<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewellery Products</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        /* General styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .table td, .table th {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle;
        }

        .navbar-custom {
            background-color: #343a40;
        }

        .navbar-custom .navbar-nav .nav-link {
            color: white;
        }

        .navbar-custom .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar-custom .navbar-text {
            font-size: 16px;
            color: #f1a93a;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border-radius: 3px;
            padding: 6px 12px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .product-table {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .action-icons a {
            color: white;
            margin: 0 5px;
        }

        .action-icons a:hover {
            color: #f1a93a;
        }

        .back-button, .add-button {
            margin-bottom: 10px;
        }

        h2 {
            font-weight: bold;
        }

        .container {
            margin-top: 20px;
        }

        .btn {
            font-size: 14px;
        }

        .table img {
            max-width: 100px;
            height: auto;
        }

    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Jewellery Shop</a>
            <div class="collapse navbar-collapse">
                <div class="navbar-nav ml-auto">
                   
                    <a href="<?= base_url('index.php/auth/logout'); ?>" class="btn logout-btn ml-3">Logout</a>
                </div>
            </div>
        </div>
    </nav>

   
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-12">
                <a href="<?= base_url('index.php/products/show_categories'); ?>" class="btn btn-secondary back-button">Back</a>
                <a href="<?= base_url('index.php/products/create'); ?>" class="btn btn-primary add-button">Add Product</a>
            </div>
        </div>

        <h2>Product List</h2>

       
        <table id="productTable" class="table table-striped product-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
           
        </table>
    </div>

  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>


    <script>
$(document).ready(function() {
    const table = $('#productTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= base_url('index.php/products/fetch_products'); ?>", 
            "type": "GET"
        },
        "columns": [
            { "data": "name" },
            { "data": "description" },
            { "data": "price" },
            { "data": "category_name" },
            { 
                "data": "image",
                "render": function(data, type, row) {
                    return '<img src="<?= base_url('uploads/'); ?>' + data + '" alt="product" class="img-fluid" style="max-width: 100px;">';
                }
            },
            {
                "data": null,
                "orderable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    const editUrl = "<?= base_url('index.php/products/edit/'); ?>" + row.id;
                    const deleteUrl = "<?= base_url('index.php/products/delete/'); ?>" + row.id;
                    return `
                        <div class="action-icons">
                            <a href="${editUrl}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="${deleteUrl}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </div>
                    `;
                }
            }
        ],
        // Enable column visibility toggle
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'colvis', // Column visibility button
                text: 'Toggle Columns'
            }
        ]
    });

    // Optional: Listen for search field changes and perform server-side search
    $('#productTable_filter input').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>

</body>
</html>
