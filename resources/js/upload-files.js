/**
 *  Handle Upload and delete a file
 */

// Only run if elements exist on this page
const drobzon = document.getElementById("fileClickzone");
const hiddenInput = document.querySelector('input[type="file"]');
const filesList = document.getElementById("filesList");

if (drobzon && hiddenInput) {
    // make the hidden input clickable :
    drobzon.addEventListener("click", () => {
        hiddenInput.click();
    });

    // get the names of files that the user will choose and then display them
    hiddenInput.addEventListener("change", () => {
        const files = hiddenInput.files; // this is read-only

        for (let i = 0; i < files.length; i++) {
            const filename = files[i].name;

            // Create a wrapper <div>
            const container = document.createElement("div");
            container.style.display = "flex";
            container.style.justifyContent = "space-between";
            container.style.marginBottom = "6px";

            // Create the file name element
            const fileDiv = document.createElement("div");
            fileDiv.textContent = filename;
            fileDiv.style.flex = "1";
            fileDiv.style.padding = "4px";
            fileDiv.style.background = "#f3f4f6";
            fileDiv.style.borderRadius = "4px";
            fileDiv.style.padding = "0px 10px";

            // Create the delete button
            const deleteButton = document.createElement("button");
            deleteButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path><path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                </svg>
            `;
            deleteButton.style.margin = "4px 4px";
            deleteButton.style.background = "#ef4444";
            deleteButton.style.color = "white";
            deleteButton.style.border = "none";
            deleteButton.style.padding = "2px 2px";
            deleteButton.style.borderRadius = "4px";
            deleteButton.style.cursor = "pointer";

            // When clicked, only remove THIS container
            deleteButton.addEventListener("click", () => {
                removeFileAtIndex(i);
                container.remove();
            });

            // Assemble and append
            container.appendChild(fileDiv);
            container.appendChild(deleteButton);
            filesList.appendChild(container);
        }
    });
}

// remove the file with the index
function removeFileAtIndex(index) {
    const dt = new DataTransfer();
    const files = Array.from(hiddenInput.files);

    files.splice(index, 1); // remove the one at `index`
    files.forEach((file) => dt.items.add(file));

    hiddenInput.files = dt.files; // now the input only contains the remaining files
}
