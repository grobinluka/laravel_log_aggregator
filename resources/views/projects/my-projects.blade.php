<x-main-master>
    @section('content')
        <h3>My Projects</h3>
        <hr>
        <table id="my-projects" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->slug }}</td>
                        <td>{{ substr($project->description, 0, 100) }}</td>
                        <td>
                            <a href="{{ route('log.create', $project->id) }}">Log a Report</a>
                            <br>
                            <hr>
                            <a href="{{ route('projects.show', $project->id) }}">Stats</a>
                            <br>
                            <hr>
                            <a href="{{ route('projects.apiKeys.index', $project->id) }}">API Keys</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {
                $('#my-projects').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ]
                });
            });
        </script>
    @endsection
</x-main-master>
