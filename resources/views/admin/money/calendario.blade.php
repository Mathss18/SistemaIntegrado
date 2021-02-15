<!doctype html>
<html lang="en">

<head>
  <title>Money</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset='utf-8' />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <link href="{{asset('assets/fullcalendar/lib/main.css')}}" rel='stylesheet' />
  <link href="{{asset('assets/fullcalendar/css/style.css')}}" rel='stylesheet' />
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
  <link rel="stylesheet" href="{{ asset('css/menuMoney.css') }}">
  <link rel="stylesheet" href="{{ asset('css/colapseMenuMoney.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars" style="color: black;"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <h1 style="color: red;"><a class="logo">Money</a></h1>
      <ul class="list-unstyled components mb-5">
        <li>
          <a href="#" data-toggle="modal" data-target="#modalBancos"><span class="fas fa-piggy-bank mr-3"></span>Bancos</a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#modalRelatorios"><span class="fa fa-clipboard-list mr-3"></span>Relatórios</a>
        </li>
        <li>
          <a href="{{route('home')}}"><span class="fas fa-sign-out-alt mr-3"></span>Sair</a>
        </li>
        <hr style="color: blue;">

      </ul>

    </nav>
    @include('admin.money.modalCalendario')
    @include('admin.money.modalBancos')
    @include('admin.money.modalRelatorios')

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">







      <div id='external-events-list' style="display: none;">
      </div>

      <div id='calendar-wrapp'>
        <div id='calendar' data-route-carregar-eventos="{{route('money.carregarEventos')}}" data-route-atualizar-evento="{{route('money.atualizarEvento')}}" data-route-inserir-evento="{{route('money.inserirEvento')}}" data-route-excluir-evento="{{route('money.excluirEvento')}}">

        </div>
      </div>



    </div>
  </div>
  <script>
    let objCalendar;
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
  <script src="{{asset('assets/fullcalendar/lib/main.js')}}"></script>
  <script src="{{asset('assets/fullcalendar/js/carregarEvento.js')}}"></script>
  <script src="{{asset('assets/fullcalendar/js/script.js')}}"></script>
  <script src="{{asset('assets/fullcalendar/lib/locales/pt-br.js')}}"></script>
  <script src="{{ asset('js/dropdownFornecedorMoney.js') }}"></script>
  <script src="{{ asset('js/dropdownImpostoMoney.js') }}"></script>
  <script src="{{ asset('js/dropdownInvestimentoMoney.js') }}"></script>
  <script src="{{ asset('js/dropdown.js') }}"></script>
  <script src="{{ asset('js/dropdownFunc.js') }}"></script>
  <script src="{{ asset('js/colapseMenuMoney.js') }}"></script>
  <script src="{{ asset('js/dropdownTranspMoney.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
</body>

</html>