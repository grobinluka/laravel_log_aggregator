<x-main-master>

    @section('content')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Project Stats - {{ $project->title . ' | ' . $project->slug }}</h1>
            <a href="{{route('projects.apiKeys.index', $project->id)}}" class="btn btn-secondary"><i class="fas fa-key fa-xs"></i> API Keys</a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Logs Last 1 Hours -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Logs Last 1 Hours</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hourCounter }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logs Last 24 Hours -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Logs Last 24 Hours</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hour24Counter }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-12">

                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Log Statistic</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($numOfLogsPerSeverityLevel as $key => $level)
                            <h4 class="small font-weight-bold">{{ $key }}<span
                                    class="float-right">{{ $level }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $level }}%; background-color: {{ fake()->unique()->hexColor() }};"
                                    aria-valuenow="{{ $level }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endsection

</x-main-master>
