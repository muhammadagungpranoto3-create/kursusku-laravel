{{-- Parameter: $enrolled (jumlah enrollment), $quota (kuota kursus) --}}
@php
    $quota = max(1, (int) $quota);
    $enrolled = (int) $enrolled;
    $percent = min(100, (int) round($enrolled / $quota * 100));
    $state = $enrolled >= $quota ? 'full' : ($percent >= 70 ? 'low' : 'ok');
    $remaining = max(0, $quota - $enrolled);
@endphp
<div class="kk-meter {{ $state }}">
    <div class="kk-meter-bar"><span style="width: {{ $percent }}%"></span></div>
    <small>{{ $enrolled }} dari {{ $quota }} kursi terisi{{ $remaining === 0 ? ', penuh' : ', sisa '.$remaining }}</small>
</div>
