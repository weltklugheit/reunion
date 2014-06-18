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
                        cwd: 'vendor/bower_components/angluar/',
                        src: ['./angular.min.js'],
                        dest: 'frontenddev/libs'
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/bootstrap-sass-official/vendor/assets/stylesheets',
                        src: ['./**/**'],
                        dest: 'frontenddev/sass/'
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/font-awesome/scss/',
                        src: ['./**/**'],
                        dest: 'frontenddev/sass/font-awesome'
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/font-awesome/fonts/',
                        src: ['./**/*'],
                        dest: 'public/fonts'
                    }
                ]
            },
            deploy: {
                files: [
                    {
                        expand: true,
                        cwd: 'frontenddev/styles/',
                        src: ['./style.css'],
                        flatten: true,
                        dest: 'public/css'
                    },
                ]
            },
        },
        compass: {
            dev: {
                options: {
                    sassDir: ['frontenddev/sass'],
                    cssDir: ['frontenddev/styles'],
                    environment: 'production',
                    outputStyle: 'compressed',
                    noLineComments: true,
                }
            },
        },
        watch: {
            sass: {
                files: ['frontenddev/sass/**/*.scss'],
                tasks: ['compass','copy:deploy']
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

    grunt.registerTask('dev', ['copy']);
    grunt.registerTask('default', ['copy','watch']);
    grunt.registerTask('install',['copy:dev', 'compass:dev', 'copy:deploy']);
    grunt.registerTask('update', ['copy:dev', 'compass:dev', 'uglify', 'copy:deploy']);

};