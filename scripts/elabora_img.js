const numero = document.getElementById('resoult');
const img = document.getElementById('canvas-image');
const boxes = document.querySelectorAll('.box');
const suspance = document.querySelector('.suspance');


function invertImage(image, imgHeight, imgWidth, ip, callback, isNumber) {
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");

    canvas.width = imgHeight;
    canvas.height = imgWidth;
    // console.log(imgHeight);
    // console.log(imgWidth);

    ctx.drawImage(image, 0, 0);

    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imageData.data;

    //scorro l'array di pixel (imageData.data) -> [r, g, b, a,  r, g, b, a,  r, g, b, a,  ...]
    // incremento di 4 perche non modifico la trasparenza
    for (let i = 0; i < data.length; i += 4) {
        data[i] = 255 - data[i]; // Rosso
        data[i + 1] = 255 - data[i + 1]; // Verde
        data[i + 2] = 255 - data[i + 2]; // Blu
    }

    ctx.putImageData(imageData, 0, 0);

    // Converti il canvas in base64 e chiama il callback
    callback(canvas.toDataURL(), ip, isNumber);
}



function sendImage(invertedSrc, ip, isNumber) {
    // img.src = invertedSrc; // Aggiorna l'immagine sulla pagina

    //creo il body
    let bodyContent = JSON.stringify({
        image: invertedSrc, // Invia l'immagine invertita
        endpoint: (isNumber ? 'number' : 'letter'),
    });
    console.log(bodyContent); //stampo cosa mando all'🐝🐝 

    // Ora manda l'immagine invertita al server
    fetch(`http://${ip}:8080/DigitML_API/`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: bodyContent,
    })
        .then(response => response.json())
        .then(r => {
            console.log(r); //stampo la risposta dell'🐝🐝

            if (r.prediction) {
                numero && (numero.innerText = r.prediction);
            } else {
                numero && (numero.innerHTML = `Errore ${r.status}:<br>${r.message}`);
            }
        })
        .catch(e => {
            console.error(e);
        });
}



// ------------------------------------------------------------------------- CODIFICIO -------------------------------------------------------------------------
