<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link href="{{asset('assets/fullcalendar/lib/main.css')}}" rel='stylesheet' />
<link href="{{asset('assets/fullcalendar/css/style.css')}}" rel='stylesheet' />
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @include('admin.money.modalCalendario')
    @include('admin.money.modalBancos')

  <div id='wrap'>

    <div id='external-events'>
      <h4>Opções Extras</h4>

      <div id='external-events-list'>
        <div>
          <div><div><button class="btn btn-danger" data-toggle="modal" data-target="#modalBancos">Bancos</button></div></div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 2</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 3</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 4</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 5</div>
        </div>
        <div>
          @foreach($bancos as $banco)
          <div><p>Saldo {{$banco->nome}}: {{$banco->saldo}}</p></div>
          @endforeach
        </div>
      </div>
    </div>

    <div id='calendar-wrap'>
        <div id='calendar' 
        data-route-carregar-eventos="{{route('money.carregarEventos')}}" 
        data-route-atualizar-evento="{{route('money.atualizarEvento')}}"
        data-route-inserir-evento="{{route('money.inserirEvento')}}"
        data-route-excluir-evento="{{route('money.excluirEvento')}}"
        >
    
        </div>
    </div>

  </div>
</body>

<script>let objCalendar;</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
<script src="{{asset('assets/fullcalendar/lib/main.js')}}"></script>
<script src="{{asset('assets/fullcalendar/js/carregarEvento.js')}}"></script>
<script src="{{asset('assets/fullcalendar/js/script.js')}}"></script>
<script src="{{asset('assets/fullcalendar/lib/locales/pt-br.js')}}"></script>
<script src="{{ asset('js/dropdownFornecedorMoney.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
<script src="{{ asset('js/dropdownFunc.js') }}"></script>
<script src="{{ asset('js/dropdownTranspMoney.js') }}"></script>


</html>
