

// Cartes 3D : inclinaison qui suit la souris
document.querySelectorAll('[data-tilt]').forEach((card) => {
    const max = Number(card.dataset.tilt) || 10;
    card.addEventListener('pointermove', (e) => {
        if (e.pointerType !== 'mouse') return;
        const r = card.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width;
        const y = (e.clientY - r.top) / r.height;
        card.style.setProperty('--ry', `${(x - 0.5) * 2 * max}deg`);
        card.style.setProperty('--rx', `${(0.5 - y) * 2 * max}deg`);
        card.style.setProperty('--gx', `${x * 100}%`);
        card.style.setProperty('--gy', `${y * 100}%`);
        card.style.setProperty('--go', '1');
    });
    card.addEventListener('pointerleave', () => {
        card.style.setProperty('--rx', '0deg');
        card.style.setProperty('--ry', '0deg');
        card.style.setProperty('--go', '0');
    });
});
// Connexion / inscription : faire glisser le panneau sans recharger la page
document.querySelectorAll('[data-auth-switch]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const box = document.querySelector('[data-auth]');
        if (!box) return;
        const toRegister = btn.dataset.authSwitch === 'register';
        box.classList.toggle('is-register', toRegister);
        // l'adresse change aussi (/login ou /register), sans rechargement
        history.replaceState(null, '', toRegister ? box.dataset.registerUrl : box.dataset.loginUrl);
    });
});

// Comptes de démonstration : remplir le formulaire de connexion en un clic
document.querySelectorAll('[data-fill-email]').forEach((btn) => {
    btn.addEventListener('click', () => {
        document.getElementById('login_email').value = btn.dataset.fillEmail;
        document.getElementById('login_password').value = btn.dataset.fillPassword;
    });
});

// Menu latéral sur mobile
document.querySelectorAll('[data-drawer-toggle]').forEach((btn) => {
    btn.addEventListener('click', () => document.getElementById('drawer')?.classList.toggle('hidden'));
});

// Messages de succès : disparaissent après 4 secondes
document.querySelectorAll('[data-autohide]').forEach((el) => setTimeout(() => el.remove(), 4000));