const filterTitles = document.querySelectorAll('.filter-title');

window.onload = function () {
  filterTitles.forEach(filterTitle => {
    filterTitle.addEventListener('click', () => {
      const parent = filterTitle.parentNode;

      if (parent.classList.contains('active-filter')) {
        parent.classList.remove('active-filter');
        parent.style.height = '40px';
        filterTitle.querySelector('.fa-solid').style.transform = 'rotate(0deg)';
      } else {
        parent.classList.add('active-filter');
        parent.style.height = 'auto';
        filterTitle.querySelector('.fa-solid').style.transform = 'rotate(180deg)';
      }
    });
  });

}

const gridWrapper = document.querySelector('.grid-wrapper');
const childDivs = gridWrapper.querySelectorAll(':scope > div');

function removeClasses() {
  if (window.innerWidth < 748) {
    childDivs.forEach(div => {
      div.className = '';
    });
  }
}

// Call removeClasses initially
removeClasses();

// Call removeClasses on window resize
window.addEventListener('resize', removeClasses);




// Create the observer instance
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      // If the child div is in the viewport, add a class to trigger the fade-in transition
      entry.target.classList.add('fade-in', 'visible');
    }
  });
}, { threshold: 0.5 });

// Observe each child div
childDivs.forEach(div => {
  observer.observe(div);
});