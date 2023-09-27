<x-main-master>
    @section('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.7.0/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/fh-3.4.0/r-2.5.0/sb-1.5.0/sp-2.2.0/datatables.min.css" rel="stylesheet">
    @endsection

    @section('content')
        <div class="container mb-5">
            <h3>All Projects</h3>
            <hr>
            <table id="projects" class="table table-striped table-bordered" style="width:100%">
                <thead>
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
                            <td>{{$project->title}}</td>
                            <td>{{$project->slug}}</td>
                            <td>{{substr($project->description, 0, 100)}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

    @section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.7.0/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/fh-3.4.0/r-2.5.0/sb-1.5.0/sp-2.2.0/datatables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#projects').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ]
                });
            });
        </script>
    @endsection
</x-main-master>
