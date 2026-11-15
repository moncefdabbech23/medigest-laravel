{{-- resources/views/prescriptions/show.blade.php (page autonome, sans layout) --}}
@php
    $appointment = $prescription->consultation->appointment;
    $doctor = $appointment->doctor;
    $patient = $appointment->patient;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ordonnance — {{ $patient->user->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #0f172a; max-width: 760px; margin: 30px auto; padding: 0
            20px; }
        header { display: flex; justify-content: space-between; border-bottom: 3px solid #0d9488;
            padding-bottom: 12px; }
        h1 { color: #0d9488; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .muted { color: #64748b; font-size: 14px; }
        .sign { margin-top: 60px; text-align: right; }
        .actions { margin: 20px 0; }
        /* À l'impression : masquer les boutons */
        @media print { .actions { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="actions">
        <button onclick="window.print()">Imprimer / Enregistrer en PDF</button>
        <a href="{{ url()->previous() }}">Retour</a>
    </div>
    <header>
        <div>
            <h1>Ordonnance</h1>
            <p class="muted">MediGest</p>
        </div>
        <div style="text-align:right">
            <strong>{{ $doctor->user->name }}</strong><br>
            <span class="muted">{{ $doctor->specialty->name }}<br>{{ $doctor->office_address }}</span>
        </div>
    </header>
    <p>Patient : <strong>{{ $patient->user->name }}</strong>
        @if ($patient->birth_date) — né(e) le {{ $patient->birth_date->format('d/m/Y') }} @endif</p>
    <p class="muted">Date : {{ $prescription->date->format('d/m/Y') }}</p>
    <table>
        <tr><th>Médicament</th><th>Dosage</th><th>Fréquence</th><th>Durée</th></tr>
        @foreach ($prescription->medications as $medication)
            <tr>
                <td><strong>{{ $medication->name }}</strong></td>
                <td>{{ $medication->pivot->dosage }}</td>
                <td>{{ $medication->pivot->frequency }}</td>
                <td>{{ $medication->pivot->duration }}</td>
            </tr>
        @endforeach
    </table>
    <p class="sign">Signature et cachet du médecin</p>
</body>
</html>
