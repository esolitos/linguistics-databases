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
                dest: './public/javascript/frontend.js',
            },
        },
        compass: {
            dev: {
                options: {
                    config: './app/assets/sass/config.rb'
                }
            }
        },
        watch: {
            css: {
                files: './app/assets/sass/*.scss',
                tasks: ['compass']
            },
            js: {
                files: './app/assets/js/*.js',
                tasks: ['concat']
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['watch']);
}