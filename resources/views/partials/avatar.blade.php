{{-- Logo profil: lingkaran berisi inisial nama. Pakai: @include('partials.avatar', ['user' => $user, 'size' => 'xl']) --}}
<span class="kk-logo kk-logo-{{ $size ?? 'md' }} tone-{{ $user->avatar_tone }}" aria-hidden="true">{{ $user->initials }}</span>
