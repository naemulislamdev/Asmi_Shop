{{-- =====================================================================
     ASMI Shop — Web live-chat widget (storefront).
     Talks to the self-hosted Node chat service behind /chat/ (same backend
     the Flutter app + admin console use). Fully additive & isolated: lazy-loads
     socket.io only when opened, namespaced `aclc-` CSS, no storefront deps.
     Logged-in web customers => minted 'user' JWT (links to their account).
     Guests => name/phone pre-chat form => /api/front/chat/guest-token.
   ===================================================================== --}}
@php
    $aclcUser = Auth::guard('web')->user();
    $aclcUserToken = null;
    if ($aclcUser) {
        $aclcSecret = env('JWT_SECRET');
        if ($aclcSecret) {
            $aclcB64 = fn ($x) => rtrim(strtr(base64_encode($x), '+/', '-_'), '=');
            $aclcH = $aclcB64(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
            $aclcP = $aclcB64(json_encode([
                'sub' => $aclcUser->id,
                'iat' => time(),
                'exp' => time() + 7 * 24 * 3600,
            ]));
            $aclcS = $aclcB64(hash_hmac('sha256', "$aclcH.$aclcP", $aclcSecret, true));
            $aclcUserToken = "$aclcH.$aclcP.$aclcS";
        }
    }
@endphp

<style>
    .aclc-fab{position:fixed;right:20px;bottom:22px;z-index:99990;width:58px;height:58px;border-radius:50%;
        background:#1598a7;color:#fff;border:none;box-shadow:0 6px 20px rgba(21,152,167,.45);cursor:pointer;
        display:flex;align-items:center;justify-content:center;font-size:26px;transition:transform .15s,box-shadow .15s;}
    .aclc-fab:hover{transform:scale(1.06);box-shadow:0 8px 26px rgba(21,152,167,.55);}
    .aclc-fab .aclc-unread{position:absolute;top:-3px;right:-3px;background:#e60023;color:#fff;border-radius:11px;
        min-width:20px;height:20px;padding:0 5px;font-size:12px;line-height:20px;text-align:center;font-weight:700;display:none;}
    .aclc-panel{position:fixed;right:20px;bottom:22px;z-index:99991;width:360px;max-width:calc(100vw - 32px);
        height:520px;max-height:calc(100vh - 90px);background:#fff;border-radius:16px;overflow:hidden;
        box-shadow:0 12px 40px rgba(0,0,0,.22);display:none;flex-direction:column;font-family:inherit;}
    .aclc-panel.open{display:flex;}
    .aclc-head{background:#1598a7;color:#fff;padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .aclc-head .aclc-avatar{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.2);
        display:flex;align-items:center;justify-content:center;font-size:18px;}
    .aclc-head .aclc-ttl{font-weight:700;font-size:15px;line-height:1.1;}
    .aclc-head .aclc-sub{font-size:11.5px;opacity:.85;margin-top:2px;display:flex;align-items:center;gap:5px;}
    .aclc-dot{width:8px;height:8px;border-radius:50%;background:#ced4da;display:inline-block;}
    .aclc-dot.on{background:#69db7c;}
    .aclc-x{margin-left:auto;background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;opacity:.9;}
    .aclc-x:hover{opacity:1;}
    .aclc-body{flex:1;overflow-y:auto;padding:14px;background:#f6f8f9;}
    .aclc-row{display:flex;margin-bottom:9px;}
    .aclc-row.user{justify-content:flex-end;}
    .aclc-row.admin{justify-content:flex-start;}
    .aclc-bubble{max-width:78%;padding:9px 12px;border-radius:14px;font-size:13.5px;line-height:1.42;word-wrap:break-word;}
    .aclc-row.user .aclc-bubble{background:#1598a7;color:#fff;border-bottom-right-radius:4px;}
    .aclc-row.admin .aclc-bubble{background:#fff;border:1px solid #e7ebee;color:#2b3338;border-bottom-left-radius:4px;}
    .aclc-bubble .aclc-t{display:block;font-size:10px;opacity:.7;margin-top:3px;}
    .aclc-empty{color:#adb5bd;text-align:center;font-size:13px;margin-top:30px;}
    .aclc-foot{padding:10px;border-top:1px solid #eef1f3;display:flex;gap:8px;background:#fff;}
    .aclc-foot input{flex:1;border:1px solid #dde2e6;border-radius:22px;padding:9px 15px;outline:none;font-size:13.5px;}
    .aclc-foot input:focus{border-color:#1598a7;}
    .aclc-foot button{border:none;background:#1598a7;color:#fff;border-radius:50%;width:40px;height:40px;
        cursor:pointer;font-size:17px;flex:none;display:flex;align-items:center;justify-content:center;}
    .aclc-foot button:disabled{opacity:.5;cursor:default;}
    .aclc-form{padding:20px 18px;display:flex;flex-direction:column;gap:12px;}
    .aclc-form .aclc-greet{font-size:13.5px;color:#5b666e;line-height:1.5;}
    .aclc-form label{font-size:12px;font-weight:600;color:#495057;margin-bottom:4px;display:block;}
    .aclc-form input{width:100%;border:1px solid #dde2e6;border-radius:9px;padding:10px 12px;outline:none;font-size:13.5px;}
    .aclc-form input:focus{border-color:#1598a7;}
    .aclc-form .aclc-err{color:#e03131;font-size:11.5px;min-height:14px;}
    .aclc-form .aclc-start{background:#1598a7;color:#fff;border:none;border-radius:9px;padding:11px;font-weight:700;
        font-size:14px;cursor:pointer;}
    .aclc-form .aclc-start:disabled{opacity:.6;cursor:default;}
    @media (max-width:480px){
        .aclc-panel{right:0;bottom:0;width:100vw;max-width:100vw;height:100vh;max-height:100vh;border-radius:0;}
    }
</style>

<button class="aclc-fab" id="aclcFab" type="button" aria-label="Live chat" title="Chat with us">
    <i class="bi bi-chat-dots-fill"></i>
    <span class="aclc-unread" id="aclcUnread">0</span>
</button>

<div class="aclc-panel" id="aclcPanel" role="dialog" aria-label="Live chat">
    <div class="aclc-head">
        <span class="aclc-avatar"><i class="bi bi-headset"></i></span>
        <div>
            <div class="aclc-ttl">ASMI Support</div>
            <div class="aclc-sub"><span class="aclc-dot" id="aclcDot"></span><span id="aclcStatus">Connecting…</span></div>
        </div>
        <button class="aclc-x" id="aclcClose" type="button" aria-label="Close">&times;</button>
    </div>

    {{-- Pre-chat form (guests only) --}}
    <div class="aclc-form" id="aclcForm" style="display:none;">
        <div class="aclc-greet">👋 Assalamu Alaikum! Share your name &amp; phone so our team can help you and follow up.</div>
        <div>
            <label for="aclcName">Your name</label>
            <input type="text" id="aclcName" maxlength="100" placeholder="e.g. Rahim Uddin" autocomplete="name">
        </div>
        <div>
            <label for="aclcPhone">Phone number</label>
            <input type="tel" id="aclcPhone" maxlength="14" placeholder="01XXXXXXXXX" autocomplete="tel">
        </div>
        <div class="aclc-err" id="aclcFormErr"></div>
        <button class="aclc-start" id="aclcStart" type="button">Start chat</button>
    </div>

    {{-- Chat thread --}}
    <div class="aclc-body" id="aclcBody" style="display:none;">
        <div class="aclc-empty" id="aclcThreadEmpty">{{ __('Loading…') }}</div>
    </div>
    <div class="aclc-foot" id="aclcFoot" style="display:none;">
        <input type="text" id="aclcInput" placeholder="Type a message…" autocomplete="off"
               onkeydown="if(event.key==='Enter'){window.aclcSend();}">
        <button id="aclcSendBtn" type="button" onclick="window.aclcSend()" aria-label="Send">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>
</div>

<script>
(function () {
    var USER_TOKEN = @json($aclcUserToken);     // non-null => logged-in web customer
    var BASE = window.location.origin + '/chat';
    var SOCKET_PATH = '/chat/socket.io';
    var GUEST_TOKEN_URL = window.location.origin + '/api/front/chat/guest-token';
    var LS_KEY = 'aclc_guest';                   // {gid,name,phone}

    var token = null, socket = null, sioLoading = false, sioLoaded = false;
    var started = false, panelOpen = false, unread = 0;

    var fab = document.getElementById('aclcFab');
    var panel = document.getElementById('aclcPanel');
    var unreadEl = document.getElementById('aclcUnread');

    function esc(s){ var d=document.createElement('div'); d.textContent=(s==null?'':s); return d.innerHTML; }
    function fmt(s){ try{ return new Date(s).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}); }catch(e){ return ''; } }
    function setStatus(on){
        document.getElementById('aclcDot').classList.toggle('on', !!on);
        document.getElementById('aclcStatus').textContent = on ? 'Online' : 'Connecting…';
    }
    function bumpUnread(){ if(!panelOpen){ unread++; unreadEl.textContent=unread; unreadEl.style.display='block'; } }
    function clearUnread(){ unread=0; unreadEl.style.display='none'; }

    function showForm(){
        document.getElementById('aclcForm').style.display='flex';
        document.getElementById('aclcBody').style.display='none';
        document.getElementById('aclcFoot').style.display='none';
    }
    function showThread(){
        document.getElementById('aclcForm').style.display='none';
        document.getElementById('aclcBody').style.display='block';
        document.getElementById('aclcFoot').style.display='flex';
    }

    // ---- lazy-load socket.io client (only when first opened) ----
    function loadSocketIO(cb){
        if (sioLoaded) return cb();
        if (sioLoading) { var iv=setInterval(function(){ if(sioLoaded){ clearInterval(iv); cb(); } },50); return; }
        sioLoading=true;
        var s=document.createElement('script');
        s.src='https://cdn.socket.io/4.7.5/socket.io.min.js';
        s.onload=function(){ sioLoaded=true; cb(); };
        s.onerror=function(){ sioLoading=false; document.getElementById('aclcStatus').textContent='Offline'; };
        document.head.appendChild(s);
    }

    function bubble(m){
        return '<div class="aclc-row '+(m.sender_type==='admin'?'admin':'user')+'">'
            + '<div class="aclc-bubble">'+esc(m.body)+'<span class="aclc-t">'+fmt(m.created_at)+'</span></div></div>';
    }
    function renderThread(msgs){
        var b=document.getElementById('aclcBody');
        b.innerHTML = (msgs && msgs.length) ? msgs.map(bubble).join('')
            : '<div class="aclc-empty">Send us a message — we usually reply quickly.</div>';
        b.scrollTop=b.scrollHeight;
    }
    function appendMsg(m){
        var b=document.getElementById('aclcBody');
        var empty=b.querySelector('.aclc-empty'); if(empty) b.innerHTML='';
        b.insertAdjacentHTML('beforeend', bubble(m));
        b.scrollTop=b.scrollHeight;
    }

    async function loadHistory(){
        try{
            var r=await fetch(BASE+'/my/messages',{headers:{'Authorization':'Bearer '+token}});
            if(r.status===401){ handleAuthFail(); return; }
            var d=await r.json();
            renderThread(d.messages||[]);
        }catch(e){ renderThread([]); }
    }

    function handleAuthFail(){
        // guest token stale/invalid -> drop and re-collect; logged-in -> just show offline
        if(!USER_TOKEN){ localStorage.removeItem(LS_KEY); token=null; started=false; showForm(); }
        document.getElementById('aclcStatus').textContent='Offline';
    }

    function connect(){
        loadSocketIO(function(){
            if(socket){ try{ socket.disconnect(); }catch(e){} }
            socket = io(window.location.origin, {
                path: SOCKET_PATH, auth:{ token: token }, transports:['websocket','polling']
            });
            socket.on('connect', function(){ setStatus(true); });
            socket.on('disconnect', function(){ setStatus(false); });
            socket.on('message:new', function(m){
                appendMsg(m);
                if(m.sender_type==='admin') bumpUnread();
            });
            socket.on('connect_error', function(e){
                setStatus(false);
                if(e && /unauthorized/i.test(e.message||'')) handleAuthFail();
            });
        });
    }

    function startSession(){
        if(started) return;
        started=true;
        showThread();
        loadHistory();
        connect();
    }

    // ---- guest token ----
    function randGid(){
        return 'web_'+Date.now().toString(36)+Math.floor(Math.random()*1e6).toString(36);
    }
    async function mintGuest(gid,name,phone){
        var fd=new URLSearchParams();
        fd.append('guest_id',gid); fd.append('name',name); fd.append('phone',phone);
        var r=await fetch(GUEST_TOKEN_URL,{method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded','Accept':'application/json'}, body:fd});
        var d=await r.json();
        if(d && d.status && d.data && d.data.token) return d.data.token;
        throw new Error('mint failed');
    }

    function validPhone(p){ return /^(\+8801[3-9][0-9]{8}|01[3-9][0-9]{8})$/.test(p); }

    async function onStartChat(){
        var name=document.getElementById('aclcName').value.trim();
        var phone=document.getElementById('aclcPhone').value.trim();
        var err=document.getElementById('aclcFormErr');
        if(name.length<2){ err.textContent='Please enter your name.'; return; }
        if(!validPhone(phone)){ err.textContent='Enter a valid Bangladeshi number (01XXXXXXXXX).'; return; }
        err.textContent='';
        var btn=document.getElementById('aclcStart'); btn.disabled=true; btn.textContent='Starting…';
        try{
            var saved=JSON.parse(localStorage.getItem(LS_KEY)||'null');
            var gid=(saved&&saved.gid)?saved.gid:randGid();
            token=await mintGuest(gid,name,phone);
            localStorage.setItem(LS_KEY, JSON.stringify({gid:gid,name:name,phone:phone}));
            startSession();
        }catch(e){
            err.textContent='Could not start chat. Please try again.';
            btn.disabled=false; btn.textContent='Start chat';
        }
    }

    // ---- open / prepare ----
    async function prepare(){
        if(started) return;
        if(USER_TOKEN){ token=USER_TOKEN; startSession(); return; }
        var saved=JSON.parse(localStorage.getItem(LS_KEY)||'null');
        if(saved && saved.gid && saved.name && saved.phone){
            // returning guest: mint a fresh token from stored identity
            try{ token=await mintGuest(saved.gid,saved.name,saved.phone); startSession(); return; }
            catch(e){ /* fall through to form */ }
        }
        showForm();
    }

    function openPanel(){
        panel.classList.add('open'); fab.style.display='none'; panelOpen=true; clearUnread();
        prepare();
        var inp=document.getElementById('aclcInput'); if(inp && started) setTimeout(function(){ inp.focus(); },50);
    }
    function closePanel(){ panel.classList.remove('open'); fab.style.display='flex'; panelOpen=false; }

    window.aclcSend=function(){
        var inp=document.getElementById('aclcInput');
        var body=inp.value.trim();
        if(!body || !socket) return;
        socket.emit('message:send', { body: body }, function(ack){
            if(!ack || !ack.ok){ /* silent retry-friendly */ }
        });
        inp.value=''; inp.focus();
    };

    fab.addEventListener('click', openPanel);
    document.getElementById('aclcClose').addEventListener('click', closePanel);
    document.getElementById('aclcStart').addEventListener('click', onStartChat);
})();
</script>
