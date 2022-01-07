<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('includes.style')
    <title>Laracamp My Dashboard</title>
</head>

<body>

    @include('includes.navbar')

    <div class="container mt-2">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        My Camps
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Camp</th>
                                    <th>Price</th>
                                    <th>Register Data</th>
                                    <th>Paid Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($checkouts as $item)
                                    <tr>
                                        <td>
                                            {{ $item->User->name }}
                                        </td>
                                        <td>
                                            {{ $item->Camp->title }}
                                        </td>
                                        <td>
                                            {{ $item->Camp->price }}K
                                        </td>
                                        <td>
                                            {{ $item->created_at->format('M - d - y') }}
                                        </td>
                                        <td>
                                            @if ($item->is_paid)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Waiting</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$item->is_paid)
                                                <form action="{{ route('admin.checkout.update', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm">Set to Paid</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Camps Registered</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js "
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj " crossorigin="anonymous ">
    </script>

</body>

</html>
