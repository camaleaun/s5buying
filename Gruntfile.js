/*jslint node: true*/

module.exports = function (grunt) {

  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  // Project configuration.
  grunt.initConfig({
    // Meta data
    pkg: grunt.file.readJSON('package.json'),

    makepot: {
      target: {
        options: {
          cwd:         '.',
          domainPath:  'languages',
          type:        'wp-plugin',
          mainFile:    's5buying.php',
          potFilename: 's5buying.pot'
        }
      }
    },

    sass: {
      main: {
        options: {
          sourcemap: 'none',
          style: 'compressed'
        },
        files: {
          'assets/css/style.css': 'assets/sass/style.scss',
          'assets/css/menu.css': 'assets/sass/menu.scss'
        }
      },
    },

    autoprefixer: {
      options: {
        browsers: [
          "Android 2.3",
          "Android >= 4",
          "Chrome >= 20",
          "Firefox >= 24",
          "Explorer >= 8",
          "iOS >= 6",
          "Opera >= 12",
          "Safari >= 6"
        ]
      },
      style: {
        src: [
          'assets/css/style.css',
          'assets/css/menu.css'
        ]
      }
    },

    watch: {
      style: {
        files: 'assets/sass/*.scss',
        tasks: ['style']
      }
    }

  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-wp-i18n');

  grunt.registerTask('style', ['sass', 'autoprefixer']);
  grunt.registerTask('install', ['watch']);

  grunt.registerTask('default', ['watch']);

};
