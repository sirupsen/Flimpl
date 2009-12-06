import sys
import os

class Flimpl:

	def app(self):
		controller = open('application/controllers/' + sys.argv[2] + '.php', 'wa')
		controller.write('<?php\n\nclass ' + sys.argv[2] + '_Controller extends Controller {\n\n}')
		controller.close()

		model = open('application/models/' + sys.argv[2] + '.php', 'wa')
		model.write('<?php\n\nclass ' + sys.argv[2] + '_Model {\n\n}')
		model.close()

		os.mkdir('application/views/' + sys.argv[2])

		index = open('application/views/' + sys.argv[2] + '.php', 'wa')
		index.close()

	def appdel(self):
		input = raw_input("Sure you want to delete the " + sys.argv[2] + " app? ")

		if input in ('y', 'Y', 'yes'):
			if os.path.exists('application/controllers/' + sys.argv[2] + '.php'):
				os.remove('application/controllers/' + sys.argv[2] + '.php')
				print "Controller for", sys.argv[2], "app deleted"
			else:
				print "Controller for", sys.argv[2], "app not found"

			if os.path.exists('application/models/' + sys.argv[2] + '.php'):
				os.remove('application/models/' + sys.argv[2] + '.php')
				print "Model for", sys.argv[2], "app deleted"
			else:
				print "Model for", sys.argv[2], "app not found"
			
			if os.path.exists('application/views/' + sys.argv[2]):
				os.removedirs('application/views/' + sys.argv[2])
				print "View for", sys.argv[2], "app deleted"
			else:
				print "View for", sys.argv[2], "app not found"
		else:
			print "Not deleting app", sys.argv[2]

getattr(Flimpl(), sys.argv[1])()
