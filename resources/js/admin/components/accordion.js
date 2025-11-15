import Accordion from 'accordion-js';

const accordion = {
  init() {
    const accordions = [...document.querySelectorAll('.accordion')];
    const defaultOptions = {
      elementClass: 'accordion-item',
      triggerClass: 'accordion-header',
      panelClass: 'accordion-body',
      activeClass: 'active',
      duration: 300,
    };

    if (accordions.length) {
      accordions.forEach((accordion) => {
        // Store accordion items
        const accordionItems = [...accordion.querySelectorAll(`.${defaultOptions.elementClass}`)];
        // Store accordion option for each accordion
        const accordionOptions = { ...defaultOptions, openOnInit: [] };

        accordionItems.forEach((item, index) => {
          if (item.classList.contains('active')) {
            // Push default active .accordion-item index
            accordionOptions.openOnInit.push(index);
          }
        });

        new Accordion(accordion, accordionOptions);
      });
    }

    // Initialize nested accordions
    this.initNestedAccordions();
  },

  initNestedAccordions() {
    // Handle nested accordion functionality
    const nestedTriggers = document.querySelectorAll('.nested-accordion-trigger');

    nestedTriggers.forEach(trigger => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation(); // Prevent parent accordion from toggling

        const targetId = trigger.getAttribute('data-target');
        const target = document.getElementById(targetId);

        if (target) {
          const isOpen = target.classList.contains('open');

          // Close all sibling nested accordions at the same level
          const parent = target.parentElement;
          const siblings = parent.querySelectorAll('.nested-accordion-content.open');
          siblings.forEach(sibling => {
            if (sibling !== target) {
              sibling.classList.remove('open');
              const siblingTrigger = document.querySelector(`[data-target="${sibling.id}"]`);
              if (siblingTrigger) {
                siblingTrigger.classList.remove('active');
              }
            }
          });

          // Toggle current nested accordion
          if (isOpen) {
            target.classList.remove('open');
            trigger.classList.remove('active');
          } else {
            target.classList.add('open');
            trigger.classList.add('active');
          }

          // Rotate chevron icon
          const chevron = trigger.querySelector('.nested-chevron');
          if (chevron) {
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
          }
        }
      });
    });

    // Handle 3-level nested accordions (child categories)
    const childTriggers = document.querySelectorAll('.child-accordion-trigger');

    childTriggers.forEach(trigger => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const targetId = trigger.getAttribute('data-target');
        const target = document.getElementById(targetId);

        if (target) {
          const isOpen = target.classList.contains('open');

          // Close sibling child accordions
          const parent = target.parentElement;
          const siblings = parent.querySelectorAll('.child-accordion-content.open');
          siblings.forEach(sibling => {
            if (sibling !== target) {
              sibling.classList.remove('open');
              const siblingTrigger = document.querySelector(`[data-target="${sibling.id}"]`);
              if (siblingTrigger) {
                siblingTrigger.classList.remove('active');
              }
            }
          });

          // Toggle current child accordion
          if (isOpen) {
            target.classList.remove('open');
            trigger.classList.remove('active');
          } else {
            target.classList.add('open');
            trigger.classList.add('active');
          }

          // Rotate chevron icon
          const chevron = trigger.querySelector('.child-chevron');
          if (chevron) {
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
          }
        }
      });
    });
  },
};

export default accordion;
