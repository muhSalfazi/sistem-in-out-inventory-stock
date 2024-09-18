@extends('layouts.app')

@section('title', 'Daftar Delivery')

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
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('msg') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('error') }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('alert') }}
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
                    <h5 class="card-title fw-semibold mb-4">Data Delivery</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <!-- Button trigger modal -->
                            <button class="btn btn-custom py-2 mt-1" data-bs-toggle="modal"
                                data-bs-target="#createStockModal">
                                <i class="ti ti-plus"></i> Created Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row mb-2"> --}}
            <div class="col-6 col-lg-2">
                <div class="d-flex gap-2 justify-content-md-end">
                    <div>
                        <button class="btn btn-excel py-2 mt-1" data-bs-toggle="modal" data-bs-target="#smallModal">
                            <i class="bi-file-earmark-spreadsheet-fill"></i> Import Excel
                        </button>

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
                                        <form action="{{ route('delivery.import') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="file" class="form-label">Upload Excel File</label>
                                                <input type="file" class="form-control" id="file" name="file"
                                                    accept=".xlsx,.xls,.csv" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Small Modal-->

                    </div>
                </div>
            </div>
            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">NO</th>
                            <th scope="col" class="text-center">Manifest No</th>
                            <th scope="col" class="text-center">Job No Customer</th>
                            <th scope="col" class="text-center">Inventory ID KBI</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $delivery)
                            <tr>
                                <td class="text-center">{{ $loop->iteration ?? 'N/A' }}</td>
                                <td class="text-center">{{ $delivery->manifest_no ?? 'N/A' }}</td>
                                <td class="text-center">{{ $delivery->job_no_customer ?? 'N/A' }}</td>
                                <td class="text-center">{{ $delivery->inventory_id_kbi ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-custom btn-sm mt-1 edit-part" data-bs-toggle="modal"
                                        data-bs-target="#editStockModal">
                                        <i class="bi bi-pen">Edit</i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('product.destroy', $delivery->id) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-custom btn-sm btn-danger mt-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Product ini?')">
                                            <i class="ti ti-trash">Delete</i>
                                        </button>
                                    </form>
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
                                    <label for="InvID" class="form-label">Manifest No</label>
                                    <input type="number" class="form-control" id="manifest_no" name="manifest_no"
                                        placeholder="silahkan input Manifest No" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Part_name" class="form-label">Job No Customer</label>
                                    <input type="text" class="form-control" id="job_no_customer"
                                        name="job_no_customer" placeholder="silahkan input Job No Customer" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Part_number" class="form-label">Qty</label>
                                    <input type="text" class="form-control" id="Qty" name="Qty"
                                        placeholder="silahkan input Qty" required>
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





        </div>

    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.datatable').DataTable();
            });
        </script>
    @endpush
