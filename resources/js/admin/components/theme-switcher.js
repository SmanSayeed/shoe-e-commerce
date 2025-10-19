class ThemeSwitcher {
  constructor(target) {
    this.dropdown = null;
    this.dropdownBtns = null;

    if (typeof target === 'string') {
      this.dropdown = document.querySelector(target);
    }

    if (target instanceof HTMLElement) {
      this.dropdown = target;
    }

    if (!target) {
      throw new Error('No target element found');
    }

    if (this.dropdown) {
      this.dropdownBtns = this.dropdown.querySelectorAll('[data-theme-mode]');
    }

    // Apply theme on initialization
    this.applyTheme();

    // Listen for system theme changes
    if (window.matchMedia) {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        // Only apply system theme if no explicit theme is set
        if (!localStorage.getItem('theme')) {
          this.applyTheme();
        }
      });
    }

    if (this.dropdownBtns && this.dropdownBtns.length) {
      this.updateActiveClass();

      [...this.dropdownBtns].forEach((btn) => {
        btn.addEventListener('click', () => this.toggle(btn));
      });
    }
  }

  toggle(btn) {
    const themeMode = btn.dataset.themeMode;

    if (themeMode === 'light') {
      // Whenever the user explicitly chooses light mode
      localStorage.setItem('theme', 'light');
    }

    if (themeMode === 'dark') {
      // Whenever the user explicitly chooses dark mode
      localStorage.setItem('theme', 'dark');
    }

    if (themeMode === 'system') {
      // Whenever the user explicitly chooses to respect the OS preference
      localStorage.removeItem('theme');
    }

    // Apply the theme immediately
    this.applyTheme();
    this.updateActiveClass();
  }

  applyTheme() {
    const theme = localStorage.getItem('theme');
    const htmlElement = document.documentElement;

    // Remove existing theme classes
    htmlElement.classList.remove('light', 'dark');

    if (theme === 'dark') {
      htmlElement.classList.add('dark');
    } else if (theme === 'light') {
      htmlElement.classList.add('light');
    } else {
      // System preference - check if user prefers dark mode
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        htmlElement.classList.add('dark');
      } else {
        htmlElement.classList.add('light');
      }
    }
  }

  updateActiveClass() {
    [...this.dropdownBtns].forEach((btn) => {
      if (btn.classList.contains('active')) {
        btn.classList.remove('active');
      }

      if (!localStorage.theme && btn.dataset.themeMode === 'system') {
        btn.classList.add('active');
      }

      if (localStorage.theme === btn.dataset.themeMode) {
        btn.classList.add('active');
      }
    });
  }
}

const themeSwitcher = {
  init() {
    const dropdownThemeSwitcher = document.querySelector('#theme-switcher-dropdown');

    if (dropdownThemeSwitcher) {
      new ThemeSwitcher(dropdownThemeSwitcher);
    }
  },
};

export default themeSwitcher;
