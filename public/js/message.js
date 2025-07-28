setTimeout(() => {
    const flash = document.getElementById('message');
    if(flash) {
        flash.style.opacity = '0';
        setTimeout(() => flash.remove(), 800)
    }
}, 3000);

setTimeout(() => {
    const iuran = document.getElementById('message-iuran');
    if(iuran) {
        iuran.style.opacity = '0';
        setTimeout(() => iuran.remove(), 800)
    }
}, 3000);
