// Set the start and end years
function populateYearDropdown(selectElement) {
    const startYear = 1940;
    const endYear = 2025;

    // Loop through the years and create option elements
    for (let year = startYear; year <= endYear; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        selectElement.appendChild(option);
    }
}

// Get all year dropdowns and populate them
document.addEventListener('DOMContentLoaded', function() {
    const yearDropdowns = document.querySelectorAll('.year-dropdown'); // Select all elements with class 'year-dropdown'
    
    yearDropdowns.forEach(function(dropdown) {
        populateYearDropdown(dropdown); // Populate each dropdown
    });
});