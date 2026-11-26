<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'username', 'email', 'phone', 'password', 'role', 'is_active', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            // 'hashed' : password otomatis di-hash (bcrypt) setiap kali diisi.
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /** Inisial untuk logo profil, contoh "Muhammad Agung" -> "MA". */
    protected function initials(): Attribute
    {
        return Attribute::get(function () {
            $words = preg_split('/\s+/', trim($this->name ?? ''), -1, PREG_SPLIT_NO_EMPTY);
            $letters = collect($words)->take(2)->map(fn ($w) => Str::upper(Str::substr($w, 0, 1)))->implode('');

            return $letters !== '' ? $letters : '?';
        });
    }

    /** Nomor 1-6 (konsisten per pengguna) untuk memilih warna aksen logo profil. */
    protected function avatarTone(): Attribute
    {
        return Attribute::get(fn () => (crc32((string) $this->username.$this->email) % 6) + 1);
    }
}
