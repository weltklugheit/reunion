module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        // CONFIG ===================================/

        copy: {
            dev: {
                files: [
                    {
                        expand: true,
                        cwd: 'vendor/bower_components/angular/',
                        src: ['./angular.min.js'],
                        dest: 'public/js/libs'
                    },
                    {
                        expand: true,
                        cwd: 'vendor/bower_components/bootstrap-sass-official/vendor/assets/stylesheets',
                        src: ['./**/**'],
                        dest: 'public/sass'
                    },
                ]
            },
        },
        compass: {
            dev: {
                options: {
                    sassDir: ['public/sass'],
                    cssDir: ['public/css'],
                    environment: 'production',
                    outputStyle: 'compressed',
                    noLineComments: true,
                }
            },
        },
        watch: {
            sass: {
                files: ['public/sass/**'],
                tasks: ['compass:dev']
            },
        },
        uglify: {
            all: {
                files: {
                    'public/js/script.min.js': [
                        'public/js/libs/angular.min.js',
                        'public/js/controller/cms.js'
                    ],
                }
            }
        },
        
        // ...
    });
    // DEPENDENT PLUGINS =========================/
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // TASKS =====================================/

    grunt.registerTask('test', ['copy:dev']);
    grunt.registerTask('dev', ['copy']);
    grunt.registerTask('holla', ['watch']);
    grunt.registerTask('default', ['copy','watch']);
    grunt.registerTask('install',['copy:dev', 'compass:dev']);
    grunt.registerTask('update', ['copy:dev', 'compass:dev', 'uglify']);

};