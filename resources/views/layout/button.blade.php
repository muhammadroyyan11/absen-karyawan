
<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : ''}}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Dashboard</strong>
        </div>
    </a>
    <a href="/history" class="item  {{ request()->is('history') ? 'active' : ''}}">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                      aria-label="calendar outline"></ion-icon>
            <strong>History</strong>
        </div>
    </a>
    <a href="/presensi/create" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="#" class="item">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                      aria-label="document text outline"></ion-icon>
            <strong>Cuti</strong>
        </div>
    </a>
    <a href="/edit-profile" class="item {{ request()->is('edit-profile') ? 'active' : ''}}" class="item">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->
