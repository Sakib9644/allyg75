@extends('backend.app', ['title' => 'Edit Story Description'])

@section('content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <div class="page-header d-flex justify-content-between align-items-center">
                <h1 class="page-title">Edit Description for: {{ $story->title }}</h1>
                <a href="{{ route('admin.story_descrips.index', $story->id) }}" class="btn btn-secondary btn-sm">Back to Descriptions</a>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.story_descrips.update', $description->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="my_stories_id" value="{{ $story->id }}">

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $description->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Cover Image -->
                                <div class="mb-3">
                                    <label for="cover_image" class="form-label">Cover Image</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control">
                                    @if($description->cover_image)
                                        <div class="mt-2">
                                            <img src="{{ asset($description->cover_image) }}" alt="Cover Image" width="120">
                                        </div>
                                    @endif
                                    @error('cover_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Update Description</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
