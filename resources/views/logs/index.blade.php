<x-main-master>
    @section('content')
        <h3>All Logs</h3>
        <hr>
        <table id="all-logs" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Severity Level</th>
                    <th>Project Title</th>
                    <th>Project Slug</th>
                    <th>User Name</th>
                    <th>Log Description</th>
                    <th>API Key</th>
                    <th>Log Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectUser as $pu)
                    @foreach ($pu->logs as $log)
                        <tr>
                            <td>{{ $log->severityLevel->level }}</td>
                            <td>{{ $pu->project->title }}</td>
                            <td>{{ $pu->project->slug }}</td>
                            <td><a href="{{route('users.projects', $pu->user->id)}}">{{ $pu->user->name }}</a></td>
                            <td>{{ $log->description }}</td>
                            <td>
                                @if($log->apiKey)
                                    <div class="text-break"><a href="{{route('projects.users.apiKeys.index', ['project_id' => $pu->project->id, 'user_id' => $pu->user->id])}}">{{ $log->apiKey->api_key }}</a></div>
                                @else
                                    /
                                @endif
                            </td>
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
