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
        @if (session('alerts'))
        <div class="alert alert-warning alert-dismissible fade show"  role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            @foreach (session('alerts') as $alert)
                <p>{{ $alert }}</p>
            @endforeach
        </div>
    @endif
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
                    <h5 class="card-title fw-semibold mb-4">Data Planning</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <!-- Button trigger modal -->
                            <button class="btn btn-custom py-2 mt-1" data-bs-toggle="modal"
                                data-bs-target="#createPlanningModal">
                                <i class="ti ti-plus"></i> Created Stock
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="d-flex gap-2 justify-content-md-end">
                    <div>
                        <!-- Button trigger modal -->
                        <button class="btn btn-excel py-2 mt-1" data-bs-toggle="modal" data-bs-target="#smallModal">
                            <i class="bi-file-earmark-spreadsheet-fill"></i> Import Excel
                        </button>
                    </div>
                </div>
            </div>

            {{-- import excel --}}
            <div class="modal fade" id="smallModal" tabindex="-1">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        {{-- modal import --}}
                        <div class="modal-body">
                            <form action="{{ route('planning.import') }}" method="POST" enctype="multipart/form-data">
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
            {{-- end excel --}}

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">NO</th>
                            <th scope="col" class="text-center">Inventory Id</th>
                            <th scope="col" class="text-center">Part Number</th>
                            <th scope="col" class="text-center">Part Name</th>
                            <th scope="col" class="text-center">min</th>
                            <th scope="col" class="text-center">max</th>
                            <th scope="col" class="text-center">Tanggal Create</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plannings as $planning)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $planning->stock->inventory_id ?? 'N/A' }}</td>
                                <td class="text-center">{{ $planning->stock->Part_number ?? 'N/A' }}</td>
                                <td class="text-center">{{ $planning->stock->Part_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $planning->min ?? 'N/A' }}</td>
                                <td class="text-center">{{ $planning->max ?? 'N/A' }}</td>
                                <td class="text-center">
                                    {{ $planning->updated_at ? $planning->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>


                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-custom btn-sm mt-1 edit-part" data-id="{{ $planning->id }}"
                                        data-bs-toggle="modal" data-bs-target="#updatePlanningModal{{ $planning->id }}">
                                        <i class="bi bi-pen"></i> Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('planning.destroy', $planning->id) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-custom btn-sm btn-danger mt-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Planning ini?')"> <i
                                                class="ti ti-trash">Delete</i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- Modal Create Planning -->
            <div class="modal fade" id="createPlanningModal" tabindex="-1" aria-labelledby="createPlanningModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('planning.store') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createPlanningModalLabel">Create Planning</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="inventory_id" class="form-label">Inventory</label>
                                    <select class="form-control" id="id_stock" name="id_stock" required>
                                        <option value="" selected disabled>Select Inventory</option>
                                        @foreach ($inventories as $inventory)
                                            <option value="{{ $inventory->id }}">{{ $inventory->inventory_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Additional fields can be filled automatically using JavaScript -->
                                <div class="mb-3">
                                    <label for="min" class="form-label">Min</label>
                                    <input type="number" class="form-control" id="min" name="min"
                                        placeholder="Minimum quantity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="max" class="form-label">Max</label>
                                    <input type="number" class="form-control" id="max" name="max"
                                        placeholder="Maximum quantity" required>
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


            <!-- Modal update Planning -->
            @foreach ($plannings as $planning)
                <!-- Modal for updating planning -->
                <div class="modal fade" id="updatePlanningModal{{ $planning->id }}" tabindex="-1"
                    aria-labelledby="updatePlanningModalLabel{{ $planning->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('planning.update', $planning->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updatePlanningModalLabel{{ $planning->id }}">Update
                                        Planning</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="min{{ $planning->id }}" class="form-label">Min</label>
                                        <input type="number" class="form-control" id="min{{ $planning->id }}"
                                            name="min" placeholder="{{ $planning->min }}"
                                            value="{{ $planning->min }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="max{{ $planning->id }}" class="form-label">Max</label>
                                        <input type="number" class="form-control" id="max{{ $planning->id }}"
                                            name="max" placeholder="{{ $planning->max }}"
                                            value="{{ $planning->max }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-custom">Save</button>
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
@endpush
