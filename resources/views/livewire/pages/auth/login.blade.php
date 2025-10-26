<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="auth-wrapper">
    <div class="auth-brand">
        <div class="brand-badge">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M11.47 3.53a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06L18 12.56v6.69a.75.75 0 0 1-.75.75h-3.5a.75.75 0 0 1-.75-.75v-3.25H11v3.25a.75.75 0 0 1-.75.75h-3.5A.75.75 0 0 1 6 19.25v-6.69l-1.97-.97a.75.75 0 0 1-.31-1.01.75.75 0 0 1 .31-.31l7.44-7.44Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <h1>Grand Tamansari Residence</h1>
            <p>Portal Admin</p>
        </div>
    </div>

    <div class="welcome-text">
        <h2>Selamat datang kembali</h2>
        <p>Masuk untuk mengelola konten Grand Tamansari Residence secara terpadu.</p>
    </div>

    <x-auth-session-status class="status-flash" :status="session('status')" />

    <form wire:submit="login" class="auth-form">
        <div class="form-field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                wire:model.live.lazy="form.email"
                id="email"
                class="input"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="username"
                placeholder="nama@grandtamansari.id"
            />
            <x-input-error :messages="$errors->get('form.email')" class="error" />
        </div>

        <div class="form-field">
            <div class="label-row">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="link" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <x-text-input
                wire:model.live.lazy="form.password"
                id="password"
                class="input"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Masukkan password"
            />
            <x-input-error :messages="$errors->get('form.password')" class="error" />
        </div>

        <label for="remember" class="remember-row">
            <input wire:model.live="form.remember" id="remember" type="checkbox" class="checkbox" name="remember">
            <span>{{ __('Ingat saya') }}</span>
        </label>

        <button type="submit" class="submit-button">
            <span>Masuk</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h9.19l-2.22-2.22a.75.75 0 0 1 1.06-1.06l3.5 3.5a.75.75 0 0 1 0 1.06l-3.5 3.5a.75.75 0 0 1-1.06-1.06l2.22-2.22H3.75A.75.75 0 0 1 3 10Zm13-6.25a.75.75 0 0 0-1.5 0v12.5a.75.75 0 0 0 1.5 0V3.75Z" clip-rule="evenodd" />
            </svg>
        </button>
    </form>
</div>

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #e3fff3 0%, #f5fffa 50%, #ffffff 100%);
        }

        .auth-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.8rem;
            max-width: 420px;
            margin: 0 auto;
            padding: 3.5rem 2rem 4rem;
            background: #ffffff;
            border-radius: 1.75rem;
            box-shadow: 0 30px 70px -35px rgba(4, 120, 87, 0.45);
            border: 1px solid rgba(16, 185, 129, 0.18);
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-badge {
            width: 3.3rem;
            height: 3.3rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #047857, #10b981);
            display: grid;
            place-items: center;
            color: #fff;
            box-shadow: 0 18px 35px -15px rgba(4, 120, 87, 0.65);
        }

        .brand-badge svg {
            width: 1.6rem;
            height: 1.6rem;
        }

        .auth-brand h1 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 600;
            color: #064e3b;
        }

        .auth-brand p {
            margin: 0.15rem 0 0;
            font-size: 0.95rem;
            color: #059669;
            font-weight: 500;
        }

        .welcome-text h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 600;
            color: #065f46;
        }

        .welcome-text p {
            margin: 0.4rem 0 0;
            font-size: 0.98rem;
            line-height: 1.6;
            color: #4b5563;
        }

        .auth-form {
            display: grid;
            gap: 1.25rem;
        }

        .form-field {
            display: grid;
            gap: 0.6rem;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .input {
            width: 100%;
            border-radius: 0.9rem;
            border: 1px solid rgba(4, 120, 87, 0.15);
            padding: 0.85rem 1rem;
            font-size: 0.98rem;
            color: #065f46;
            background: rgba(4, 120, 87, 0.03);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.18);
            background: #ffffff;
        }

        .remember-row {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: #047857;
        }

        .checkbox {
            width: 1rem;
            height: 1rem;
            border-radius: 0.3rem;
            border: 1px solid rgba(4, 120, 87, 0.4);
        }

        .submit-button {
            width: 100%;
            border: none;
            border-radius: 999px;
            padding: 0.95rem 1.2rem;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 0.6rem;
            font-weight: 600;
            font-size: 1rem;
            color: #ffffff;
            background: linear-gradient(120deg, #047857, #10b981);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 15px 30px -15px rgba(4, 120, 87, 0.65);
        }

        .submit-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 20px 36px -16px rgba(4, 120, 87, 0.8);
        }

        .submit-button svg {
            width: 1.1rem;
            height: 1.1rem;
        }

        .link {
            font-size: 0.9rem;
            color: #059669;
            text-decoration: none;
            font-weight: 500;
        }

        .link:hover {
            color: #047857;
        }

        .error {
            color: #dc2626;
            font-size: 0.85rem;
        }

        .status-flash {
            border-radius: 0.75rem;
            border: 1px solid rgba(16, 185, 129, 0.15);
            background: rgba(236, 253, 245, 0.7);
            color: #047857;
            font-size: 0.92rem;
        }

        @media (max-width: 640px) {
            .auth-wrapper {
                margin: 2rem 1rem;
                padding: 3rem 1.5rem;
            }
        }
    </style>
@endpush
