window.onload = function () {
  setTimeout(() => {
    window.scrollTo(0, 0);
  }, 15);
};


document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const closeBtn = document.getElementById('closeSidebar');

    const overlay = document.getElementById('overlay');


    toggleBtn?.addEventListener('click', () => {
        sidebar?.classList.add("show");
        overlay?.classList.add("show");
    });

    closeBtn?.addEventListener('click', () => {
        sidebar?.classList.remove("show");
        overlay?.classList.remove("show");
    })

    overlay?.addEventListener('click', () =>{
        sidebar?.classList.remove("show");
        overlay?.classList.remove("show");
    })

    })

    const more = document.getElementById('more');
    const moreAcc = document.getElementById('more-action');

    more?.addEventListener('click', () => {
        moreAcc?.classList.add("show");
    })

    document.addEventListener('click', function(event){
        if(!more?.contains(event.target)) {
            moreAcc?.classList.remove("show");
        }});


    const pilih = document.getElementById('opsiKK');
    const memilih = document.getElementById('pilih');
    const buat = document.getElementById('buat');

    pilih.addEventListener('change', () => {
        if (pilih.value == 'ada'){
            memilih.style.display = 'block';
            buat.style.display = 'none'
        }else{
            memilih.style.display = 'none';
            buat.style.display = 'block';
        }
    })


    // REVISI PASSWORD
    function showPassword() {
        const input = document.getElementById('password');
        if (input.type === 'password'){
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }


    // LOADING
    function loading() {
        document.getElementById('loading').style.transform = 'scale(1)';
    }
