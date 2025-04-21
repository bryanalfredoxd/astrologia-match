    // Toggle para mostrar/ocultar contraseña
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#contrasena');
    
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#contrasena_confirmation');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
    
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
    
    // Validación de formulario con Bootstrap
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
    })();

    // Validación de formulario
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
    })();
    
    // Inicializar AOS para animaciones
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    document.addEventListener('DOMContentLoaded', function() {
    const cosmicBtn = document.querySelector('.cosmic-btn');
    
    if(cosmicBtn) {
        cosmicBtn.addEventListener('click', function(e) {
            // Solo animar si el formulario es válido
            const form = this.closest('form');
            if(form && form.checkValidity()) {
                this.classList.add('clicked');
                
                // Remover la clase después de la animación
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 800);
                
                // Animación del icono de estrellas
                const starIcon = this.querySelector('.bi-stars');
                if(starIcon) {
                    starIcon.style.transform = 'scale(1.5)';
                    setTimeout(() => {
                        starIcon.style.transform = 'scale(1)';
                    }, 300);
                }
            }
        });
    }
    });

    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const termsCheckbox = document.getElementById('terms');
    const termsFeedback = document.querySelector('.terms-feedback');
    
    if(form) {
        // Validación al enviar el formulario
        form.addEventListener('submit', function(e) {
            if(!termsCheckbox.checked) {
                e.preventDefault();
                termsCheckbox.classList.add('is-invalid');
                termsFeedback.style.display = 'block';
                
                // Scroll suave al campo no válido
                termsCheckbox.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
        
        // Validación en tiempo real
        termsCheckbox.addEventListener('change', function() {
            if(this.checked) {
                this.classList.remove('is-invalid');
                termsFeedback.style.display = 'none';
            } else {
                this.classList.add('is-invalid');
                termsFeedback.style.display = 'block';
            }
        });
    }
});
