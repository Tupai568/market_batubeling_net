@if (session()->has('success'))
    <div class="container-notif">
        <div class="notif bg-success"> <span>{{ session("success") }}</span></div>
    </div>
@endif
@if (session()->has('error'))
    <div class="container-notif">
        <div class="notif bg-danger"> <span>{{ session("error") }}</span></div>
    </div>
@endif
@if (session()->has('warning'))
    <div class="container-notif">
        <div class="notif bg-warning"> <span>{!! session("warning") !!}</span></div>
    </div>
@endif