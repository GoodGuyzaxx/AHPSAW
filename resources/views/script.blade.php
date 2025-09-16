{{-- scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="{{ url('backend/js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
{{-- <script src="{{ url('backend/assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ url('backend/assets/demo/chart-bar-demo.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script src="{{ url('backend/js/datatables-simple-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="{{ url('frontend/scripts/script.js') }}"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
    // Mobile menu toggle
    const toggle = () => {
        const m = document.querySelector('.menu');
        if(!m) return; m.classList.toggle('show');
    };


    // Dropdown handler (data-dropdown)
    document.addEventListener('click', (e) => {
        const isBtn = e.target.closest('[data-dropdown]');
        const all = document.querySelectorAll('.dropdown, .profile-menu');
        all.forEach(el => { if(!el.contains(e.target)) el.classList.remove('open'); });
        if(isBtn){
            const wrap = isBtn.closest('.dropdown, .profile-menu');
            wrap?.classList.toggle('open');
        }
    });


    // Mark active link by current URL
    window.addEventListener('DOMContentLoaded', () => {
        const here = location.pathname.replace(/\/$/, '');
        document.querySelectorAll('[data-nav] a').forEach(a => {
            const path = a.getAttribute('href')?.replace(/\/$/, '') || '';
            if(path && here === path){ a.setAttribute('aria-current','page'); a.classList.add('active'); }
        });
    });
</script>


{{-- alert from session --}}
@if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            type: "success"
        }).then((result) => {
            // Reload the Page
            location.reload();
        });
    </script>
@endif

@if (session()->has('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: "{{ session('failed') }}",
            type: "failed"
        }).then((result) => {
            // Reload the Page
            location.reload();
        });
    </script>

    @if ((isset($errors) && $errors->has('oldPassword')) || $errors->has('password'))
        <script>
            const myModal = document.getElementById('modalUbahPassword');
            const modal = bootstrap.Modal.getOrCreateInstance(myModal);
            modal.show();
        </script>
    @endif
@endif
