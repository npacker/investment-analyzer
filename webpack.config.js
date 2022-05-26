module.exports = {
  entry: './app/scripts/app.js',
  mode: 'development',
  output: {
    path: `${__dirname}/app/dist`,
    filename: 'bundle.js',
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
    ],
  },
};
