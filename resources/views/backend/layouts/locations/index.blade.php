@extends('backend.app', ['title' => 'Locations'])

@section('content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <div class="page-header d-flex justify-content-between align-items-center">
                <h1 class="page-title">Location List</h1>
                <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-sm">Add Location</a>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Address</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($location as $center)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $center->title }}</td>
                                            <td>{{ $center->address }}</td>
                                            <td>{{ $center->latitude ?? '-' }}</td>
                                            <td>{{ $center->longitude ?? '-' }}</td>
                                            <td>
                                                @if($center->is_open)
                                                    <span class="badge bg-success">Open</span>
                                                @else
                                                    <span class="badge bg-danger">Closed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.locations.edit', $center->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('admin.locations.destroy', $center->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this location?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No locations found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $location->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
