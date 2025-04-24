<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $ticket->ticket_code }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .ticket {
            border: 2px dashed #333;
            padding: 20px;
            width: 500px;
            margin: auto;
        }
        h2 {
            text-align: center;
        }
        .qr {
            margin-top: 20px;
            text-align: center;
        }
        .info {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="ticket">
    <h2>🎟 Ticket pour l’événement : {{ $ticket->event->title }}</h2>

    <div class="info"><strong>Nom de l'invité :</strong> {{ $ticket->guest->name }}</div>
    <div class="info"><strong>Email invité :</strong> {{ $ticket->guest->email }}</div>
    <div class="info"><strong>Catégorie :</strong> {{ $ticket->category->name }}</div>
    <div class="info"><strong>Code du ticket :</strong> {{ $ticket->ticket_code }}</div>
    <div class="info"><strong>Date de l'événement :</strong> {{ $ticket->event->start_time }}</div>

    <div class="info"><strong>Réservé par :</strong> {{ $user->name }} ({{ $user->email }})</div>

    <div class="qr">
        <p><strong>QR Code :</strong></p>
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
    </div>
</div>
</body>
</html>
