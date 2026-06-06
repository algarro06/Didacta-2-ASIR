@include('includes.header')

<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">
<script src="{{ asset('recursos/js/principal.js') }}"></script>

<div class="event-create-page">

    <div class="event-create-wrapper">

        <div class="event-top">

            <div>
                <h1>Crear nuevo evento</h1>
                <p>Organiza talleres, clases y actividades educativas</p>
            </div>

            <a href="{{ url('/events') }}" class="back-events-btn">
                ← Volver al calendario
            </a>

        </div>

        <div class="event-form-card">

            <form method="POST" action="{{ url('/events/store') }}">
                @csrf

                <!-- FECHA -->
                <input type="hidden" name="start_time" value="{{ $date }}">

                <div class="event-grid">

                    <div>

                        <div class="form-group-custom">
                            <label>Título del evento</label>
                            <input
                                type="text"
                                name="title"
                                class="form-control custom-input"
                                placeholder="Ej: Taller de Laravel"
                                required>
                        </div>

                        <div class="form-group-custom">
                            <label>Descripción</label>
                            <textarea
                                name="description"
                                class="form-control custom-input custom-textarea"
                                placeholder="Describe el evento..."></textarea>
                        </div>

                        <div class="form-group-custom">
                            <label>Tipo de evento</label>

                            <select name="type" class="form-control custom-input">
                                <option value="">Selecciona un tipo</option>
                                <option value="Clase">Clase</option>
                                <option value="Taller">Taller</option>
                                <option value="Conferencia">Conferencia</option>
                                <option value="Examen">Examen</option>
                                <option value="Actividad">Actividad</option>
                            </select>
                        </div>

                    </div>

                    <div>

                        <div class="form-group-custom">
                            <label>Ubicación</label>
                            <input
                                type="text"
                                name="location"
                                class="form-control custom-input"
                                placeholder="Ej: Aula 2B">
                        </div>

                        <div class="form-group-custom">
                            <label>Instructor</label>
                            <input
                                type="text"
                                name="instructor"
                                class="form-control custom-input"
                                placeholder="Nombre del profesor">
                        </div>

                        <div class="form-group-custom">
                            <label>Color del evento</label>
                            <input
                                type="color"
                                name="color"
                                class="form-control color-picker"
                                value="#4b6cb7">
                        </div>

                        <div class="form-group-custom">
                            <label>Hora final</label>
                            <input
                                type="datetime-local"
                                name="end_time"
                                class="form-control custom-input">
                        </div>

                    </div>

                </div>

                <div class="selected-date-box">
                    Fecha seleccionada:
                    <b>{{ $date }}</b>
                </div>

                <div class="event-actions">

                    <a href="{{ url('/events') }}" class="cancel-btn">
                        Cancelar
                    </a>

                    <button type="submit" class="save-btn">
                        Guardar evento
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@include('includes.footer')

<style>

.event-create-page {
    min-height: 100vh;
    background: transparent;
    padding: 40px 20px;
    color: #111827;
}

.dark-mode .event-create-page {
    background: #121212 !important;
    color: #f1f1f1 !important;
}


.event-create-wrapper {
    max-width: 1200px;
    margin: auto;
}


.event-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    color: inherit;
}

.event-top h1 {
    font-size: 38px;
    font-weight: 700;
    margin-bottom: 5px;
}

.event-top p {
    opacity: 0.7;
}

.back-events-btn {
    background: #ffffff;
    color: #111827;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none;
    border: 1px solid #e5e7eb;
    transition: 0.2s;
}

.back-events-btn:hover {
    background: #f3f4f6;
}

.dark-mode .back-events-btn {
    background: rgba(255,255,255,0.08);
    color: #ffffff;
    border: 1px solid rgba(255,255,255,0.08);
}


.event-form-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 35px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.dark-mode .event-form-card {
    background: #1e1e1e;
    color: #ffffff;
    border: 1px solid rgba(255,255,255,0.08);
}


.event-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}


.form-group-custom {
    margin-bottom: 20px;
}

.form-group-custom label {
    display: block;
    color: #111827;
    margin-bottom: 10px;
    font-weight: 600;
}

.dark-mode .form-group-custom label {
    color: #ffffff;
}


.custom-input {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    color: #111827;
    border-radius: 14px;
    padding: 14px;
    outline: none;
    transition: 0.2s;
}

.custom-input:focus {
    border-color: #4b6cb7;
    box-shadow: 0 0 0 0.2rem rgba(75,108,183,0.2);
}

.dark-mode .custom-input {
    background: #1b2742;
    border: 1px solid rgba(255,255,255,0.08);
    color: #ffffff;
}

/* TEXTAREA */
.custom-textarea {
    min-height: 180px;
    resize: none;
}


.color-picker {
    height: 55px;
    border-radius: 14px;
    border: none;
    background: transparent;
}


.selected-date-box {
    margin-top: 20px;
    background: rgba(75,108,183,0.12);
    border: 1px solid rgba(75,108,183,0.3);
    padding: 18px;
    border-radius: 16px;
    color: inherit;
}


.event-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 30px;
}

.cancel-btn {
    background: #ffffff;
    color: #111827;
    padding: 14px 22px;
    border-radius: 14px;
    text-decoration: none;
    border: 1px solid #e5e7eb;
}

.dark-mode .cancel-btn {
    background: rgba(255,255,255,0.08);
    color: #ffffff;
    border: none;
}

.save-btn {
    background: linear-gradient(135deg, #4b6cb7, #182848);
    border: none;
    color: white;
    padding: 14px 24px;
    border-radius: 14px;
    font-weight: bold;
    transition: 0.2s;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.25);
}


@media (max-width: 900px) {

    .event-grid {
        grid-template-columns: 1fr;
    }

    .event-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
}

</s
```
