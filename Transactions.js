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

  function validateAmount() {
    const amountInput = document.querySelector('input[name="AmountOfMoney"]');
    const amount = parseFloat(amountInput.value);

    if (amount <= 0) {
        alert("Please enter a positive amount for the transaction.");
        return false; // Prevents form submission
    }
    return true; // Allows form submission if amount is valid
} 
  document.addEventListener('DOMContentLoaded', function () {
    
    const aboutLinks = document.querySelectorAll(".about-link");
    const newsLinks = document.querySelectorAll(".news-link");
    const contactUsLinks = document.querySelectorAll(".contact-us-link");
  
  aboutLinks.forEach(link => {
      link.addEventListener("click", function(event) {
          // Prevent the default link behavior
          event.preventDefault();
  
          // Get the element with the class of "about"
          const aboutSection = document.querySelector(".about");
  
          // Scroll to the about section
          aboutSection.scrollIntoView({
              behavior: "smooth"
          });
      });
  });
  
  newsLinks.forEach(link => {
      link.addEventListener("click", function(event) {
          // Prevent the default link behavior
          event.preventDefault();
  
          // Get the element with the class of "news"
          const newsSection = document.querySelector(".news");
  
          // Scroll to the news section
          newsSection.scrollIntoView({
              behavior: "smooth"
          });
      });
  });
  
  contactUsLinks.forEach(link => {
      link.addEventListener("click", function(event) {
          // Prevent the default link behavior
          event.preventDefault();
  
          // Get the element with the class of "contact-us"
          const contactSection = document.querySelector(".contact-us");
  
          // Scroll to the contact us section
          contactSection.scrollIntoView({
              behavior: "smooth"
          });
      });
  });
});