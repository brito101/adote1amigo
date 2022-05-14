<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/login.css')) }}" />
    <link rel="icon" type="image/png" href="{{ url(asset('backend/assets/images/logo.png')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Adote 1 amigo.com.br - Criação de conta</title>
</head>

<body>

    <div class="ajax_response"></div>

    <div class="dash_login">
        <div class="dash_login_left">
            <article class="dash_login_left_box">
                <header class="dash_login_box_headline">
                    <div class="dash_login_box_headline_logo bg-white radius pt-1">
                        <a href="{{ route('admin.login') }}">
                            <img src="{{ url(asset('backend/assets/images/brand.png')) }}" width="150">
                        </a>
                    </div>
                </header>

                <form name="newAccount" action="{{ route('admin.account.do') }}" method="post" autocomplete="off">
                    <label>
                        <span class="field icon-user">Nome:</span>
                        <input type="text" name="name" placeholder="Informe seu nome" minlength="3" maxlength="191"
                            required />
                    </label>

                    <label>
                        <span class="field icon-envelope">E-mail:</span>
                        <input type="email" name="email" placeholder="Informe seu e-mail" maxlength="191" required />
                    </label>

                    <label>
                        <span class="field icon-unlock-alt">Senha:</span>
                        <input type="password" name="password_check" placeholder="Informe sua senha" id="password"
                            required />
                    </label>

                    <label>
                        <span class="field icon-unlock-alt">Confirmar Senha:</span>
                        <input type="password" name="password_confirm" placeholder="Confirme sua nova senha"
                            id="confirm_password" required />
                    </label>

                    <button class="gradient gradient-orange radius icon-paper-plane-o">Enviar</button>
                </form>

                <div class="text-center mb-2">
                    <a href="{{ route('web.home') }}" class="btn btn-info icon-home"
                        style="text-decoration: none;">Página Principal</a>
                    <a href="{{ route('admin.login') }}" class="btn btn-orange icon-key"
                        style="text-decoration: none;">Realizar Login</a>
                </div>

                <footer>
                    <p>Desenvolvido por <a href="https://www.rodrigobrito.dev.br"
                            target="_blank">www.<b>rodrigobrito</b>.dev.br</a></p>
                    <p>&copy; <?= date('Y') ?> - Todos os Direitos Reservados</p>
                    <p class="dash_login_left_box_support">
                        <a target="_blank" class="icon-whatsapp transition text-green"
                            href="https://api.whatsapp.com/send?phone=55+021+9922479-68&text=Olá, preciso de ajuda com o login.">Precisa
                            de Suporte?</a>
                    </p>
                </footer>
            </article>
        </div>

        <div class="dash_login_right"></div>

    </div>

    <script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
    <script src="{{ url(mix('backend/assets/js/login.js')) }}"></script>

</body>

</html>
