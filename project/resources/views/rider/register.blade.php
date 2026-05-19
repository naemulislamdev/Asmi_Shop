@extends('layouts.front')

@section('css')
    <style>
        .reg-section {
            min-height: 100vh;
            padding: 3rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f4f0;
        }

        .reg-card {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 2.3rem 2rem;
        }

        .reg-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 500;
            color: #185FA5;
            background: #E6F1FB;
            border-radius: 100px;
            padding: 5px 14px;
            margin-bottom: 1.25rem;
            letter-spacing: 0.02em;
        }

        .reg-badge svg {
            width: 14px;
            height: 14px;
        }

        .reg-title {
            font-size: 22px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 0.25rem;
            line-height: 1.3;
        }

        .reg-subtitle {
            font-size: 14px;
            color: #888;
            margin: 0 0 2rem;
        }

        .section-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #aaa;
            margin: 0 0 0.85rem;
        }

        .field-group {
            display: grid;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .field label {
            font-size: 13px;
            font-weight: 500;
            color: #555;
            letter-spacing: 0.01em;
            margin: 0;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap .field-icon {
            position: absolute;
            left: 12px;
            width: 16px;
            height: 16px;
            color: #bbb;
            pointer-events: none;
            flex-shrink: 0;
        }

        .input-wrap input,
        .input-wrap select {
            width: 100%;
            height: 42px;
            font-size: 14px;
            padding: 0 12px 0 38px;
            background: #f8f7f4;
            border: 0.5px solid rgba(0, 0, 0, 0.12);
            border-radius: 8px;
            color: #1a1a1a;
            transition: border-color 0.15s, box-shadow 0.15s;
            box-sizing: border-box;
            outline: none;
            -webkit-appearance: none;
            appearance: none;
            font-family: inherit;
        }

        .input-wrap input:focus,
        .input-wrap select:focus {
            border-color: #378ADD;
            box-shadow: 0 0 0 3px rgba(55, 138, 221, 0.12);
            background: #fff;
        }

        .input-wrap input::placeholder {
            color: #ccc;
        }

        .input-wrap input.is-invalid,
        .input-wrap select.is-invalid {
            border-color: #E24B4A;
            box-shadow: 0 0 0 3px rgba(226, 75, 74, 0.1);
        }

        .text-danger {
            font-size: 12px;
            color: #E24B4A;
            margin-top: 2px;
        }

        .select-wrap {
            position: relative;
            width: 100%;
        }

        .select-wrap .chevron-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            color: #bbb;
            pointer-events: none;
        }

        .select-wrap select {
            padding-right: 36px;
            cursor: pointer;
        }

        .pass-input-wrap {
            position: relative;
            width: 100%;
        }

        .pass-input-wrap input {
            padding-right: 40px;
        }

        .eye-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            color: #bbb;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            transition: color 0.15s;
        }

        .eye-toggle:hover {
            color: #888;
        }

        .eye-toggle svg {
            width: 16px;
            height: 16px;
        }

        .eye-toggle .icon-eye-on {
            display: none;
        }

        .eye-toggle.visible .icon-eye-off {
            display: none;
        }

        .eye-toggle.visible .icon-eye-on {
            display: block;
        }

        .submit-btn {
            width: 100%;
            height: 44px;
            border-radius: 8px;
            background: #185FA5;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s, transform 0.1s;
            letter-spacing: 0.01em;
            margin-top: 0.25rem;
        }

        .submit-btn:hover {
            background: #0C447C;
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .submit-btn svg {
            width: 16px;
            height: 16px;
        }

        .login-redirect {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 13.5px;
            color: #888;
            margin-bottom: 0;
        }

        .login-redirect a {
            color: #185FA5;
            font-weight: 500;
            text-decoration: none;
        }

        .login-redirect a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .field-row {
                grid-template-columns: 1fr;
            }

            .reg-card {
                padding: 2rem 1.25rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="reg-section">
        <div class="reg-card">
            {{-- Badge --}}
            <span class="reg-badge">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                @lang('Rider Portal')
            </span>
            <div class="">
                <h2 class="reg-title">@lang('Create your account')</h2>
                <p class="reg-subtitle">@lang('Join as a rider and start delivering today')</p>
            </div>

            <form action="{{ route('rider-register-submit') }}" method="POST" novalidate>
                @csrf

                {{-- Personal Info --}}
                <div class="field-group">
                    {{-- Name & Phone row --}}
                    <div class="field-row">
                        <div class="field">
                            <label for="name">@lang('Full name')</label>
                            <div class="input-wrap">
                                <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    placeholder="@lang('Rahim Uddin')" class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="phone">@lang('Phone number')</label>
                            <div class="input-wrap">
                                <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="+880 1X XX XXX XXX"
                                    class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="field">
                        <label for="email">@lang('Email address')</label>
                        <div class="input-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="you@example.com" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="field">
                        <label for="address">@lang('Address')</label>
                        <div class="input-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                placeholder="@lang('Mirpur, Dhaka')" class="{{ $errors->has('address') ? 'is-invalid' : '' }}">
                        </div>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Branch --}}
                    <div class="field">
                        <label for="branch">@lang('Branch')</label>
                        <div class="input-wrap select-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            @php $branches = App\Models\Branch::all(); @endphp
                            <select id="branch" name="branch_id"
                                class="{{ $errors->has('branch_id') ? 'is-invalid' : '' }}">
                                <option value="">@lang('Select your branch')</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="chevron-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        @error('branch_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Security --}}
                <div class="field-group">

                    {{-- Password --}}
                    <div class="field">
                        <label for="create-password">@lang('Password')</label>
                        <div class="input-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div class="pass-input-wrap">
                                <input type="password" id="create-password" name="password"
                                    placeholder="@lang('Create a password')"
                                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                                <button type="button" class="eye-toggle"
                                    onclick="togglePassword('create-password', this)" aria-label="@lang('Toggle password visibility')">
                                    <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                    <svg class="icon-eye-on" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="field">
                        <label for="confirm-password">@lang('Confirm password')</label>
                        <div class="input-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div class="pass-input-wrap">
                                <input type="password" id="confirm-password" name="password_confirmation"
                                    placeholder="@lang('Repeat your password')">
                                <button type="button" class="eye-toggle"
                                    onclick="togglePassword('confirm-password', this)" aria-label="@lang('Toggle confirm password visibility')">
                                    <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                    <svg class="icon-eye-on" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Submit --}}
                <button type="submit" class="submit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    @lang('Create Account')
                </button>

                <p class="login-redirect">
                    @lang('Already have an account?')
                    <a href="{{ route('rider.login') }}">@lang('Login')</a>
                </p>

            </form>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.classList.add('visible');
            } else {
                input.type = 'password';
                btn.classList.remove('visible');
            }
        }
    </script>
@endsection
