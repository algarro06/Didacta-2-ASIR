@include('includes.header')

<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">
<script src="{{ asset('recursos/js/principal.js') }}"></script>

<div class="events-page">

    <div class="container">

        <div class="row w-100">

            <!-- SIDEBAR -->
            <div class="col-md-3 sidebar">

                <h4>Próximos eventos</h4>

                @foreach($events as $event)
                    <div class="card mb-2 p-2 event-card"
                         style="border-left: 4px solid {{ $event->color ?? '#4b6cb7' }};"
                         onclick="showEvent(@js($event))">

                        <b>{{ $event->title }}</b><br>

                        <small>
                            🕒 {{ \Carbon\Carbon::parse($event->start_time)->format('d M H:i') }}
                        </small><br>

                        <small>{{ $event->type }}</small><br>

                        <small>{{ $event->location }}</small>

                    </div>
                @endforeach

            </div>

            <div class="col-md-6">

                <h4>Calendario</h4>

                @php
                    $days = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
                @endphp

                <div class="calendar-grid mb-2">

                    @foreach($days as $day)
                        <div class="day day-header">
                            {{ $day }}
                        </div>
                    @endforeach

                </div>

                <div class="calendar-grid">

                    @for($i = 1; $i <= 30; $i++)

                        @php
                            $date = \Carbon\Carbon::now()->format('Y-m') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                            $hasEvents = isset($eventsByDate[$date]);
                        @endphp

                        <div class="day {{ $hasEvents ? 'has-event' : '' }}"
                             onclick="showDayEvents('{{ $date }}')">

                            <span>{{ $i }}</span>

                            @if((int) auth()->user()->id_role !== 3)
                                <a href="{{ url('/events/create/' . $date) }}"
                                   class="create-btn"
                                   onclick="event.stopPropagation()">
                                    +
                                </a>
                            @endif

                        </div>

                    @endfor

                </div>

                <div class="card p-3 event-card" style="margin-top: 25px;">

                    <h5>Eventos del día</h5>

                    <div id="eventText">
                        Selecciona un día del calendario
                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <h4>Detalles</h4>

                <div class="card p-3" id="eventInfo">
                    Selecciona un evento
                </div>

            </div>

        </div>

    </div>

</div>

@include('includes.footer')

<script>

const userRole = Number("{{ auth()->user()->id_role }}");

function showDayEvents(date) {

    fetch("/events/day/" + date)
        .then(res => res.json())
        .then(events => {

            let html = "";

            if (events.length === 0) {

                html = `<p>No hay eventos este día.</p>`;

            } else {

                events.forEach(event => {

                    html += `
                        <div class="event-item"
                            style="
                                margin-bottom:10px;
                                padding:10px;
                                border-left:4px solid ${event.color ?? '#4b6cb7'};
                                border-radius:8px;
                                cursor:pointer;
                            "
                            onclick='showEvent(${JSON.stringify(event)})'>

                            <b>${event.title}</b><br>

                            ${event.start_time}<br>

                            ${event.type ?? ''}<br>

                            ${event.location ?? ''}

                        </div>
                    `;
                });

            }

            document.getElementById("eventText").innerHTML = html;

        });

}

function showEvent(event) {

    let html = `
    <div class="event-card">

        <h5>${event.title}</h5>

        <p>${event.start_time}</p>

        <p>${event.type ?? ''}</p>

        <p>${event.location ?? ''}</p>

        <p>${event.instructor ?? ''}</p>

        <p>${event.description ?? ''}</p>
    `;

    if (userRole !== 3) {
        html += `
        <a href="/events/edit/${event.id}"
           style="
                display:block;
                margin-top:10px;
                text-align:center;
                padding:10px;
                border-radius:10px;
                background:#3b82f6;
                color:white;
                text-decoration:none;
                font-weight:600;
           ">
            Editar evento
        </a>
        `;
    }

    if (userRole !== 3) {
        html += `
        <form method="POST" action="/events/delete/${event.id}">
            @csrf
            @method('DELETE')

            <button type="submit"
                    style="
                        margin-top:10px;
                        width:100%;
                        border:none;
                        background:#ef4444;
                        color:white;
                        padding:10px;
                        border-radius:10px;
                        font-weight:600;
                        cursor:pointer;
                    ">

                🗑 Eliminar evento

            </button>
        </form>
        `;
    }

    html += `</div>`;

    document.getElementById("eventInfo").innerHTML = html;
}

</script>