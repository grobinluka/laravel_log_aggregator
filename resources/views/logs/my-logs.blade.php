<x-main-master>
    @section('content')
        <h3>My Logs</h3>
        <hr>
        <table id="my-logs" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Severity Level</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Create At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectuser as $pu)
                    @foreach ($pu->logs as $log)
                        <tr>
                            <td>{{ $log->severityLevel->level }}</td>
                            <td>{{ $pu->project->title }}</td>
                            <td>{{ $pu->project->slug }}</td>
                            <td>{{ $pu->user->name }}</td>
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
