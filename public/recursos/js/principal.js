function applyTheme(isDark) {

    document.body.classList.toggle("dark-mode", isDark);

    localStorage.setItem("theme", isDark ? "dark" : "light");

    const btn = document.getElementById("theme-toggle");

    if (btn) {
        btn.textContent = isDark ? "☀️" : "🌙";
    }

    // 🔥 DEBUG (IMPORTANTE)
    console.log("Dark mode:", isDark);
}

document.addEventListener("DOMContentLoaded", () => {

    const savedTheme = localStorage.getItem("theme") === "dark";

    applyTheme(savedTheme);

    const btn = document.getElementById("theme-toggle");

    if (btn) {
        btn.addEventListener("click", () => {

            const isDark = document.body.classList.contains("dark-mode");

            applyTheme(!isDark);
        });
    }

    document.body.classList.add("loaded");
});