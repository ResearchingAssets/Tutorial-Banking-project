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

  const aboutLink = document.querySelectorAll(".about-link");
  const newsLink = document.querySelectorAll(".news-link")
  const ContactUsLink = document.querySelectorAll(".contact-us-link")
  const SignUpLink = document.querySelectorAll(".sign-up-link")

  SignUpLink.forEach(link => {
    link.addEventListener("click", function(event) {
      // Prevent the default link behavior
      event.preventDefault();
  
      // Get the element with the class of "about"
      const SignUpSection = document.querySelector(".sign-up-container");
  
      // Scroll to the socials section
      SignUpSection.scrollIntoView({
        behavior: "smooth"
      });
    });
  });

  aboutLink.forEach(link => {
    link.addEventListener("click", function(event) {
      // Prevent the default link behavior
      event.preventDefault();
  
      // Get the element with the class of "about"
      const aboutSection = document.querySelector(".about");
  
      // Scroll to the socials section
      aboutSection.scrollIntoView({
        behavior: "smooth"
      });
    });
  });

  newsLink.forEach(link => {
    link.addEventListener("click", function(event) {
      // Prevent the default link behavior
      event.preventDefault();
  
      // Get the element with the class of "about"
      const newsSection = document.querySelector(".news");
  
      // Scroll to the socials section
      newsSection.scrollIntoView({
        behavior: "smooth"
      });
    });
  });

  ContactUsLink.forEach(link => {
    link.addEventListener("click", function(event) {
      // Prevent the default link behavior
      event.preventDefault();
  
      // Get the element with the class of "about"
      const ContactSection = document.querySelector(".contact-us");
  
      // Scroll to the socials section
      ContactSection.scrollIntoView({
        behavior: "smooth"
      });
    });
  });


  const FirstElement = document.querySelector('.login-container');
  const SecondElement = document.querySelector('.sign-up-container');
  
  window.addEventListener('scroll', () => {
      const scrollPosition = window.scrollY;

      if (scrollPosition > 475) {
        FirstElement.style.opacity = '0';
      } else {
        FirstElement.style.opacity = '1';
      }
  
      if (scrollPosition < 450 | scrollPosition > 1000) {
        SecondElement.style.opacity = '0';
      } else {
        SecondElement.style.opacity = '1';
      }
    });
    
