const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    app: path.resolve(__dirname, 'app/scripts/app.js'),
  },
  mode: 'development',
  output: {
    path: path.resolve(__dirname, 'app/dist'),
    filename: '[name].bundle.js',
    clean: true,
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css',
    }),
    new webpack.ProvidePlugin({
      React: 'react',
    }),
  ],
  module: {
    rules: [
      // Javascripts
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: [
          'babel-loader',
        ],
      },
      // Stylesheets
      {
        test: /\.css$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          'css-loader',
        ],
      },
    ],
  },
  resolve: {
    extensions: ['*', '.js' ,'.jsx']
  }
};
