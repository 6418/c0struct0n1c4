'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        pgk: grunt.file.readJSON( 'package.json' ),

        // https://github.com/gruntjs/grunt-contrib-watch
        watch: {
            compass: {
                files: 'assets/sass/**/*.scss',
                tasks: ['compass','autoprefixer']
            },
            js: {
                files: ['Gruntfile.js','assets/js/*.js'],
                tasks: ['requirejs:compile', 'jshint']
            }
        },

        // https://npmjs.org/package/grunt-contrib-compass
        compass: {
            dist: {
                options: {
                    sassDir: 'assets/sass',
                    cssDir: '.', // style.css, editor-style.css & rtl.css placed in theme root folder
                    imagesDir:'assets/images',
                    outputStyle: 'compact',
                    relativeAssets: true,
                    noLineComments: true,
                    importPath: [
                        'bower_components/bootstrap-sass/assets/stylesheets',
                        'bower_components/fontawesome/scss'
                    ]
                }
            }
        },

        // https://github.com/nDmitry/grunt-autoprefixer
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 9', 'ie 10']
            },
            files: {
                expand: true,
                flatten: true,
                src: '*.css',
                dest: ''
            }
        },

        // https://github.com/gruntjs/grunt-contrib-jshint
        jshint: {
            options: {
                "bitwise": true,
                "browser": true,
                "curly": true,
                "eqeqeq": true,
                "eqnull": true,
                "es5": true,
                "esnext": true,
                "immed": true,
                "jquery": true,
                "latedef": true,
                "newcap": true,
                "noarg": true,
                "node": true,
                "strict": false,
                "undef": true,
                "globals": {
                    "jQuery": true,
                    "alert": true,
                    "google": true,
                    "InfoBox": true,
                    "themeajax": true,
                    "ajaxurl": true,
                    "Favico": true,
                    "BackgroundCheck": true,
                    "smoothScroll": true
                }
            }
        },

        copy: {
            main: {
                expand: true,
                dot: false,
                flatten: false,
                src: [
                    '*.css',
                    '*.php',
                    'Gruntfile.js',
                    'package.json',
                    'bower.json',
                    'wpml-config.xml',
                    'screenshot.{jpg,png}',
                    'readme.txt',
                    'assets/**',
                    'bundled-plugins/**',
                    'bower_components/bootstrap-sass/assets/**',
                    'bower_components/fontawesome/css/font-awesome.min.css',
                    'bower_components/fontawesome/fonts/**',
                    'bower_components/almond/almond.js',
                    'bower_components/requirejs/require.js',
                    'demo-files/**',
                    'headers/**',
                    'inc/**',
                    'languages/**',
                    'loop/**',
                    'parts/**',
                    'radium-one-click-demo-install/**',
                    'woocommerce/**',
                ],
                dest: 'the-landscaper/',
            },
        },

        compress: {
            main: {
                options: {
                    archive: 'the-landscaper.zip',
                    mode:    'zip'
                },
                src: 'the-landscaper/**'
            }
        },

        // https://github.com/gruntjs/grunt-contrib-requirejs
        requirejs: {
            compile: {
                options: {
                    baseUrl: '',
                    mainConfigFile: 'assets/js/main.js',
                    optimize: 'uglify2',
                    preserveLicenseComments: false,
                    wrap: true,
                    useStrict: true,
                    name: 'bower_components/almond/almond',
                    include: 'assets/js/main',
                    out: 'assets/js/main.min.js'
                }
            }
        },

        makepot: {
            target: {
                options: {
                    domainPath: '/languages/',
                    potFilename: 'thelandscaper.pot',
                    type: 'wp-theme',
                    exclude: [
                        'inc/tgmpa/.*',
                        'inc/tgm-plugin-activation.*',
                        'inc/acf-fields.*',
                        'node_modules/.*',
                        'bower_components/.*',
                        'bundled-plugins/.*',
                        'radium-one-click-demo-install/.*'
                    ]
                }
            }
        },

        // https://www.npmjs.com/package/grunt-browser-sync
        browserSync: {
            options: {
                proxy: 'qt.dev/dev/thelandscaper',
                reloadDelay: 20,
                watchTask: true
            },
            bsFiles: {
                src: [
                    '*.php',
                    '*.css',
                    '*.scss',
                    'inc/*.php',
                    'woocommerce/*.php',
                    'assets/js/*.js'
                ]
            },
        },

    });

    grunt.registerTask('live', [
        'browserSync',
        'watch'
    ]);

    // register task
    grunt.registerTask('default', [
        'copy',
        'compress',
        'compass',
        'autoprefixer',
        'requirejs',
        'browserSync',
        'watch'
    ]);

};