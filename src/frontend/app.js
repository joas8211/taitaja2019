import Vue from 'vue';
import VueHead from 'vue-head';

Vue.use(VueHead);

new Vue({
    el: '#app',
    components: {
        Page: () => import('./' + window._page_ + '.js'),
    },
    render(createElement) {
        return createElement('Page', {
            props: window._vars_,
        });
    },
});