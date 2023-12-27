const webpack = require('webpack');
const path = require('path');
const miniCss = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');

const relativePath = '/wp-content/themes/evotor';

module.exports = (env) => {
  const isProduction = env.mode === 'production';
  //
  const mode = isProduction ? 'production' : 'development';
  const needClean = true;
  const watch = env.watch === 'watch';
  const fileName = isProduction ? '[name].[chunkhash]' : '[name]';
  const chunkName = isProduction ? '[name].[chunkhash].chunk' : '[name].chunk';

  return {
    mode: mode,
    //stats: 'detailed',
    devtool: isProduction ? false : 'inline-source-map',

    entry: {
      index: './src/js/index.js',
      redesign: './src/js/redesign.js',
      single: './src/js/single.js',
    },

    output: {
      path: path.resolve(__dirname, './dist'),
      filename: 'js/' + fileName + '.js',
      publicPath: relativePath + '/dist/',
      chunkFilename: `js/scripts/${chunkName}.js`,
      asyncChunks: true, // не создавать отдельные чанки для import './a.js'; загруженных модулей
      clean: true,
    },
    optimization: {
      moduleIds: 'named',
      minimizer: [
        new TerserPlugin({
          extractComments: false,
        })
      ],
      runtimeChunk: {
        name: 'runtime',
      },
      splitChunks: {
        chunks(chunk) { // Игнорируем разбиение по чанкам для entry->index
          return chunk.name !== 'index';
        },
        hidePathInfo: true,
        minSize: 10,
        automaticNameDelimiter: '-',
        maxInitialRequests: Infinity,
        cacheGroups: {
          vendor: {
            test: /[\\/]node_modules[\\/](.*)[\\/]/,
            name: 'vendor'
          },
        },
      },
    },

    plugins: [
      new miniCss({
        filename: `css/${fileName}.css`,
        chunkFilename: `css/${chunkName}.css`,
      }),
      new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery",
        "window.jquery": "jquery"
      }),
    ],

    module: {
      rules: [
        {
          test: /\.scss$/,
          use: [
            {
              loader: miniCss.loader,
            },
            {
              loader: 'css-loader',
              options: {
                url: false,
              }
            },
            {
              loader: 'sass-loader'
            },
          ]
        }
      ]
    },

    watch: (!mode || watch),

    watchOptions: {
      ignored: [
        'node_modules/**',
      ]
    },

    externals: {
      jquery: 'jQuery',
    },
  }
}
