import './bootstrap';

const content = document.querySelector('#');
function loadMoreContent(entry) {
    if (entry.target === content) import('./content.js')
}

var observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            loadMoreContent(entry);
        }
    });
},
    {
        root: null,
        rootMargin: '0px',
        thresold: 0.1,
    }
);

observer.observe(content);