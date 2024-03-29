@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-building-o">Editar ONG</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.companies.index') }}">ONGs</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        @if ($errors->all())
            @foreach ($errors->all() as $error)
                @message(['color' => 'orange'])
                <p class="icon-asterisk">{{ $error }}</p>
                @endmessage
            @endforeach
        @endif

        @if (session()->exists('message'))
            @message(['color' => session()->get('color')])
            <p class="icon-asterisk">{{ session()->get('message') }}</p>
            @endmessage
        @endif

        <div class="dash_content_app_box">
            @if ($company->cover)
                <div class="img-responsive-16by9 mb-1 text-center">
                    <img src="{{ $company->cover() }}" class="radius" alt="" width="250">
                </div>
            @endif
            <div class="dash_content_app_box_stage">
                <form class="app_form" action="{{ route('admin.companies.update', ['company' => $company]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @hasanyrole('Administrador|Gerente')
                        <label class="label">
                            <span class="legend">Responsável Legal:</span>
                            <select name="user" class="select2">
                                <option value="" selected>Selecione um responsável legal</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $company->user ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                            <p style="margin-top: 4px;">
                                <a href="{{ route('admin.users.edit', ['user' => $company->user]) }}"
                                    class="text-orange icon-link" style="font-size: .8em;" target="_blank">Acessar
                                    Cadastro</a>
                            </p>
                        </label>
                    @else
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                    @endhasanyrole

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Razão Social:</span>
                            <input type="text" name="social_name" placeholder="Razão Social"
                                value="{{ old('social_name') ?? $company->social_name }}" required />
                        </label>
                        <label class="label">
                            <span class="legend">*CEP:</span>
                            <input type="tel" name="zipcode" class="mask-zipcode zip_code_search" placeholder="Digite o CEP"
                                value="{{ old('zipcode') ?? $company->zipcode }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Endereço:</span>
                            <input type="text" name="street" class="street" placeholder="Endereço Completo"
                                value="{{ old('street') ?? $company->street }}" required />
                        </label>
                        <label class="label">
                            <span class="legend">*Número:</span>
                            <input type="text" name="number" placeholder="Número do Endereço"
                                value="{{ old('number') ?? $company->number }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Bairro:</span>
                            <input type="text" name="neighborhood" class="neighborhood" placeholder="Bairro"
                                value="{{ old('neighborhood') ?? $company->neighborhood }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*Cidade:</span>
                            <input type="text" name="city" class="city" placeholder="Cidade"
                                value="{{ old('city') ?? $company->city }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Estado:</span>
                            <input type="text" name="state" class="state" placeholder="Estado"
                                value="{{ old('state') ?? $company->state }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*E-mail:</span>
                            <input type="email" name="email" class="email" placeholder="E-mail da ONG"
                                value="{{ old('email') ?? $company->email }}" required />
                        </label>

                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">Telefone Fixo:</span>
                            <input type="tel" name="telephone" class="mask-phone"
                                placeholder="Número do Telefonce com DDD"
                                value="{{ old('telephone') ?? $company->telephone }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*Celular:</span>
                            <input type="tel" name="cell" class="mask-cell" placeholder="Número do Telefonce com DDD"
                                value="{{ old('cell') ?? $company->cell }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">Logo simples medindo até 7x4cm (horizontal).</span>
                            <input type="file" name="cover">
                        </label>

                        <label class="label">
                            <span class="legend">*Link para a ONG (sem espaços ou símbolos):</span>
                            <input type="text" name="slug" class="link" placeholder="Link"
                                value="{{ old('slug') ?? $company->slug }}" required />
                        </label>

                    </div>

                    <div class="text-right">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Editar ONG</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
