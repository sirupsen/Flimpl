#! /usr/bin/env python

import sys
import os

class Flimpl:

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
		index = open('application/views/' + sys.argv[2] + '.php', 'wa')
		index.close()

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
				os.removedirs('application/views/' + sys.argv[2])
				print "View for", sys.argv[2], "app deleted"
			else:
				print "View for", sys.argv[2], "app not found"
		# Negative to confirmation, stop program
		else:
			print "Not deleting app", sys.argv[2]

# Call the method defined in the argument given
getattr(Flimpl(), sys.argv[1])()
