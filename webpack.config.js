const path = require('path');

module.exports = {
    mode: 'development',
    entry: './public/js/cartnotifications.js',
    output: {
        path: __dirname + '/views/js',
        filename: 'cartnotifications.js'
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader'],
            }
        ]
    }
};
