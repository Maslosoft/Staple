#
# Ilmatar build file
# 
#

# includes
fs = require "fs"

module.exports = (grunt) ->

	# Some basic setup
	# ilmatar-path, generated-path and bower-path should be set, rest is optional
	generatedPath = grunt.option("generated-path") or "assets"
	bowerPath = grunt.option("bower-path") or "vendor/bower-asset"
	
	distPath = grunt.option("dist-path") or "#{generatedPath}"
	jsDistPath = grunt.option("js-dist-path") or "#{generatedPath}/js"
	cssDistPath = grunt.option("css-dist-path") or "#{generatedPath}/css"
	
	
	dist = [
		"#{bowerPath}/jquery/dist/jquery.min.js"
		"#{bowerPath}/bootstrap/dist/js/bootstrap.min.js"
		"#{bowerPath}/magnific-popup/dist/jquery.magnific-popup.min.js"
		"#{bowerPath}/sticky-kit/jquery.sticky-kit.min.js"
		"#{bowerPath}/maslosoft-playlist/dist/playlist.min.js"
		"#{bowerPath}/awe-share/dist/awe-share.min.js"
	]

	css = [
		"#{bowerPath}/bootstrap/dist/css/bootstrap.min.css"
		"#{bowerPath}/bootstrap/dist/css/bootstrap-theme.min.css"
		"#{bowerPath}/font-awesome/css/font-awesome.min.css"
		"#{bowerPath}/maslosoft-playlist/dist/playlist.css"
		"#{bowerPath}/awe-share/dist/awe-share.min.css"
	]

	copy = {
		fa:
			expand:true
			nonull: true
			cwd: "#{bowerPath}/font-awesome/fonts/"
			src: "*"
			dest: "#{distPath}/fonts"
		glyphicons:
			expand:true
			nonull: true
			cwd: "#{bowerPath}/bootstrap/fonts/"
			src: "*"
			dest: "#{distPath}/fonts"
	}


	# Project configuration.
	grunt.initConfig
		concat:
			options:
				separator: ";\n"
			dist:
				src: dist
				dest: "#{jsDistPath}/application.min.js"
				nonull: true
		concat_css:
			css:
				src: css
				dest: "#{cssDistPath}/application.css"
				nonull: true
		copy: copy
		# This minimizes css
		cssmin:
			target:
				files:
					"#{cssDistPath}/application.min.css" : [
						"#{cssDistPath}/application.css"
					]

	# These plugins provide necessary tasks.

	grunt.loadNpmTasks "grunt-contrib-concat"
	grunt.loadNpmTasks "grunt-contrib-copy"
	grunt.loadNpmTasks "grunt-contrib-cssmin"
	grunt.loadNpmTasks "grunt-concat-css"
	

	# Default task.
	grunt.registerTask "default", ["concat", "concat_css", "cssmin", "copy"]
	grunt.registerTask "temp", ["copy"]
