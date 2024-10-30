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
function downloadCSV() {
    let csvContent = "Date,Transaction Type,Amount,Balance After\n";
    const rows = document.querySelectorAll("table tbody tr");

    rows.forEach(row => {
        const columns = row.querySelectorAll("td");
        const rowData = Array.from(columns).map(col => {
            const text = col.textContent.trim();
            // Parse the amount if it contains commas or is formatted with currency symbols
            if (col.cellIndex === 2 || col.cellIndex === 3) { // Assuming amount and balance are in specific columns
                const amount = parseFloat(text.replace(/,/g, '')); // Remove commas and parse as float
                return amount.toFixed(2); // Format to two decimal places
            }
            return text;
        });
        csvContent += rowData.join(",") + "\n";
    });

    // Create a downloadable link
    const blob = new Blob([csvContent], { type: "text/csv" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "Transaction_History.csv";
    a.style.display = "none";

    document.body.appendChild(a);
    a.click();

    // Clean up
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}