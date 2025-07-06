document.addEventListener('DOMContentLoaded', () => {
  // Gestion des notifications
  const notificationsSection = document.querySelector('.notifications');
  const notificationCards = document.querySelectorAll('.notification-card');
  
  // Animer l'apparition des notifications
  notificationCards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
      card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 100); // Délai progressif pour chaque notification
  });

  // Gestion du menu hamburger
  const hamburger = document.querySelector('.hamburger');
  const navMenu = document.querySelector('.nav-menu');

  if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
      const isExpanded = hamburger.getAttribute('aria-expanded') === 'true';
      hamburger.setAttribute('aria-expanded', !isExpanded);
      navMenu.classList.toggle('active');
      hamburger.querySelector('i').classList.toggle('fa-bars');
      hamburger.querySelector('i').classList.toggle('fa-times');
    });

    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.querySelector('i').classList.add('fa-bars');
        hamburger.querySelector('i').classList.remove('fa-times');
      });
    });
  }

  // Gestion du thème sombre/clair
  const themeToggle = document.querySelector('.theme-toggle');
  const body = document.body;
  const savedTheme = localStorage.getItem('theme') || 'light';
  body.classList.toggle('dark-mode', savedTheme === 'dark');
  themeToggle.querySelector('i').classList.toggle('fa-sun', savedTheme === 'dark');
  themeToggle.querySelector('i').classList.toggle('fa-moon', savedTheme !== 'dark');

  // Mettre à jour le thème des notifications
  function updateNotificationTheme() {
    const isDark = body.classList.contains('dark-mode');
    notificationCards.forEach(card => {
      if (isDark) {
        card.style.backgroundColor = '#1a1a1a';
        card.style.color = '#ffffff';
        card.querySelector('.notification-meta').style.color = '#999';
      } else {
        card.style.backgroundColor = '#ffffff';
        card.style.color = '#333';
        card.querySelector('.notification-meta').style.color = '#666';
      }
    });
  }

  themeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    const isDark = body.classList.contains('dark-mode');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    themeToggle.querySelector('i').classList.toggle('fa-moon');
    themeToggle.querySelector('i').classList.toggle('fa-sun');
    updateNotificationTheme();
  });

  // Gestion de la barre de recherche (simulation)
  const searchInput = document.getElementById('search');
  const searchButton = document.querySelector('.search-bar button');

  if (searchInput && searchButton) {
    searchButton.addEventListener('click', () => {
      const query = searchInput.value.trim();
      if (query && !searchInput.disabled) {
        console.log('Recherche effectuée :', query);
        // À remplacer par une vraie logique de recherche
      }
    });

    searchInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter' && searchInput.value.trim() && !searchInput.disabled) {
        console.log('Recherche via Enter :', searchInput.value.trim());
        // À remplacer par une vraie logique de recherche
      }
    });
  }

  // Validation du formulaire de connexion
  const loginForm = document.getElementById('login-form');
  if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      let isValid = true;

      document.querySelectorAll('.error').forEach(error => error.textContent = '');

      const email = document.getElementById('email').value;
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById('email-error').textContent = 'Veuillez entrer un email valide.';
        isValid = false;
      }

      const password = document.getElementById('password').value;
      if (password.length < 6) {
        document.getElementById('password-error').textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
        isValid = false;
      }

      if (isValid) {
        loginForm.submit();
      }
    });
  }

  // Validation du formulaire d'inscription
  const registerForm = document.getElementById('register-form');
  if (registerForm) {
    registerForm.addEventListener('submit', (e) => {
      e.preventDefault();
      let isValid = true;

      document.querySelectorAll('.error').forEach(error => error.textContent = '');

      const nom = document.getElementById('nom').value;
      if (nom.trim().length < 2) {
        document.getElementById('nom-error').textContent = 'Le nom doit contenir au moins 2 caractères.';
        isValid = false;
      }

      const email = document.getElementById('email').value;
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById('email-error').textContent = 'Veuillez entrer un email valide.';
        isValid = false;
      }

      const classe = document.getElementById('classe').value;
      if (!classe) {
        document.getElementById('classe-error').textContent = 'Veuillez sélectionner une classe.';
        isValid = false;
      }

      const password = document.getElementById('password').value;
      if (password.length < 6) {
        document.getElementById('password-error').textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
        isValid = false;
      }

      const confirmPassword = document.getElementById('confirm_password').value;
      if (password !== confirmPassword) {
        document.getElementById('confirm-password-error').textContent = 'Les mots de passe ne correspondent pas.';
        isValid = false;
      }

      if (isValid) {
        registerForm.submit();
      }
    });
  }

  // Validation du formulaire d'administration
  const adminForm = document.getElementById('admin-form');
  if (adminForm) {
    adminForm.addEventListener('submit', (e) => {
      e.preventDefault();
      let isValid = true;

      document.querySelectorAll('.error').forEach(error => error.textContent = '');

      const classe = document.getElementById('classe').value;
      if (!classe) {
        document.getElementById('classe-error').textContent = 'Veuillez sélectionner une classe.';
        isValid = false;
      }

      const semaine = document.getElementById('semaine').value.trim();
      if (!semaine) {
        document.getElementById('semaine-error').textContent = 'Veuillez entrer une semaine.';
        isValid = false;
      }

      const contenu = document.getElementById('contenu').value.trim();
      if (!contenu) {
        document.getElementById('contenu-error').textContent = 'Veuillez entrer le contenu de l\'emploi du temps.';
        isValid = false;
      }

      if (isValid) {
        adminForm.submit();
      }
    });
  }

  // Validation du formulaire de profil
  const profileForm = document.getElementById('profile-form');
  if (profileForm) {
    profileForm.addEventListener('submit', (e) => {
      e.preventDefault();
      let isValid = true;

      document.querySelectorAll('.error').forEach(error => error.textContent = '');

      const currentPassword = document.getElementById('current_password').value;
      if (!currentPassword) {
        document.getElementById('current-password-error').textContent = 'Veuillez entrer votre mot de passe actuel.';
        isValid = false;
      }

      const newPassword = document.getElementById('new_password').value;
      if (newPassword.length < 6) {
        document.getElementById('new-password-error').textContent = 'Le nouveau mot de passe doit contenir au moins 6 caractères.';
        isValid = false;
      }

      const confirmPassword = document.getElementById('confirm_password').value;
      if (newPassword !== confirmPassword) {
        document.getElementById('confirm-password-error').textContent = 'La confirmation du mot de passe ne correspond pas.';
        isValid = false;
      }

      if (isValid) {
        profileForm.submit();
      }
    });
  }

  // Gestion de l'afficher/masquer le mot de passe
  document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', () => {
      const passwordInput = toggle.previousElementSibling;
      const isPasswordVisible = passwordInput.type === 'text';
      passwordInput.type = isPasswordVisible ? 'password' : 'text';
      toggle.querySelector('i').classList.toggle('fa-eye');
      toggle.querySelector('i').classList.toggle('fa-eye-slash');
      toggle.setAttribute('aria-label', isPasswordVisible ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
    });
  });
});