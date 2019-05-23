<template>
    <Layout :user="user">
        <main>
            <h1>Pepper-robotti</h1>
            <a href="#video" @click="videoShown = true">Katso esittelyvideo</a>
            <img src="/assets/pepper-robot-esittelykuva.png" alt="Pepper robotin esittelykuva" usemap="#robot-map" ref="robot">
            <map name="robot-map">
                <area alt="Mikrofonit" href="#mikrofonit" coords="532,6,703,35" shape="rect" @mouseenter="showFeature('mikrofonit')" @mouseleave="showFeature()">
                <area alt="Kamerat" href="#kamerat" coords="17,148,204,170" shape="rect" @mouseenter="showFeature('kamerat')" @mouseleave="showFeature()">
                <area alt="Kaiuttimet" href="#kaiuttimet" coords="505,95,683,123" shape="rect" @mouseenter="showFeature('kaiuttimet')" @mouseleave="showFeature()">
                <area alt="Näyttö" href="#naytto" coords="63,307,283,328" shape="rect" @mouseenter="showFeature('naytto')" @mouseleave="showFeature()">
                <area alt="Käynnistys" href="#kaynnistys" coords="584,236,778,275" shape="rect" @mouseenter="showFeature('kaynnistys')" @mouseleave="showFeature()">
                <area alt="Lataus" href="#lataus" coords="44,557,240,581" shape="rect" @mouseenter="showFeature('lataus')" @mouseleave="showFeature()">
            </map>
            <div class="video-container" v-if="videoShown" @click="videoShown = false">
                <video autoplay controls>
                    <source src="/assets/pepper-robot-video.mp4" type="video/mp4">
                </video>
            </div>
        </main>
    </Layout>
</template>

<style>
    main {
        width: calc(100% - 30px);
        max-width: 1100px;
        background-color: #ffffff;
        margin: 20px auto;
        padding: 15px;
        text-align: center;
    }

    main img {
        display: block;
        margin: auto;
        max-width: calc(100% - 40px);
    }

    .video-container {
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.6);
    }

    video {
        display: block;
        width: 100%;
        max-width: 1100px;
        margin: auto;
    }
</style>

<script>
    import Layout from "../components/layout.vue";

    export default {
        data: () => ({
            videoShown: false,
        }),
        components: { Layout },
        props: ['user'],
        head: {
            title: {
                inner: 'Pepper-robotti',
                separator: '-',
                complement: 'RoboBisnes-hanke',
            },
        },
        methods: {
            showFeature(feature, n) {
                this.$refs.robot.src = `/assets/pepper-robot-esittelykuva${feature ? '-' + feature : ''}.png`;
            },
        },
    };
</script>