<x-main-master>
    @section('content')
        <h3>New Project</h3>
        <hr>
        <form action="{{ route('projects.store') }}" method="POST" class="user">
            @csrf

            <!-- Input Field -->
            <div class="form-group">
                <label for="project_id">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter project title..." required>
            </div>

            <!-- Select Dropdown -->
            <div class="form-group">
                <label for="selectOption">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug..." required>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label for="message">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    @endsection
</x-main-master>
