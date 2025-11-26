@extends('backend.app', ['title' => 'Edit Story'])

@section('content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title">Edit Story</h1>
                <a href="{{ route('admin.mystories.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.mystories.update', $mystory->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $mystory->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Short Description -->
                                <div class="mb-3">
                                    <label for="short_descriptions" class="form-label">Short Description <span class="text-danger">*</span></label>
                                    <textarea name="short_descriptions" id="short_descriptions" class="form-control" rows="3" required>{{ old('short_descriptions', $mystory->short_descriptions) }}</textarea>
                                    @error('short_descriptions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Thumbnail -->
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                                    @if($mystory->thumbnail)
                                        <div class="mt-2">
                                            <img src="{{ asset($mystory->thumbnail) }}" alt="{{ $mystory->title }}" width="120" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    @error('thumbnail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @php
                                    $storyDescription = $mystory->descriptions ?? null;
                                @endphp

                                <!-- Long Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Long Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $storyDescription->description ?? '') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Cover Image -->
                                <div class="mb-3">
                                    <label for="cover_image" class="form-label">Cover Image</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control">
                                    @if($storyDescription && $storyDescription->cover_image)
                                        <div class="mt-2">
                                            <img src="{{ asset($storyDescription->cover_image) }}" alt="Cover Image" width="120" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    @error('cover_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Update Story</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
