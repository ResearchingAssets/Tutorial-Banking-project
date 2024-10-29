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
function ChangeToTransactions(){
    alert("You will be redirected soon.");
    setTimeout(function(){
        window.location.href = 'Transactions.php';
    }, 2500);}

    function ChangeToTransactionHistory(){
        alert("You will be redirected soon.");
        setTimeout(function(){
            window.location.href = 'TransactionHistory.php';
        }, 2500);}

        function ChangeToTransactionHistoryDownload(){
            alert("You will be redirected soon.");
            setTimeout(function(){
                window.location.href = 'TransactionDownload.php';
            }, 2500); }

            function QuickTransfer(){
                alert("You will be redirected soon.");
                setTimeout(function(){
                    window.location.href = 'QuickTransfer.php';
                }, 2500); 
}
  
