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
                        cwd: 'bower_components/angular/',
                        src: ['./angular.min.js'],
                        dest: 'public/js/libs'
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/bootstrap-sass-official/vendor/assets/stylesheets',
                        src: ['./**/**'],
                        dest: 'public/sass'
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/font-awesome/scss/',
                        src: ['./**/**'],
                        dest: 'public/sass/font-awesome'
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/font-awesome/fonts/',
                        src: ['./**/*'],
                        dest: 'public/fonts'
                    }
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
                files: ['public/sass/**/*.scss'],
                tasks: ['compass:dev']
            },
        },
        uglify: {
            all: {
                files: {
                    'public/js/script.min.js': [
                        'frontenddev/libs/jquery.js',
                        'frontenddev/libs/bootstrap.js',
                        'frontenddev/js/script.js'
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