
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/font-awesome/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/Ionicons/css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/square/blue.css') }}">


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script nonce="a9700ac4-b020-481b-9c09-cea6061842d5">try{(function(w,d){!function(c,d,e,f){if(c.zaraz)console.error("zaraz is loaded twice");else{c[e]=c[e]||{};c[e].executed=[];c.zaraz={deferred:[],listeners:[]};c.zaraz._v="5714";c.zaraz.q=[];c.zaraz._f=function(g){return async function(){var h=Array.prototype.slice.call(arguments);c.zaraz.q.push({m:g,a:h})}};for(const i of["track","set","debug"])c.zaraz[i]=c.zaraz._f(i);c.zaraz.init=()=>{var j=d.getElementsByTagName(f)[0],k=d.createElement(f),l=d.getElementsByTagName("title")[0];l&&(c[e].t=d.getElementsByTagName("title")[0].text);c[e].x=Math.random();c[e].w=c.screen.width;c[e].h=c.screen.height;c[e].j=c.innerHeight;c[e].e=c.innerWidth;c[e].l=c.location.href;c[e].r=d.referrer;c[e].k=c.screen.colorDepth;c[e].n=d.characterSet;c[e].o=(new Date).getTimezoneOffset();if(c.dataLayer)for(const p of Object.entries(Object.entries(dataLayer).reduce(((q,r)=>({...q[1],...r[1]})),{})))zaraz.set(p[0],p[1],{scope:"page"});c[e].q=[];for(;c.zaraz.q.length;){const s=c.zaraz.q.shift();c[e].q.push(s)}k.defer=!0;for(const t of[localStorage,sessionStorage])Object.keys(t||{}).filter((v=>v.startsWith("_zaraz_"))).forEach((u=>{try{c[e]["z_"+u.slice(7)]=JSON.parse(t.getItem(u))}catch{c[e]["z_"+u.slice(7)]=t.getItem(u)}}));k.referrerPolicy="origin";k.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(c[e])));j.parentNode.insertBefore(k,j)};["complete","interactive"].includes(d.readyState)?zaraz.init():c.addEventListener("DOMContentLoaded",zaraz.init)}}(w,d,"zarazData","script");})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script></head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Administrator</b> Login</a>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="/prosesLoginAdmin" method="post">
            @csrf
            <div class="form-group has-feedback">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>
    </div>

</div>


<script src="{{ asset('assets/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ asset('assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{asset('assets/admin/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>
