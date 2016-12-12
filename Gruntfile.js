module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        uglify: {
            min: {
                files: grunt.file.expandMapping( [
                    'assets/**/*.js',
                    '!assets/**/*.min.js',
                    '!assets/**/*.min-latest.js'
                ], 'assets/js/', {
                    rename : function ( destBase, destPath ) {
                        return destBase + destPath.replace( '.js', '.min.js' );
                    },
                    flatten: true
                } )
            }
        },
        cssmin: {
            options: {
                keepSpecialComments: 0
            },
            minify : {
                expand: true,
                cwd   : 'assets/css/',
                src   : ['*.css', '!*.min.css'],
                dest  : 'assets/css/',
                ext   : '.min.css'
            }
        },
        clean: {
            build: ["etc/**", "node_modules/**",".git/**",".gitignore","composer.json","Gruntfile.js","package.json"],
        },

    });

    //load modules
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    //installer tasks
    grunt.registerTask( 'default', [ 'cssmin', 'uglify' ] );

};
