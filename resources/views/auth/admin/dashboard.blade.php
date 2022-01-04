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

    <section class="dashboard my-5">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        My Bootcamps
                    </h2>
                </div>
            </div>
            @include('components.alert')
            <div class="row my-5 table-responsive">
                <table class="table text-center ">
                    <thead>
                        <tr>
                            <th>
                                Picture
                            </th>
                            <th>
                                Camps Name
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Service
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checkouts as $item)
                            <tr class="align-middle">
                                <td width="18%">
                                    <img src="{{ url('assets/images/item_bootcamp.png') }}" height="120" alt="">
                                </td>
                                <td>
                                    <p class="mb-2">
                                        <strong>{{ $item->Camp->title }}</strong>
                                    </p>
                                    <p>
                                        {{ $item->created_at->format('M d, Y') }}
                                    </p>
                                </td>
                                <td>
                                    <strong>${{ $item->Camp->price }}K</strong>
                                </td>
                                <td>
                                    @if ($item->is_paid)
                                        <Strong class="text-success">Payment Success</Strong>
                                    @else
                                        <Strong>Waiting for Payment</Strong>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary">
                                        Contact Support
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5">No Data Camp</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js "
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj " crossorigin="anonymous ">
    </script>

</body>

</html>
