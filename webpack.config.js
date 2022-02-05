const mode = process.env.NODE_ENV === 'production' ? 'production' : "development";

module.exports = {
    mode: mode,

    module: {
        rules: [
            /*{
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    //without additional settings, this will reference .babelrc
                    loader: 'babel-loader'
                }
            },*/
            {
                test: /\.(s[ac]|c)ss$/, //css , scss, sass files
                use: ["css-loader", "postcss-loader"]
            },
        ]
    },
}