let index = 0;
let timer = null;
let stopped = false;

const player = document.getElementById('player');
const btnStop = document.getElementById('btnStop');

function playNext() {
    if (stopped || !window.PLAYLIST.length) return;

    clearTimeout(timer);
    player.innerHTML = '';

    const item = window.PLAYLIST[index];
    const file = `/storage/${item.file}`;
    const ext = file.split('.').pop().toLowerCase();

    if (['mp4', 'mov', 'avi', 'mkv', 'webm'].includes(ext)) {
        const video = document.createElement('video');
        video.src = file;
        video.autoplay = true;
        video.muted = true;
        video.onended = next;
        player.appendChild(video);
    } else {
        const img = document.createElement('img');
        img.src = file;
        player.appendChild(img);

        timer = setTimeout(next, (item.duration || 5) * 1000);
    }
}

function next() {
    index++;
    if (index >= window.PLAYLIST.length) index = 0;
    playNext();
}

// STOP BUTTON
btnStop.addEventListener('click', () => {
    stopped = true;
    clearTimeout(timer);
    player.innerHTML = '';
    window.close(); // opsional
});

document.addEventListener('DOMContentLoaded', playNext);

document.addEventListener('click', () => {
    if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
    }
}, { once: true });

