document.addEventListener('DOMContentLoaded', function () {
    const BankingLinks = document.querySelectorAll(".banking-options-link")
    const aboutLinks = document.querySelectorAll(".about-link");
  const newsLinks = document.querySelectorAll(".news-link");
  const contactUsLinks = document.querySelectorAll(".contact-us-link");
  
  BankingLinks.forEach(link => {
    link.addEventListener("click", function(event) {
        // Prevent the default link behavior
        event.preventDefault();

        // Get the element with the class of "about"
        const BankingOptionsSection = document.querySelector(".options");

        // Scroll to the about section
        BankingOptionsSection.scrollIntoView({
            behavior: "smooth"
        });
    });
});

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
