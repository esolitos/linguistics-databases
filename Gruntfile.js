module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                separator: ';',
            },
            dev: {
                src: [
                './vendor/zurb/foundation/js/vendor/custom.modernizr.js',
                './vendor/zurb/foundation/js/vendor/jquery.js',
                './vendor/zurb/foundation/js/vendor/zepto.js',
                './vendor/zurb/foundation/js/foundation/foundation.js',
                './vendor/zurb/foundation/js/foundation/foundation.*.js',
                ],
                dest: './public/javascript/package.js',
            },
        },
        copy: {
            dev: {
                flatten: true,
                expand: true,
                filter: 'isFile',
                src: './app/assets/js/*.js',
                dest: './public/javascript/'
            }
        },
        compass: {
            dev: {
                options: {
                    config: './app/assets/sass/config.rb'
                }
            }
        },
        watch: {
            scss: {
                files: './app/assets/sass/*.scss',
                tasks: ['compass']
            },
            js: {
                files: './app/assets/js/*.js',
                // tasks: ['concat']
                tasks: ['copy']
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['concat', 'copy', 'watch']);
}