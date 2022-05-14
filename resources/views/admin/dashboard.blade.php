@extends('admin.master.master')

@section('content')
    <div style="flex-basis: 100%; max-width: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Dashboard</h2>
            </header>

            <div class="dash_content_app_box">
                <section class="app_dash_home_stats">
                    @hasanyrole('Administrador|Gerente')
                        <article class="control radius">
                            <h4 class="icon-users">Clientes</h4>
                            <p><b>Total:</b> {{ $team }}</p>
                        </article>

                        <article class="control radius">
                            <h4 class="icon-list">Lista de clientes</h4>
                            <div class="d-flex justify-content-center">
                                <a download="Clientes" href="{{ Storage::url('clientes.txt') }}" title="Clientes"
                                    class="btn btn-orange icon-download mx-auto">Download</a>
                            </div>
                        </article>

                        <article class="control radius">
                            <h4 class="icon-list">Lista de contatos</h4>
                            <div class="d-flex justify-content-center">
                                <a download="Contatos" href="{{ Storage::url('usuarios.txt') }}" title="Contatos"
                                    class="btn btn-orange icon-download mx-auto">Download</a>
                            </div>
                        </article>
                    @endhasanyrole

                    @hasrole('Anunciante')
                        <article class="blog radius">
                            <h4 class="icon-heart">Animais</h4>
                            <p><b>Ativos:</b> {{ $automotivesAvailable }}</p>
                            <p><b>Inativos:</b> {{ $automotivesUnavailable }}</p>
                            <p><b>Total:</b> {{ $automotivesTotal }}</p>
                        </article>

                        <article class="blog radius">
                            <h4 class="icon-picture-o">Visualizações</h4>
                            <p>Seus anúncios e seus banners foram vistos 2.345 vezes por pessoas da sua cidade.</p>
                        </article>

                        <article class="radius mt-2" style="flex-basis: 100%;">
                            <h4 class="icon-info-circle">Informações</h4>
                            <p class="text-red my-0"><b>NUNCA</b> entraremos em contato solicitando senha, dados pessoais ou
                                qualquer
                                tipo de informação.</p>
                            <p class="text-red my-0"><b>NUNCA</b> enviaremos mensagens via SMS, Whatsapp, Telegram ou qualquer
                                tipo.
                            </p>
                            <p class="text-red my-0">Qualquer contato será feito apenas pelo email
                                {{ env('ADMIN_EMAIL') }}.
                            </p>
                            <p class="text-red my-0">Confira se o email que você recebeu realmente é nosso antes de responder.
                            </p>
                        </article>

                        <article class="radius mt-2" style="flex-basis: 100%;">
                            <h4 class="icon-gift">Dicas</h4>
                            <p class="my-0">Faça fotos de boa qualidade e iluminadas.</p>
                        </article>
                    @endhasrole
                </section>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-heart">Últimos Animais Cadastrados</h2>
            </header>

            <div class="dash_content_app_box">
                <div class="dash_content_app_box_stage">
                    <div class="realty_list">
                        @if (!empty($automotives))
                            @foreach ($automotives as $automotive)
                                <div class="realty_list_item mb-2">
                                    <div class="realty_list_item_actions_stats">
                                        <img src="{{ $automotive->cover() }}" alt="">
                                    </div>

                                    <div class="realty_list_item_content">
                                        <h4>#{{ $automotive->id }} {{ $automotive->title }}</h4>

                                        <div class="realty_list_item_card">
                                            <div class="realty_list_item_card_image">
                                                <span class="icon-bar-chart"></span>
                                            </div>
                                            <div class="realty_list_item_card_content">
                                                <div class="text-center" style="flex-basis: 100%;">
                                                    Visualizações:{{ $automotive->views }}</div>
                                                <a href="{{ route('web.buyAutomotive', ['slug' => $automotive->slug]) }}"
                                                    class="btn btn-blue button_action" target="_blank">Ver Anúncio</a>
                                            </div>
                                        </div>

                                        <div class="realty_list_item_card">
                                            <div class="realty_list_item_card_image">
                                                <span class="icon-upload"></span>
                                            </div>
                                            <div class="realty_list_item_card_content">
                                                @php
                                                    $active = $automotive->active_date >= Carbon\Carbon::now()->subDays(30);
                                                @endphp
                                                <div class="text-center" style="flex-basis: 100%;">Status:
                                                    {{ $active == 1 ? 'Ativo desde de ' . date('d/m/Y', strtotime($automotive->active_date)) : 'Inativo' }}
                                                </div>
                                                @if ($active == 0)
                                                    <form
                                                        action="{{ route('admin.animals.reactive', ['animal' => $automotive->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <input class="btn btn-orange button_action" type="submit"
                                                            value="Reativar">
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        @can('Editar Animais')
                                            <div class="realty_list_item_card">
                                                <div class="realty_list_item_card_image">
                                                    <span class="icon-pencil"></span>
                                                </div>
                                                <div class="realty_list_item_card_content">
                                                    <a href="{{ route('admin.animals.edit', ['animal' => $automotive->id]) }}"
                                                        class="btn btn-green button_action">Editar</a>
                                                </div>
                                            </div>
                                        @endcan

                                        @can('Remover Animais')
                                            <div class="realty_list_item_card">
                                                <div class="realty_list_item_card_image">
                                                    <span class="icon-trash"></span>
                                                </div>
                                                <div class="realty_list_item_card_content">
                                                    <form
                                                        action="{{ route('admin.animals.destroy', ['animal' => $automotive->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <input class="btn btn-red button_action" type="submit" value="Remover">
                                                    </form>
                                                </div>
                                            </div>
                                        @endcan

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-content">Não foram encontrados registros!</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
