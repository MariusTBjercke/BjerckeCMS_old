const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const TerserPlugin = require('terser-webpack-plugin');
const webpack = require('webpack');
const isProduction = process.argv[process.argv.indexOf('--mode') + 1] === 'production';

// Compress output files?
const compressFiles = true;

// Clean/remove all files on build?
const cleanFiles = false;

const jsConfig = {
    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.json'],
        alias: {
            '@assets': __dirname + '/assets/',
            '@tiles': __dirname + '/includes/classes/Tiles/',
            '@pages': __dirname + '/includes/classes/Pages/',
        },
        fallback: {
            "crypto": false
        },
    },
    entry: {
        bundle: '/assets/js/index.ts',
        creative: '/assets/js/creative-index.ts'
    },
    output: {
        filename: 'assets/js/[name].min.js',
        path: path.resolve(__dirname, 'html'),
        clean: cleanFiles
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.svg|png|jpg|jpeg|gif$/,
                type: 'asset/resource',
                generator: {
                    filename: 'assets/img/[name][ext]'
                }
            },
        ]
    },
    devtool: 'source-map',
    optimization: {
        minimize: isProduction ? true : compressFiles,
        minimizer: [
            new TerserPlugin(),
        ],
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery'
        })
    ]
};

const cssConfig = {
    resolve: {
        alias: {
            '@assets': __dirname + '/assets/',
            '@tiles': __dirname + '/includes/classes/Tiles/',
            '@pages': __dirname + '/includes/classes/Pages/',
        },
    },
    entry: {
        style: '/assets/scss/style.scss',
        creative: '/assets/scss/creative.scss'
    },
    output: {
        filename: 'assets/js/[name].min.js',
        path: path.resolve(__dirname, 'html'),
    },
    module: {
        rules: [
            {
                test: /\.svg|png|jpg|jpeg|gif$/,
                type: 'asset/resource',
                generator: {
                    filename: 'assets/img/[name][ext]'
                }
            },
            {
                test: /\.woff($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)/i,
                type: 'asset/resource',
                generator: {
                    filename: 'assets/fonts/[name][ext]'
                }
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: {
                                plugins: [
                                    function () {
                                        return [require('autoprefixer')];
                                    }
                                ],
                            },
                        },
                    },
                    "sass-loader"
                ],
                include: path.resolve(__dirname, 'assets'),
            },
        ]
    },
    devtool: 'source-map',
    optimization: {
        minimize: isProduction ? true : compressFiles,
        minimizer: [
            new CssMinimizerPlugin(),
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "assets/css/[name].min.css",
        }),
        new FixStyleOnlyEntriesPlugin({
            silent: true,
        }),
    ]
};

module.exports = [jsConfig, cssConfig];