

import { readdirSync } from 'fs';

import resolve from 'rollup-plugin-node-resolve';
import commonjs from 'rollup-plugin-commonjs' 
import VuePlugin from 'rollup-plugin-vue';
import replace from 'rollup-plugin-replace';
import postcss from 'rollup-plugin-postcss';

const mode = 'development';
const src = './src/frontend';

export default {
    input: readdirSync(src + '/pages')
            .filter((filename) => /\.vue$/.test(filename))
            .map((filename) => src + '/pages/' + filename)
            .concat([src + '/app.js']),
    output: {
        dir: 'public/assets',
        format: 'esm',
    },
    plugins: [
        replace({
            'process.env.NODE_ENV': JSON.stringify(mode),
        }),
        resolve(),
        commonjs(),
        VuePlugin(),
        postcss(),
    ],
};