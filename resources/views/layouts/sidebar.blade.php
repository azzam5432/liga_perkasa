<style>
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    .container,
    .container-fluid,
    .row,
    .col,
    .col-12,
    .col-md-12,
    [class*="col-"] {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    *{
        font-family: "Ubuntu", sans-serif;
        margin: 0;
        padding: 0;
    }

    .container{
        display: flex;
        min-height: 100vh;
        padding: 0 !important;     
        margin: 0 !important;      
        max-width: 100% !important;
    }

    .sidebar{
        background-color: #111827;
        width: 260px;
        padding: 24px;
        display: flex;
        box-sizing: border-box;
        flex-direction: column;
        position: sticky;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
    }

    .main-content{
        flex-grow: 1;
        margin-left: 260px;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        padding: 0 !important;
        margin: 0 !important;
        width: calc(100% - 260px) !important;
        max-width: calc(100% - 260px) !important;
    }

    .main-content .content-wrapper {
        flex: 1;
        padding: 20px;
    }

    .footer {
        background-color: #1f2937;
        color: #ffffff;
        padding: 20px 0 !important;
        text-align: center;
        width: 100% !important;
        box-sizing: border-box !important;
        margin-top: auto;
        border-top: 2px solid #ff9900;
        margin-left: 0 !important;
        margin-right: 0 !important;
        position: relative;
        left: 0;
        right: 0;
    }

    .footer * {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        max-width: 100% !important;
    }

    .footer .footer-text {
        padding: 0 30px !important;
    }

    .footer a {
        color: #ff9900;
        text-decoration: none;
    }

    .footer a:hover {
        color: #ffffff;
        text-decoration: underline;
    }

    .sidebar .description-header{
        font-family: 'ubuntu';
        font-style: normal;
        font-weight: 700;
        font-size: 18px;
        line-height: 16px;
        text-align: center;
        color: #ffffff;
    }

    .sidebar a{
        text-decoration: none;
    }

    .sidebar .header .list-item{
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 12px 10px;
        border-radius: 8px;
        height: 40px;
        box-sizing: border-box; 
    }

    .sidebar .header .list-item .icon{
        margin-right: 12px;
    }

    .sidebar .header .ilustration {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 10px;
        margin: 10px 0 22px 0;
    }

    .sidebar .main .list-item .description{
        font-family: 'ubuntu';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 16px;
        text-align: center;
        color: #ffffff;
    }

    .sidebar .main .list-item .icon{
        margin-right: 12px;
    }

    .sidebar .main .list-item{
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 12px 10px;
        border-radius: 8px;
        width: 212px;
        box-sizing: border-box;
        transition: all ease-in .2s;
    }

    .sidebar .main .list-item:hover{
        background: #ff9900;
        transition: all ease-in .2s;
    }
</style>

<div class="container">
    <div class="sidebar">
        <div class="header">
            <div class="list-item">
                <a href="#">
                    <img src="{{ asset('icon/youtube.svg') }}" alt="" class="icon">
                    <span class="description-header">Liga Perkasa</span>
                </a>
            </div>
            <div class="ilustration">
                <img src="{{ asset('icon/ilustrator.png') }}" alt="">
            </div>
        </div>
        <div class="main">
            <a href="/dashboard">
                <div class="list-item">
                    <img src="{{ asset('icon/dashboard.svg') }}" alt="" class="icon">
                    <span class="description">Dashboard</span>
                </div>
            </a>
            
            <!-- <div class="list-item">
                <a href="">
                    <img src="{{ asset('icon/analytic.svg') }}" alt="" class="icon">
                    <span class="description">Analytic</span>
                </a>
            </div>
            <div class="list-item">
                <a href="">
                    <img src="{{ asset('icon/category.svg') }}" alt="" class="icon">
                    <span class="description">Category</span>
                </a>
            </div> -->
            <a href="/peserta" style="text-decoration: none;">
                <div class="list-item">
                    <img src="{{ asset('icon/team.svg') }}" alt="" class="icon">
                    <span class="description">Peserta Lomba</span>
                </div>
            </a>
            <!-- <div class="list-item">
                <a href="">
                    <img src="{{ asset('icon/event.svg') }}" alt="" class="icon">
                    <span class="description">Event</span>
                </a>
            </div>
            <div class="list-item">
                <a href="">
                    <img src="{{ asset('icon/explore.svg') }}" alt="" class="icon">
                    <span class="description">Explore</span>
                </a>
            </div> -->
            <!-- <div class="list-item">
                <a href="">
                    <img src="{{ asset('icon/history.svg') }}" alt="" class="icon">
                    <span class="description">History</span>
                </a>
            </div>
            <div class="list-item">
                <a href="">
                    <img src="{{ asset('icon/setting.svg') }}" alt="" class="icon">
                    <span class="description">Setting</span>
                </a>
            </div>
            <div class="list-item">
                <a href="">
                    <img src="{{ asset('icon/setting.svg') }}" alt="" class="icon">
                    <span class="description">Setting</span>
                </a>
            </div> -->
            <div class="text-center border-top pt-3">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="content-wrapper"> 
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>
</div>