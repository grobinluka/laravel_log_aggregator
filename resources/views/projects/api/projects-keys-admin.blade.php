<x-main-master>

    @section('content')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="mb-0 text-gray-800">Project: {{ $project->title . ' | ' . $project->slug }}</h3>
                <hr>
                <h5 class="mb-0 text-gray-800">User: <a href="{{route('users.projects', $user->id)}}">{{$user->name}}</a></h5>
            </div>
            <div>
                <a href="#" class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#storeModal"><i
                        class="fas fa-key fa-xs"></i> Generate API Key</a>
                <br>
                <small><strong>UUID:</strong> {{ $user->uuid }}</small>
            </div>
        </div>

        <!-- Content Row -->
        <hr>
        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            <div class="col-lg-12 mb-12">
                <h5 class="text-gray-800">Available API Keys</h5>
                <table id="user-apis" class="table table-striped table-bordered" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>API Key</th>
                            <th>Created At</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @foreach ($apiKeys as $apiKey)
                            <tr>
                                <td>{{ $apiKey->name }}</td>
                                <td>{{ $apiKey->api_key }}</td>
                                <td>{{ $apiKey->created_at->toDateTimeString() }}</td>
                                <td>
                                    <a href="#" data-toggle="modal"
                                        data-target="#deleteModal{{ $counter }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <!-- Delete Modal-->
                                    <div class="modal fade" id="deleteModal{{ $counter }}" tabindex="-1"
                                        role="dialog" aria-labelledby="deleteModal{{ $counter }}" aria-hidden="true">
                                        <form action="{{ route('projects.users.apiKeys.destroy', ['project_id' => $project->id, 'user_id' => $user->id, 'api_key_id' => $apiKey->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete API Key</h5>
                                                        <button class="close" type="button" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" value="{{ $apiKey->name }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="form-control btn btn-primary"
                                                            value="Delete">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Store Modal-->
        <div class="modal fade" id="storeModal" tabindex="-1" role="dialog" aria-labelledby="storeModal"
            aria-hidden="true">
            <form action="{{ route('projects.users.apiKeys.store', ['project_id' => $project->id, 'user_id' => $user->id]) }}" method="POST">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Generate API Key</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter name..." required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="form-control btn btn-primary" value="Generate">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {
                $('#user-apis').DataTable();
            });
        </script>
    @endsection

</x-main-master>
