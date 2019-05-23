<template>
    <Layout :user="user">
        <main>
            <h1>Robotin tiedot</h1>
            <input type="date" v-model="fromDate"> - <input type="date" v-model="toDate">
            <div class="chart-container">
                <h2>Päivittäinen käyttöaika tunneissa</h2>
                <chartist
                    class="chart operating-time"
                    type="Line"
                    :data="operatingTime"
                    :options="operatingTimeChartOptions">
                </chartist>
            </div>
            <div class="chart-container">
                <h2>Toimintojen kokonaiskäyttöajat [min]</h2>
                <chartist
                    class="chart function-usage"
                    type="Bar"
                    :data="functionUsage"
                    :options="functionUsageChartOptions">
                </chartist>
            </div>
            <div class="chart-container">
                <h2>Akun lataustiedot</h2>
                <chartist
                    class="chart battery-charge"
                    type="Bar"
                    :data="batteryCharge"
                    :options="batteryChartOptions">
                </chartist>
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

    .chart-container {
        margin: auto;
        max-width: 500px;
        text-align: center;
    }

    .chart {
        height: 300px;
    }

    .operating-time.chart .ct-label {
        transform: rotate(20deg);
    }
</style>

<script>
    import Vue from 'vue';
    import Layout from '../components/layout.vue';
    import chartist from 'vue-chartist';
    import 'chartist/dist/chartist.css';

    Vue.use(chartist, {
        messageNoData: 'Tietoja ei saatavilla valitulle aikavälille.',
    });

    export default {
        components: { Layout },
        props: ['user', 'fullOperatingTime', 'fullFunctionUsage', 'fullBatteryCharge'],
        head: {
            title: {
                inner: 'Robotin tiedot',
                separator: '-',
                complement: 'RoboBisnes-hanke',
            },
        },
        data: () => ({
            operatingTimeChartOptions: {
                lineSmooth: false,
            },
            functionUsageChartOptions: {},
            batteryChartOptions: {
                axisY: {
                    labelInterpolationFnc: (value) => value + '%',
                },
            },
            fromDate: null,
            toDate: null,
        }),
        computed: {
            operatingTime() {
                let labels = [];
                let values = [];

                // Order the data
                var fullOperatingTime = this.fullOperatingTime.sort(
                    (a, b) => new Date(a.date).getTime() - new Date(b.date).getTime(),
                );

                for (let item of fullOperatingTime) {
                    if (item.name != 'pepper-robot') continue;

                    let date = new Date(item.date);
                    if (date.getTime() < new Date(this.fromDate).getTime()) continue;
                    if (date.getTime() > new Date(this.toDate).getTime()) continue;

                    labels.push(`${date.getDate()}.${date.getMonth() + 1}.${date.getFullYear()}`);
                    values.push((item.Minute || item.minute) / 60);
                }

                return {
                    labels,
                    series: [values],
                };
            },
            functionUsage() {
                let labels = [];
                let values = [];

                let sums = {};
                for (let item of this.fullFunctionUsage) {
                    let date = new Date(item.paivays);
                    if (date.getTime() < new Date(this.fromDate).getTime()) continue;
                    if (date.getTime() > new Date(this.toDate).getTime()) continue;

                    if (!sums[item.nimi]) sums[item.nimi] = 0;
                    sums[item.nimi] += parseInt(item.aika);
                }

                for (let nimi of Object.keys(sums)) {
                    labels.push(nimi);
                    values.push(sums[nimi]);
                }

                return {
                    labels,
                    series: [values],
                };
            },
            batteryCharge() {
                let labels = [];
                let values = [];

                let fullBatteryCharge = this.fullBatteryCharge.sort(
                    (a, b) => new Date(a.datetime).getTime() - new Date(b.datetime).getTime(),
                );

                for (let item of fullBatteryCharge) {
                    let date = new Date(item.datetime);
                    labels.push(`${date.getDate()}.${date.getMonth() + 1}.${date.getFullYear()}`);
                    values.push(item.battery_charge);
                }

                return {
                    labels,
                    series: [values],
                };
            },
        },
    };
</script>