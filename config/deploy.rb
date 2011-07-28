 # What is the name of the local application?
set :application, "staging.rowndly.com"
 
# What user is connecting to the remote server?
set :user, "rowndly"
 
# Where is the local repository?
set :repository,  "git@git.assembla.com:rowndly.git"
 
# What is the production server domain?
role :web, "staging.rowndly.com"
 
# What remote directory hosts the production website?
set :deploy_to,   "/httpdocs"
 
# Is sudo required to manipulate files on the remote server?
set :use_sudo, false
  
# What version control solution does the project use?
set :scm,        :git
set :branch,     'master'

# How are the project files being transferred?
set :deploy_via, :copy
 
# Maintain a local repository cache. Speeds up the copy process.
set :copy_cache, true
 
# Ignore any local files?
set :copy_exclude, %w(.git)
  
# This task symlinks the proper .htaccess file to ensure the 
# production server's APPLICATION_ENV var is set to production
task :create_symlinks, :roles => :web do
   run "rm #{current_release}/public/.htaccess"
   run "ln -s #{current_release}/production/.htaccess 
              #{current_release}/public/.htaccess"
end
  
# After deployment has successfully completed
# create the .htaccess symlink
after "deploy:finalize_update", :create_symlinks