document.getElementById("home").addEventListener("click", () => {
    window.location.assign("/");
});

async function loadData(data) {
    console.log(data);

    //check if error
    if (data["error"] != undefined) {
        document.getElementById("process").classList.add("hidden");
        document.getElementById("error").classList.remove("hidden");
        document.getElementById("error").innerHTML = data["error"];
        return;
    }

    //hiding process and form
    document.getElementById("process").classList.add("hidden");
    document.getElementById("form").classList.add("hidden");

    //removing retrieved
    document.getElementById("retrieved").classList.remove("hidden");

    //taking cresidentials
    let id = data["id"];

    //if result is text
    if (data["text"] != undefined) {
        document.getElementById("text").value = data["text"];
        return;
    }

    let url = data["url"];
    let share_url = data["share_url"];

    document.getElementById("file").src = url;

    //loading if audio file
    if (id.includes("audio")) {
        document.getElementById("file").load();
    }

    //changing download id
    document.getElementById("download_id").value = id;

    //sending share url to share
    share(share_url);
}

function share(share_url) {
    //share on social media
    const link = encodeURI(share_url);
    const msg = encodeURIComponent('Hey, Check out this Image');

    document.getElementById('facebook').href =
        `https://www.facebook.com/share.php?u=${link}`;

    document.getElementById('whatsapp').href =
        `https://api.whatsapp.com/send?text=${msg}: ${link}`;

    document.getElementById('twitter').href =
        `https://x.com/intent/post?url=${link}&text=${msg}&hashtags=ai,image`;

    //copying link
    document.getElementById("clipboard").addEventListener("click", () => {
        navigator.clipboard.writeText(share_url);
    })
}

function copy(word) {
    //copying word
    navigator.clipboard.writeText(word);
}

async function PngToJpg() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/pngtojpg.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function PngToWebp() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/pngtowebp.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function WebpToPng() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/webptopng.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function JpgToPng() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/jpgtopng.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function WebpToJpg() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/webptojpg.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function JpgToWebp() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/jpgtowebp.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function TextToAudio() {
    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let prompt = document.getElementById("prompt").value;
    let voice = document.getElementById("voice").value;

    //clearing prompt
    document.getElementById("prompt").value = "";

    //declaring endpoint
    let url = "../php/texttoaudio.php";

    let res = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            "prompt": prompt,
            "voice": voice
        })
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function getVoice() {
    let res = await fetch("../php/side/voices.php");
    let data = await res.json();

    data.map(language => {
        document.getElementById("voice").innerHTML +=
            `<option value="${language.voice_id}">${language.voice_name} - ${language.voice_gender} - ${language.voice_accent}</option>`;
    })
}

async function TextToImage() {
    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking prompt and aspect ratio
    let prompt = document.getElementById("prompt").value;
    let aspectRatio = document.getElementById("aspect_ratio").value;

    //clearing prompt
    document.getElementById("prompt").value = "";

    //declaring endpoint
    let url = "../php/texttoimage.php";

    let res = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            "prompt": prompt,
            "aspect_ratio": aspectRatio
        })
    });

    let data = await res.json();

    loadData(data);
}

async function ImageToText() {
    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/imagetotext.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function TextToMD5() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let text = document.getElementById("input-text").value;

    //clearing prompt
    document.getElementById("input-text").value = "";

    //declaring endpoint
    let url = "../php/texttomd5.php";

    let res = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            "text": text
        })
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function RemoveBackground() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("input-file");

    // Check if any files are selected
    if (fileInput.files.length === 0) {
        console.log("No file selected");
        return;
    }

    let file = fileInput.files[0];

    // Create a FormData object to hold the file
    let formData = new FormData();
    formData.append("image", file);

    //clearing image
    document.getElementById("input-file").value = "";

    //declaring endpoint
    let url = "../php/removebackground.php";

    let res = await fetch(url, {
        method: "POST",
        body: formData
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function CaseConvert(type) {

    //taking data from text
    let text = document.getElementById("text").value;

    //making min length
    if (text.length < 3) {
        document.getElementById("error").classList.remove("hidden");
        document.getElementById("error").innerHTML = "Input too small. Must be 3 letter";
        return;
    }

    //declaring endpoint
    let url = "../php/caseconvertor.php";

    let res = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            "text": text,
            "type": type
        })
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function WordCounter() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let text = document.getElementById("input-text").value;

    //clearing prompt
    document.getElementById("input-text").value = "";

    //declaring endpoint
    let url = "../php/wordcounter.php";

    let res = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            "text": text
        })
    });

    let data = await res.json();

    //sending data to load Function
    loadData(data);
}

async function ColorCodeConvertor(type) {
    let color = [];
    //convert for type
    let convert = "";

    if (type.includes("rgb")) {
        //getting data
        const red = document.getElementById("red");
        const green = document.getElementById("green");
        const blue = document.getElementById("blue");
        const alpha = document.getElementById("alpha");

        //setting value
        color = [red.value, green.value, blue.value, alpha.value];
        convert = "hex";

        //clearing prompt
        red.value = "";
        green.value = "";
        blue.value = "";
        alpha.value = "";

    } else if (type.includes("hex")) {
        const hex = document.getElementById("hex");

        //setting value
        color = [(hex.value).replace("#", "").replace(" ", "")];
        convert = "rgba"

        //clearing
        hex.value = "";
    }

    //declaring endpoint
    let url = "../php/colorcodeconvertor.php";

    //declaring para
    let params = new URLSearchParams();

    //assinging value to para
    color.forEach((val, index) => {
        params.append(`color[${index}]`, val);
    });
    params.append('convert', convert);

    let res = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: params
    });

    let data = await res.json();
    
    //sending data to load Function
    loadData(data);
}