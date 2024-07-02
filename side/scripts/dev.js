async function PngToJpg() {

    //showing that request is being proceded
    document.getElementById("process").classList.remove("hidden");

    //taking data
    let fileInput = document.getElementById("file");

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
    let image = data["image_url"];
    let share_url = data["share_url"];
    let id = data["id"];

    //changing image
    document.getElementById("retrieved").classList.remove("hidden");
    document.getElementById("image").src = image;

    //changing download id
    document.getElementById("download_id").value = id;

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