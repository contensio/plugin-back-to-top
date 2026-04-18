@php
    use Contensio\Plugins\BackToTop\Support\BackToTopConfig;
    try {
        $bttConfig = BackToTopConfig::all();
    } catch (\Throwable) {
        $bttConfig = ['position' => 'bottom-right', 'threshold' => 400];
    }
    $posCss    = BackToTopConfig::positionCss($bttConfig['position']);
    $threshold = (int) $bttConfig['threshold'];
@endphp
<button id="back-to-top"
        onclick="window.scrollTo({top:0,behavior:'smooth'})"
        aria-label="Back to top"
        style="display:none;position:fixed;{{ $posCss }};z-index:50;width:2.75rem;height:2.75rem;border-radius:50%;background:#e05b2b;color:#fff;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,.15);align-items:center;justify-content:center;transition:opacity .2s,transform .2s;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
    </svg>
</button>
<script>
(function(){
    var btn = document.getElementById('back-to-top');
    if (!btn) return;
    var threshold = {{ $threshold }};
    window.addEventListener('scroll', function () {
        if (window.scrollY > threshold) {
            btn.style.display = 'flex';
            btn.style.opacity = '1';
        } else {
            btn.style.opacity = '0';
            setTimeout(function () { if (window.scrollY <= threshold) btn.style.display = 'none'; }, 200);
        }
    }, { passive: true });
}());
</script>
