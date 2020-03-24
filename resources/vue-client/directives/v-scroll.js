import Vue from 'vue';

const scrollToBottom = (element) => {

    if (typeof element.scroll === 'function') {
        element.scroll({
            top: element.scrollHeight,
            behavior: 'smooth',
            block: 'end'
        });
    } else {
        element.scrollTop = element.scrollHeight;
    }
};

export const vScroll = {
    bind: (element) => {
        (new MutationObserver(e => {
            scrollToBottom(element);
        })).observe(element, {childList: true, subtree: true});
    },
    inserted: (element) => {
        scrollToBottom(element);
    }
};

Vue.directive('scroll-bottom', vScroll);

export default vScroll;

