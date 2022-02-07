const mode = process.env.NODE_ENV === 'production' ? 'production' : "development";
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

module.exports = {
    mode: mode,
    entry: [
        './src/web/css/main.css'
    ],
    output: {
        filename: './src/web/css/[name].min.css',
    },
    module: {
        rules: [
            {
                test: /.s?css$/,
                use: [MiniCssExtractPlugin.loader, "css-loader"],
            },
            /*{
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    //without additional settings, this will reference .babelrc
                    loader: 'babel-loader'
                }
            },*/
            /* {
                 test: /\.(s[ac]|c)ss$/, //css , scss, sass files
                 use: ["css-loader", "postcss-loader"]
             },*/
            /*{
                test: /\.(s[ac]|c)ss$/i,

                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {publicPath: ""}
                    },
                    "css-loader", "postcss-loader", "sass-loader"],
            }*/
        ]
    },
    optimization: {
        minimize: true,
        minimizer: [
            // For webpack@5 you can use the `...` syntax to extend existing minimizers (i.e. `terser-webpack-plugin`), uncomment the next line
            //`...`,
            new CssMinimizerPlugin({
                include: /\/src\/web\/css/,
                test: /\.css(\?.*)?$/i,
                minify: [
                    CssMinimizerPlugin.cssnanoMinify,
                    CssMinimizerPlugin.cleanCssMinify
                ],
                minimizerOptions: {
                    preset: [
                        "default",
                        {
                            discardComments: {removeAll: true},
                        },
                    ],
                }
            }),
        ],
    },
    plugins: [new MiniCssExtractPlugin()],
}