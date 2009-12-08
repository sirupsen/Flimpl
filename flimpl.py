#! /usr/bin/env python

import sys
import os
import urllib
import shutil

class Flimpl:

	def run(self):
		try:
			func = getattr(self, sys.argv[1])
		# Command not found
		except AttributeError:
			print "The command", sys.argv[1], "doesn't exist"
		# No action defined, show help
		except IndexError:
			self.help()
		else:
			if callable(func):
				try:
					func()
				except IndexError:
					print "Missing argument for command '" + sys.argv[1] + "' check help"

	def help(self):
		print "Commands are as follows:"
		print "\tapp [name] - Creates files for new app."
		print "\tappdel [name] - Delete files from existing app."
		print "\tview [app] [name] - Create a view file for app."
		print "\treadme - Download README file"
		print "\tsample - Download Sample app."
		print "\thelp - Lists this information"

	def readme(self):
		# Prepare
		url = urllib.URLopener()

		# If the README file already exists, delete it
		if os.path.exists('README.markdown'):
			print "Readme already exists, deleting and downloding new.."
			os.remove('README.markdown')	

		# Download the file
		url.retrieve('http://github.com/Sirupsen/Flimpl-Extras/raw/master/README_FLIMPL.markdown', 'README.markdown')
		print "Done! Saved to ./README.markdown"

	def sample(self):
		# Prepare
		url = urllib.URLopener()

		# Download the controller for the sample
		print "Downloading controller.."
		url.retrieve('http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/controllers/sample.php', 'application/controllers/sample.php')
		print "Done!"

		# Then the model
		print "Downloading model.."
		url.retrieve('http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/models/sample.php', 'application/models/sample.php')
		print "Done!"
		
		# Finally, create the sample view folder and put the index into here
		print "Creating view folder and fetching sample view.."
		os.mkdir("application/views/sample")
		url.retrieve('http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/views/sample/index.php', 'application/views/sample/index.php')

		# All done!
		print "Done!"
	
	def view(self):
		# Create the view file
		index = open('application/views/' + sys.argv[2] + '/' + sys.argv[3] + '.php', 'wa')
		index.close()

	def app(self):
		# Open the controller for the new app
		controller = open('application/controllers/' + sys.argv[2] + '.php', 'wa')
		# Create the basic class
		controller.write('<?php\n\nclass ' + sys.argv[2] + '_Controller extends Controller {\n\n}')
		controller.close()

		# Open the model file and write the basic content
		model = open('application/models/' + sys.argv[2] + '.php', 'wa')
		model.write('<?php\n\nclass ' + sys.argv[2] + '_Model {\n\n}')
		model.close()

		# Make the view directory
		os.mkdir('application/views/' + sys.argv[2])

		# Create the view file for the index
		index = open('application/views/' + sys.argv[2] + '/index.php', 'wa')
		index.close()

		print "Files created for", sys.argv[2], "app"

	def appdel(self):
		# Confirm deletion
		input = raw_input("Sure you want to delete the " + sys.argv[2] + " app? ")

		# If any of the words in the tuple was the answer:
		if input in ('y', 'Y', 'yes'):
			# Check if the controller exists, then delete else give error
			if os.path.exists('application/controllers/' + sys.argv[2] + '.php'):
				os.remove('application/controllers/' + sys.argv[2] + '.php')
				print "Controller for", sys.argv[2], "app deleted"
			else:
				print "Controller for", sys.argv[2], "app not found"

			# Again, check if the model exists, then delete - else, error
			if os.path.exists('application/models/' + sys.argv[2] + '.php'):
				os.remove('application/models/' + sys.argv[2] + '.php')
				print "Model for", sys.argv[2], "app deleted"
			else:
				print "Model for", sys.argv[2], "app not found"
			
			# If the view directory for the app is present, delete it, else - error
			if os.path.exists('application/views/' + sys.argv[2]):
				shutil.rmtree('application/views/' + sys.argv[2])
				print "View for", sys.argv[2], "app deleted"
			else:
				print "View for", sys.argv[2], "app not found"
		# Negative to confirmation, stop program
		else:
			print "Not deleting app", sys.argv[2]

Flimpl().run()
