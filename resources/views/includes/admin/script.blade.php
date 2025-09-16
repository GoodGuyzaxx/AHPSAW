{{-- Bootstrap Bundle JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

{{-- Core Scripts --}}
<script src="{{ url('backend/js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

{{-- DataTables --}}
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{ url('backend/js/datatables-simple-demo.js') }}"></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- jQuery --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

{{-- Modern UI Enhancements --}}
<script>
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading animation to forms
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation to cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in');
        });

        // Enhanced dropdown interactions
        const dropdownTriggers = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        dropdownTriggers.forEach(trigger => {
            trigger.addEventListener('show.bs.dropdown', function() {
                this.querySelector('.dropdown-toggle').style.transform = 'rotate(180deg)';
            });
            trigger.addEventListener('hide.bs.dropdown', function() {
                this.querySelector('.dropdown-toggle').style.transform = 'rotate(0deg)';
            });
        });

        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });

    // Enhanced navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    // Add progress bar for page loading
    window.addEventListener('beforeunload', function() {
        document.body.style.opacity = '0.8';
    });
</script>

{{-- Custom CSS for animations --}}
<style>
    /* Ripple effect for buttons */
    .btn {
        position: relative;
        overflow: hidden;
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Navbar scroll effect */
    .navbar-scrolled {
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        backdrop-filter: blur(20px);
    }

    /* Loading animation */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Smooth transitions */
    * {
        transition: all 0.3s ease;
    }

    /* Custom scrollbar for dropdowns */
    .dropdown-menu {
        max-height: 400px;
        overflow-y: auto;
    }

    .dropdown-menu::-webkit-scrollbar {
        width: 4px;
    }

    .dropdown-menu::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.2);
        border-radius: 4px;
    }
</style>

{{-- Session Alerts with Modern Styling --}}
@if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#fff',
            color: '#333',
            customClass: {
                popup: 'swal-toast-success'
            }
        });
    </script>
@endif

@if (session()->has('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('failed') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#fff',
            color: '#333',
            customClass: {
                popup: 'swal-toast-error'
            }
        });
    </script>

    @if ((isset($errors) && $errors->has('oldPassword')) || $errors->has('password'))
        <script>
            const myModal = document.getElementById('modalUbahPassword');
            if (myModal) {
                const modal = bootstrap.Modal.getOrCreateInstance(myModal);
                modal.show();
            }
        </script>
    @endif
@endif

{{-- Enhanced Logout Confirmation --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutButtons = document.querySelectorAll('.btnLogout');
        logoutButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin keluar dari sistem?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal',
                    background: '#fff',
                    customClass: {
                        popup: 'swal-logout-confirm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
