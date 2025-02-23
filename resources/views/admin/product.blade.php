<x-app-layout>
    <div class="container mt-4">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8">
                <button type="button" class="btn btn-success mb-3 w-100" id="toggleCategoryForm">Add Product</button>
                <!-- Product Form -->
                <div class="card shadow-sm" id="productFormDiv" style="display: none;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add Product</h5>
                    </div>
                    <div class="card-body">
                        <form id="productForm">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Select Category</label>
                                <select class="form-control" id="category_id" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subcategory_id" class="form-label">Select Subcategory</label>
                                <select class="form-control" id="subcategory_id" required>
                                    <option value="">-- Select Subcategory --</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="addProductBtn">Add Product</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">

                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="mb-0">Product List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTable">
                                @foreach ($products as $product)
                                    <tr id="product-{{ $product->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->subcategory->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-product"
                                                data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                data-category="{{ $product->category_id }}"
                                                data-subcategory="{{ $product->subcategory_id }}"
                                                data-vendor="{{ $product->vendor_id }}"
                                                data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                                data-description="{{ $product->description }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-product"
                                                data-id="{{ $product->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="edit_product_id" val="">

                        <div class="mb-3">
                            <label for="edit_category_id" class="form-label">Select Category</label>
                            <select class="form-control" id="edit_category_id" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_subcategory_id" class="form-label">Select Subcategory</label>
                            <select class="form-control" id="edit_subcategory_id" required>
                                <option value="">-- Select Subcategory --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="edit_product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="edit_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="edit_stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="updateProductBtn">Update
                            Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                function loadSubcategories(categoryId, subcategoryDropdown, selectedSubcategory = null) {
                    subcategoryDropdown.html('<option value="">-- Select Subcategory --</option>');
                    if (categoryId) {
                        $.get("{{ route('admin.getSubcategories') }}", {
                            category_id: categoryId
                        }, function(data) {
                            $.each(data, function(index, subcategory) {
                                subcategoryDropdown.append(
                                    `<option value="${subcategory.id}">${subcategory.name}</option>`
                                );
                            });

                            // Set selected subcategory if available (for edit mode)
                            if (selectedSubcategory) {
                                subcategoryDropdown.val(selectedSubcategory);
                            }
                        });
                    }
                }

                // Load subcategories when category changes
                $('#category_id').change(function() {
                    let categoryId = $(this).val();
                    loadSubcategories(categoryId, $('#subcategory_id'));
                });
                $('#edit_category_id').change(function() {
                    let categoryId = $(this).val();
                    loadSubcategories(categoryId, $('#edit_subcategory_id'));
                });
                // Add Product
                $('#addProductBtn').click(function(e) {
                    e.preventDefault();
                    let productData = {
                        _token: "{{ csrf_token() }}",
                        category_id: $('#category_id').val(),
                        subcategory_id: $('#subcategory_id').val(),
                        name: $('#product_name').val(),
                        price: $('#price').val(),
                        stock: $('#stock').val(),
                        description: $('#description').val(),
                    };

                    $.post("{{ route('product.store') }}", productData, function() {
                        location.reload();
                    }).fail(function(xhr) {
                        alert("Error: " + xhr.responseText);
                    });
                });

                // Delete Product
                $('.delete-product').click(function() {
                    let productId = $(this).data('id');
                    if (confirm("Are you sure?")) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('product.delete') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                productId: productId
                            },
                            success: function() {
                                $("#product-" + productId).remove();
                            }
                        });
                    }
                });

                // Open Edit Modal
                $('.edit-product').click(function() {
                    let productId = $(this).data('id');
                    let categoryId = $(this).data('category');
                    let subcategoryId = $(this).data('subcategory');
                    $('#edit_product_name').val($(this).data('name'));
                    $('#edit_price').val($(this).data('price'));
                    $('#edit_stock').val($(this).data('stock'));
                    $('#edit_description').val($(this).data('description'));
                    $('#edit_category_id').val($(this).data('category')).trigger('change');
                    $('#edit_product_id').val(productId);
                    loadSubcategories(categoryId, $('#edit_subcategory_id'), subcategoryId);

                    $('#editProductModal').modal('show');
                });

                // Update Product
                $('#updateProductBtn').click(function() {
                    let productId = $('#edit_product_id').val();
                    
                    let updatedData = {
                        _token: "{{ csrf_token() }}",
                        productId: productId,
                        category_id: $('#edit_category_id').val(),
                        subcategory_id: $('#edit_subcategory_id').val(),
                        name: $('#edit_product_name').val(),
                        price: $('#edit_price').val(),
                        stock: $('#edit_stock').val(),
                        description: $('#edit_description').val(),
                    };

                    $.ajax({
                        type: "POST",
                        url: "{{ route('product.update') }}",
                        data: updatedData,
                        success: function() {
                            $('#editProductModal').modal('hide');
                            location.reload();
                        }
                    });
                });

                $("#toggleCategoryForm").click(function() {
                    $("#productFormDiv").slideToggle();
                });
            });
        </script>
    @endpush
</x-app-layout>
