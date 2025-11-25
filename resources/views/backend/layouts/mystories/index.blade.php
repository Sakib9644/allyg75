@extends('backend.app', ['title' => 'My Stories'])

@section('content')
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">

                <!-- Page Header -->
                <div class="page-header d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="page-title mb-1">My Stories</h1>
                        <p class="text-muted mb-0">Manage your story collection</p>
                    </div>
                    <a href="{{ route('admin.mystories.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>Add New Story
                    </a>
                </div>

                <!-- Success Message -->
                @if (session('t-success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fe fe-check-circle me-2"></i>{{ session('t-success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fe fe-alert-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Stories Card -->
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">Stories List</h3>
                        <div class="ms-auto">
                            <span class="badge bg-primary">Total: {{ $stories->total() }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($stories->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="60">#</th>
                                            <th>Title</th>
                                            <th width="120">Thumbnail</th>
                                            <th>Short Description</th>
                                            <th width="280" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stories as $story)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($stories->currentPage() - 1) * $stories->perPage() }}
                                                </td>
                                                <td>
                                                    <strong>{{ $story->title }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    @if ($story->thumbnail)
                                                        <img src="{{ asset($story->thumbnail) }}"
                                                             alt="{{ $story->title }}"
                                                             class="img-thumbnail"
                                                             width="80"
                                                             height="80"
                                                             style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                             style="width: 80px; height: 80px; border-radius: 4px;">
                                                            <i class="fe fe-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        {{ Str::limit($story->short_descriptions, 80) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm d-flex flex-wrap gap-1" role="group">
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('admin.mystories.edit', $story->id) }}"
                                                           class="btn btn-info"
                                                           data-bs-toggle="tooltip"
                                                           title="Edit Story">
                                                            <i class="fe fe-edit"></i> Edit
                                                        </a>

                                                        <!-- Add Description Button -->
                                                        <a href="{{ route('admin.story_descrips.create', $story->id) }}"
                                                           class="btn btn-warning"
                                                           data-bs-toggle="tooltip"
                                                           title="Add Description">
                                                            <i class="fe fe-plus-circle"></i> Add Long Desc
                                                        </a>

                                                        <!-- View Descriptions Button -->
                                                        <a href="{{ route('admin.story_descrips.index', $story->id) }}"
                                                           class="btn btn-primary"
                                                           data-bs-toggle="tooltip"
                                                           title="View Descriptions">
                                                            <i class="fe fe-eye"></i> View
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('admin.mystories.destroy', $story->id) }}"
                                                              method="POST"
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this story? This action cannot be undone.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-danger"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Delete Story">
                                                                <i class="fe fe-trash-2"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $stories->firstItem() }} to {{ $stories->lastItem() }} of {{ $stories->total() }} entries
                                </div>
                                <div>
                                    {{ $stories->links() }}
                                </div>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fe fe-book-open" style="font-size: 64px; color: #ddd;"></i>
                                </div>
                                <h4 class="mb-2">No Stories Found</h4>
                                <p class="text-muted mb-4">You haven't created any stories yet. Start by adding your first story.</p>
                                <a href="{{ route('admin.mystories.create') }}" class="btn btn-primary">
                                    <i class="fe fe-plus me-2"></i>Create Your First Story
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush
