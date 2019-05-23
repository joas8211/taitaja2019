<template>
    <div>
        <Header :user="user"></Header>
        <slot></slot>
        <Footer></Footer>
    </div>
</template>

<style>
    @font-face {
        font-family: "MoonHouse";
        src: url(/assets/moonhouse.ttf) format("truetype")
    }

    body {
        margin: 0;
        background-color: #f0f0f0;
    }

    h1, h2, h3, h4 {
        font-family: "MoonHouse";
    }

    h1 {
        text-align: center;
    }
</style>

<script>
    import Header from './header.vue';
    import Footer from './footer.vue';

    export default {
        props: ['user'],
        components: { Header, Footer },
    };
</script>