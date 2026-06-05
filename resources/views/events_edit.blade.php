@include('includes.header')

<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">
<script src="{{ asset('recursos/js/principal.js') }}"></script>

<div class="event-edit-page">

    <div class="event-edit-wrapper">

        <!-- CABECERA -->
        <div class="event-top-edit">

            <div>
                <h1>Editar evento</h1>
                <p>Modifica la información del evento</p>
            </div>

            <a href="{{ url('/events') }}" class="back-events-btn">
                ← Volver al calendario
            </a>

        </div>

        <div class="event-form-card event-form-card-light">

            <form method="POST" action="{{ url('/events/update/' . $event->id) }}">
                @csrf
                @method('PUT')

                <div class="event-grid">

                    <div>

                        <div class="form-group-custom">
                            <label>Título del evento</label>
                            <input type="text"
                                   name="title"
                                   class="form-control custom-input"
                                   value="{{ $event->title }}"
                                   required>
                        </div>

                        <div class="form-group-custom">
                            <label>Descripción</label>
                            <textarea name="description"
                                      class="form-control custom-input custom-textarea">{{ $event->description }}</textarea>
                        </div>

                        <div class="form-group-custom">
                            <label>Tipo de evento</label>

                            <select name="type" class="form-control custom-input">
                                <option value="">Selecciona un tipo</option>
                                <option value="Clase" {{ $event->type == 'Clase' ? 'selected' : '' }}>Clase</option>
                                <option value="Taller" {{ $event->type == 'Taller' ? 'selected' : '' }}>Taller</option>
                                <option value="Conferencia" {{ $event->type == 'Conferencia' ? 'selected' : '' }}>Conferencia</option>
                                <option value="Examen" {{ $event->type == 'Examen' ? 'selected' : '' }}>Examen</option>
                                <option value="Actividad" {{ $event->type == 'Actividad' ? 'selected' : '' }}>Actividad</option>
                            </select>
                        </div>

                    </div>

                    <div>

                        <div class="form-group-custom">
                            <label>Ubicación</label>
                            <input type="text"
                                   name="location"
                                   class="form-control custom-input"
                                   value="{{ $event->location }}">
                        </div>

                        <div class="form-group-custom">
                            <label>Instructor</label>
                            <input type="text"
                                   name="instructor"
                                   class="form-control custom-input"
                                   value="{{ $event->instructor }}">
                        </div>

                        <div class="form-group-custom">
                            <label>Color del evento</label>
                            <input type="color"
                                   name="color"
                                   class="form-control color-picker"
                                   value="{{ $event->color ?? '#4b6cb7' }}">
                        </div>

                        <div class="form-group-custom">
                            <label>Fecha y hora</label>
                            <input type="datetime-local"
                                   name="start_time"
                                   class="form-control custom-input"
                                   value="{{ \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i') }}">
                        </div>

                    </div>

                </div>

                <div class="event-actions">

                    <a href="{{ url('/events') }}" class="cancel-btn">
                        Cancelar
                    </a>

                    <button type="submit" class="save-btn">
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@include('includes.footer')


<style>

/* =========================
   EVENT EDIT PAGE
========================= */

.event-edit-page {
    min-height: 100vh;
    background: transparent;
    padding: 40px 20px;
    color: #111827;
}

.dark-mode .event-edit-page {
    background: #121212 !important;
    color: #f1f1f1 !important;
}

/* =========================
   WRAPPER
========================= */

.event-edit-wrapper {
    max-width: 1200px;
    margin: auto;
}

/* =========================
   HEADER
========================= */

.event-top-edit {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    color: inherit;
}

.event-top-edit h1 {
    font-size: 38px;
    font-weight: 700;
    margin-bottom: 5px;
}

.event-top-edit p {
    opacity: 0.7;
}

/* =========================
   BOTÓN VOLVER
========================= */

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

/* =========================
   CARD PRINCIPAL
========================= */

.event-form-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 35px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.dark-mode .event-form-card {
    background: #1e1e1e !important;
    color: #ffffff !important;
    border: 1px solid rgba(255,255,255,0.08);
}

/* =========================
   GRID
========================= */

.event-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

/* =========================
   FORM GROUP
========================= */

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
    color: #ffffff !important;
}

/* =========================
   INPUTS
========================= */

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
    background: #2a2a2a !important;
    color: #ffffff !important;
    border: 1px solid rgba(255,255,255,0.08);
}

.dark-mode .custom-input::placeholder {
    color: #bdbdbd;
}

/* =========================
   TEXTAREA
========================= */

.custom-textarea {
    min-height: 180px;
    resize: none;
}

/* =========================
   SELECT
========================= */

.dark-mode select.custom-input option {
    background: #2a2a2a;
    color: white;
}

/* =========================
   COLOR PICKER
========================= */

.color-picker {
    height: 55px;
    border-radius: 14px;
    border: none;
    background: transparent;
}

/* =========================
   BOTONES
========================= */

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
    border: 1px solid rgba(255,255,255,0.08);
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

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 900px) {

    .event-grid {
        grid-template-columns: 1fr;
    }

    .event-top-edit {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

}

/* Títulos de los recuadros */
.form-group-custom label {
    color: #111827 !important;
}

/* Botón volver al calendario */
.back-events-btn {
    color: #111827 !important;
}

/* Botón cancelar */
.cancel-btn {
    color: #111827 !important;
}

.event-edit-page .form-group-custom label {
    color: #111827 !important;
}

.dark-mode .event-edit-page .form-group-custom label {
    color: #ffffff !important;
}

/* inputs no se tocan */
.event-edit-page .custom-input {
    color: #111827 !important;
}

.dark-mode .event-edit-page .custom-input {
    color: #ffffff !important;
}

.event-edit-page .back-events-btn {
    color: #111827 !important;
}

.dark-mode .event-edit-page .back-events-btn {
    color: #ffffff !important;
}
</style>