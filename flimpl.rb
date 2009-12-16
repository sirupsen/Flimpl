#!/usr/bin/env ruby

require 'fileutils'
require 'open-uri'

# App list
class FlimplList < Hash
  # New instance
  def initialize(path)
    @path = path
 
    notallowed = ["..", "."]
 
    # Load existing apps
    Dir.foreach(@path + 'controllers/') do |file|
      unless notallowed.include?(file)
        add file.split(".")[0]
      end
    end
 
    self
  end
 
  # Add an app
  def add(app)
    if app.is_a?(App)
      self[app.name] = app
    else
      self[app] = App.new(app)
    end
  end
 
  # Write
  def write
    # For each of the apps
    each do |index, app|
      # Possible files and their contents
      @files = [
        ["controllers/#{app}.php", "<?php\n\nclass #{app}_Controller extends Controller {\n}"],
        ["models/#{app}.php", "<?php\n\nclass #{app}_Model {\n}"],
        ["views/#{app}"],
        ["views/#{app}/index.php"],
      ]

      new(app)
      delete(app)
      view(app)
    end
  end

  def view(app)
    app.view.each do |view|
      File.open(@path + "/views/#{app}/#{view}.php", 'w') {}
    end
  end

  def new(app)
    # If app wants to be ccreated
    if app.write?
      @files.each do |file|
        if File.exist?(@path + file[0])
          return false
        elsif file[0][-3..-1] == 'php'
          File.open(@path + file[0], 'w') { |f| f.write(file[1]) }
        else
          Dir.mkdir(@path + file[0])
        end
      end
    end
  end

  def delete(app)
    # If app wants to be deleted
    if app.delete?
      @files.each do |file|
        if File.directory?(@path + file[0])
          FileUtils.rm_rf(@path + file[0])
        elsif File.exist?(@path + file[0])
          File.delete(@path + file[0])
        end
      end
    end
  end
end
 
# App
class App
  attr_accessor :name, :write, :delete
  attr_reader :view
 
  alias_method :write?, :write
  alias_method :delete?, :delete
 
  def initialize(name, write = false, delete = false)
    @name = name
    @write = write
    @delete = delete
    @view = []
  end

  def view=(name)
    @view << name
  end

  def delete
    @delete = true
  end
 
  def to_s
    @name
  end
end

# Handling external content
class FlimplExternal
  # Download a file
  def download(file, url, input = false)
    if ["y", "Y"].include?(input) 
      File.delete(file)
    else 
      exit if input
    end

    raise "File #{file} already exist." if File.exist?(file)

    File.open(file, 'w') { |f| f.write(open(url).read) }
  end

  # Download sample files
  def sample(input = false)
    files = [
            ['application/controllers/sample.php', 'http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/controllers/sample.php'],
            ['application/models/sample.php', 'http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/models/sample.php'], 
            ['application/views/sample'],
            ['application/views/sample/index.php', 'http://github.com/Sirupsen/Flimpl-Extras/raw/master/sample/views/sample/index.php']
    ] 

    files.each do |file|
      if file[0][-3..-1] == 'php'
        download(file[0], file[1], input)
      else
        Dir.mkdir(file[0])
      end
    end
  end
end
 
# Command line interface
class CommandLineInterface
  # Instance
  def initialize
    @list = FlimplList.new("application/")	
    @ext = FlimplExternal.new

    # Handle command
    begin
      send ARGV[0]
      write
    rescue ArgumentError
      puts $!
    rescue TypeError
      help
    end
  end
 
  # List apps
  def list
    @list.each { |index, app| puts app.name.capitalize }
  end

  # Download sample
  def sample
    @ext.sample
  end

  # Create view
  def view
    raise ArgumentError, "Missing argument: [App name] for View" unless ARGV[1]
    raise ArgumentError, "Missing argument: [View name] for View" unless ARGV[2]

    begin
      @list[ARGV[1]].view = ARGV[2]
    # Couldn't call #view on object
    rescue NoMethodError
      puts "App. '" + ARGV[1] + "' doesn't exist."
    end
  end

  # Get readme
  def readme
    file = "README"
    url = "http://github.com/Sirupsen/Flimpl-Extras/raw/master/README_FLIMPL.markdown"

    begin
      @ext.download(file, url)
    rescue RuntimeError
      print file + " already exist. Confirm replacing: [Y/N] "
      input = $stdin.gets.strip
    end

    @ext.download(file, url, input)
  end

  def help
    puts <<-help
Commands for Flimpl.rb:
   app [name] - Creates files for new app.
   del [name] - Delete files from existing app.
   view [app] [name] - Create a view file for app.
   readme - Download README file
   sample - Download Sample app.
   help - Prints this information.
help
  end
 
  # Create app
  def app
    raise ArgumentError, "Missing argument: [App name] for View" unless ARGV[1]

    @list.add App.new(ARGV[1], true)
  end
 
  # Delete app
  def del
    raise ArgumentError, "Missing argument: [App name] for View" unless ARGV[1]

    ARGV[1..ARGV.length].each do |app|
      print "Confirm deletion of #{app}: [Y/N] "
      input = $stdin.gets.strip

      begin
        @list[app].delete = true if ["y", "Y"].include?(input)
      # App not found, #delete not found on object
      rescue NoMethodError
        puts "App '" + app + "' doesn't exist"
      end
    end
  end
 
  # Write
  def write
    @list.write
  end
end
 
CommandLineInterface.new
