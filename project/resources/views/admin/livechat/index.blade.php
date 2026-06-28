@extends('layouts.admin')

@section('styles')
    <style>
        .lc-wrap { display:flex; gap:14px; height:calc(100vh - 170px); min-height:480px; }
        .lc-inbox { width:320px; flex:none; background:#fff; border:1px solid #edf0f5; border-radius:12px;
                    overflow-y:auto; }
        .lc-inbox h6 { padding:14px 16px; margin:0; border-bottom:1px solid #f1f3f9; font-weight:700; }
        .lc-conv { padding:12px 16px; border-bottom:1px solid #f4f6fa; cursor:pointer; }
        .lc-conv:hover, .lc-conv.active { background:#f3f6ff; }
        .lc-conv .nm { font-weight:600; color:#1f2937; }
        .lc-conv .meta { font-size:12px; color:#868e96; margin-top:2px; }
        .lc-conv .badge-unread { background:#f03e3e; color:#fff; border-radius:10px; padding:0 7px; font-size:11px; float:right; }
        .lc-main { flex:1; display:flex; flex-direction:column; background:#fff; border:1px solid #edf0f5; border-radius:12px; }
        .lc-head { padding:14px 16px; border-bottom:1px solid #f1f3f9; font-weight:700; display:flex; align-items:center; gap:8px; }
        .lc-status { width:9px; height:9px; border-radius:50%; background:#adb5bd; }
        .lc-status.on { background:#37b24d; }
        .lc-body { flex:1; overflow-y:auto; padding:16px; background:#fafbfc; }
        .lc-row { display:flex; margin-bottom:10px; }
        .lc-row.user { justify-content:flex-start; }
        .lc-row.admin { justify-content:flex-end; }
        .lc-bubble { max-width:70%; padding:9px 13px; border-radius:14px; font-size:14px; line-height:1.4; }
        .lc-row.user .lc-bubble { background:#fff; border:1px solid #e9ecef; color:#343a40; border-bottom-left-radius:4px; }
        .lc-row.admin .lc-bubble { background:#4c6ef5; color:#fff; border-bottom-right-radius:4px; }
        .lc-bubble .t { display:block; font-size:10.5px; opacity:.7; margin-top:3px; }
        .lc-foot { padding:12px; border-top:1px solid #f1f3f9; display:flex; gap:8px; }
        .lc-foot input { flex:1; border:1px solid #dee2e6; border-radius:22px; padding:10px 16px; outline:none; }
        .lc-foot button { border:none; background:#4c6ef5; color:#fff; border-radius:22px; padding:0 20px; font-weight:600; cursor:pointer; }
        .lc-empty { color:#adb5bd; text-align:center; margin-top:40px; }
        /* Customer context panel */
        .lc-context { width:280px; flex:none; background:#fff; border:1px solid #edf0f5; border-radius:12px; overflow-y:auto; padding:16px; }
        .lc-context h6 { font-weight:700; margin:0 0 10px; }
        .lc-ctx-name { font-weight:700; color:#1f2937; font-size:15px; }
        .lc-ctx-tag { display:inline-block; font-size:11px; padding:1px 8px; border-radius:10px; margin-left:6px; }
        .lc-ctx-tag.reg { background:#e6fcf5; color:#0ca678; } .lc-ctx-tag.guest { background:#fff3bf; color:#e67700; }
        .lc-ctx-line { font-size:13px; color:#495057; margin-top:4px; }
        .lc-ctx-stats { display:flex; gap:10px; margin:12px 0; }
        .lc-ctx-stat { flex:1; background:#f8f9fb; border-radius:8px; padding:8px; text-align:center; }
        .lc-ctx-stat .v { font-weight:700; font-size:16px; color:#1f2937; } .lc-ctx-stat .l { font-size:11px; color:#868e96; }
        .lc-ord { border-top:1px solid #f1f3f9; padding:8px 0; font-size:12.5px; }
        .lc-ord .on { font-weight:600; color:#343a40; } .lc-ord .st { color:#868e96; }
        @media (max-width: 991px){ .lc-context { display:none; } }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <h4 style="font-weight:700;margin-bottom:12px;">{{ __('Live Chat') }}</h4>
        <div class="lc-wrap">
            <div class="lc-inbox">
                <h6>{{ __('Conversations') }}</h6>
                <div id="lc-list"><div class="lc-empty">{{ __('Loading…') }}</div></div>
            </div>
            <div class="lc-main">
                <div class="lc-head">
                    <span class="lc-status" id="lc-conn"></span>
                    <span id="lc-title">{{ __('Select a conversation') }}</span>
                </div>
                <div class="lc-body" id="lc-thread">
                    <div class="lc-empty">{{ __('Pick a customer on the left to start chatting.') }}</div>
                </div>
                <div class="lc-foot">
                    <input type="text" id="lc-input" placeholder="{{ __('Type a message…') }}" disabled
                           onkeydown="if(event.key==='Enter'){lcSend();}">
                    <button onclick="lcSend()" id="lc-send" disabled>{{ __('Send') }}</button>
                </div>
            </div>
            <div class="lc-context" id="lc-context">
                <div class="lc-empty">{{ __('Customer details appear here') }}</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
    <script>
        var TOKEN = @json($chatToken);
        var BASE = @json($chatBase);
        var SOCKET_PATH = @json($socketPath);
        var CONTEXT_URL = @json($contextUrl);
        var currentConv = null, socket = null;

        function authHeaders() { return { 'Authorization': 'Bearer ' + TOKEN }; }
        function esc(s){ var d=document.createElement('div'); d.textContent=s==null?'':s; return d.innerHTML; }
        function fmtTime(s){ try { return new Date(s).toLocaleString(); } catch(e){ return ''; } }

        async function loadInbox() {
            try {
                var r = await fetch(BASE + '/admin/conversations', { headers: authHeaders() });
                var d = await r.json();
                renderInbox(d.conversations || []);
            } catch (e) { /* ignore */ }
        }

        function renderInbox(list) {
            var el = document.getElementById('lc-list');
            if (!list.length) { el.innerHTML = '<div class="lc-empty">{{ __('No conversations yet') }}</div>'; return; }
            el.innerHTML = list.map(function (c) {
                var unread = c.unread_admin > 0 ? '<span class="badge-unread">' + c.unread_admin + '</span>' : '';
                var active = c.id === currentConv ? ' active' : '';
                var label = c.guest_name ? esc(c.guest_name) : ('{{ __('Customer') }} #' + (c.user_id || '?'));
                var phone = c.guest_phone || '';
                var meta = (phone ? esc(phone) + ' · ' : '') + (c.last_message_at ? fmtTime(c.last_message_at) : '');
                return '<div class="lc-conv' + active + '" onclick="openConv(' + c.id + ',' + (c.user_id || 'null') + ',\'' + phone + '\')">'
                    + unread + '<div class="nm">' + label + '</div>'
                    + '<div class="meta">' + meta + '</div></div>';
            }).join('');
        }

        async function openConv(id, userId, phone) {
            currentConv = id;
            document.getElementById('lc-title').textContent =
                (phone ? phone : '{{ __('Customer') }} #' + (userId || '?'));
            document.getElementById('lc-input').disabled = false;
            document.getElementById('lc-send').disabled = false;
            loadContext(userId, phone);
            try {
                var r = await fetch(BASE + '/admin/conversations/' + id + '/messages', { headers: authHeaders() });
                var d = await r.json();
                renderThread(d.messages || []);
                if (socket) socket.emit('conversation:open', { conversationId: id });
                loadInbox();
            } catch (e) { /* ignore */ }
        }

        async function loadContext(userId, phone) {
            var el = document.getElementById('lc-context');
            var q = [];
            if (userId && userId !== 'null' && userId !== null) q.push('user_id=' + encodeURIComponent(userId));
            if (phone) q.push('phone=' + encodeURIComponent(phone));
            if (!q.length) { el.innerHTML = '<div class="lc-empty">{{ __('No customer info') }}</div>'; return; }
            el.innerHTML = '<div class="lc-empty">{{ __('Loading…') }}</div>';
            try {
                var r = await fetch(CONTEXT_URL + '?' + q.join('&'), { headers: { 'Accept': 'application/json' } });
                renderContext(await r.json());
            } catch (e) { el.innerHTML = '<div class="lc-empty">{{ __('Could not load') }}</div>'; }
        }

        function renderContext(d) {
            var el = document.getElementById('lc-context');
            if (!d || d.status === false) { el.innerHTML = '<div class="lc-empty">{{ __('No data') }}</div>'; return; }
            var p = d.profile || {}, s = d.stats || {}, recent = d.recent || [];
            var tag = p.is_registered
                ? '<span class="lc-ctx-tag reg">{{ __('Registered') }}</span>'
                : '<span class="lc-ctx-tag guest">{{ __('Guest') }}</span>';
            var html = '<h6>{{ __('Customer') }}</h6>'
                + '<div class="lc-ctx-name">' + esc(p.name || '{{ __('Unknown') }}') + tag + '</div>'
                + (p.phone ? '<div class="lc-ctx-line">📞 ' + esc(p.phone) + '</div>' : '')
                + (p.email ? '<div class="lc-ctx-line">✉ ' + esc(p.email) + '</div>' : '')
                + '<div class="lc-ctx-stats"><div class="lc-ctx-stat"><div class="v">' + (s.orders || 0) + '</div><div class="l">{{ __('Orders') }}</div></div>'
                + '<div class="lc-ctx-stat"><div class="v">৳' + (s.spent || 0) + '</div><div class="l">{{ __('Spent') }}</div></div></div>'
                + '<h6>{{ __('Recent orders') }}</h6>';
            if (recent.length) {
                recent.forEach(function (o) {
                    html += '<div class="lc-ord"><span class="on">' + esc(o.order_number || '') + '</span> · ৳' + (o.pay_amount || 0)
                        + '<br><span class="st">' + esc(o.status || '') + ' · ' + fmtTime(o.created_at) + '</span></div>';
                });
            } else { html += '<div class="lc-empty">{{ __('No orders') }}</div>'; }
            el.innerHTML = html;
        }

        function renderThread(msgs) {
            var b = document.getElementById('lc-thread');
            b.innerHTML = msgs.map(bubble).join('') || '<div class="lc-empty">{{ __('No messages yet') }}</div>';
            b.scrollTop = b.scrollHeight;
        }
        function bubble(m) {
            return '<div class="lc-row ' + (m.sender_type === 'admin' ? 'admin' : 'user') + '">'
                + '<div class="lc-bubble">' + esc(m.body) + '<span class="t">' + fmtTime(m.created_at) + '</span></div></div>';
        }
        function appendMsg(m) {
            var b = document.getElementById('lc-thread');
            if (b.querySelector('.lc-empty')) b.innerHTML = '';
            b.insertAdjacentHTML('beforeend', bubble(m));
            b.scrollTop = b.scrollHeight;
        }

        function lcSend() {
            var inp = document.getElementById('lc-input');
            var body = inp.value.trim();
            if (!body || !currentConv || !socket) return;
            socket.emit('message:send', { conversationId: currentConv, body: body }, function (ack) {
                if (!ack || !ack.ok) alert('{{ __('Message failed to send') }}');
            });
            inp.value = '';
        }

        function initSocket() {
            socket = io(window.location.origin, {
                path: SOCKET_PATH, auth: { token: TOKEN }, transports: ['websocket', 'polling']
            });
            socket.on('connect', function () { document.getElementById('lc-conn').classList.add('on'); });
            socket.on('disconnect', function () { document.getElementById('lc-conn').classList.remove('on'); });
            socket.on('message:new', function (m) {
                if (m.conversation_id === currentConv) appendMsg(m);
                loadInbox();
            });
            socket.on('inbox:update', function () { loadInbox(); });
            socket.on('connect_error', function (e) { console.log('chat connect_error', e.message); });
        }

        initSocket();
        loadInbox();
    </script>
@endsection
