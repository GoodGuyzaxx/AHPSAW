<style>
    .icon-shape { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .bg-gradient-info { background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important; }
    .animate-fade-in { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.6s ease forwards; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if (togglePassword) {
            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
