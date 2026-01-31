<script>
    (function () {
        const applyPageLoaded = () => document.body.classList.add('page-loaded');

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', applyPageLoaded);
        } else {
            applyPageLoaded();
        }

        const items = Array.from(document.querySelectorAll('.reveal'));
        if (!items.length || !('IntersectionObserver' in window)) {
            items.forEach(el => el.classList.add('is-visible'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -5% 0px' });

        items.forEach(el => observer.observe(el));
    })();
</script>

