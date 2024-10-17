const rootElement = document.documentElement;
const icon = document.getElementById('change-icon');
const element = document.querySelector('.header');

let currentMode = 'dark';

function modeChange() {
    if (currentMode === 'dark') {
      // Switch to light mode
      rootElement.style.setProperty('--fg-color', getComputedStyle(rootElement).getPropertyValue('--light-fg-color'));
      rootElement.style.setProperty('--bg-color', getComputedStyle(rootElement).getPropertyValue('--light-bg-color'));
      currentMode = 'light';
      icon.textContent = '🌙';
      } else {
      // Switch to dark mode
      rootElement.style.setProperty('--fg-color', getComputedStyle(rootElement).getPropertyValue('--dark-fg-color'));
      rootElement.style.setProperty('--bg-color', getComputedStyle(rootElement).getPropertyValue('--dark-bg-color'));
      currentMode = 'dark';
      icon.textContent = '💡';
    }
  }
