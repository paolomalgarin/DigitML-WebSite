function setSystemTheme() {
    const isDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    document.documentElement.setAttribute("data-theme", isDark ? "dark" : "light");
}

// Imposta il tema al caricamento della pagina
setSystemTheme();

// Aggiunge un listener per aggiornare il tema in caso di cambiamento
window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", setSystemTheme);
