setTimeout(() => {
    const flash = document.getElementById('message-success');
    if(flash) {
        flash.style.opacity = '0';
        setTimeout(() => flash.remove(), 500)
    }
}, 3000);
