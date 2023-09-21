<x-main-master>
    @section('content')
        @inject('userController', 'App\Http\Controllers\UserController')
        <h3>{{ $user->name }} Projects</h3>
        <hr>
        <table id="project-user" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->slug }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ substr($project->description, 0, 100) }}</td>
                        <td>
                            @if (!$userController->checkUserProject($user->id, $project->id))
                                <form id="assign-form"
                                    action="{{ route('users.projects.assign', ['user_id' => $user->id, 'project_id' => $project->id]) }}"
                                    method="POST">
                                    @csrf
                                    <input class="btn btn-primary" type="submit" name="submit" value="Assign"
                                        onclick="return confirm('Are you sure you want to assign?')">
                                </form>
                            @elseif($userController->checkUserProject($user->id, $project->id))
                                <form id="unassign-form"
                                    action="{{ route('users.projects.unassign', ['user_id' => $user->id, 'project_id' => $project->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-danger" type="submit" name="submit" value="Unassign"
                                        onclick="return confirm('Are you sure you want to unassign?')">
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {
                $('#project-user').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ]
                });
            });
        </script>
    @endsection
</x-main-master>
