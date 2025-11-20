@extends('backend.app', ['title' => 'Events'])

@section('content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <div class="page-header d-flex justify-content-between align-items-center">
                <h1 class="page-title">Event List</h1>
                <a href="{{ route('admin.event.create') }}" class="btn btn-primary btn-sm">Add Event</a>
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
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                    <tr>
                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->date }}</td>
                                        <td>{{ $event->start_time }}</td>
                                        <td>{{ $event->end_time }}</td>
                                        <td>{{ $event->address }}</td>
                                        <td>
                                            <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No events found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $events->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
