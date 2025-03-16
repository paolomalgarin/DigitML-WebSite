// ------------------------------------------------------- VARIABILI -------------------------------------------------------
const canvas = document.getElementById("drawing-board");
const canvasContainer = document.getElementById('canvas-container');
const toolbar = document.getElementById('toolbar');
const ctx = canvas.getContext("2d");

const canvasOffsetX = canvas.offsetLeft;
const canvasOffsetY = canvas.offsetTop;

canvas.width = canvasContainer.clientWidth;
canvas.height = canvasContainer.clientHeight;

let isPainting = false;
let lineWidth = canvas.width / 30 * 2;
let startX;
let startY;

// ------------------------------------------------------- METODI -------------------------------------------------------
function setup() {
    ctx.lineCap = 'round';
    ctx.lineWidth = lineWidth;
    ctx.strokeStyle = '#010101';

    fill_canvas('#fefefe');
}

function sendForm() {
    const cvImage = document.getElementById('canvas-image');
    let image = canvas.toDataURL("image/png");
    cvImage.value = image;
    return true;
}

function fill_canvas(color) {
    ctx.fillStyle = color;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function clear_canvas() {
    // ctx.clearRect(0, 0, canvas.width, canvas.height);
    fill_canvas('#fefefe');
    return true;
}

function change_stroke_color(t) {
    ctx.strokeStyle = t.value;
}

function change_line_width(width) {
    let w = 1;
    document.getElementById('sizes-checkbox').checked = false;
    switch (width) {
        case 's': w = canvas.width / 30 * 1; break;
        case 'm': w = canvas.width / 30 * 2; break;
        case 'l': w = canvas.width / 30 * 4; break;
        default: w = 20; break;
    }
    ctx.lineWidth = w;
}

// Modifica della funzione draw per supportare eventi mouse e touch
function draw(e) {
    e.preventDefault();
    e.stopPropagation();
    if (!isPainting) return;
    
    let clientX, clientY;
    // Se l'evento è un touch, prendi le coordinate del primo tocco
    if (e.touches) {
        clientX = e.touches[0].clientX;
        clientY = e.touches[0].clientY;
    } else {
        clientX = e.clientX;
        clientY = e.clientY;
    }

    ctx.lineTo(clientX - canvasOffsetX, clientY - canvasOffsetY);
    ctx.stroke();

    ctx.beginPath(); // Avvia un nuovo percorso per evitare collegamenti indesiderati
    ctx.moveTo(clientX - canvasOffsetX, clientY - canvasOffsetY);
}

// ------------------------------------------------------- EVENTI -------------------------------------------------------

// Eventi per mouse
canvas.addEventListener('mousedown', (e) => {
    isPainting = true;
    startX = e.clientX - canvasOffsetX;
    startY = e.clientY - canvasOffsetY;
    ctx.beginPath();
    ctx.moveTo(e.clientX - canvasOffsetX, e.clientY - canvasOffsetY);
    draw(e); // Disegna il puntino iniziale
});

document.addEventListener('mouseup', (e) => {
    isPainting = false;
    ctx.stroke();
    ctx.beginPath(); // Resetta il percorso per evitare linee collegate
});

canvas.addEventListener('mousemove', draw);

// Eventi per touch
canvas.addEventListener('touchstart', (e) => {
    isPainting = true;
    let clientX = e.touches[0].clientX;
    let clientY = e.touches[0].clientY;
    startX = clientX - canvasOffsetX;
    startY = clientY - canvasOffsetY;
    ctx.beginPath();
    ctx.moveTo(clientX - canvasOffsetX, clientY - canvasOffsetY);
    draw(e);
});

canvas.addEventListener('touchmove', draw);

canvas.addEventListener('touchend', (e) => {
    isPainting = false;
    ctx.stroke();
    ctx.beginPath();
});

// ------------------------------------------------------- CODICE -------------------------------------------------------
setup();
