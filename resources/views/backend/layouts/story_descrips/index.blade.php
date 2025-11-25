@extends('backend.app', ['title' => 'Story Descriptions'])

@section('content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <div class="page-header d-flex justify-content-between align-items-center">
                <h1 class="page-title">Descriptions for: {{ $story->title }}</h1>
                <a href="{{ route('admin.story_descrips.create', $story->id) }}" class="btn btn-primary btn-sm">Add Description</a>
            </div>

            @if(session('t-success'))
                <div class="alert alert-success">{{ session('t-success') }}</div>
            @endif

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Cover Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($descriptions as $description)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($description->description, 50) }}</td>
                                    <td>
                                        @if($description->cover_image)
                                            <img src="{{ asset($description->cover_image) }}" alt="Cover Image" width="80">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.story_descrips.edit', $description->id) }}" class="btn btn-sm btn-info">Edit</a>

                                        <form action="{{ route('admin.story_descrips.destroy', $description->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination if needed -->
                    <div class="mt-3">
                        {{ $descriptions->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
