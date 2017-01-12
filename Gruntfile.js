module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: {
            post_build: [
                'build/'
            ],
            pre_compress: [
                'build/releases'
            ]
        },
        copy: {
            build: {
                options: {
                    mode: true
                },
                src: [
                    '**',
                    '!node_modules/**',
                    '!releases',
                    '!releases/**',
                    '!build',
                    '!build/**',
                    '!.git/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!.gitignore',
                    '!.gitmodules',
                    '!.gitattributes',
                    '!composer.lock',
                    '!README.md',
                    '!naming-conventions.txt',
                    '!how-to-grunt.md',
                    '!.travis.yml',
                    '!.scrutinizer.yml',
                    '!phpunit.xml',
                    '!tests/**'
                ],
                dest: 'build/<%= pkg.textdomain %>/'
            }
        },
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: 'releases/<%= pkg.textdomain %>-<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'build/',
                src: [
                    '**/*',
                    '!build/*'
                ]
            }
        },
        uglify: {
            min: {
                files: grunt.file.expandMapping([
                    'assets/js/*.js',
                    '!assets/js/*.min.js',
                    '!assets/js/*.min-latest.js'
                ], 'assets/js/', {
                    rename: function (destBase, destPath) {
                        console.log( destBase + destPath );
                        return destBase + destPath.replace('.js', '.min.js');
                    },
                    flatten: true
                })
            }
        },
        cssmin: {
            options: {
                keepSpecialComments: 0
            },
            minify: {
                expand: true,
                cwd: 'assets/css/',
                src: ['*.css', '!*.min.css'],
                dest: 'assets/css/',
                ext: '.min.css'
            }
        },
        clean: {
            build: ["etc/**", "node_modules/**", ".git/**", ".gitignore", "composer.json", "Gruntfile.js", "package.json"],
        },

    });

    //load modules
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-text-replace');
    grunt.loadNpmTasks('grunt-shell');
    //installer tasks
    grunt.registerTask('default', ['cssmin', 'uglify']);
    grunt.registerTask('build', ['cssmin', 'uglify', 'copy', 'compress']);

};
