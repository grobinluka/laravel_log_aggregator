<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

{{-- {{dd($logs)}} --}}
<body class="antialiased">
    <div class="container">
        <h1>Bootstrap Table Example</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Name</th>
                    <th>Severity</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td></td>
                        <td>{{$log->projectuser->project->title}}</td>
                        <td>{{$log->projectuser->user->name}}</td>
                        <td>{{$log->severitylevel->level}}</td>
                        <td>{{$log->description}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
