#!/usr/bin/env ruby

require 'open-uri'
require 'fileutils'

class Utilities
	def download(url, save)
		file = File.open(save, 'wb')
		file.write(open(url).read)
		file.close
	end

end

class Flimpl < Utilities
	@argv
	@controller
	@model
	@view

	def initialize(*argv)
		@argv = argv
		@controller = "application/controllers/#{@argv[1]}.php"
		@model = "application/models/#{@argv[1]}.php"
		@view = "application/views/#{@argv[1]}"

		begin
			send(ARGV[0])
		rescue NoMethodError
			puts "Command '" + ARGV[0] + "' doesn't exist"
		rescue TypeError
			self.help
		end
	end

	def help
		puts <<-help
Commands for Flimpl.rb:
   app [name] - Creates files for new app.
   appdel [name] - Delete files from existing app.
   view [app] [name] - Create a view file for app.
   readme - Download README file
   sample - Download Sample app.
   help - Prints this information.
help
	end

	def readme
		if File.exist?('README')
			print "Replace old README file? "
			input = $stdin.gets
		end

		if ["y", "yes", "ok", "k", "yeah", "ye"].include?(input.strip)
			File.delete('README') 
			puts "Deleted old README file."
		else
			exit if input
		end

		print "Downloading README file.. "
		download("http://github.com/Sirupsen/Flimpl-Extras/raw/master/README_FLIMPL.markdown", 'README')
		print "Done!\nREADME file saved to ./README\n"
	end 

	def sample
		controller = "application/controllers/sample.php"
		model = "application/models/sample.php"
		view = "application/views/sample"
		sample_view = "application/views/sample/index.php"

		print "Downloading controller.. "
		if File.exist?(controller)
			puts "Already exists!"
		else
			download('http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/controllers/sample.php', controller)
			print "Done!\n"
		end

		print "Downloading model.. "
		if File.exist?(model)
			puts "Already exists!"
		else
			download('http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/models/sample.php', model)
			print "Done!\n"
		end

		print "Creating view folder.. "
		if File.exist?(view)
			puts "Already exists!"
		else
			Dir.mkdir(view)
			print "Done!"
		end

		print "Downloading sample view.. "
		if File.exist?(sample_view)
			puts "Already exists!"
		else
			download('http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/views/sample/index.php', sample_view)
			print "Done!"
		end
	end

	def app
		unless @argv[1]
			puts "Lacking argument [App name]"
			exit
		end

		if File.exist?(@controller)
			puts "Controller for #{@argv[1]} (#{@controller}) already exist."
		else
			controller = open(@controller, 'wb')
			controller.write("<?php\n\nclass #{@argv[1].capitalize}_Controller extends Controller {\n}")
			controller.close()

			puts "Created Controller. (#{@controller})"
		end

		if File.exist?(@model)
			puts "Model for #{@argv[1]} (#{@model}) already exist."
		else
			model = open(@model, 'wb')
			model.write("<?php\n\nclass #{@argv[1].capitalize}_Model {\n}")
			model.close()

			puts "Created Model. (#{@model})"
		end

		if File.exist?(@view)
			puts "View folder for #{@argv[1]} (#{@view}) already exist."
		else
			Dir.mkdir(@view)

			puts "Created View folder. (#{@view})"
		end

		if File.exist?(@view + '/index.php')
			puts "Index file for #{@argv[1]} (#{@view}/index.php) already exist."
		else
			view = open("application/views/#{@argv[1]}/index.php", 'wb')
			view.close()

			puts "Created Index view. (#{@view}/index.php)"
		end
	end

	def appdel
		unless @argv[1]
			puts "Lacking argument [App name]"
			exit
		end

		print "Confirm deletion of app. #{@argv[1]}: "
		input = $stdin.gets

		if ["y", "yes", "ok", "k", "yeah", "ye"].include?(input.strip)
			if File.exist?(@controller)
				File.delete(@controller)
				puts "Deleted Controller. (#{@controller})"
			else
				puts "Controller (#{@controller}) not found."
			end

			if File.exist?(@model)
				File.delete(@model)
				puts "Deleted Model. (#{@model})"
			else
				puts "Model (#{@model}) not found."
			end

			if File.exist?(@view)
				FileUtils.rm_rf(@view)
				puts "Deleted view folder. (#{@view})"
			else
				puts "View folder (#{@view}) not found."
			end
		else
			exit if input
		end
	end

	def view
		unless @argv[1]
			puts "Lacking argument [App name]"
			exit
		end
		unless @argv[2]
			puts "Lacking argument [View name]"
			exit
		end

		file = open('application/views/' + @argv[1] + '/' + @argv[2] + '.php', 'wb')
		file.close
	end
end

Flimpl.new(*ARGV)
