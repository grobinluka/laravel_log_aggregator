<x-main-master>
    @section('content')
        <h3>New Log Report for {{ $project->slug }}</h3>
        <hr>
        <form action="{{ route('log.store', $project->id) }}" method="POST" class="user">
            @csrf

            <!-- Input Field -->
            <div class="form-group">
                <label for="project_id">Project</label>
                <input type="text" class="form-control" id="project_id" name="project_id"
                    value="{{ $project->slug . ' | ' . $project->title }}" disabled>
            </div>

            <!-- Select Dropdown -->
            <div class="form-group">
                <label for="selectOption">Select Option</label>
                <select class="form-control" id="selectOption" name="severitylevel" required>
                    @foreach ($severitylevels as $level)
                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="description" rows="4" required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Report</button>
            </div>
        </form>
    @endsection
</x-main-master>
