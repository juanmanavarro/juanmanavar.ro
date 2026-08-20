/*
  App Logic
  Renders content from portfolioData (data.js)
*/

document.addEventListener('DOMContentLoaded', () => {
  renderProjects();
  renderJobs();
  renderSocials();
});

function renderProjects() {
  const container = document.getElementById('projects-grid');
  if (!container) return;

  container.innerHTML = portfolioData.projects.map(project => `
    <a
      href="${project.link}"
      class="project-card"
      style="background-color: ${project.color};"
      target="_blank"
      rel="noopener noreferrer"
      title="${project.title} - ${project.description}"
      aria-label="Abrir proyecto ${project.title}: ${project.description}"
    >
      <div style="color: white; font-weight: bold; font-size: 2rem;">${project.title.split(' ')[0]}</div>
      <div class="project-content">
        <h3>${project.title}</h3>
        <p class="text-sm">${project.description}</p>
      </div>
    </a>
    `).join('');

  // Adjust font sizes after rendering
  adjustProjectTitleSizes();

  // Re-adjust on window resize
  window.addEventListener('resize', adjustProjectTitleSizes);
}

function adjustProjectTitleSizes() {
  const cards = document.querySelectorAll('.project-card');

  cards.forEach(card => {
    // The title is the first div child of the card
    const titleEl = card.querySelector('div:first-child');
    if (!titleEl) return;

    // Reset font size to base to measure correctly
    titleEl.style.fontSize = '2rem';

    const containerWidth = card.clientWidth;
    const minPadding = 40; // 20px left + 20px right
    const maxContentWidth = containerWidth - minPadding;

    // Check if text overflows
    if (titleEl.scrollWidth > maxContentWidth) {
      let currentSize = 2; // rem
      const minSize = 1; // Minimum font size in rem
      const step = 0.1;

      while (titleEl.scrollWidth > maxContentWidth && currentSize > minSize) {
        currentSize -= step;
        titleEl.style.fontSize = `${currentSize}rem`;
      }
    }
  });
}

function renderSocials() {
  const container = document.getElementById('socials-list');
  if (!container) return;

  container.innerHTML = portfolioData.socials.map(social => `
    <li>
      <a
        href="${social.link}"
        target="_blank"
        rel="noopener noreferrer me"
        title="${social.name} de Juanma Navarro"
      >${social.name}</a>
    </li>
  `).join('');
}

function renderJobs() {
  const container = document.getElementById('jobs-grid');
  if (!container || !portfolioData.jobs) return;

  container.innerHTML = portfolioData.jobs.map(job => `
    <a
      href="${job.link}"
      class="project-card job-card"
      style="background-color: ${job.color || '#111827'};"
      target="_blank"
      rel="noopener noreferrer"
      title="${job.title} - ${job.description}"
      aria-label="Abrir trabajo ${job.title}: ${job.description}"
    >
      <div style="color: white; font-weight: bold; font-size: 2rem;">${job.title.split(' ')[0]}</div>
      <div class="project-content">
        <h3>${job.title}</h3>
        <p class="text-sm">${job.description}</p>
      </div>
    </a>
  `).join('');

  adjustProjectTitleSizes();
}
