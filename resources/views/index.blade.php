<x-main-master>

    @section('content')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0">Dashboard</h1>
        </div>
        
        <!-- Content Row -->
        <div class="row">
            @foreach ($projects as $p)
                <div class="col-xl-4 col-md-6 mb-4">
                    <a href="{{ route('projects.show', $p->project->id) }}" class="text-decoration-none">
                        <div class="card shadow h-100 py-2" style="border-left: 4px solid {{ fake()->unique()->hexColor() }}">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Project:</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $p->project->slug }}</div>
                                    </div>
                                    <div class="col text-right">
                                        <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endsection

</x-main-master>
