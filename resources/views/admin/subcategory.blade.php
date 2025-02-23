<x-app-layout>
    <div class="container mt-4">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6">
                <button class="btn btn-success mb-3 w-100" id="toggleSubcategoryForm">Add Subcategory</button>
                <!-- Subcategory Form -->
                <div class="card shadow-sm" id="subcategoryFormContainer" style="display: none;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add Subcategory</h5>
                    </div>
                    <div class="card-body">
                        <form id="subcategoryForm">
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
                                <label for="subcategory_name" class="form-label">Subcategory Name</label>
                                <input type="text" class="form-control" id="subcategory_name" required>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="addSubcategoryBtn">Add
                                Subcategory</button>
                        </form>
                    </div>
                </div>

                <!-- Subcategory List -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Subcategory List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Subcategory Name</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="subcategoryTable">
                                @foreach ($subcategories as $subcategory)
                                    <tr id="subcat-{{ $subcategory->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $subcategory->name }}</td>
                                        <td>{{ $subcategory->category->name }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-subcategory"
                                                data-id="{{ $subcategory->id }}" data-name="{{ $subcategory->name }}"
                                                data-category="{{ $subcategory->category_id }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-subcategory"
                                                data-id="{{ $subcategory->id }}">
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

    <!-- Edit Subcategory Modal -->
    <div class="modal fade" id="editSubcategoryModal" tabindex="-1" aria-labelledby="editSubcategoryLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubcategoryLabel">Edit Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_subcategory_id">
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
                        <label for="edit_subcategory_name" class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" id="edit_subcategory_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateSubcategoryBtn">Update Subcategory</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Add Subcategory
                $('#addSubcategoryBtn').click(function(e) {
                    e.preventDefault();
                    let categoryId = $('#category_id').val();
                    let subcategoryName = $('#subcategory_name').val();

                    if (categoryId === "" || subcategoryName.trim() === "") {
                        alert("Please select a category and enter a subcategory name.");
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.subcategories.store') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            category_id: categoryId,
                            name: subcategoryName
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert("Error: " + xhr.responseText);
                        }
                    });
                });

                // Delete Subcategory
                $('.delete-subcategory').click(function() {
                    let subcategoryId = $(this).data('id');
                    if (confirm("Are you sure?")) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.subcategories.delete') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                subcategoryId: subcategoryId
                            },
                            success: function() {
                                $("#subcat-" + subcategoryId).remove();
                            }
                        });
                    }
                });

                // Open Edit Modal
                $('.edit-subcategory').click(function() {
                    let subcategoryId = $(this).data('id');
                    let subcategoryName = $(this).data('name');
                    let categoryId = $(this).data('category');

                    $('#edit_subcategory_id').val(subcategoryId);
                    $('#edit_subcategory_name').val(subcategoryName);
                    $('#edit_category_id').val(categoryId);
                    $('#editSubcategoryModal').modal('show');
                });

                // Update Subcategory
                $('#updateSubcategoryBtn').click(function() {
                    let subcategoryId = $('#edit_subcategory_id').val();
                    let subcategoryName = $('#edit_subcategory_name').val();
                    let categoryId = $('#edit_category_id').val();

                    if (categoryId === "" || subcategoryName.trim() === "") {
                        alert("Please select a category and enter a subcategory name.");
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.subcategories.update') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            subcategoryId: subcategoryId,
                            category_id: categoryId,
                            name: subcategoryName
                        },
                        success: function() {
                            $('#editSubcategoryModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr) {
                            alert("Error: " + xhr.responseText);
                        }
                    });
                });

                $("#toggleSubcategoryForm").click(function() {
                    $("#subcategoryFormContainer").slideToggle();
                });
            });
        </script>
    @endpush
</x-app-layout>
