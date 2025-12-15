{{-- resources/views/layouts/footer.blade.php --}}
<footer class="footer-nav">
    <a href="{{ route('workouts.index') }}"
       class="footer-item {{ request()->routeIs('workouts.*') ? 'active' : '' }}">
        カレンダー
    </a>

    <a href="{{ route('exercises.create') }}"
       class="footer-item {{ request()->routeIs('exercises.*') ? 'active' : '' }}">
        種目
    </a>

    <a href="{{ route('settings.index') }}"
       class="footer-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        設定
    </a>
</footer>
