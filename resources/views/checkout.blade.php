<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('includes.style')

    <title>Laracamp - Solusi Freelance</title>
</head>

<body>

    @include('includes.navbar')

    <section class="checkout">
        <div class="container">
            <div class="row text-center pb-70">
                <div class="col-lg-12 col-12 header-wrap">
                    <p class="story">
                        YOUR FUTURE CAREER
                    </p>
                    <h2 class="primary-header">
                        Start Invest Today
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9 col-12">
                    <div class="row">
                        <div class="col-lg-5 col-12">
                            <div class="item-bootcamp">
                                <img src="{{ url('assets/images/item_bootcamp.png') }}" alt="" class="cover">
                                <h1 class="package">
                                    {{ $camp->title }}
                                </h1>
                                <p class="description">
                                    Bootcamp ini akan mengajak Anda untuk belajar penuh mulai dari pengenalan dasar
                                    sampai membangun sebuah projek asli
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-1 col-12"></div>
                        <div class="col-lg-6 col-12">
                            <form action="{{ route('checkout.store', $camp->id) }}" class="basic-form"
                                method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input name="name" type="text"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                        value="{{ Auth::user()->name }}">
                                    @if ($errors->has('name'))
                                        <p class="text-danger mt-2">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input name="email" type="email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        id="email" value="{{ Auth::user()->email }}">
                                    @if ($errors->has('email'))
                                        <p class="text-danger mt-2">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input name="occupation" type="text"
                                        class="form-control {{ $errors->has('occupation') ? 'is-invalid' : '' }}"
                                        id="occupation" value="{{ old('occupation') ?: Auth::user()->occupation }}">
                                    @if ($errors->has('occupation'))
                                        <p class="text-danger mt-2">{{ $errors->first('occupation') }}</p>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="card" class="form-label">Card Number</label>
                                    <input name="card_number" type="number"
                                        class="form-control {{ $errors->has('card_number') ? 'is-invalid' : '' }}"
                                        id="card" value="{{ old('card_number') ?: Auth::user()->card_number }}">
                                    @if ($errors->has('card_number'))
                                        <p class="text-danger mt-2">{{ $errors->first('card_number') }}</p>
                                    @endif
                                </div>
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <label for="expired" class="form-label">Expired</label>
                                            <input name="expired" type="month"
                                                class="form-control {{ $errors->has('expired') ? 'is-invalid' : '' }}"
                                                id="expired" value="{{ old('expired') ?: Auth::user()->expired }}">
                                            @if ($errors->has('expired'))
                                                <p class="text-danger mt-2">{{ $errors->first('expired') }}</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <label for="cvc"
                                                class="form-label {{ $errors->has('cvc') ? 'is-invalid' : '' }}">CVC</label>
                                            <input name="cvc" type="number" class="form-control" id="cvc"
                                                value="{{ old('cvc') ?: Auth::user()->cvc }}">
                                            @if ($errors->has('cvc'))
                                                <p class="text-danger mt-2">{{ $errors->first('cvc') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="w-100 btn btn-primary">Pay Now</button>
                                <p class="text-center subheader mt-4">
                                    <img src="{{ url('assets/images/ic_secure.svg') }}" alt=""> Your payment is
                                    secure
                                    and encrypted.
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
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
