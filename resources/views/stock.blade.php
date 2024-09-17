@extends('layouts.app')

@section('title', 'Daftar Stock')

<!-- Custom CSS -->
<style>

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
                            {{-- <button class="btn btn-custom py-2 mt-1" data-bs-toggle="modal"
                                data-bs-target="#createStockModal">
                                <i class="ti ti-plus"></i> Created Stock
                            </button> --}}
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
                            <th scope="col" class="text-center">Inventory Id</th>
                            <th scope="col" class="text-center">Part Number</th>
                            <th scope="col" class="text-center">Part Name</th>
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
                                <td class="text-center">{{ $stock->inventory_id ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->Part_number ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->Part_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $stock->min ?? 'N/A'}}</td>
                                <td class="text-center">{{ $stock->max  ?? 'N/A'}}</td>
                                <td class="text-center">{{ $stock->act_stock ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if($stock->status == 'danger')
                                        <span class="badge bg-danger">Danger</span>
                                    @elseif($stock->status == 'okey')
                                        <span class="badge bg-success">Okey</span>
                                    @elseif($stock->status == 'over')
                                        <span class="badge bg-warning">Over</span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <!-- Edit Button -->
                                    {{-- <button class="btn btn-custom btn-sm mt-1 edit-part" data-id="{{ $stock->id }}"
                                       data-bs-toggle="modal"
                                        data-bs-target="#editStockModal">
                                        <i class="bi bi-pen">Edit</i>
                                    </button> --}}

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






        </div>

    </div>

@endsection

@push('scripts')
@endpush
