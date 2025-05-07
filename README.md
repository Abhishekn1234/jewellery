Jewellery Product Management System (CI3)
A CodeIgniter 3-based Jewellery Product Management System that includes:

User Authentication (Login, Registration, and Logout)

Product Management (CRUD with Image Upload & Resize)

Category Management

Pagination and Search Logic

Features & Explanation
1. User Authentication (Login, Registration, and Logout)
Login: The system provides a login functionality using session-based authentication. Users can log in with their credentials (username and password). The login form is styled with Bootstrap for a clean, user-friendly UI.

Login URL: /auth/login

After successful login, users are redirected to a dashboard or home page with available functionalities.

Registration: Users can register by providing their username, email, and password.

Registration URL: /auth/register

After registering, users are automatically logged in.

Logout: Users can log out from the system at any time.

Logout URL: /auth/logout

After logging out, users are redirected to the login page.

2. Product Management (CRUD with Image Upload & Resize)
Create: Users can add new products to the database. Each product includes:

Product Name

Description

Price

Category (Dropdown selection of available categories)

Image (Uploaded image is resized to 500x500px before saving to ensure consistency)

Read: Users can view the list of products, which is displayed using DataTables. Features include:

Server-side pagination: Only a limited number of products are shown at a time, improving performance.

Search: Users can search products by name, category, or price.

Sorting: Columns can be sorted (by name, price, etc.).

Column visibility: Users can toggle visibility for different product columns.

Update: Users can edit product details (e.g., name, description, price, category, and image).

Delete: Users can delete products from the list.

3. Category Management
Categories: Products are organized by categories. When creating or editing a product, users can select a category from a dropdown list.

Categories are managed in the backend, and users can associate products with the appropriate categories.

4. Server-Side Pagination and Search Logic
Server-Side Pagination: The product list is fetched using AJAX, implementing server-side pagination. Only a limited number of products are loaded per page to improve performance.

Search: The system supports searching products based on different parameters, such as:

Product Name

Category

Price

The search functionality is powered by server-side logic, ensuring only matching products are returned from the server.

5. Product Image Upload and Resize
Users can upload images for each product. The system uses CodeIgniter’s Image Manipulation Library to resize the uploaded images to a maximum width and height of 500px while maintaining the aspect ratio.

Workflow Summary
User Authentication:

Users can log in, register, or log out.

After successful login, users are redirected to the home page with access to product management features.

Product Management:

Users can add, update, or delete products.

The product list is displayed using DataTables, which includes features like search, sorting, and pagination.

Images are resized before saving to maintain consistency.

Category Management:

Users can select a category when adding or editing products.

Categories are managed and stored in the backend.

Search & Pagination:

Server-side pagination ensures efficient loading of products.

Users can search products by name, category, or price.

Results are dynamically fetched using AJAX.

