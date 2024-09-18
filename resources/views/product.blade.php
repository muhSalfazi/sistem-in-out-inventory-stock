@extends('layouts.app')

@section('title', 'Daftar Produksi')

<!-- Custom CSS -->
<style>
    .btn-custom {
        background: linear-gradient(90deg, rgba(58, 123, 213, 1) 0%, rgba(0, 212, 255, 1) 100%);
        border: none;
        color: white;
        font-weight: bold;
    }

    .btn-custom:hover {
        background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(58, 123, 213, 1) 100%);
    }

    .btn-excel {
        background: linear-gradient(90deg, rgb(12, 158, 31) 0%, rgb(53, 252, 106) 100%);
        border: none;
        color: white;
        font-weight: bold;
    }

    .btn-excel:hover {
        background: linear-gradient(90deg, rgb(53, 252, 106) 0%, rgb(12, 158, 31)100%);
    }

    .btn-custom.btn-danger {
        background: linear-gradient(90deg, rgba(255, 0, 0, 1) 0%, rgba(255, 69, 0, 1) 100%);
        border: none;
        color: white;
        font-weight: bold;
    }

    .btn-custom.btn-danger:hover {
        background: linear-gradient(90deg, rgba(255, 69, 0, 1) 0%, rgba(255, 0, 0, 1) 100%);
    }
</style>

@section('content')
    <div class="pb-2">
        @if (session('alerts'))
            <div class="alert alert-warning alert-dismissible fade show"  role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                @foreach (session('alerts') as $alert)
                    <p>{{ $alert }}</p>
                @endforeach
            </div>
        @endif
        @if (session('pesan'))
            <div class="alert alert-warning alert-dismissible fade show"  role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                @foreach (session('pesan') as $pesan)
                    <p>{{ $pesan }}</p>
                @endforeach
            </div>
        @endif

        @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show"  role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('msg') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('error') }}
            </div>
        @endif
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Table and button to add new part -->
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Product</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <!-- Button trigger modal -->
                            <button class="btn btn-excel py-2 mt-1" data-bs-toggle="modal" data-bs-target="#smallModal">
                                <i class="bi-file-earmark-spreadsheet-fill"></i> Import Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-md-end">
                <div>

                    <div class="modal fade" id="smallModal" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Import Excel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                {{-- modal import --}}
                                <div class="modal-body">
                                    <form action="{{ route('product.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload Excel File</label>
                                            <input type="file" class="form-control" id="file" name="file"
                                                accept=".xlsx,.xls,.csv" required>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Small Modal-->

                </div>
            </div>
            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">NO</th>
                            <th scope="col" class="text-center">ID KBI</th>
                            <th scope="col" class="text-center">Part Number</th>
                            <th scope="col" class="text-center">Part Name</th>
                            <th scope="col" class="text-center">Wo No</th>
                            <th scope="col" class="text-center">Inventory ID</th>
                            <th scope="col" class="text-center">Line</th>
                            <th scope="col" class="text-center">Qty</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="text-center">{{ $loop->iteration ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->Id_kbi ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->Part_number ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->Part_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->Wo_no ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->inventory_id ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->line ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->Qty ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-custom btn-sm mt-1" data-bs-toggle="modal"
                                        data-bs-target="#editStockModal{{ $product->id }}">
                                        <i class="bi bi-pen"> Edit</i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- DataTables JavaScript and CSS -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('.datatable').DataTable({
                        // Optional configurations for DataTables
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        lengthChange: false
                    });
                });
            </script>


            <!-- Modal Create Product -->
            <div class="modal fade" id="createStockModal" tabindex="-1" aria-labelledby="createPartModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('product.store') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createPartModalLabel">Create Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="InvID" class="form-label">InvID</label>
                                    <input type="text" class="form-control" id="Inv_id" name="Inv_id"
                                        placeholder="silahkan input InvID" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Part_name" class="form-label">Part Name</label>
                                    <input type="text" class="form-control" id="Part_name" name="Part_name"
                                        placeholder="silahkan input Part name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Part_number" class="form-label">Part Number</label>
                                    <input type="text" class="form-control" id="Part_number" name="Part_number"
                                        placeholder="silahkan input part number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Qty" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="Qty" name="Qty"
                                        placeholder="silahkan input quantity" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-custom">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal Edit Product -->
            @foreach ($products as $product)
                <div class="modal fade" id="editStockModal{{ $product->id }}" tabindex="-1"
                    aria-labelledby="editStockModalLabel{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('product.update', $product->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStockModalLabel{{ $product->id }}">Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_id" name="id" value="{{ $product->id }}">

                                    <div class="mb-3">
                                        <label for="edit_Id_kbi{{ $product->id }}" class="form-label">ID KBI</label>
                                        <input type="text" class="form-control" id="edit_Id_kbi{{ $product->id }}"
                                            name="Id_kbi" value="{{ old('Id_kbi', $product->Id_kbi) }}"
                                            placeholder="input ID KBI">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_Part_name{{ $product->id }}" class="form-label">Part
                                            Name</label>
                                        <input type="text" class="form-control"
                                            id="edit_Part_name{{ $product->id }}" name="Part_name"
                                            value="{{ old('Part_name', $product->Part_name) }}"
                                            placeholder="input part name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_Part_number{{ $product->id }}" class="form-label">Part
                                            Number</label>
                                        <input type="text" class="form-control"
                                            id="edit_Part_number{{ $product->id }}" name="Part_number"
                                            value="{{ old('Part_number', $product->Part_number) }}"
                                            placeholder="Input part number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_Part_number{{ $product->id }}" class="form-label">WO No</label>
                                        <input type="text" class="form-control" id="edit_Wo_no{{ $product->id }}"
                                            name="Wo_no" value="{{ old('Wo_no', $product->Wo_no) }}"
                                            placeholder="Input part WO No">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_Part_number{{ $product->id }}" class="form-label">Inventory
                                            Id</label>
                                        <input type="text" class="form-control"
                                            id="edit_Inventory_id{{ $product->id }}" name="inventory_id"
                                            value="{{ old('inventory_id', $product->inventory_id) }}"
                                            placeholder="Input part Inventory Id">
                                    </div>


                                    <div class="mb-3">
                                        <label for="edit_Qty{{ $product->id }}" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="edit_Qty{{ $product->id }}"
                                            name="Qty" value="{{ old('Qty', $product->Qty) }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-custom">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>




    </div>

@endsection

@push('scripts')
    <script></script>
@endpush
