//fetch tools name and their image
async function fetchTools() {
    const endpoint = "../php/side/tools.php";
    let res = await fetch(endpoint);
    let tools = await res.json();
    tools.map(tool => {
        const name = tool.name;
        const url = tool.url;
        const img = tool.image;
        document.getElementById("tools-container").innerHTML +=
        `<a href="${url}" class="m-4 w-28 p-4 flex flex-col items-center justify-center space-y-4 border border-gray-800">
            <img src="${img}" class="w-full">
            <p class="text-center font-semibold text-lg">${name}</p>
        </a>`;
    })
}

document.addEventListener("load", fetchTools());