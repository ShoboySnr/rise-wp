class AdvisorsBlog extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.innerHTML = `
      <article>
        <img />
        
      </article>
`;
  }
}
window.customElements.define('advisors-blog', AdvisorsBlog);
