import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Lightbox modal store for screenshots
Alpine.store('lightbox', {
    isOpen: false,
    imageSrc: '',
    title: '',
    subtitle: '',
    open(src, title = '', subtitle = '') {
        this.imageSrc = src;
        this.title = title;
        this.subtitle = subtitle;
        this.isOpen = true;
        document.body.classList.add('overflow-hidden');
    },
    close() {
        this.isOpen = false;
        document.body.classList.remove('overflow-hidden');
    }
});

// Global copy-to-clipboard helper
window.copyToClipboard = async function (text, buttonElement) {
    try {
        await navigator.clipboard.writeText(text);
        if (buttonElement) {
            const originalText = buttonElement.dataset.originalText || buttonElement.innerHTML;
            buttonElement.dataset.originalText = originalText;
            buttonElement.innerHTML = `<svg class="w-4 h-4 inline-block text-emerald-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Copied!`;
            setTimeout(() => {
                buttonElement.innerHTML = originalText;
            }, 2000);
        }
        return true;
    } catch (err) {
        console.error('Failed to copy: ', err);
        return false;
    }
};

Alpine.start();
