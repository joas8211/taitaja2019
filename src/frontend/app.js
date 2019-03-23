import Vue from 'vue';

new Vue({
    el: '#app',
    components: {
        Page: () => import('./' + window._page_ + '.js'),
    },
    render(createElement) {
        return createElement('Page');
    },
});