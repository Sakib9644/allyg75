    @forelse($events as $event)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $event->title }}</td>
            <td>{{ $event->date }}</td>
            <td>{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</td>

            <td>{{ $event->address }}</td>
            <td>
                <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST"  class="delete-form"
                    style="display:inline-block;" onsubmit="return confirmDelete()">
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
