<x-main-master>
    @section('content')
        <h3>My Logs</h3>
        <hr>
        <table id="my-logs" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Severity Level</th>
                    <th>Project Title</th>
                    <th>Project Slug</th>
                    <th>Log Description</th>
                    <th>Log Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectUser as $pu)
                    @foreach ($pu->logs as $log)
                        <tr>
                            <td>{{ $log->severityLevel->level }}</td>
                            <td><a href="{{route('projects.show', $pu->project->id)}}">{{ $pu->project->title }}</a></td>
                            <td><a href="{{route('projects.show', $pu->project->id)}}">{{ $pu->project->slug }}</a></td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->created_at->toDateTimeString() }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {
                $('#my-logs').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ]
                });
            });
        </script>
    @endsection
</x-main-master>
