document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('theme-toggle');
    let themeLink = document.getElementById('theme-style');
    
    if (!themeLink) {
        themeLink = document.createElement('link');
        themeLink.rel = 'stylesheet';
        themeLink.id = 'theme-style';
        document.head.appendChild(themeLink);
    }

    const currentTheme = getCookie('theme');
    if (currentTheme === 'dark') {
        themeLink.href = 'dark.css';
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            if (themeLink.href.includes('dark.css')) {
                themeLink.href = '';
                document.cookie = "theme=light; path=/; max-age=31536000";
            } else {
                themeLink.href = 'dark.css';
                document.cookie = "theme=dark; path=/; max-age=31536000";
            }
        });
    }

    function getCookie(name) {
        let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null;
    }
});