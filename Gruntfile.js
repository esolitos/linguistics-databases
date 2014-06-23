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
                dest: './public/javascript/<%= pkg.name %>.js',
            },
            dist: {
                src: [
                './vendor/zurb/foundation/js/vendor/custom.modernizr.js',
                './vendor/zurb/foundation/js/vendor/jquery.js',
                './vendor/zurb/foundation/js/vendor/zepto.js',
                './vendor/zurb/foundation/js/foundation/foundation.js',
                './vendor/zurb/foundation/js/foundation/foundation.*.js',
                ],
                dest: './public/javascript/<%= pkg.name %>.js',
            },
        },
        copy: {
            dev: {
                expand: true,
                flatten: true,
                filter: 'isFile',
                src: './app/assets/js/*.js',
                dest: './public/javascript/'
            },
            dist: {
                expand: true,
                flatten: true,
                filter: 'isFile',
                src: './app/assets/js/*.js',
                dest: './public/javascript/'
            }
        },
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
            },
            dist: {
                files: {
                    'public/javascript/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>'],
                    'public/javascript/app.min.js': ['./app/assets/js/app.js']
                }
            }
        },
        compass: {
            dev: {
                options: {
                    config: './app/assets/sass/config-dev.rb'
                }
            },
            dist: {
                options: {
                    config: './app/assets/sass/config-dist.rb'
                }
            }
        },
        watch: {
            scss: {
                files: './app/assets/sass/*.scss',
                tasks: ['compass:dev']
            },
            js: {
                files: './app/assets/js/*.js',
                tasks: ['newer:copy:dev']
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    
    grunt.loadNpmTasks('grunt-newer');

    grunt.registerTask('default', ['concat:dev', 'copy:dev', 'compass:dev', 'watch']);
    grunt.registerTask('dist', ['concat:dist', 'copy:dist', 'compass:dist', 'uglify:dist']);
}