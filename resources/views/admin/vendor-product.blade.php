<x-app-layout>

    <div class="container mt-4">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="mb-0">Product List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Vendor</th>
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
                                    <td>{{ $product->vendorUser->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->subcategory->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
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

    @push('scripts')
        <script>
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
        </script>
    @endpush
</x-app-layout>
