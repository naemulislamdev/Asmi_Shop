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
            max-width: 440px;
            background: #ffffff;
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 2.5rem 2rem;
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
            margin-bottom: 1.25rem;
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
            z-index: 1;
        }

        .input-wrap input {
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
            font-family: inherit;
        }

        .input-wrap input:focus {
            border-color: #378ADD;
            box-shadow: 0 0 0 3px rgba(55, 138, 221, 0.12);
            background: #fff;
        }

        .input-wrap input::placeholder {
            color: #ccc;
        }

        .input-wrap input.is-invalid {
            border-color: #E24B4A;
            box-shadow: 0 0 0 3px rgba(226, 75, 74, 0.1);
        }

        .text-danger {
            font-size: 12px;
            color: #E24B4A;
            margin-top: 2px;
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

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #185FA5;
            cursor: pointer;
            margin: 0;
            flex-shrink: 0;
        }

        .remember-check span {
            font-size: 13px;
            color: #666;
        }

        .forgot-link {
            font-size: 13px;
            color: #185FA5;
            font-weight: 500;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
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

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.25rem 0;
        }

        .divider-line {
            flex: 1;
            height: 0.5px;
            background: rgba(0, 0, 0, 0.1);
        }

        .divider-text {
            font-size: 12px;
            color: #bbb;
        }

        .register-redirect {
            text-align: center;
            font-size: 13.5px;
            color: #888;
            margin: 0;
        }

        .register-redirect a {
            color: #185FA5;
            font-weight: 500;
            text-decoration: none;
        }

        .register-redirect a:hover {
            text-decoration: underline;
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

            <h2 class="reg-title">@lang('Welcome back')</h2>
            <p class="reg-subtitle">@lang('Login to your rider account to continue')</p>

            <form action="{{ route('rider.login.submit') }}" method="POST" novalidate>
                @csrf

                <div class="field-group">
                    {{-- Phone --}}
                    <div class="field">
                        <label for="phone">@lang('Phone number')</label>
                        <div class="input-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                placeholder="01xxxxxxxxx" class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="create-password">@lang('Password')</label>
                        <div class="input-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div class="pass-input-wrap">
                                <input type="password" id="create-password" name="password" placeholder="@lang('Enter your password')"
                                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                                <button type="button" class="eye-toggle" onclick="togglePassword('create-password', this)"
                                    aria-label="@lang('Toggle password visibility')">
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

                </div>

                {{-- Remember me & Forgot password --}}
                <div class="remember-row">
                    <label class="remember-check">
                        <input type="checkbox" name="remember" id="remember">
                        <span>@lang('Remember me')</span>
                    </label>
                    <a href="{{ route('rider.forgot') }}" class="forgot-link">@lang('Forgot password?')</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="submit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    @lang('Login')
                </button>

                {{-- Divider --}}
                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">@lang('or')</span>
                    <div class="divider-line"></div>
                </div>

                {{-- Register link --}}
                <p class="register-redirect">
                    @lang("Don't have an account?")
                    <a href="{{ route('rider.register') }}">@lang('Create new account')</a>
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
