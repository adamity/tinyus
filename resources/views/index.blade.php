<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tinyus - URL Shortener</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body class="bg-dark vh-100">
    <div class="container fixed-top">
        @include('inc.message')
    </div>

    <div class="container h-100">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="card bg-light border-0 rounded-5">
                <div class="card-body">
                    <div class="row my-lg-5">
                        <div class="col-12 col-lg-5 text-center">
                            <p class="fw-bold fs-1">Tinyus</p>
                            <p class="lead fs-4 mb-5">Tinyus allows you to convert your long URL into shorten tiny URL. ✨</p>
                            <p class="d-inline-block bg-danger-subtle border border-danger rounded-pill text-danger user-select-none small fw-semibold px-3 py-1 " data-bs-toggle="tooltip" data-bs-title="This is a demo site, so the shorten link will be deleted without notice.">Demo Only ⓘ</p>
                        </div>
                        <div class="col-12 col-lg-7 my-5">
                            <div class="d-flex flex-column align-items-center">
                                <form action="{!! route('encoder') !!}" method="POST" class="w-100">
                                    {!! csrf_field() !!}
                                    <div class="input-group mb-5">
                                        <input type="text" class="form-control form-control-lg" name="origin_link" id="origin_link" placeholder="https://example.com/this-url-is-so-long" aria-label="https://example.com/this-url-is-so-long" aria-describedby="submit">
                                        <button type="submit" class="btn btn-dark" name="submit" id="submit">Go Tiny!</button>
                                    </div>
                                </form>

                                @if (empty($shorten_link))
                                    <button type="button" class="btn btn-outline-dark rounded-pill px-4 disabled">📋 Shorten Link Here...</button>
                                @else
                                    <button type="button" class="btn btn-outline-dark rounded-pill px-4" onclick="copyToClipboard('#shorten')">
                                        📋 <i id="shorten">{{ $shorten_link }}</i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom -->
    <script src="{{ asset('js/modify.js') }}"></script>
</body>

</html>