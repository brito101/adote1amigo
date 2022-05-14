@extends('web.master.master')

@section('css')
    <link rel="stylesheet" href="{{ url(asset('frontend/assets/libs/libs.css')) }}">
@endsection

@section('content')
    <div class="main_filter page_filter pb-2">
        <div class="container">
            <section class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="col-12 col-md-9 text-center" style="margin-top: 30px;">
                        @if ($banner->link3)
                            <a href="{{ $banner->link3 ?? route('web.register') }}">
                                <img src="{{ $banner->cover3? asset('storage/' . $banner->cover3): url(asset('frontend/assets/images/banner-horizontal.png')) }}"
                                    class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt="Anuncie Grátis"
                                    title="Anuncie Grátis"></a>
                        @else
                            <a href="{{ route('web.register') }}">
                                <img src="{{ url(asset('frontend/assets/images/banner-horizontal.png')) }}"
                                    class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt="Anuncie Grátis"
                                    title="Anuncie Grátis"></a>
                        @endif
                    </div>
                    <div class="col-12 col-md-3 text-center d-none d-md-block" style="margin-top: 30px;">
                        @if ($banner->link2)
                            <a href="{{ $banner->link2 ?? route('web.register') }}"
                                class="d-flex justify-content-center align-content-center h-100">
                                <img src="{{ $banner->cover2? asset('storage/' . $banner->cover2): url(asset('frontend/assets/images/banner-horizontal.png')) }}"
                                    class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt="Anúncios desta ONG"
                                    title="Anúncios desta ONG"></a>
                        @else
                            <a href="{{ route('web.register') }}"
                                class="d-flex justify-content-center align-content-center h-100">
                                <img src="{{ url(asset('frontend/assets/images/banner-horizontal-lateral.png')) }}"
                                    class="img-thumbnail border-0 w-100 m-0 p-0 d-inline-block" alt="Anuncie Grátis"
                                    title="Anuncie Grátis"></a>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <form action="{{ route('web.filter') }}" method="post" class="w-100 p-3 mb-0">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12 mt-3">
                                <select class="selectpicker" name="filter_city" id="city" title="Cidade"
                                    data-actions-box="true" data-index="1"
                                    data-action="{{ route('component.main-filter.city') }}">
                                    @foreach ($cities as $city)
                                        <option>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <select class="selectpicker" name="filter_category" id="category" title="Animal"
                                    data-index="2" data-action="{{ route('component.main-filter.category') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>

                            <div class="col-12 text-center button_search">
                                <button class="btn btn-front icon-search">Pesquisar</button>
                            </div>
                        </div>
                    </form>

                </div>

                <div class=" col-12 col-md-9 overflow-hidden">


                    @if ($spotlight->count() > 0)
                        <div class="row pb-2 pb-lg-5" style="margin-top: 30px;">
                            <div class="col-12">
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="d-flex">
                                                @foreach ($spotlight->slice(0, 4) as $automotive)
                                                    <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                        <div class="img-responsive">
                                                            <a
                                                                href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                <img src="{{ $automotive->coverFront() }}"
                                                                    class="card-img-top rounded"
                                                                    alt="{{ $automotive->title }}" style="height: auto">
                                                            </a>
                                                        </div>

                                                        <div class="d-flex flex-wrap justify-content-between">
                                                            <p class="my-1 col-12 text-left"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->model . ' - ' . $automotive->brand }}</a>
                                                            </p>
                                                            <p class="col-9 text-truncate"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->state . ' - ' . $automotive->neighborhood }}</a>
                                                            </p>
                                                            <a href="#"
                                                                class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                data-id="{{ $automotive->id }}"></a>
                                                        </div>
                                                    </article>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if ($spotlight->count() > 4)
                                            <div class="carousel-item">
                                                <div class="d-flex">
                                                    @foreach ($spotlight->slice(3, 4) as $automotive)
                                                        <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                            <div class="img-responsive">
                                                                <a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                    <img src="{{ $automotive->coverFront() }}"
                                                                        class="card-img-top rounded"
                                                                        alt="{{ $automotive->title }}"
                                                                        style="height: auto">
                                                                </a>
                                                            </div>
                                                            <p class="my-1 col-12 text-left"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->model . ' - ' . $automotive->brand }}</a>
                                                            </p>
                                                            <p class="col-9 text-truncate"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->state . ' - ' . $automotive->neighborhood }}</a>
                                                            </p>
                                                            <div class="d-flex flex-wrap justify-content-between">

                                                                <a href="#"
                                                                    class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                    data-id="{{ $automotive->id }}"></a>
                                                            </div>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if ($spotlight->count() > 8)
                                            <div class="carousel-item">
                                                <div class="d-flex">
                                                    @foreach ($spotlight->slice(7, 4) as $automotive)
                                                        <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                            <div class="img-responsive">
                                                                <a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                    <img src="{{ $automotive->coverFront() }}"
                                                                        class="card-img-top rounded"
                                                                        alt="{{ $automotive->title }}"
                                                                        style="height: auto">
                                                                </a>
                                                            </div>
                                                            <p class="my-1 col-12 text-left"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->model . ' - ' . $automotive->brand }}</a>
                                                            </p>
                                                            <p class="col-9 text-truncate"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->state . ' - ' . $automotive->neighborhood }}</a>
                                                            </p>
                                                            <div class="d-flex flex-wrap justify-content-between">

                                                                <a href="#"
                                                                    class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                    data-id="{{ $automotive->id }}"></a>
                                                            </div>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if ($spotlight->count() > 12)
                                            <div class="carousel-item">
                                                <div class="d-flex">
                                                    @foreach ($spotlight->slice(11, 4) as $automotive)
                                                        <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                            <div class="img-responsive">
                                                                <a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                    <img src="{{ $automotive->coverFront() }}"
                                                                        class="card-img-top rounded"
                                                                        alt="{{ $automotive->title }}"
                                                                        style="height: auto">
                                                                </a>
                                                            </div>
                                                            <p class="my-1 col-12 text-left"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->model . ' - ' . $automotive->brand }}</a>
                                                            </p>
                                                            <p class="col-9 text-truncate"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->state . ' - ' . $automotive->neighborhood }}</a>
                                                            </p>
                                                            <div class="d-flex flex-wrap justify-content-between">

                                                                <a href="#"
                                                                    class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                    data-id="{{ $automotive->id }}"></a>
                                                            </div>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if ($spotlight->count() > 16)
                                            <div class="carousel-item">
                                                <div class="d-flex">
                                                    @foreach ($spotlight->slice(15, 4) as $automotive)
                                                        <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                            <div class="img-responsive">
                                                                <a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                    <img src="{{ $automotive->coverFront() }}"
                                                                        class="card-img-top rounded"
                                                                        alt="{{ $automotive->title }}"
                                                                        style="height: auto">
                                                                </a>
                                                            </div>
                                                            <p class="my-1 col-12 text-left"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->model . ' - ' . $automotive->brand }}</a>
                                                            </p>
                                                            <p class="col-9 text-truncate"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->state . ' - ' . $automotive->neighborhood }}</a>
                                                            </p>
                                                            <div class="d-flex flex-wrap justify-content-between">

                                                                <a href="#"
                                                                    class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                    data-id="{{ $automotive->id }}"></a>
                                                            </div>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if ($spotlight->count() > 20)
                                            <div class="carousel-item">
                                                <div class="d-flex">
                                                    @foreach ($spotlight->slice(19, 4) as $automotive)
                                                        <article class="col-6 col-lg-3 mb-2 mb-lg-0">
                                                            <div class="img-responsive">
                                                                <a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                                    <img src="{{ $automotive->coverFront() }}"
                                                                        class="card-img-top rounded"
                                                                        alt="{{ $automotive->title }}"
                                                                        style="height: auto">
                                                                </a>
                                                            </div>
                                                            <p class="my-1 col-12 text-left"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->model . ' - ' . $automotive->brand }}</a>
                                                            </p>
                                                            <p class="col-9 text-truncate"><a
                                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                                    class="text-dark main_properties_price text-truncate d-block"
                                                                    style="font-size: 16px">{{ $automotive->state . ' - ' . $automotive->neighborhood }}</a>
                                                            </p>
                                                            <div class="d-flex flex-wrap justify-content-between">

                                                                <a href="#"
                                                                    class="ml-2 heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                                    data-id="{{ $automotive->id }}"></a>
                                                            </div>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                        data-slide="prev" style="margin-top: -50px; margin-left: -60px; opacity:1;">
                                        <span class="icon-chevron-left" aria-hidden="true"
                                            style="font-size: 20px; color:#aaa"></span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                    <a class="carousel-control-next overflow-hidden" href="#carouselExampleControls"
                                        role="button" data-slide="next"
                                        style="margin-top: -50px; margin-right: -60px; opacity:1;">
                                        <span class="icon-chevron-right" aria-hidden="true"
                                            style="font-size: 20px; color:#aaa"></span>
                                        <span class="sr-only">Próximo</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <section class="row main_properties d-flex justify-content-center">
                        @if ($automotives)
                            @foreach ($automotives as $automotive)
                                <div class="col-12 col-md-12 col-lg-6 mb-4">
                                    <article class="card main_properties_item border border-primary p-2">
                                        <h2 class="m-0 mb-2 d-flex justify-content-between">
                                            <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                class="text-dark main_properties_price text-truncate d-block">{{ $automotive->title }}</a>
                                            <a href="#"
                                                class="heart-like text-front icon-heart-o text-dark text-decoration-none text-right"
                                                data-id="{{ $automotive->id }}"></a>
                                        </h2>
                                        <div class="container p-0 col-12 d-flex">
                                            <div class="img-responsive col-7 p-0 pb-2">
                                                <a
                                                    href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}">
                                                    <img src="{{ $automotive->coverFront() }}"
                                                        class="card-img-top rounded" alt="{{ $automotive->title }}">
                                                </a>
                                            </div>
                                            <div class="card-body p-0 col-5 pl-2 pt-2">
                                                <div
                                                    class="d-flex flex-wrap justify-content-center h-100 main_automotives_item">
                                                    <div class="col-12 d-flex flex-wrap justify-content-center">

                                                        <p
                                                            class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                            {{ $automotive->brand }}</p>
                                                    </div>
                                                    <div class="col-12 d-flex flex-wrap justify-content-center">
                                                        <p
                                                            class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                            {{ $automotive->model }}</p>
                                                    </div>
                                                    <div class="col-12 d-flex flex-wrap justify-content-center">
                                                        <p
                                                            class="font-weight-bold text-sm text-dark text-truncate mt-2 mb-n1 w-100 text-center main_automotives_item">
                                                            {{ $automotive->year ?? $automotive->year }}
                                                        </p>
                                                    </div>
                                                    <div class="col-12 d-flex flex-wrap justify-content-center">
                                                        <p
                                                            class="mt-2 mb-n1 text-muted text-center w-100 main_automotives_item">
                                                            {{ $automotive->city }}</p>
                                                        <p class="mb-2 text-muted main_automotives_item text-center w-100">
                                                            {{ $automotive->neighborhood }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 p-5 bg-white my-5">
                                <h2 class="text-front icon-info text-center">
                                    Ooops, não encontramos nenhum animal para você adotar!</h2>
                                <p class="text-center">
                                    Utiliza o filtro avançado para encontrar o animal dos seus sonhos...
                                </p>
                            </div>
                        @endif
                    </section>

                </div>
            </section>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ url(asset('frontend/assets/js/like.js')) }}"></script>
    <script src="{{ url(asset('frontend/assets/js/jquery-ui.js')) }}"></script>
@endsection
