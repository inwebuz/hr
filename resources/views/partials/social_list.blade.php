
@php
    $telegram = Helper::setting('contact.telegram', 5);
    $facebook = Helper::setting('contact.facebook', 5);
    $instagram = Helper::setting('contact.instagram', 5);
    $youtube = Helper::setting('contact.youtube', 5);
@endphp
@if ($telegram)
    {{-- <li><a class="social-btn telegram" href="{{ setting('contact.telegram') }}" title="Telegram" target="_blank" rel="nofollow"><i class="ion-paper-airplane fab fa-telegram-plane"></i></a></li> --}}
    <li>
        <a href="{{ $telegram }}" title="Telegram" target="_blank" rel="nofollow">
            <i class="fas fa-paper-plane"></i>
        </a>
    </li>
@endif
@if ($facebook)
    {{-- <li><a class="social-btn facebook" href="{{ setting('contact.facebook') }}" title="Facebook" target="_blank" rel="nofollow"><i class="ion-social-facebook fab fa-facebook-f"></i></a></li> --}}
    <li>
        <a href="{{ $facebook }}" title="Facebook" target="_blank" rel="nofollow">
            <i class="fab fa-facebook-f"></i>
        </a>
    </li>
@endif
@if ($instagram)
    {{-- <li><a class="social-btn instagram" href="{{ setting('contact.instagram') }}" title="Instagram" target="_blank" rel="nofollow"><i class="ion-social-instagram-outline fab fa-instagram"></i></a></li> --}}
    <li>
        <a href="{{ $instagram }}" title="Instagram" target="_blank" rel="nofollow">
            <i class="fab fa-instagram"></i>
        </a>
    </li>
@endif
@if ($youtube)
    <li>
        <a href="{{ $youtube }}" title="Youtube" target="_blank" rel="nofollow">
            <i class="fab fa-youtube"></i>
        </a>
    </li>
@endif

