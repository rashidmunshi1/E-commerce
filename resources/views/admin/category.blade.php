<x-app-layout>
    <div class="container mt-4">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6">
                <button class="btn btn-success w-100 mb-3" id="toggleCategoryForm">
                    Add Category
                </button>

                <!-- Category Form -->
                <div class="card shadow-sm" id="categoryFormContainer" style="display: none;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add Category</h5>
                    </div>
                    <div class="card-body">
                        <form id="categoryForm">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="name" required>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="addCategoryBtn">Add
                                Category</button>
                        </form>
                    </div>
                </div>

                <!-- Category List -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Category List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTable">
                                @foreach ($categories as $category)
                                    <tr id="cat-{{ $category->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-category"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-category"
                                                data-id="{{ $category->id }}">
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

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_category_id">
                    <div class="mb-3">
                        <label for="edit_category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="edit_category_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateCategoryBtn">Update Category</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Add Category
                $('#addCategoryBtn').click(function(e) {
                    e.preventDefault();
                    let categoryName = $('#category_name').val();

                    if (categoryName.trim() === "") {
                        alert("Please enter a category name.");
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.categories.store') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            name: categoryName
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert("Error: " + xhr.responseText);
                        }
                    });
                });

                // Delete Category
                $('.delete-category').click(function() {
                    let categoryId = $(this).data('id');
                    if (confirm("Are you sure?")) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.categories.delete') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                categoryId: categoryId
                            },
                            success: function() {
                                $("#cat-" + categoryId).remove();
                            }
                        });
                    }
                });

                // Open Edit Modal
                $('.edit-category').click(function() {
                    let categoryId = $(this).data('id');
                    let categoryName = $(this).data('name');

                    $('#edit_category_id').val(categoryId);
                    $('#edit_category_name').val(categoryName);
                    $('#editCategoryModal').modal('show');
                });

                // Update Category
                $('#updateCategoryBtn').click(function() {
                    let categoryId = $('#edit_category_id').val();
                    let categoryName = $('#edit_category_name').val();

                    if (categoryName.trim() === "") {
                        alert("Please enter a category name.");
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.categories.update') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            categoryId: categoryId,
                            name: categoryName
                        },
                        success: function(response) {
                            $('#editCategoryModal').modal('hide');
                            $("#cat-" + categoryId).find("td:eq(1)").text(categoryName);
                        },
                        error: function(xhr) {
                            alert("Error: " + xhr.responseText);
                        }
                    });
                });
                $("#toggleCategoryForm").click(function() {
                    $("#categoryFormContainer").slideToggle();
                });
            });
        </script>
    @endpush
</x-app-layout>
