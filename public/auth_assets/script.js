let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-item');

function nextSlide() {
    if (slides.length === 0) return;
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
}

setInterval(nextSlide, 5000);

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.innerText = 'visibility_off';
    } else {
        passwordInput.type = 'password';
        passwordIcon.innerText = 'visibility';
    }
}

const loginForm = document.getElementById('loginForm');
const errorMessage = document.getElementById('errorMessage');
const errorText = document.getElementById('errorText');

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const btn = document.getElementById('loginBtn');
    const originalContent = btn.innerHTML;

    errorMessage.classList.add('hidden');
    btn.disabled = true;
    btn.innerHTML =
        '<span class="material-symbols-outlined animate-spin" data-icon="progress_activity">progress_activity</span> Processing...';

    const formData = new FormData(loginForm);

    fetch(window.location.href, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => {
        return response.json().then(data => ({ status: response.status, data }));
    })
    .then(({ status, data }) => {
        btn.disabled = false;
        btn.innerHTML = originalContent;

        if (data.success) {
            window.location.href = data.redirect;
        } else {
            errorText.textContent = data.message;
            errorMessage.classList.remove('hidden');

            const formContainer = document.querySelector('main .w-full.max-w-\\[400px\\]');
            formContainer.classList.add('animate-shake');
            setTimeout(() => formContainer.classList.remove('animate-shake'), 500);
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = originalContent;
        errorText.textContent = 'A network error occurred. Please try again.';
        errorMessage.classList.remove('hidden');
    });
});
