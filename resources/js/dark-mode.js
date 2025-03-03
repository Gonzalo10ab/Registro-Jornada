window.toggleDarkMode = function () {
    const html = document.documentElement;
    const darkModeIcon = document.getElementById('darkModeIcon');
    const button = document.querySelector('button[onclick="toggleDarkMode()"]'); // Buscar por onclick
    const currentTheme = localStorage.getItem('hs_theme');

    if (currentTheme === 'dark') {
        html.classList.remove('dark');
        localStorage.setItem('hs_theme', 'light');

        // 🌙 Cambiar al icono de la luna (Modo Claro)
        darkModeIcon.innerHTML = `
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
        </svg>
        `;
    } else {
        html.classList.add('dark');
        localStorage.setItem('hs_theme', 'dark');

        // ☀️ Cambiar al icono del sol (Modo Oscuro)
        darkModeIcon.innerHTML = `
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2"></path>
            <path d="M12 20v2"></path>
            <path d="m4.93 4.93 1.41 1.41"></path>
            <path d="m17.66 17.66 1.41 1.41"></path>
            <path d="M2 12h2"></path>
            <path d="M20 12h2"></path>
            <path d="m6.34 17.66-1.41 1.41"></path>
            <path d="m19.07 4.93-1.41 1.41"></path>
        </svg>
        `;
    }

    // ✅ 🔥 Forzar una actualización del hover para que se "reinicie"
    button.classList.remove("hover:bg-gray-200", "dark:hover:bg-gray-700");
    void button.offsetWidth; // Triggers reflow
    button.classList.add("hover:bg-gray-200", "dark:hover:bg-gray-700");
}

// ✅ Aplicar el tema guardado al cargar la página con los iconos correctos
document.addEventListener("DOMContentLoaded", function() {
    const darkModeIcon = document.getElementById('darkModeIcon');

    if (localStorage.getItem('hs_theme') === 'dark') {
        document.documentElement.classList.add('dark');

        // ☀️ Sol cuando el modo oscuro está activado
        darkModeIcon.innerHTML = `
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4"></circle>
                <path d="M12 2v2"></path>
                <path d="M12 20v2"></path>
                <path d="m4.93 4.93 1.41 1.41"></path>
                <path d="m17.66 17.66 1.41 1.41"></path>
                <path d="M2 12h2"></path>
                <path d="M20 12h2"></path>
                <path d="m6.34 17.66-1.41 1.41"></path>
                <path d="m19.07 4.93-1.41 1.41"></path>
            </svg>
        `;
    } else {
        document.documentElement.classList.remove('dark');

        // 🌙 Luna cuando el modo claro está activado
        darkModeIcon.innerHTML = `
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
            </svg>
        `;
    }
});
