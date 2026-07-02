document.addEventListener('DOMContentLoaded', function () {
    const navToggle = document.getElementById('navToggle');
    const navLinks  = document.getElementById('navLinks');
    
    if (navToggle && navLinks) {
        navToggle.addEventListener('click', function () {
            navLinks.classList.toggle('open');
            navToggle.classList.toggle('open');
        });
    }
    const header = document.querySelector('.site-header');
    if (header) {
        window.addEventListener('scroll', function () {
            // Ajouter une ombre quand on scrolle vers le bas
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    const backTop = document.getElementById('backTop');
    if (backTop) {
        window.addEventListener('scroll', function () {
            // Montrer le bouton après 400px de scroll
            if (window.scrollY > 400) {
                backTop.classList.add('visible');
            } else {
                backTop.classList.remove('visible');
            }
        });

        backTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    const filterBtns = document.querySelectorAll('.filter-btn');
    const prodCards  = document.querySelectorAll('#prodGrid .prod-card');

    if (filterBtns.length > 0) {
        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                // Retirer la classe active de tous les boutons
                filterBtns.forEach(function (b) { b.classList.remove('active'); });
                // Ajouter la classe active au bouton cliqué
                btn.classList.add('active');

                const filter = btn.dataset.filter; // Ex: 'femmes', 'new', 'all'

                // Afficher ou cacher les cartes selon le filtre
                prodCards.forEach(function (card) {
                    const tags = card.dataset.filter || '';

                    if (filter === 'all' || tags.includes(filter)) {
                        card.style.display = ''; // Afficher
                    } else {
                        card.style.display = 'none'; // Cacher
                    }
                });
            });
        });
    }
    const flash = document.querySelector('.flash-message');
    if (flash) {
        setTimeout(function () {
            flash.style.opacity = '0';
            flash.style.transition = 'opacity 0.5s';
            setTimeout(function () { flash.remove(); }, 500);
        }, 3000);
    }
    document.querySelectorAll('.confirm-delete').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Êtes-vous sûr ?')) {
                e.preventDefault();
            }
        });
    });

});
