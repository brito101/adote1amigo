@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-heart">Novo Animal</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.animals.index') }}">Animal</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">

            <div class="nav">

                @if ($errors->all())
                    @foreach ($errors->all() as $error)
                        @message(['color' => 'orange'])
                        <p class="icon-asterisk">{{ $error }}</p>
                        @endmessage
                    @endforeach
                @endif

                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                    </li>
                </ul>

                <form action="{{ route('admin.animals.store') }}" method="post" class="app_form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="nav_tabs_content">
                        <div id="data">

                            <div class="label_g4">

                                <label class="label">
                                    <span class="legend">Categoria:</span>
                                    <select name="category" class="select2">
                                        <option value="Cão" {{ old('category') == 'Cão' ? 'selected' : '' }}>
                                            Cão</option>
                                        <option value="Gato" {{ old('category') == 'Gato' ? 'selected' : '' }}>Gato
                                        </option>
                                        <option value="Outros" {{ old('category') == 'Outros' ? 'selected' : '' }}>Outros
                                        </option>
                                    </select>
                                </label>

                                <label class="label">
                                    <span class="legend">Nome do animal:</span>
                                    <input type="text" name="brand" placeholder="Nome" value="{{ old('brand') }}" />
                                </label>

                                <label class="label">
                                    <span class="legend">Sexo:</span>
                                    <input type="text" name="model" placeholder="Sexo" value="{{ old('model') }}" />
                                </label>

                                <label class="label">
                                    <span class="legend">Idade:</span>
                                    <input type="tel" name="year" placeholder="Idade" value="{{ old('year') }}" />
                                </label>
                            </div>

                            @hasanyrole('Administrador|Gerente')
                                <label class="label">
                                    <span class="legend">Proprietário:</span>
                                    <select name="user" class="select2">
                                        <option value="">Selecione o proprietário</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if (old('user') == $user->id) {{ 'selected' }} @endif>
                                                {{ $user->name }} ({{ $user->document }})</option>
                                        @endforeach
                                    </select>
                                </label>
                            @else
                                <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                            @endhasanyrole

                            <div>
                                <label class="label">
                                    <span class="legend">*Título:</span>
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        placeholder="Até 191 caracteres">
                                </label>
                            </div>

                            <label class="label">
                                <span class="legend">Descrição do Animal:</span>
                                <textarea name="description" cols="30" rows="10"
                                    class="mce">{{ old('description') }}</textarea>
                            </label>

                        </div>

                        <div class="label">
                            <span class="legend">Destacar Anúncio:</span>
                            <label class="label">
                                <input type="checkbox" name="spotlight"
                                    {{ old('spotlight') == 'on' || old('spotlight') == true ? 'checked' : '' }}>
                                <span>
                                    Será consumido um crédito adicional de anúncio
                                </span>
                            </label>
                        </div>

                        <label class="label">
                            <span class="legend">Imagens</span>
                            <input type="file" name="files[]" multiple>
                        </label>

                        <div class="content_image"></div>
                    </div>

                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o">Cadastrar Animal</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(function() {
            $('input[name="files[]"]').change(function(files) {

                $('.content_image').text('');

                $.each(files.target.files, function(key, value) {
                    var reader = new FileReader();
                    reader.onload = function(value) {
                        $('.content_image').append(
                            '<div class="property_image_item">' +
                            '<div class="embed radius" ' +
                            'style="background-image: url(' + value.target.result +
                            '); background-size: cover; background-position: center center;">' +
                            '</div>' +
                            '</div>');
                    };
                    reader.readAsDataURL(value);
                });
            });
        });
    </script>
@endsection
