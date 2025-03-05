<div>
    <h3>Participants for QR Expiration: {{ $latestQrExpireAt ?? 'N/A' }}</h3>
    <ul>
        @forelse ($participants as $participant)
            <li>{{ $participant['name'] }} - Scanned At: {{ $participant['scanned_at'] }}</li>
        @empty
            <li>No participants yet.</li>
        @endforelse
    </ul>
</div>
