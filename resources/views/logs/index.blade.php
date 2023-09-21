<x-main-master>
    @section('content')
        <h3>All Logs</h3>
        <hr>
        <table id="all-logs" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Severity Level</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Log Description</th>
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
                $('#all-logs').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ]
                });
            });
        </script>
    @endsection
</x-main-master>
