<x-main-master>
    @section('content')
        <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                        <div class="col-lg-7">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Edit {{ $user->name }}!</h1>
                                </div>
                                <form method="POST" action="{{ route('users.update', $user->id) }}" class="user">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input id="name" type="text" class="form-control form-control-user"
                                                @error('name') is-invalid @enderror" name="name" required
                                                autocomplete="name" autofocus placeholder="Name"
                                                value="{{ $user->name }}">

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input id="email" type="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            name="email" required autocomplete="email" placeholder="Email Address"
                                            value="{{ $user->email }}">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <select name="role_id" id="role_id" class="form-control">
                                                @foreach ($roles as $role)
                                                    @if ($user->role_id === $role->id)
                                                        <option value="{{ $role->id }}" selected>
                                                            {{ ucfirst($role->name) }}</option>
                                                    @else
                                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                {{ __('Update') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-main-master>
