/**
 * Handel Search
 */

document.addEventListener("DOMContentLoaded", () => {
    const searchType = document.getElementById("searchType");
    const searchInput = document.getElementById("searchInput");
    const tableContainer = document.getElementById("tableContainer");

    if (!searchType || !searchInput || !tableContainer) {
        return; // Elements don't exist on this page
    }

    if (searchType && searchType.value === "date") {
        searchInput.type = "date";
    }

    // 1) Debounce helper
    function debounce(fn, delay = 300) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    // 2) AJAX fetch & render
    async function fetchAndRender(url) {
        console.log("Fetching:", url);
        const res = await fetch(url, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });
        const html = await res.text();
        tableContainer.innerHTML = html;
        attachPaginationHandlers();
    }

    // 3) On search change
    function onSearchChange() {
        const type = searchType.value;
        const term = encodeURIComponent(searchInput.value.trim());
        const url = `/registry?type=${type}&term=${term}`;
        fetchAndRender(url);
    }

    // 4) Wire up search inputs
    if (searchType && searchInput) {
        const debouncedSearch = debounce(onSearchChange, 300);
        searchType.addEventListener("change", debouncedSearch);
        searchInput.addEventListener("input", debouncedSearch);
    }

    // 5) Handle pagination clicks
    function attachPaginationHandlers() {
        const paginationLinks = tableContainer.querySelectorAll(".pagination a");
        if (paginationLinks.length === 0) {
            return; // No pagination
        }
        
        paginationLinks.forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                fetchAndRender(link.href);
            });
        });
    }
    attachPaginationHandlers();
});
