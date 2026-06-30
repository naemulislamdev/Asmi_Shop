@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-3" style="max-width:900px;">
        <h4 style="font-weight:700;margin-bottom:16px;">{{ __('Marketing Push') }}</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div style="background:#fff;border:1px solid #edf0f5;border-radius:12px;padding:20px;margin-bottom:24px;">
            <form method="POST" action="{{ route('admin.marketing-push.send') }}"
                  onsubmit="return confirm('{{ __('This sends a push to ALL app users. Continue?') }}');">
                @csrf
                <div class="form-group">
                    <label style="font-weight:600;">{{ __('Title') }}</label>
                    <input type="text" name="title" class="form-control" maxlength="120" required
                           value="{{ old('title') }}" placeholder="{{ __('e.g. Eid Sale is live!') }}">
                </div>
                <div class="form-group">
                    <label style="font-weight:600;">{{ __('Message') }}</label>
                    <textarea name="body" class="form-control" rows="3" maxlength="500" required
                              placeholder="{{ __('Up to 500 characters') }}">{{ old('body') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="font-weight:600;">
                    <i class="fas fa-bullhorn"></i> {{ __('Send to ALL users') }}
                </button>
                <span style="color:#868e96;font-size:13px;margin-left:10px;">
                    {{ __('Goes to every installed app (FCM topic: all).') }}
                </span>
            </form>
        </div>

        <h6 style="font-weight:700;margin-bottom:10px;">{{ __('Recent campaigns') }}</h6>
        <div style="background:#fff;border:1px solid #edf0f5;border-radius:12px;overflow:hidden;">
            <table class="table" style="margin:0;">
                <thead>
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Message') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Sent') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($campaigns as $c)
                        <tr>
                            <td style="font-weight:600;">{{ $c->title }}</td>
                            <td style="color:#495057;">{{ \Illuminate\Support\Str::limit($c->body, 60) }}</td>
                            <td>
                                @if ($c->status === 'sent')
                                    <span class="badge badge-success">{{ __('Sent') }}</span>
                                @elseif ($c->status === 'failed')
                                    <span class="badge badge-danger">{{ __('Failed') }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $c->status }}</span>
                                @endif
                            </td>
                            <td style="color:#868e96;font-size:13px;">{{ $c->created_at }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;color:#adb5bd;padding:18px;">{{ __('No campaigns yet') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
