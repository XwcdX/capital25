<div>
    <h3>Participants for QR Expiration: {{ $latestQrExpireAt }}</h3>
    <ul>
        @forelse($participants as $participant)
            <li>{{ $participant->team->name }} - Scanned At: {{ $participant->scanned_at }}</li>
        @empty
            <li>No participants yet.</li>
        @endforelse
    </ul>
</div>
