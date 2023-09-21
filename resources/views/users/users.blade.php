<x-main-master>
    @section('content')
        <h3>All Users</h3>
        <hr>
        <table id="users" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Email Verified</th>
                    <th>Role</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->email_verified_at)
                                {{ $user->email_verified_at->diffForHumans() }}
                            @else
                                Not Verified
                            @endif
                        </td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="{{ route('users.projects', $user->id) }}">Assign Projects</a>
                            <br>
                            <a href="{{ route('users.edit', $user->id) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {
                $('#users').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ]
                });
            });
        </script>
    @endsection
</x-main-master>
