document.getElementById("home").addEventListener("click", () => {
    window.location.assign("/");
});

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
    document.getElementById("file").value = "";

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
    let res = await fetch("../php/voices.php");
    let data = await res.json();

    data.map(language => {
        document.getElementById("voice").innerHTML +=
            `<option value="${language.voice_id}">${language.voice_name} - ${language.voice_gender} - ${language.voice_accent}</option>`;
    })
}

function loadData(data) {
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

    //taking cresidentials
    let audio = data["url"];
    let share_url = data["share_url"];
    let id = data["id"];

    //changing image
    document.getElementById("retrieved").classList.remove("hidden");
    document.getElementById("file").src = audio;
    document.getElementById("file").load();

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