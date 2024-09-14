@extends('layouts.app')

@section('title', 'Daftar Stock')

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
                    <h5 class="card-title fw-semibold mb-4">Data Stock</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <!-- Button trigger modal -->
                            <button class="btn btn-custom py-2 mt-1" data-bs-toggle="modal"
                                data-bs-target="#createStockModal">
                                <i class="ti ti-plus"></i> Created Stock
                            </button>
                        </div>
                    </div>
                </div>
            </div>
                        
                  
            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">NO</th>
                            <th scope="col" class="text-center">ID KBI</th>
                            <th scope="col" class="text-center">Part Name</th>
                            <th scope="col" class="text-center">Part Number</th>
                            <th scope="col" class="text-center">Inventory Id</th>
                            <th scope="col" class="text-center">min</th>
                            <th scope="col" class="text-center">max</th>
                            <th scope="col" class="text-center">act stock</th>
                            <th scope="col" class="text-center">status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $stock->Id_kbi ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->Part_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->Part_number ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->inventory_id ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->min ?? 'N/A'}}</td>
                                <td class="text-center">{{ $stock->max  ?? 'N/A'}}</td>
                                <td class="text-center">{{ $stock->act_stock ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->status ?? 'N/A' }}</td>

                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-custom btn-sm mt-1 edit-part" data-id="{{ $stock->id }}"
                                       data-bs-toggle="modal"
                                        data-bs-target="#editStockModal">
                                        <i class="bi bi-pen">Edit</i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('stock.destroy', $stock->id) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-custom btn-sm btn-danger mt-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Stock ini?')">   <i class="ti ti-trash">Delete</i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal Create Stock -->
            <div class="modal fade" id="createStockModal" tabindex="-1" aria-labelledby="createPartModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('stock.store') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createPartModalLabel">Create Stock</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="InvID" class="form-label">InvID</label>
                                    <input type="number" class="form-control" id="InvID" name="InvID" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Part_name" class="form-label">Part Name</label>
                                    <input type="text" class="form-control" id="Part_name" name="Part_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Part_number" class="form-label">Part Number</label>
                                    <input type="text" class="form-control" id="Part_number" name="Part_number"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="min" class="form-label">Min Quantity</label>
                                    <input type="number" class="form-control" id="min" name="min" required>
                                </div>
                                <div class="mb-3">
                                    <label for="max" class="form-label">Max Quantity</label>
                                    <input type="number" class="form-control" id="max" name="max" required>
                                </div>
                                <div class="mb-3">
                                    <label for="act_stock" class="form-label">Actual Stock</label>
                                    <input type="number" class="form-control" id="act_stock" name="act_stock" required>
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


            <!-- Modal Edit Part -->
            <div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {{-- @foreach ($stocks as $stock) --}}
                            <form id="editPartForm" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStockModalLabel">Edit Part</h5>
                                    <button type="button" class="btn-close btn-custom" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_part_id" name="id">

                                    <div class="mb-3">
                                        <label for="edit_Inv_id" class="form-label">InvID</label>
                                        <input type="number" class="form-control" id="edit_InvID" name="Inv_id"
                                            placeholder="silahkan input InvID">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_Part_name" class="form-label">Nama Part</label>
                                        <input type="text" class="form-control" id="edit_Part_name" name="Part_name"
                                            placeholder="silahkan input nama part">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_Part_number" class="form-label">No Part</label>
                                        <input type="text" class="form-control" id="edit_Part_number"
                                            name="Part_number" placeholder="silahkan input part number">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_min" class="form-label">Min</label>
                                        <input type="number" class="form-control" id="edit_Qty" name="min"
                                            placeholder="silahkan input min">
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_max" class="form-label">Max</label>
                                        <input type="number" class="form-control" id="edit_Qty" name="max"
                                            placeholder="silahkan input max">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_actstock" class="form-label">Act Stock</label>
                                        <input type="number" class="form-control" id="edit_max" name="max"
                                            placeholder="silahkan input actual stock">
                                    </div>
                                    
                                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-custom">Save changes</button>
                    </div>
                    </form>
                    {{-- @endforeach --}}
                </div>
            </div>



        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('edit_InvID').value = this.getAttribute('data-invid');
        document.getElementById('edit_Part_name').value = part_name;
        document.getElementById('edit_Part_number').value = part_number;
        document.getElementById('edit_Qty').value = qty;
    </script>
@endpush
